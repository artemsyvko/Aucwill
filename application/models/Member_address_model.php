<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Member_address_model extends CI_Model
{
    protected $table = 'member_addresses';

    protected $allowedFields = [
        'id',
        'member_id',
        'name',
        'post_code',
        'prefecture',
        'address',
        'building',
        'phone',
        'delivery_type',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
    ];


    public function create($delivery_type, $post_code, $prefecture, $address, $building, $name, $phone, $member_id) {
        $current_time = date('Y-m-d H:i:s', time());

        $data = array(
            'member_id' => $member_id,
            'name' => $name,
            'post_code' => $post_code,
            'prefecture' => $prefecture,
            'address' => $address,
            'building' => $building,
            'phone' => $phone,
            'delivery_type' => $delivery_type == '国内' ? 0 : 1,
            'is_active' => true,
            'is_deleted' => false,
            'created_at' => $current_time,
            'updated_at' => $current_time
        );

        return $this->db->insert('member_addresses', $data);
    }


    public function get_member_addresses($member_id)
    {
        $filter = array(
            'member_id' => $member_id,
            'is_deleted' => false,
        );
        return $this->db->get_where('member_addresses', $filter)->result_array();
    }

    
    public function get_member_address_by_member_id($member_id) {
        $filter = array(
            'member_id' => $member_id,
        );
        return $this->db->get_where('member_addresses', $filter)->row_array();
    }


    public function get_member_address($address_id)
    {
        return $this->db->get_where('member_addresses', array('id' => $address_id))->row_array();
    }


    public function update($address_id, $member_id, $name, $post_code, $delivery_type, $prefecture, $address, $building, $phone)
    {
        $current_time = date('Y-m-d H:i:s', time());

        $id = $address_id;
        $updated_member_address = array(
            'member_id' => $member_id,
            'name' => $name,
            'post_code' => $post_code,
            'prefecture' => $prefecture,
            'address' => $address,
            'building' => $building,
            'phone' => $phone,
            'delivery_type' => 0,
            'updated_at' => $current_time,
        );

        $this->db->where('id', $id);
        $this->db->update('member_addresses', $updated_member_address);
    }


    public function delete($address_id)
    {
        $current_time = date('Y-m-d H:i:s', time());

        $id = $address_id;
        $deleted_member_address = array(
            'is_deleted' => true,
            'updated_at' => $current_time,
        );

        $this->db->where('id', $id);
        $this->db->update('member_addresses', $deleted_member_address);
    }

    public function permanentDeleteSender($sender_id)
    {
        $this->db->delete('senders', array('id' => $sender_id));

        if ($this->db->affected_rows() > 0) {
            echo "Sender deleted successfully";
        } else {
            echo "Unable to delete sender. Sender may not exist.";
        }
    }
}