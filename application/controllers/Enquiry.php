<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Enquiry extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'enquiry';
        $this->header['sub_page'] = 'enquiry';
        $this->header['title'] = 'お問い合わせ';
        $this->load->model('enquiry_model');
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
        $this->data['enquiries'] = $this->enquiry_model->get_parent_enquiries_by_member_id($member_id);

        $this->load_view_with_menu("enquiry/index");
    }

    public function admin_index()
    {
        $this->data['enquiries'] = $this->enquiry_model->get_parent_enquiries_for_admin();

        $this->load_view_with_menu("enquiry/admin_index");
    }

    public function create()
    {
        $member_id = $this->session->userdata('member_id');

        $subject = $this->input->post('subject');
        $content = $this->input->post('content');
        $parent_id = $this->input->post('parent');
        $type = 0; //$this->input->post('type');
        $category = $this->input->post('category');

        $this->enquiry_model->create(
                                    $member_id,
                                    $subject,
                                    $content,
                                    $parent_id,
                                    $type,
                                    $category
                                );

        redirect("enquiry");
    }
    
    public function reply()
    {
        $member_id = $this->session->userdata('member_id');

        $subject = '*';
        $content = $this->input->post('content');
        $parent_id = $this->input->post('parent_id');
        $type = 0;
        if ($this->session->userdata('isadmin')) {
            $type = 1;
        }
        $category = 5;

        $result = $this->enquiry_model->create(
                                            $member_id,
                                            $subject,
                                            $content,
                                            $parent_id,
                                            $type,
                                            $category
                                        );
                                        
        
        if ($parent_id != '0')
            $this->enquiry_model->parent_enquiry_update($parent_id);

        $response = array('result' => $result);

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function close()
    {
        $enquiry_id = $this->input->post('enquiry_id');

        $result = $this->enquiry_model->close_ticket($enquiry_id);
        
        $response = array('result' => $result);

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_replies()
    {
        $enquiry_id = $this->input->post('enquiry_id');
        
        $replies = $this->enquiry_model->get_replies($enquiry_id);
        
        $response = array('replies' => $replies);

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
