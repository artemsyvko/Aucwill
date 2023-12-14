<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Address extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'address';
        $this->header['sub_page'] = 'address';
        $this->header['title'] = '発送元登録';
        $this->load->model('member_address_model');
        $this->check_login();
    }

    public function check_login(){
        if (!$this->session->userdata('is_logged')) {
            redirect('/login');
        }
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $member_id = $this->session->userdata('member_id');

        $this->data['member_addresses'] = $this->member_address_model->get_member_addresses($member_id);
        $this->load_view_with_menu('address/index');
    }

    public function create()
    {
        if ($this->input->method(true) == 'POST') {
            $this->form_validation->set_rules('delivery_type', '種別', 'required|max_length[255]');
            $this->form_validation->set_rules('post_code', '郵便番号', 'required|max_length[255]');
            $this->form_validation->set_rules('prefecture', '都道府県', 'required|max_length[255]');
            $this->form_validation->set_rules('address', '住所', 'required|max_length[255]');
            $this->form_validation->set_rules('building', 'アパート名、会社名など', 'max_length[255]');
            $this->form_validation->set_rules('name', 'お名前', 'required|max_length[255]');
            $this->form_validation->set_rules('phone', '電話番号', 'required|max_length[255]');

            if($this->form_validation->run() == false) {
                $this->data['delivery_type'] = $this->input->post('delivery_type');
                $this->data['post_code'] = $this->input->post('post_code');
                $this->data['prefecture'] = $this->input->post('prefecture');
                $this->data['address'] = $this->input->post('address');
                $this->data['building'] = $this->input->post('building');
                $this->data['name'] = $this->input->post('name');
                $this->data['phone'] = $this->input->post('phone');

                $this->load_view_with_menu("address/create");
            } else {
                $delivery_type = $this->input->post('delivery_type');
                $post_code = $this->input->post('post_code');
                $prefecture = $this->input->post('prefecture');
                $address = $this->input->post('address');
                $building = $this->input->post('building');
                $name = $this->input->post('name');
                $phone = $this->input->post('phone');
                
                $member_id = $this->session->userdata('member_id');

                $this->member_address_model->create($delivery_type, $post_code, $prefecture, $address, $building, $name, $phone, $member_id);

                redirect('address/index');
            }
        } else {
            $this->load_view_with_menu("address/create");
        }
    }


    public function edit($address_id)
    {
        $this->data['member_address'] = $this->member_address_model->get_member_address($address_id);
        $this->load_view_with_menu('address/edit');
    }


    public function update()
    {
        $this->form_validation->set_rules('address_id', 'SENDER_ID', 'required|max_length[255]');
        $this->form_validation->set_rules('delivery_type', '種別', 'required|max_length[255]');
        $this->form_validation->set_rules('post_code', '郵便番号', 'required|max_length[255]');
        $this->form_validation->set_rules('prefecture', '都道府県', 'required|max_length[255]');
        $this->form_validation->set_rules('address', '住所', 'required|max_length[255]');
        $this->form_validation->set_rules('building', 'アパート名、会社名など', 'max_length[255]');
        $this->form_validation->set_rules('name', 'お名前', 'required|max_length[255]');
        $this->form_validation->set_rules('phone', '電話番号', 'required|max_length[255]');

        if($this->form_validation->run() == false) {
            $address_id = $this->input->post('address_id');
            redirect("address/".$address_id."/edit");
        } else {
            $address_id = $this->input->post('address_id');
            $delivery_type = $this->input->post('delivery_type');
            $post_code = $this->input->post('post_code');
            $prefecture = $this->input->post('prefecture');
            $address = $this->input->post('address');
            $building = $this->input->post('building');
            $name = $this->input->post('name');
            $phone = $this->input->post('phone');
            
            $member_id = $this->session->userdata('member_id');
            
            $this->member_address_model->update($address_id, $member_id, $name, $post_code, $delivery_type, $prefecture, $address, $building, $phone);

            redirect('/address/index');
        }
    }


    public function delete($sender_id)
    {
        $this->member_address_model->delete($sender_id);
        redirect('/address/index');
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
