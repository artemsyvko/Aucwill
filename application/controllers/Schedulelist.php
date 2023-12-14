<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Schedulelist extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'schedulelist';
        $this->header['sub_page'] = 'schedulelist';
        $this->header['title'] = '納品予定一覧';
        $this->load->model('schedule_model');
        $this->load->model('product_model');
        $this->load->model('transfer_model');
        $this->check_login();
        $this->load->model('member_address_model');
        $this->check_member_address();
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

        $schedules = $this->schedule_model->get_schedules($member_id);
        
        $schedules1 = array();

        foreach ($schedules as $schedule) {
            $products = $this->product_model->get_scheduled_products($schedule['id']);
            $transfer = $this->transfer_model->get_transter_name_by_id($schedule['transfer_id']);

            $schedule1 = array(
                'schedule' => $schedule,
                'products' => $products,
                'transfer' => $transfer['company_name'],
            );

            array_push($schedules1, $schedule1);
        }

        $this->data['schedules'] = $schedules1;
        $this->load_view_with_menu("schedulelist/index");
    }


    public function delete_scheduled_product()
    {
        $prod_id = $this->input->post('prod_id');
        $response = array('success' => $this->product_model->delete_scheduled_product($prod_id));
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    public function delete()
    {
        $schedule_id = $this->input->post('schedule_id');

        $result =  $this->schedule_model->delete($schedule_id);
        $response = array('success' => $result);
        if($result) {
            $this->product_model->deleteMultiple($schedule_id);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }


    public function product_update()
    {
        $name = $this->input->post('name');     //$name: product-columName-productId
        $value = $this->input->post('value');

        $prod_id = explode('-', $name)[1];
        $column = explode('-', $name)[0];

        $response = array('success' => $this->product_model->update_in_schedule_list($prod_id, $column, $value));
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
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
