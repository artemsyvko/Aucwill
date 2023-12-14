<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Domestic extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'domestic';
        $this->header['sub_page'] = 'domestic';
        $this->header['title'] = '国内発送一覧';
        $this->load->model('product_model');
        $this->load->model('photo_model');
        $this->load->model('measure_model');
        $this->load->model('delivery_schedule_model');
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
        $pending_delivery_schedules = $this->delivery_schedule_model->get_delivery_schedules_by_status($member_id, 1);

        $schedules = [];

        if(count($pending_delivery_schedules) > 0) {
            foreach($pending_delivery_schedules as $schedule) {
                $first_image = $this->photo_model->get_prod_image_by_prod_id($schedule['prod_id']);
                $prod_measure = $this->measure_model->get_prod_measure_by_prod_id_for_domestic($schedule['prod_id']);

                array_push($schedules, array(
                                            'schedule' => $schedule,
                                            'img_path' => $first_image,
                                            'prod_measure' => $prod_measure
                                        ));
            }
        }

        $this->data['schedules'] = $schedules;

        $this->load_view_with_menu("domestic/index");
    }

    public function orders_sent()
    {
        $member_id = $this->session->userdata('member_id');
        $pending_delivery_schedules = $this->delivery_schedule_model->get_delivery_schedules_by_status($member_id, 2);

        $schedules = [];

        if(count($pending_delivery_schedules) > 0) {
            foreach($pending_delivery_schedules as $schedule) {
                $first_image = $this->photo_model->get_prod_image_by_prod_id($schedule['prod_id']);
                $prod_measure = $this->measure_model->get_prod_measure_by_prod_id_for_domestic($schedule['prod_id']);

                array_push($schedules, array(
                                            'schedule' => $schedule,
                                            'img_path' => $first_image,
                                            'prod_measure' => $prod_measure
                                        ));
            }
        }

        $this->data['schedules'] = $schedules;

        $this->load_view_with_menu("domestic/sent");
    }

    public function export()
    { 
        $sent = $this->input->get_post('sent');
        if (empty($sent)) {
            $sent = 0;
        }
        $this->data['sent'] = $sent;  
        $this->load_view_with_menu("domestic/index");
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
