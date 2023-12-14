<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Dashboard extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'dashboard';
        $this->header['sub_page'] = 'dashboard';
        $this->header['title'] = 'ホーム';
        $this->load->model('delivery_schedule_model');
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

        $this->data['completed_order_num'] = $this->delivery_schedule_model->get_completed_order_num($member_id);

        $this->load_view_with_menu("dashboard/index");
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
