<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Overseas extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'overseas';
        $this->header['sub_page'] = 'overseas';
        $this->header['title'] = '海外発送一覧';
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
        $sent = $this->input->get_post('sent');
        if (empty($sent)) {
            $sent = 0;
        }
        $this->data['sent'] = $sent;  

        $this->load_view_with_menu("overseas/index");
    }

    public function export()
    { 
        $sent = $this->input->get_post('sent');
        if (empty($sent)) {
            $sent = 0;
        }
        $this->data['sent'] = $sent;  
        $this->load_view_with_menu("overseas/index");
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
