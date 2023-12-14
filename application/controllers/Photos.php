<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/core/AdminController.php';

class Photos extends AdminController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(ROLE_STAFF);

        //チャットボット
        $this->header['page'] = 'photos';
        $this->header['sub_page'] = 'photos';
        $this->header['title'] = '撮影済写真';
        $this->load->model('product_model');
        $this->load->model('photo_model');
        $this->check_login();
        $this->load->model('member_address_model');
        $this->check_member_address();

        $this->load->library('zip');
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
        $products = $this->product_model->get_products_for_images($member_id);

        $photos = [];

        foreach($products as $product) {
            $photo = [];
            $photo['prod_name'] = $product['prod_name'];
            $photo['prod_management_number'] = $product['prod_management_number'];
            $photo['prod_serial'] = $product['prod_serial'];
            $photo['path'] = $this->photo_model->get_photo_path($product['id']);
            // array_push($photo, array('prod_name'=>$product['prod_name']));
            // array_push($photo, array('prod_management_number'=>$product['prod_management_number']));
            // array_push($photo, array('prod_serial'=>$product['prod_serial']));
            // array_push($photo, array('path'=>$this->photo_model->get_photo_path($product['id'])));

            if (count($this->photo_model->get_photo_path($product['id'])) > 0) {
                array_push($photos, $photo);
            }
        }
        
        $this->data['photos'] = $photos;
        $this->load_view_with_menu("photos/index");
    }

    function free_download()
    {
        $member_id = $this->session->userdata('member_id');
        $products = $this->product_model->get_products_for_images($member_id);

        foreach($products as $product) {
            $photo['path'] = $this->photo_model->get_photo_path($product['id']);

            foreach($photo['path'] as $path) {
                $filepath = FCPATH.'/uploads/photo/original/'.$path['filename'];
                $this->zip->read_file($filepath);
            }
        }

        $filename = 'AUCWILL-'.date('YmdHis', time()).".zip";
        $this->zip->download($filename);
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
