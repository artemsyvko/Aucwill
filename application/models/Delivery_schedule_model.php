<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_schedule_model extends CI_Model{
    protected $table = 'delivery_schedules';

    protected $allowedFields = [
        'member_id',
        'prod_id',
        'prod_management_number',
        'prod_name',
        'prod_quantity_out',
        'buyer_name',
        'buyer_post_code',
        'buyer_prefecture',
        'buyer_address',
        'buyer_building',
        'buyer_phone',
        'arrival_date',
        'arrival_time',
        'note',
        'delivery_type',
        'member_post_code',
        'member_prefecture',
        'member_address',
        'member_building',
        'member_name',
        'member_phone',
        'in_packet',
        'qrcode',
        'status'
    ];

    public function create(
        $member_id,
        $prod_id,
        $prod_management_number,
        $prod_name,
        $prod_quantity_out,
        $buyer_name,
        $buyer_post_code,
        $buyer_prefecture,
        $buyer_address,
        $buyer_building,
        $buyer_phone,
        $arrival_date,
        $arrival_time,
        $note,
        $delivery_type,
        $member_post_code,
        $member_prefecture,
        $member_address,
        $member_building,
        $member_name,
        $member_phone,
        $in_packet,
        $qrcode)
    {
        $current_time = date('Y-m-d H:i:s', time());
        $data = array(
            'member_id' => $member_id,
            'prod_id' => $prod_id,
            'prod_management_number' => $prod_management_number,
            'prod_name' => $prod_name,
            'prod_quantity_out' => $prod_quantity_out,
            'buyer_name' => $buyer_name,
            'buyer_post_code' => $buyer_post_code,
            'buyer_prefecture' => $buyer_prefecture,
            'buyer_address' => $buyer_address,
            'buyer_building' => $buyer_building,
            'buyer_phone' => $buyer_phone,
            'arrival_date' => $arrival_date,
            'arrival_time' => $arrival_time,
            'note' => $note,
            'delivery_type' => 0,
            'member_post_code' => $member_post_code,
            'member_prefecture' => $member_prefecture,
            'member_address' => $member_address,
            'member_building' => $member_building,
            'member_name' => $member_name,
            'member_phone' => $member_phone,
            'in_packet' => $in_packet,
            'qrcode' => $qrcode,
            'created_at' => $current_time,
            'created_at' => $current_time
        );
        $this->db->set($data);
        return $this->db->insert('delivery_schedules', $data);
    }

    public function get_delivery_schedules()
    {
        // $this->db->where('');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('delivery_schedules')->result_array();
    }

    public function update_status($schedule_id, $status)
    {
        $this->db->where('id', $schedule_id);
        $data = array('status'=> $status);

        return $this->db->update('delivery_schedules', $data);
    }

    public function get_delivery_schedule_by_id($schedule_id)
    {
        $filter = array(
            'schedule_id' => $schedule_id
        );
        return $this->db->get_where('schedules', $filter)->result_array();
    }

    public function get_delivery_schedules_by_status($member_id, $status)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('member_id', $member_id);
        $this->db->where('status', $status);

        return $this->db->get('delivery_schedules')->result_array();
    }

    public function get_completed_order_num($member_id)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('member_id', $member_id);
        $this->db->where('status', 2);

        return count($this->db->get('delivery_schedules')->result_array());
    }

    public function get_delivery_schedules_for_print()
    {
        $this->db->order_by('created_at', 'DESC');
        // $this->db->where('DATE(created_at)', date('Y-m-d'));
        $this->db->where('status', 0);

        return $this->db->get('delivery_schedules')->result_array();
    }
}