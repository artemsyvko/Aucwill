<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Users extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'user';
        $this->header['sub_page'] = 'user';
        $this->header['title'] = '会員管理';
        $this->load->model('member_address_model');
        $this->load->model('user_model');
        $this->check_login();
        $this->check_role();
    }

    public function check_login(){
        if (!$this->session->userdata('is_logged')) {
            redirect('/login');
        }
    }

    public function check_role(){
        if (!$this->session->userdata('isadmin')) {
            redirect('/dashboard');
        }
    }

    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $users = $this->user_model->get_users();
        $this->data['users'] = $users;
        $this->load_view_with_menu('admin/users');
    }

    public function create()
    {
        if ($this->input->method(true) == 'POST') {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $company = $this->input->post('company');
            // $password = $this->input->post('password');
            $password = '1234567890!';

            $is_new = empty($this->user_model->is_new($email));

            if($is_new) {
                $this->data['is_new'] = $is_new;
                $this->user_model->createUser($name, $email, $company, $password);

                $this->data['is_new'] = true;
                $this->data['created'] = $name;
                $this->load_view_with_menu('admin/createUser');
            } else {
                $this->data['name'] = $name;
                $this->data['email'] = $email;
                $this->data['company'] = $company;

                $this->data['is_new'] = false;
                $this->data['created'] = false;
                $this->load_view_with_menu('admin/createUser');
            }
        } else {
            $this->data['is_new'] = true;
            $this->data['created'] = false;
            $this->load_view_with_menu('admin/createUser');
        }
    }

    public function update()
    {
        if ($this->input->method(true) == 'POST') {
            $member_id = $this->input->post('member_id');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $company = $this->input->post('company');
            // $password = $this->input->post('password');
            // $password = '1234567890!';

            $is_new_for_udpate = empty($this->user_model->is_new_for_update($email, $member_id));

            if($is_new_for_udpate) {
                $this->data['is_new'] = true;
                $this->user_model->udpateUser($member_id, $name, $email, $company);

                $this->data['is_new'] = true;
                $this->data['updated'] = $name;
                redirect('uuser?member='.$member_id);
            } else {
                $this->data['member_id'] = $member_id;
                $this->data['name'] = $name;
                $this->data['email'] = $email;
                $this->data['company'] = $company;

                $this->data['is_new'] = false;
                $this->data['updated'] = false;
                redirect('uuser?member='.$member_id);
            }
        } else {
            $member_id = $this->input->get('member');
            $member = $this->user_model->get_user_by_member_id($member_id);
            
            $this->data['member_id'] = $member_id;
            $this->data['name'] = $member['name'];
            $this->data['email'] = $member['email'];
            $this->data['company'] = $member['company'];

            $this->data['is_new'] = true;
            $this->data['updated'] = false;
            $this->load_view_with_menu('admin/editUser');
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = '404エラー';

        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>
