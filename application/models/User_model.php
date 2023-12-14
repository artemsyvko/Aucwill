<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
    protected $table = 'users';

    protected $allowedFields = [
        'name',
        'email',
        'company',
        'status',
        'member_id',
        'password',
        'created_at',
        'updated_at'
    ];

    public function createUser($name, $email, $company, $password) {
        $current_time = date('Y-m-d H:i:s', time());
        $member_id = $this->generateMemberID(100000, 999999);

        $data = array(
            'name' => $name,
            'email' => $email,
            'company' => $company,
            'status' => false,
            'member_id' => $member_id,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'created_at' => $current_time,
            'updated_at' => $current_time
        );

        $data['role'] = '0';

        $this->db->set($data);

        return $this->db->insert('users', $data);
    }

    public function get_user_by_member_id($member_id) {
        return $this->db->get_where('users', array('member_id' => $member_id))->row_array();
    }

    public function generateMemberID($from, $to) {
        $unique_id = mt_rand($from, $to);
        
        while ($this->checkIfIDExists($unique_id)) {
            $unique_id = mt_rand(100000, 999999);
        }
        return $unique_id;
    }

    public function get_member_registered_date($member_id) {
        $this->db->where('member_id', $member_id);
        return $this->db->get('users')->row_array()['created_at'];
    }

    public function is_new($email) {
        $this->db->where('email', $email);
        return $this->db->get('users')->row_array();
    }

    public function is_new_for_update($email, $member_id)
    {
        $this->db->where('member_id!=', $member_id);
        $this->db->where('email', $email);
        return $this->db->get('users')->row_array();
    }

    public function get_users() {
        return $this->db->get('users')->result_array();
    }
    
    public function udpateUser($member_id, $name, $email, $company)
    {
        $this->db->where('member_id', $member_id);
        $data = array(
            'name' => $name,
            'email' => $email,
            'company' => $company
        );
        $result = $this->db->update('users', $data);
    }

    public function checkIfIDExists($id) {
        if (!empty($this->db->get_where('users', array('member_id' => $id))->row_array())) {
            return true;
        } else {
            return false;
        }
    }
}