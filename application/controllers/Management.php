<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Management extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'management';
        $this->header['sub_page'] = 'management';
        $this->header['title'] = '管理者画面';
        $this->load->model('schedule_model');
        $this->load->model('product_model');
        $this->load->model('user_model');
        $this->load->model('photo_model');
        $this->load->model('measure_model');
        $this->load->model('enquiry_model');
        $this->load->model('delivery_schedule_model');
        $this->load->model('billing_model');
        $this->load->model('user_billing_view_model');
        $this->check_login();
        $this->load->model('member_address_model');
        $this->check_member_address();
        $this->check_role();


        $this->load->library('upload');
        $this->load->library('image_lib');
    }


    public function check_login(){
        if (!$this->session->userdata('is_logged')) {
            redirect('/login');
        }
    }
    
    public function check_member_address(){
        $member_id = $this->session->userdata('member_id');
        $member_addresses = $this->member_address_model->get_member_addresses($member_id);
        
        if (empty($member_addresses)) {
            redirect('address');
        }
    }

    public function check_role(){
        if (!$this->session->userdata('isadmin')) {
            redirect('/dashboard');
        }
    }

    public function schedule() {
        $schedules1 = array();
        $schedules = $this->schedule_model->get_all_schedules();
        foreach($schedules as $schedule) {
            $products = $this->product_model->get_scheduled_products($schedule['id']);
            $user = $this->user_model->get_user_by_member_id($schedule['member_id']);
            $member = $this->member_address_model->get_member_address_by_member_id($schedule['member_id']);

            array_push($schedules1, array(
                'schedule' => $schedule,
                'products' => $products,
                'member' => $member,
                'user' => $user,
            ));
        }

        $this->data['schedules'] = $schedules1;
        $this->load_view_with_menu("admin/schedule");
    }


    public function upload_photos() {
      
        $config['upload_path'] = './uploads/photo/original';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 40*1024;
        $this->upload->initialize($config);
      
        $uploaded_files = array();
      
        // Handle multiple file uploads
        if (!empty($_FILES['files']['name'])) {
            $file_count = count($_FILES['files']['name']);
        
            for ($i = 0; $i < $file_count; $i++) {
                $original_filename = $_FILES['files']['name'][$i];
                $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);

                // Generate a new filename with the original extension
                $new_filename = date('YmdHis', time()) . mt_rand(1000000000, 9999999999) . '.' . $file_extension;

                $_FILES['userfile']['name'] = $new_filename;
                // $_FILES['userfile']['name'] = $_FILES['files']['name'][$i];
                $_FILES['userfile']['type'] = $_FILES['files']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $_FILES['files']['error'][$i];
                $_FILES['userfile']['size'] = $_FILES['files']['size'][$i];
        
                if ($this->upload->do_upload('userfile')) {
                    $uploaded_files[] = $this->upload->data();
                } else {
                    $error = $this->upload->display_errors();
                    echo "失敗: " . $error;
                }
            }
        
            // Files uploaded successfully
            if (!empty($uploaded_files)) {
                foreach($uploaded_files as $file) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/photo/original/' . $file['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 120;
                    $config['new_image'] = './uploads/photo/' . $file['file_name'];

                    // $config['wm_type'] = 'overlay';
                    // $config['wm_overlay_path'] = './uploads/watermark.png';
                    // $config['wm_vrt_alignment'] = 'middle';
                    // $config['wm_hor_alignment'] = 'center';
                    // $config['wm_opacity'] = 100;

                    $this->load->library('image_lib', $config); // Load the library if not already loaded

                    $this->image_lib->initialize($config);

                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                    } else {
                        // $this->image_lib->clear(); // Clear any previous configurations
                        
                        
                        // $this->image_lib->initialize($config);

                        // if (!$this->image_lib->watermark()) {
                        //     echo $this->image_lib->display_errors();
                        // } else {
                        //     echo "Image resized and watermarked successfully!";
                        // }
                    }

                }
                $prod_id = $_POST['prod_id'];
                $this->photo_model->save_photos($prod_id, $uploaded_files);
                echo "成功: " . count($uploaded_files) . "つがアップロードされています。";
            }
        }
    }


    public function save_measure() { 
        $prod_id = $this->input->post('prod_id');
        $content = $this->input->post('content');

        $result = $this->measure_model->save_measure($prod_id, $content);
        // if($result == true) {
            echo "商品寸法に関する資料が保管されました。";
        // } else {
        //     echo "商品寸法資料が保管失敗。";
        // }
    }


    public function update_checkbox_status() {
        $prod_id = $this->input->post('id');
        $prod_management_number = $this->input->post('prod_management_number');
        $column = $this->input->post('column');
        $checked = $this->input->post('checked');

        $member_id = $this->input->post('member_id');

        $fee_type = BASIC_FEE_TYPE;

        if($column == 'req_photo') {
            $fee_type = SHOOT_FEE_TYPE;
            $fee_amount = SHOOT_FEE;
            $this->billing_model->createTransaction($member_id, $prod_management_number, $fee_type, $fee_amount, $prod_management_number);
        }
        if($column == 'req_measure') {
            $fee_type = MEASURE_FEE_TYPE;
            $fee_amount = MEASURE_FEE;
            $this->billing_model->createTransaction($member_id, $prod_management_number, $fee_type, $fee_amount, $prod_management_number);
        }
        if($column == 'req_call') {
            $fee_type = CALL_FEE_TYPE;
            $fee_amount = CALL_FEE;
            $this->billing_model->createTransaction($member_id, $prod_management_number, $fee_type, $fee_amount, $prod_management_number);
        }

        $result = $this->product_model->update_checkbox_status($prod_id, $column, $checked);
        echo $result;
    }

    
    public function complete_schedule()
    {
        $schedule_id = $this->input->post('id');
        $this->product_model->update_prod_quantities_after_schedule($schedule_id);
        $result = $this->schedule_model->complete_schedule($schedule_id);
        echo $result;
    }


    public function enquiry()
    {
        $this->data['enquiries'] = $this->enquiry_model->get_parent_enquiries_for_admin();

        $this->load_view_with_menu("admin/enquiry");
    }


    public function selling_schedule() {
        $this->data['selling_schedules'] = $this->delivery_schedule_model->get_delivery_schedules();
        $this->load_view_with_menu("admin/sellingSchedule");
    }

    public function download_schedules()
    {
        $mpdf = new \Mpdf\Mpdf();

        // Set the default font and encoding for the PDF
        $mpdf->autoLangToFont = true;
        $mpdf->autoScriptToLang = true;

        $schedules = $this->data['selling_schedules'] = $this->delivery_schedule_model->get_delivery_schedules_for_print();

        if (count($schedules) > 0) {
            foreach ($schedules as $key => $schedule) {
                
                $arrival_time = '';
                        
                if($schedule['arrival_time'] == '00') $arrival_time = 'なし';
                if($schedule['arrival_time'] == '51') $arrival_time = '午前中';
                if($schedule['arrival_time'] == '52') $arrival_time = '12~14時';
                if($schedule['arrival_time'] == '53') $arrival_time = '14~16時';
                if($schedule['arrival_time'] == '54') $arrival_time = '16~18時';
                if($schedule['arrival_time'] == '55') $arrival_time = '18~20時';
                if($schedule['arrival_time'] == '56') $arrival_time = '20~21時';
                
                // Add a new page at the beginning of each iteration
                $mpdf->AddPage('P', 'A4');

                // Create HTML content
                $html = '
                    <html lang="ja">
                        <head>
                            <meta charset="UTF-8">
                            <title>Aucwill-Schedule-'.date('Y-m-d', time()).'</title>
                            <style>
                                tr th {
                                    padding: 4px;
                                    font-size: 13px;
                                    color: white;
                                    background-color: #676464;
                                    border: solid 0.001px #514b4b85;
                                }
                                tr td {
                                    border: solid 0.001px #514b4b85;
                                    font-size: 11px;
                                    padding: 5px;
                                }
                            </style>
                        </head>
                        <body>
                            <div style="text-align: right;">
                                <small>'.date('Y年m月d日 H:i', time()).'</small>
                            </div>
                            <hr style="width: 100%; border-top: 1px dashed #d5d5d5c7">
                            <h3 style="text-align: center">オークウイル本日発送予定分</h3>
                            <table style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 16%;">受注番号</th>
                                        <th style="width: 28%;">オークウイル会員住所</th>
                                        <th style="width: 28%;">受取人住所</th>
                                        <th style="width: 28%;">お荷物情報</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 16%; text-align: center;">'.str_pad($schedule['id'], 5, '0', STR_PAD_LEFT).'</td>
                                        <td style="width: 28%;">
                                            <ul>
                                                <li>会員番号: '.$schedule['member_id'].'</li>
                                                <li>お名前: '.$schedule['member_name'].'</li>
                                                <li>発送元住所: </li>
                                                '.'〒'.$schedule['member_post_code'].' '.
                                                    $schedule['member_prefecture'].
                                                    $schedule['member_address'].
                                                    $schedule['member_building'].'
                                                <li>電話番号: '.$schedule['member_phone'].'</li>
                                            </ul>
                                        </td>'.
                                        (
                                        $schedule['qrcode'] == '' ? 
                                        '<td style="width: 28%;">
                                            <ul>
                                                <li>お客様名: '.$schedule['buyer_name'].'</li>
                                                <li>発送元住所: </li>
                                                '.'〒'.$schedule['buyer_post_code'].' '.
                                                    $schedule['buyer_prefecture'].
                                                    $schedule['buyer_address'].
                                                    $schedule['buyer_building'].'
                                                <li>電話番号: '.$schedule['buyer_phone'].'</li>
                                            </ul>
                                        </td>' :
                                        '<td style="width: 28%; text-align: center;"><img style="width: 150px" src="'.base_url('uploads/qrcode/'.$schedule['qrcode']).'" alt="qrcode"></td>'
                                        ).
                                        '<td>
                                            <ul>
                                                <li>商品管理番号: '.$schedule['prod_management_number'].'</li>
                                                <li>商品名: '.$schedule['prod_name'].'</li>
                                                <li>数量: '.$schedule['prod_quantity_out'].'</li>
                                                <li>依頼日時: '.$schedule['created_at'].'</li>
                                                <li>配達希望日: '.($schedule['arrival_date']=='0000-00-00'?'なし':$schedule['arrival_date']).'</li>
                                                <li>配達希望時間: '.$arrival_time.'</li>
                                                <li>'.($schedule['in_packet']?'可能な限りゆうパケットでの発送を希望する':'').'</li>
                                                <li>備考: '.$schedule['note'].'</li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </body>
                    </html>';

                // Write HTML to the PDF
                $mpdf->WriteHTML($html);
            }
        } else {
            $html = '<html lang="ja">
                        <head>
                            <meta charset="UTF-8">
                            <title>Aucwill-Schedule-'.date('Y-m-d', time()).'</title>
                        </head>
                        <body>
                            <p style="margin-top: 200px; text-align: center;">本日予約された配送予定はありません。</p>
                        </body>
                    </html>';
            $mpdf->WriteHTML($html);
        }

        // Output the PDF
        $mpdf->Output();
    }

    public function get_last_product_consecutive_number()
    {
        $member_id = $this->session->userdata('member_id');

        return $this->product_model->get_consecutive_product_number($member_id);
    }

    public function billing()
    {
        $this->data['billings'] = $this->user_billing_view_model->get_billing_view_data();

        $this->load_view_with_menu("admin/billing");
    }
}