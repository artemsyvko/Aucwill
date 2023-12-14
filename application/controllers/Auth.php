<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'core/AdminController.php';

class Auth extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        if($this->_login_check(ROLE_COMPANY)){
           redirect('dashboard');
        }
        $this->check_login();
    }

    public function check_login(){
        if ($this->session->userdata('is_logged')) {
            redirect('/dashboard');
        }
    }

    /**
     * Index Page for this controller.
     */
    public function login()
    {
        if ($this->input->method(true) == 'POST') {
            $this->form_validation->set_rules('member_id', '会員番号', 'required|numeric|max_length[6]|trim');
            $this->form_validation->set_rules('password', 'パスワード', 'required|max_length[255]');

            if($this->form_validation->run() == false) {
                $this->load->view('login');
            } else {
                $member_id = $this->input->post('member_id');
                $password = $this->input->post('password');

                $this->load->model('user_model');
                $user = $this->user_model->get_user_by_member_id($member_id);
                
                if (!empty($user) && password_verify($password, $user['password'])) {
                    $isadmin = false;
                    if($member_id == '123456') $isadmin = true;
                    $this->session->set_userdata(array(
                        'user_id' => $user['id'],
                        'member_id' => $user['member_id'],
                        'name' => $user['name'],
                        'company' => $user['company'],
                        'isadmin' => $isadmin,
                        'is_logged' => TRUE
                    ));
                    
                    redirect('/dashboard');
                } else {
                    $this->session->set_flashdata('login_error', '会員番号またはパスワードが間違っています。');
                    $this->load->view('/login');
                }
            }
        } else {
            $this->load->view('/login');
        }        
    }


    public function signup() {
        if ($this->input->method(true) == 'POST') {
            $this->form_validation->set_rules('name', '氏名', 'required|max_length[5]|trim');
            $this->form_validation->set_rules('email', 'メールアドレス', 'required|valid_email|max_length[255]|trim');
            $this->form_validation->set_rules('password', 'パスワード', 'required|max_length[255]');

            if($this->form_validation->run() == false) {
                $this->session->set_flashdata('signup_success', '');
                $this->load->view('signup');
            } else {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $this->load->model('user_model');
                $this->user_model->createUser($name, $email, $password);

                $this->session->set_flashdata('signup_success', 'Registration Successful!');
                $this->load->view('signup');
            }
        } else {
            $this->session->set_flashdata('signup_success', '');
            $this->load->view('signup');
        }
    }


    public function forgotPassword()
    {
        $company = $this->session->userdata('company');

        if(empty($company))
        {
            $this->load->view('forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';

        $this->load->library('form_validation');

        $this->form_validation->set_rules('login_email','メールアドレス','trim|required|valid_email');

        var_dump($this->form_validation->run());die();
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else
        {
            $email = strtolower($this->security->xss_clean($this->input->post('login_email')));

            if($this->company_model->checkEmailExists($email))
            {
                $encoded_email = urlencode($email);

                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();

                $save = $this->company_model->resetPasswordUser($data);

                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->company_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo->name;
                        $data1["email"] = $userInfo->email;
                        $data1["message"] = "パスワードをリセット";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "パスワードリセット用リンクのメールを送信しました。");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "メールの送信に失敗しました。");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "送信中にエラーが発生しました。もう一度お試しください。");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "このメールは登録されていません。");
            }
            //登録されていない、または仮登録のメールアドレスです
            //仮登録の場合は別途登録メールにお送りしている「本登録のお願い」より、本登録の完了をお願いいたします
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);

        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

        $data['email'] = $email;
        $data['activation_code'] = $activation_id;

        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }

    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = strtolower($this->input->post("email"));
        $activation_id = $this->input->post("activation_code");

        $this->load->library('form_validation');

        $this->form_validation->set_rules('password','パスワード','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','パスワード（確認）','trim|required|matches[password]|max_length[20]');

        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');

            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);

            if($is_correct == 1)
            {
                $this->login_model->createPasswordUser($email, $password);

                $status = 'success';
                $message = 'パスワードが正常にリセットされました';
            }
            else
            {
                $status = 'error';
                $message = 'パスワードのリセットに失敗しました';
            }

            setFlashData($status, $message);

            redirect("/login");
        }
    }

}
