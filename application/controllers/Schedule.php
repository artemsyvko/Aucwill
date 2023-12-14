<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Schedule extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'schedule';
        $this->header['sub_page'] = 'schedule';
        $this->header['title'] = '納品予定連絡';
        $this->load->model('transfer_model');
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
    public function index()
    {
        $this->data['transfers'] = $this->transfer_model->get_transfers();
        $this->load_view_with_menu("schedule/index");
    }

    public function create()
    {
        $member_id = $this->session->userdata('member_id');

        $current_time = date('Ymd', time());
        $typed_current_time = substr($current_time, 2, 9);

        $this->form_validation->set_rules('product_list_ids', 'PRODUCT LIST IDS', 'required');

        $id_string = $this->input->post('product_list_ids');
        if($id_string == ','){
            // product count is 0, and can't make a schedule
            redirect('/schedule');
        }

        // create new schedule to company -- table: schedules
        $transfer_id = $this->input->post('transfer_id');
        $tracking_number = $this->input->post('tracking_number');
        $consecutive_schedule_number = $this->schedule_model->get_consecutive_schedule_number($member_id);
        $management_number = $member_id . $typed_current_time . $consecutive_schedule_number;
        $arrival_date = $this->input->post('arrival_date');
            $arrival_date == "" ? date('Y-m-d', strtotime('+1 day')) : $arrival_date;
        $memo = $this->input->post('memo');
        $member_id = $this->session->userdata('member_id');
        $last_consecutive_product_number = $this->product_model->get_consecutive_product_number($member_id);

        $schedule_id = $this->schedule_model->create($transfer_id, $tracking_number, $management_number, $arrival_date, $memo, $member_id, false);

        // insert products -- table: products
        $id_string1 = substr($id_string, 1, strlen($id_string)-2);
        $product_list_ids = explode(',', $id_string1);
        $products = array();
        foreach($product_list_ids as $key => $product_list_id) {
            array_push($products, array(
                'prod_name' => $this->input->post('prod_name_'.$product_list_id),
                'prod_serial' => $this->input->post('prod_serial_'.$product_list_id),
                'prod_management_number' => $member_id . str_pad($last_consecutive_product_number + $key + 1, 4, '0', STR_PAD_LEFT),
                'prod_price' => 0,
                'prod_quantity' => 0, // current
                'prod_quantity_in' => $this->input->post('prod_quantity_in_'.$product_list_id), // scheduled to company
                'prod_quantity_out' => 0, // scheduled to sale
                'prod_quantity_sold' => 0, // sold
                'is_brand' => $this->input->post('is_brand_'.$product_list_id) == 'on' ? true : false,
                'req_photo' => $this->input->post('req_photo_'.$product_list_id) == 'on' ? true : false,
                'req_measure' => $this->input->post('req_measure_'.$product_list_id) == 'on' ? true : false,
                'req_call' => $this->input->post('req_call_'.$product_list_id) == 'on' ? true : false,
                'memo_a' => '', 
                'memo_b' => '',
                'member_id' => $member_id,
                'schedule_id' => $schedule_id,
                'delivery_schedule_id' => 0,
                'created_at' => date('Y-m-d H:i:s', time()),
            ));
        }
        $member_address = $this->member_address_model->get_member_addresses($this->session->userdata('member_id'))[0];

        // info@aucwill.com
        $this->email->from('artemsyvko71@gmail.com', 'オークウィル管理者');
        $this->email->to('fishingamateur71@gmail.com');
        $this->email->cc('artemsyvko71@gmail.com');

        $this->email->subject('【Aucwill】 国内発送完了のお知らせ');

        $product_info = '';
        foreach($products as $product) {
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

        $prod_ids = $this->product_model->insertMultiple($member_id, $products);

        redirect('/schedulelist/index');
    }

    
    public function fill_from_csv()
    {
        $member_id = $this->session->userdata('member_id');

        $schedule = $this->schedule_model->get_last_csv_schedule($member_id);

        // if there is no CSV schedule $schedule = -1
        if($schedule == -1) {
            redirect('/dashboard');
        }

        $products = $this->product_model->get_scheduled_products($schedule['id']);

        $this->data['schedule'] = $schedule;
        $this->data['products'] = $products;
        $this->data['transfers'] = $this->transfer_model->get_transfers();

        $this->load_view_with_menu("csv/schedule");
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
