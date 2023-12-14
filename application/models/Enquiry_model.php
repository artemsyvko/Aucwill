<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry_model extends CI_Model
{
    protected $table = 'enquiries';

    protected $allowedFields = [
        'id',
        'member_id',
        'subject',
        'content',
        'parent_id',
        'is_completed',
        'type', // 0: from user, 1: from admin
        'category', // 0,1,2,3,4,5
        'created_at',
        'updated_at'
    ];

    public function create (
        $member_id,
        $subject,
        $content,
        $parent_id,
        $type,
        $category
    ) {
        $current_time = date('Y-m-d H:i:s', time());
        $data = array(
            'member_id' => $member_id,
            'subject' => $subject,
            'content' => $content,
            'parent_id' => $parent_id,
            'is_completed' => 0,
            'type' => $type,
            'category' => $category,
            'created_at' => $current_time,
            'updated_at' => $current_time
        );
        $this->db->set($data);
        return $this->db->insert('enquiries', $data);
    }

    public function parent_enquiry_update ($parent_id) {
        $current_time = date('Y-m-d H:i:s', time());
        
        $this->db->where('id', $parent_id);
        $data = array(
            'updated_at' => $current_time,
            'is_completed' => 0
        );
        $this->db->update('enquiries', $data);
    }

    public function close_ticket ($enquiry_id) {
        $current_time = date('Y-m-d H:i:s', time());

        $this->db->where('id', $enquiry_id);
        $data = array(
            'is_completed' => 1,
            'updated_at' => $current_time
        );

        return $this->db->update('enquiries', $data);
    }

    public function get_parent_enquiries_by_member_id ($member_id) {
        $this->db->where('member_id', $member_id);
        $this->db->where('parent_id', 0);
        $this->db->order_by('updated_at', 'DESC');
        $enquiries = $this->db->get('enquiries')->result_array();

        return $enquiries;
    }

    public function get_parent_enquiries_for_admin () {
        $this->db->where('parent_id', 0);
        $this->db->order_by('is_completed', 'ASC');
        $this->db->order_by('updated_at', 'DESC');
        $enquiries = $this->db->get('enquiries')->result_array();

        return $enquiries;
    }

    public function get_replies ($enquiry_id) {
        $this->db->where('parent_id', $enquiry_id);
        $this->db->order_by('created_at', 'ASC');
        $replies = $this->db->get('enquiries')->result_array();

        return $replies;
    }

}