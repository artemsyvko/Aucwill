<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Photo_model extends CI_Model{
    protected $table = 'prod_photos';

    protected $allowedFields = [
        'prod_id',
        'filename',
        'created_at'
    ];

    public function save_photos($prod_id, $filename_list) {
        $current_time = date('Y-m-d H:i:s', time());
        foreach ($filename_list as $file) {
            $data = array(
                'prod_id' => $prod_id,
                'filename' => $file['file_name'],
                'created_at' => $current_time
            );
            $this->db->set($data);
            $this->db->insert('prod_photos', $data);            
        }
    }

    public function get_photo_path($prod_id) {
        $this->db->where('prod_id', $prod_id);
        $photos = $this->db->get('prod_photos')->result_array();
        return $photos;
    }

    public function get_prod_image_by_prod_id($prod_id) {
        $this->db->where('prod_id', $prod_id);
        $image_paths = $this->db->get('prod_photos')->result_array();
        if(count($image_paths) > 0) {
            $image_path = 'uploads/photo/' . $image_paths[0]['filename'];
        } else {
            $image_path = 'assets/images/noImage.jpg';
        }
        return $image_path;
    }
}