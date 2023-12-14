<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
    protected $table = 'schedules';

    protected $allowedFields = [
        'transfer_id',
        'tracking_number',
        'management_number',
        'arrival_date',
        'memo',
        'member_id',
        'is_completed',
        'is_deleted',
        'is_csv_schedule',
        'created_at',
        'updated_at'
    ];


    public function create($transfer_id, $tracking_number, $management_number, $arrival_date, $memo, $member_id, $is_csv_schedule)
    {
        $current_time = date('Y-m-d H:i:s', time());

        $data = array(
            'transfer_id' => $transfer_id,
            'tracking_number' => $tracking_number,
            'management_number' => $management_number,
            'arrival_date' => $arrival_date == "" ? date('Y-m-d', strtotime('+1 day')) : $arrival_date,
            'memo' => $memo,
            'member_id' => $member_id,
            'is_completed' => false,
            'is_deleted' => false,
            'is_csv_schedule' => $is_csv_schedule,
            'created_at' => $current_time,
            'updated_at' => $current_time
        );

        $this->db->insert('schedules', $data);
        
        // retrieving schedule id
        return $this->db->insert_id();
    }


    public function get_schedules($member_id)
    {
        $filter = array(
            'member_id' => $member_id,
            'is_completed' => false,
            'is_deleted' => false,
        );
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('schedules', $filter)->result_array();
    }


    public function delete($schedule_id)
    {
        $current_time = date('Y-m-d H:i:s', time());

        $deleted_schedule = array(
            'is_deleted' => true,
            'updated_at' => $current_time,
        );
        
        $this->db->where('id', $schedule_id);
        return $this->db->update('schedules', $deleted_schedule);
    }


    public function get_last_schedule($member_id)
    {
        $filter = array(
            'member_id' => $member_id,
            'is_completed' => false,
            'is_deleted' => false,
        );
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('schedules', $filter)->result_array()[0];
    }


    public function get_last_csv_schedule($member_id)
    {
        $filter = array(
            'member_id' => $member_id,
            'is_completed' => false,
            'is_deleted' => false,
            'is_csv_schedule' => true,
        );
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get_where('schedules', $filter)->row_array();
        return ($result) ? $result : -1;
    }


    public function update_csv_schedule($schedule_id, $transfer_id, $tracking_number, $management_number, $arrival_date, $memo, $member_id)
    {
        $updated_schedule = array(
            'transfer_id' => $transfer_id,
            'tracking_number' => $tracking_number,
            'management_number' => $management_number,
            'arrival_date' => $arrival_date == "" ? date('Y-m-d', strtotime('+1 day')) : $arrival_date,
            'memo' => $memo,
            'member_id' => $member_id,
            'is_csv_schedule' => 2
        );

        $this->db->where('id', $schedule_id);
        $this->db->where('is_completed', 0);
        $this->db->where('is_deleted', 0);
        return $this->db->update('schedules', $updated_schedule);
    }


    public function get_all_schedules()
    {
        $filter = array(
            'is_completed' => false,
            'is_deleted' => false,
        );
        $this->db->order_by('id', 'DESC');
        return $this->db->get_where('schedules', $filter)->result_array();
    }


    public function complete_schedule($schedule_id)
    {
        $complete_schedule = array(
            'is_completed' => true
        );

        $this->db->where('id', $schedule_id);
        return $this->db->update('schedules', $complete_schedule);
    }

    public function get_consecutive_schedule_number($member_id)
    {
        $filter = array(
            'member_id' => $member_id
        );
        $result = $this->db->get_where('schedules', $filter)->result_array();
        
        return str_pad(count($result)+1, 3, '0', STR_PAD_LEFT);
    }
}
