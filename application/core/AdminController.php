<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class AdminController
 */
class AdminController extends CI_Controller
{
    public $data;
    public $header;
    public $footer;
    public $staff;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct($role = ROLE_GUEST)
    {
        parent::__construct();

        $this->header['page'] = $this->uri->segment(1);
        $this->header['role'] = $role;
        if (!$this->_login_check($role)) {
            if ($role == ROLE_ADMIN) redirect('/admin/login');
            else if ($role == ROLE_COMPANY) redirect('/login');
        } else {
            if ($role == ROLE_ADMIN) $this->header['title'] = '管理画面【管理者用】';
            else if ($role == ROLE_COMPANY) $this->header['title'] = '管理画面【企業用】';

        }
    }

    function logout($role = ROLE_COMPANY)
    {
        // switch ($role) {
        //     case ROLE_ADMIN:
        //         $this->session->set_userdata('admin', '');
        //         redirect('admin/login');
        //         break;
        //     case ROLE_COMPANY:
        //         $this->session->set_userdata('company', '');
        //         redirect('login');
        //         break;
        // }
        $this->session->sess_destroy();
        redirect('login');
    }

    function _login_check($role = ROLE_GUEST)
    {
        if ($role == ROLE_GUEST) return true;
        switch ($role) {
            case ROLE_ADMIN:
                $this->user = $this->session->userdata('admin');
                if (!empty($this->user)) {
                    $this->header['user'] = $this->user;
                    return true;
                }
                break;
            case ROLE_STAFF:
                $this->staff = $this->session->userdata('staff');
                if (!empty($this->staff)) {
                    $this->header['staff'] = $this->staff;
                    return true;
                }
                break;
        }

        return false;
    }

    // function _load_view_only($viewName = "")
    // {

    //     $this->load->view($viewName, $this->data);
    // }

    // function _load_view($viewName = "", $prefix = '')
    // {

    //     $this->load->view($prefix . 'includes/header', $this->header);
    //     $this->load->view($viewName, $this->data);
    //     $this->load->view($prefix . 'includes/footer', $this->footer);
    // }

    // function _load_view_admin($viewName = "")
    // {

    //     $this->load->view('admin/includes/header', $this->header);
    //     $this->load->view($viewName, $this->data);
    //     $this->load->view('admin/includes/footer', $this->footer);
    // }

    // function _search_url($text)
    // {
    //     $index = strpos($text, 'http://');
    //     if ($index !== FALSE) {
    //         $prefix = substr($text, 0, $index);
    //         $real_url = substr($text, $index);
    //         $ref_url = filter_var($real_url, FILTER_SANITIZE_URL);
    //         $href_url = str_replace($ref_url, ('<a href="' . $ref_url . '">' . $ref_url . '</a>'), $real_url);
    //         return $prefix . " " . $href_url;
    //     } else {
    //         $index = strpos($text, 'https://');
    //         if ($index !== FALSE) {
    //             $prefix = substr($text, 0, $index);
    //             $real_url = substr($text, $index);
    //             $ref_url = filter_var($real_url, FILTER_SANITIZE_URL);
    //             $href_url = str_replace($ref_url, ('<a href="' . $ref_url . '">' . $ref_url . '</a>'), $real_url);
    //             return $prefix . " " . $href_url;
    //         }
    //     }
    //     return $text;
    // }

    // protected function debug($val)
    // {
    //     echo '<pre/>';
    //     print_r($val);
    //     die;
    // }


    // /**
    //  * This function used provide the pagination resources
    //  * @param {string} $link : This is page link
    //  * @param {number} $count : This is page count
    //  * @param {number} $perPage : This is records per page limit
    //  * @return {mixed} $result : This is array of records and pagination data
    //  */
    // function _paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT)
    // {
    //     $this->load->library('pagination');

    //     $config ['base_url'] = base_url() . $link;
    //     $config ['total_rows'] = $count;
    //     $config ['uri_segment'] = $segment;
    //     $config ['per_page'] = $perPage;
    //     $config ['num_links'] = 5;
    //     $config ['full_tag_open'] = '<nav><ul class="pagination">';
    //     $config ['full_tag_close'] = '</ul></nav>';
    //     $config ['first_tag_open'] = '<li class="arrow">';
    //     $config ['first_tag_close'] = '</li>';
    //     $config ['prev_tag_open'] = '<li class="arrow">';
    //     $config ['prev_tag_close'] = '</li>';
    //     $config ['next_tag_open'] = '<li class="arrow">';
    //     $config ['next_tag_close'] = '</li>';
    //     $config ['cur_tag_open'] = '<li class="active"><a href="#">';
    //     $config ['cur_tag_close'] = '</a></li>';
    //     $config ['num_tag_open'] = '<li>';
    //     $config ['num_tag_close'] = '</li>';
    //     $config ['last_tag_open'] = '<li class="arrow">';
    //     $config ['last_tag_close'] = '</li>';

    //     $this->pagination->initialize($config);
    //     $page = $config ['per_page'];
    //     $segment = $this->uri->segment($segment);

    //     return array(
    //         "page" => $page,
    //         "segment" => $segment
    //     );
    // }

    function load_view_with_menu($viewName = "", $prefix = "")
    {
        $this->header['contents'] = $this->load->view($viewName, $this->data, true);
        $this->load->view($prefix . 'includes/withmenu', $this->header);
    }
}
