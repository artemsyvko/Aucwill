<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Stock extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'stock';
        $this->header['sub_page'] = 'stock';
        $this->header['title'] = '在庫';
        $this->load->model('schedule_model');
        $this->load->model('product_model');
        $this->load->model('photo_model');
        $this->load->model('measure_model');
        $this->load->model('member_address_model');
        $this->load->model('delivery_schedule_model');
        $this->load->model('billing_model');
        $this->load->library('upload');
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
    public function index()
    {        
        $member_id = $this->session->userdata('member_id');

        // $products = $this->product_model->get_products_by_member_id($member_id);
        $products = $this->product_model->get_stock_products_by_member_id($member_id);
        
        $n_products = [];
        foreach ($products as $product) {
            // product image
            $image_path = $this->photo_model->get_prod_image_by_prod_id($product['id']);
            // product measure
            $measure = $this->measure_model->get_prod_measure_by_prod_id($product['id']);

            array_push($n_products, array(  $product,
                                            array('thumbnail'=>$image_path),
                                            array('measure'=>$measure)
                ));
        }
        $this->data['products'] = $n_products;
        
        $this->load_view_with_menu("stock/index");
    }

    public function product_update ()
    {
        $name = $this->input->post('name');     //$name: columName-productId
        $value = $this->input->post('value');

        $prod_id = explode('-', $name)[1];
        $column = explode('-', $name)[0];

        $response = array('success' => $this->product_model->update_product_in_stock($prod_id, $column, $value));
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function sale_order ()
    {
        if($this->input->method() === 'get') {
            $str_val_prod_ids = $this->input->get('prod_ids');

            if(!isset($str_val_prod_ids))
                return redirect('stock');

            if($str_val_prod_ids == ',')
                return redirect('stock');

            // accept only one product for sale order
            $prod_ids = explode(',', substr($str_val_prod_ids, 1, strlen($str_val_prod_ids)-2));
            $products = $this->product_model->get_product_by_id($prod_ids[0]);
            $product = $products[0];

            $this->data['product'] = $product;

            $member_id = $this->session->userdata('member_id');
            $addresses = $this->member_address_model->get_member_addresses($member_id);
            $this->data['member_addresses'] = $addresses;

            $this->load_view_with_menu('stock/order');
        } else if ($this->input->method() === 'post') {
            $member_id = $this->session->userdata('member_id');

            $prod_id = $this->input->post('prod_id');
            $prod_management_number = $this->input->post('prod_management_number');
            $prod_name = $this->input->post('prod_name');
            $prod_quantity_out = $this->input->post('prod_quantity_out');

            if ($this->input->post('address-option') == 'qrcode') {
                $buyer_name = '';
                $buyer_post_code = '';
                $buyer_prefecture = '';
                $buyer_address = '';
                $buyer_building = '';
                $buyer_phone = '';
            } else {
                $buyer_name = $this->input->post('buyer_name');
                $buyer_post_code = $this->input->post('buyer_post_code');
                $buyer_prefecture = $this->input->post('buyer_prefecture');
                $buyer_address = $this->input->post('buyer_address');
                $buyer_building = $this->input->post('buyer_building');
                $buyer_phone = $this->input->post('buyer_phone');
            }

            $arrival_date = $this->input->post('arrival_date');
            $arrival_time = $this->input->post('arrival_time');
            $note = $this->input->post('note');
            
            $delivery_type = $this->input->post('0');

            $member_post_code = $this->input->post('member_post_code');
            $member_prefecture = $this->input->post('member_prefecture');
            $member_address = $this->input->post('member_address');
            $member_building = $this->input->post('member_building');
            $member_name = $this->input->post('member_name');
            $member_phone = $this->input->post('member_phone');

            $in_packet = $this->input->post('in_packet');
            $in_packet = $in_packet==null ? 0 : 1;

            $prod_quantity = $this->product_model->get_prod_quantity_by_id($prod_id);

            if ($prod_quantity_out > $prod_quantity) {
                $products = $this->product_model->get_product_by_id($prod_id);
                $product = $products[0];
                $this->data['product'] = $product;

                $member_id = $this->session->userdata('member_id');
                $addresses = $this->member_address_model->get_member_addresses($member_id);
                $this->data['member_addresses'] = $addresses;
    
                $this->load_view_with_menu('stock/order');
            } else {
                $config['upload_path'] = './uploads/qrcode';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 1 * 1024;

                $qrcode = '';

                $this->upload->initialize($config);

                if(!empty($_FILES['qrcode'])) {
                    $original_filename = $_FILES['qrcode']['name'];
                    $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);

                    $new_filename = date('YmdHis', time()) . mt_rand(1000000000, 9999999999) . '.' . $file_extension;
    
                    $_FILES['userfile']['name'] = $new_filename;
                    // $_FILES['userfile']['name'] = $_FILES['qrcode']['name'];
                    $_FILES['userfile']['type'] = $_FILES['qrcode']['type'];
                    $_FILES['userfile']['tmp_name'] = $_FILES['qrcode']['tmp_name'];
                    $_FILES['userfile']['error'] = $_FILES['qrcode']['error'];
                    $_FILES['userfile']['size'] = $_FILES['qrcode']['size'];
            
                    if ($this->upload->do_upload('userfile')) {
                        $qrcode = $new_filename;
                        // $uploaded_file[] = $this->upload->data();
                    } else {
                        $error = $this->upload->display_errors();
                        echo "失敗: " . $error;
                    }
                }

                $this->product_model->prod_quantity_update($prod_id, $prod_quantity, $prod_quantity_out);

                $delivery_schedule_id = $this->delivery_schedule_model->create(
                                                    $member_id,
                                                    $prod_id,
                                                    $prod_management_number,
                                                    $prod_name,
                                                    $prod_quantity_out,
                                                    $buyer_name,
                                                    $buyer_post_code,
                                                    $buyer_prefecture,
                                                    $buyer_address,
                                                    $buyer_building,
                                                    $buyer_phone,
                                                    $arrival_date,
                                                    $arrival_time,
                                                    $note,
                                                    $delivery_type,
                                                    $member_post_code,
                                                    $member_prefecture,
                                                    $member_address,
                                                    $member_building,
                                                    $member_name,
                                                    $member_phone,
                                                    $in_packet,
                                                    $qrcode
                                                );
                
                $member_address = $this->member_address_model->get_member_addresses($this->session->userdata('member_id'))[0];

                $this->email->from('artemsyvko71@gmail.com', 'オークウィル管理者');
                $this->email->to('fishingamateur71@gmail.com');
                $this->email->cc('artemsyvko71@gmail.com');

                $this->email->subject('【Aucwill】国内発送依頼を承りました  注文番号〇〇');

                $content = 
                    $this->session->userdata('name').'様
                    <br><br>
                    お客様のお手続きにより
                    <br>
                    下記の通り、発送依頼を受け付けました。
                    <br><br><br>
                    注文番号&nbsp;'.$delivery_schedule_id.'
                    <br><br>
                    発送元情報<br>
                    〒'.$member_address['post_code'].$member_address['prefecture'].$member_address['address'].$member_address['building'].'
                    <br><br><br>
                    商品管理番号&nbsp;'.$prod_management_number.'<br>
                    商品名&nbsp;'.$prod_name.'<br>
                    数量&nbsp;'.$prod_quantity_out.'<br><br><br>

                    何卒宜しくお願い申し上げます。          
                    ';
                $this->email->message($content);

                $this->email->send();
                var_dump($content);exit;

                return redirect('stock');
            }
        } else {
            return redirect('stock');
        }
    }

    public function quantity_check()
    {
        $prod_id = $this->input->post['prod_id'];
        $prod_quantity_out = $this->input->post['prod_quantity_out'];

        $prod_quantity = $this->product_model->get_prod_quantity_by_id($prod_id);

        if($prod_quantity < $prod_quantity_out) {
            
        }

        echo 'welcome';
    }

    public function downloadCsv_in_stock() {
        $member_id = $this->session->userdata('member_id');

        $products = $this->product_model->get_stock_products_by_member_id_for_csv_download($member_id);

        $this->generateCsvAndDownload($products);
    }

    private function generateCsvAndDownload($data) {
        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="product-in-stock.csv"');
    
        // Open output stream
        $output = fopen('php://output', 'w');
    
        // Add UTF-8 BOM
        echo "\xEF\xBB\xBF";
    
        // Define your custom header row
        $customHeader = array('商品名', '管理番号', 'ナンバリング', '原価', '数量', 'メモA', 'メモB');
        
        // Write custom header row to CSV
        fputcsv($output, $customHeader);
    
        // Write data to CSV
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
    
        // Close the output stream
        fclose($output);
        exit; // Terminate script
    }

    public function get_product_images_and_measure ()
    {
        $column = $this->input->post('column_name');
        $prod_id = $this->input->post('prod_id');

        if($column == 'measure') {
            $html = $this->measure_model->get_prod_measure_by_prod_id($prod_id);

            $response = array('html' => $html);
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }
    
    public function order_status_change()
    {
        $fee_type = BASIC_FEE_TYPE;
        $fee_amount = BASIC_FEE;

        $member_id = $this->input->post('member_id');
        $schedule_id = $this->input->post('schedule_id');
        $prod_management_number = $this->input->post('prod_management_number');
        $status = $this->input->post('status');

        if($status == '2') {
            $this->billing_model->createTransaction($member_id, $prod_management_number, $fee_type, $fee_amount, $schedule_id);
            
            $member_address = $this->member_address_model->get_member_addresses($member_id)[0];

            $this->email->from('artemsyvko71@gmail.com', 'オークウィル管理者');
            $this->email->to('fishingamateur71@gmail.com');
            $this->email->cc('artemsyvko71@gmail.com');

            $this->email->subject('【Aucwill】 国内発送完了のお知らせ');

            get_prod_serial_by_management_number($prod_management_number);

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
                <br><br><br>
                商品管理番号&nbsp;'.$this->delivery_schedule_model->get_delivery_schedule_by_id($schedule_id)[0]->prod_management_number.'<br>
                品名&nbsp;'.$this->delivery_schedule_model->get_delivery_schedule_by_id($schedule_id)[0]->prod_name.'<br>
                数量&nbsp;'.$this->delivery_schedule_model->get_delivery_schedule_by_id($schedule_id)[0]->prod_quantity_out.'<br>
                ナンバリング&nbsp;'.$this->product_model->get_prod_serial_by_management_number($prod_management_number).'<br><br><br>
                何卒宜しくお願い申し上げます。
                ';
            $this->email->message($content);

            $this->email->send();
            var_dump($content);exit;
        }
        
        echo $this->delivery_schedule_model->update_status($schedule_id, $status);
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
