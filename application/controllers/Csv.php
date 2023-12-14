<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Csv extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'csv';
        $this->header['sub_page'] = 'csv';
        $this->header['title'] = 'CSVで納品予定連絡';
        $this->load->model('schedule_model');
        $this->load->model('product_model');
        $this->check_login();
        $this->load->model('member_address_model');
        $this->check_member_address();
        $this->load->library('email');
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

    /**
     * This function used to load the first screen of the user
     */

    public function create()
    {
        $this->load_view_with_menu("csv/index");
    }


    public function upload_csv()
    {

        $csv_file = $_FILES['csv_file'];

        if($csv_file['size'] == 0) {
            
            redirect('csv/create');

        } else {
            if (pathinfo($csv_file['name'], PATHINFO_EXTENSION) != "csv") {
                redirect('csv/create');
            }

            $this->load->library('upload');

            $config['upload_path'] = './uploads/csv/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 100;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('csv_file')) {
                echo ("csv upload failed");
            } else {
                $data = $this->upload->data();
                $csv_filepath = $data['full_path'];

                // Read CSV content
                $csv_content = file_get_contents($csv_filepath);

                $encoding = 'utf8';
                $encoding = $this->input->post('encoding');
                if ($encoding == 'utf8') {
                    $csv_rows = array_map('str_getcsv', file($csv_filepath));
                }

                if ($encoding == 'sjis') {
                    $csv_content = mb_convert_encoding($csv_content, 'UTF-8', 'Shift_JIS');
                    $csv_rows = array_map('str_getcsv', explode("\n", $csv_content));
                }
            }

            $this->data['csv_rows'] = $csv_rows;

            
            if ($this->data['csv_rows'] == null || !isset($this->data['csv_rows'])) {
                redirect('csv/create');
            }

            $this->data['file_path'] = $csv_filepath;
            
            $this->load_view_with_menu("csv/edit");
        }
    }


    public function set_csv_header_name()
    {
        $new_row_head = $this->input->post('new_row_head');
        $file_path = $this->input->post('file_path');

        $member_id = $this->session->userdata('member_id');

        $schedule_id = $this->schedule_model->create(3, "000000000000", "000000000000000", '', '', $member_id, true);
        
        $last_consecutive_product_number = $this->product_model->get_consecutive_product_number($member_id);

        if(($handle = fopen($file_path, "r")) !== false) {
            $row_number = 0;
            $count = 0;
            while (($row = fgetcsv($handle, 1000, ",")) != false) {
                $row_number ++;
                if ($row_number === 1) {
                    continue;
                }

                $index_prod_name = array_search('prod_name', $new_row_head);
                $index_prod_serial = array_search('prod_serial', $new_row_head);
                $index_prod_price = array_search('prod_price', $new_row_head);
                $index_prod_quantity_in = array_search('prod_quantity_in', $new_row_head);
                $index_is_brand = array_search('is_brand', $new_row_head);
                $index_req_photo = array_search('req_photo', $new_row_head);
                $index_req_measure = array_search('req_measure', $new_row_head);
                $index_req_call = array_search('req_call', $new_row_head);
                $index_memo_a = array_search('memo_a', $new_row_head);
                $index_memo_b = array_search('memo_b', $new_row_head);

                $data = array(
                    'prod_name' => $row[$index_prod_name],
                    'prod_serial' => $index_prod_serial == false ? '' : $row[$index_prod_serial],
                    'prod_management_number' => $member_id . str_pad($last_consecutive_product_number + $count + 1, 4, '0', STR_PAD_LEFT),
                    'prod_price' => $index_prod_price == false ? 0 : $row[$index_prod_price],
                    'prod_quantity' => 0, 
                    'prod_quantity_in' => $row[$index_prod_quantity_in],
                    'prod_quantity_out' => 0, 
                    'prod_quantity_sold' => 0, 
                    'is_brand' => $row[$index_is_brand],
                    'req_photo' => $row[$index_req_photo],
                    'req_measure' => $row[$index_req_measure],
                    'req_call' => $row[$index_req_call],
                    'memo_a' => $index_memo_a == false ? '' : $row[$index_memo_a],
                    'memo_b' => $index_memo_b == false ? '' : $row[$index_memo_b],
                    'member_id' => $this->session->userdata('member_id'), 
                    'schedule_id' => $schedule_id,
                    'is_deleted' => 0,
                    'created_at' => date('Y-m-d H:i:s', time()),
                );

                $this->db->insert('products', $data);

                $count ++;
            }
        }

        $response = array(
            'success' => true,
            'schedule' => '',
            'products' => $this->product_model->get_scheduled_products($schedule_id)
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    public function update_csv_schedule()
    {
        $member_id = $this->session->userdata('member_id');

        $current_time = date('Ymd', time());
        $typed_current_time = substr($current_time, 2, 9);

        $schedule_id = $this->input->post('schedule_id');
        $transfer_id = $this->input->post('transfer_id');
        $tracking_number = $this->input->post('tracking_number');
        $consecutive_schedule_number = $this->schedule_model->get_consecutive_schedule_number($member_id);
        $management_number = $member_id . $typed_current_time . $consecutive_schedule_number;
        $arrival_date = $this->input->post('arrival_date');
        $memo = $this->input->post('memo');

        $is_schedule_updated = $this->schedule_model->update_csv_schedule($schedule_id, $transfer_id, $tracking_number, $management_number, $arrival_date, $memo, $member_id);
        
        if($is_schedule_updated) {
            // do something
            $id_string = $this->input->post('product_list_ids');
            
            $id_string1 = substr($id_string, 1, strlen($id_string)-2);
            $prod_ids = explode(',', $id_string1);

            $last_consecutive_product_number = $this->product_model->get_consecutive_product_number($member_id);

            $presaved_scheduled_products = $this->product_model->get_scheduled_products($schedule_id);
            $presaved_scheduled_prod_ids = [];

            foreach($presaved_scheduled_products as $presaved_scheduled_product) {
                array_push($presaved_scheduled_prod_ids, $presaved_scheduled_product['id']);
            }

            foreach($presaved_scheduled_prod_ids as $prod_id) {
                if(array_search($prod_id, $prod_ids) === false) {                       // delete
                    $this->product_model->delete($prod_id);
                } else {                                                                // update
                    $prod_name = $this->input->post('prod_name_'.$prod_id);
                    $prod_serial = $this->input->post('prod_serial_'.$prod_id);
                    $prod_quantity_in = $this->input->post('prod_quantity_in_'.$prod_id);
                    $is_brand = $this->input->post('is_brand_'.$prod_id) == 'on' ? true : false;
                    $req_photo = $this->input->post('req_photo_'.$prod_id) == 'on' ? true : false;
                    $req_measure = $this->input->post('req_measure_'.$prod_id) == 'on' ? true : false;
                    $req_call = $this->input->post('req_call_'.$prod_id) == 'on' ? true : false;

                    $this->product_model->update_product_in_schedule($prod_id, $prod_name, $prod_serial, $prod_quantity_in, $req_photo, $req_measure, $req_call);
                }
            }

            $new_products = [];
            
            foreach($prod_ids as $prod_id) {                                            // create
                if(array_search($prod_id, $presaved_scheduled_prod_ids) === false) {
                    $prod_name = $this->input->post('prod_name_'.$prod_id);
                    $prod_serial = $this->input->post('prod_serial_'.$prod_id);
                    $prod_quantity_in = $this->input->post('prod_quantity_in_'.$prod_id);
                    $is_brand = $this->input->post('is_brand_'.$prod_id) == 'on' ? true : false;
                    $req_photo = $this->input->post('req_photo_'.$prod_id) == 'on' ? true : false;
                    $req_measure = $this->input->post('req_measure_'.$prod_id) == 'on' ? true : false;
                    $req_call = $this->input->post('req_call_'.$prod_id) == 'on' ? true : false;

                    array_push($new_products, array(
                        'prod_name' => $prod_name,
                        'prod_serial' => $prod_serial,
                        'prod_management_number' => $member_id . str_pad($last_consecutive_product_number + $key + 1, 4, '0', STR_PAD_LEFT),
                        'prod_quantity_in' => $prod_quantity_in,
                        'is_brand' => $is_brand == 'on' ? true : false,
                        'req_photo' => $req_photo == 'on' ? true : false,
                        'req_measure' => $req_measure == 'on' ? true : false,
                        'req_call' => $req_call == 'on' ? true : false,
                        'member_id' => $member_id,
                        'schedule_id' => $schedule_id,
                        'created_at' => date('Y-m-d H:i:s', time()),
                    ));
                }
            }
            if(count($new_products) > 0) {
                $this->product_model->insertMultiple($member_id, $new_products);
            }

            $products_for_email =  $this->product_model->get_scheduled_products($schedule_id);
            
            $member_address = $this->member_address_model->get_member_addresses($this->session->userdata('member_id'))[0];

            // info@aucwill.com
            $this->email->from('artemsyvko71@gmail.com', 'オークウィル管理者');
            $this->email->to('fishingamateur71@gmail.com');
            $this->email->cc('artemsyvko71@gmail.com');

            $this->email->subject('【Aucwill】 国内発送完了のお知らせ');

            $product_info = '';
            foreach($products_for_email as $product) {
                $product_info .= '
                    商品管理番号&nbsp;'.$product['prod_management_number'].'<br>
                    商品名&nbsp;'.$product['prod_name'].'<br>
                    数量&nbsp;'.$product['prod_quantity_in'].'<br><br>';
            }

            $content = 
                $this->session->userdata('name').'様
                <br><br>
                お客様のお手続きにより
                <br>
                下記の通り、発送依頼を受け付けました。
                <br><br><br>
                注文番号&nbsp;'.$schedule_id.'
                <br><br>
                発送元情報<br>
                〒'.$member_address['post_code'].$member_address['prefecture'].$member_address['address'].$member_address['building'].'
                <br><br><br>'.
                $product_info.'<br>
                何卒宜しくお願い申し上げます。          
                ';
            $this->email->message($content);

            $this->email->send();
            var_dump($content);exit;
            
            redirect('/schedulelist/index');
        } else {
            // redirect with error
            redirect("schedule/fill");
        }
    }


    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = '404エラー';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>
