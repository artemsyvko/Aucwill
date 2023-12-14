<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Billing_model extends CI_Model
{
    protected $table = 'billings';

    protected $allowedFields = [
        'member_id',
        'prod_management_number',
        'fee_type',
        'fee_amount',
        'reference_id',
        'created_at'
    ];

    public function createTransaction($member_id, $prod_management_number, $fee_type, $fee_amount, $reference_id)
    {
        $current_time = date('Y-m-d H:i:s', time());
        $data = array(
            'member_id' => $member_id,
            'prod_management_number' => $prod_management_number,
            'fee_type' => $fee_type,
            'fee_amount' => $fee_amount,
            'reference_id' => $reference_id,
            'created_at' => $current_time
        );
        return $this->db->insert('billings', $data);
    }

    public function get_billings_by_month($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);
        
        $this->db->where('YEAR(created_at)', $givenYear);
        $this->db->where('MONTH(created_at)', $givenMonth);

        return $this->db->get('billings')->result_array();
    }

    public function get_monthly_fee($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);

        // Build the query
        $this->db->select_sum('fee_amount');
        $this->db->where('YEAR(created_at)', $givenYear);
        $this->db->where('MONTH(created_at)', $givenMonth);
        $query = $this->db->get('billings'); // Replace with your actual table name

        // Get the result
        $result = $query->row();
        $sum = $result->fee_amount;
        
        return $sum;
    }
    
    public function count_shipping($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);
        
        $this->db->where('fee_type', BASIC_FEE_TYPE);
        $this->db->where('YEAR(created_at)', $givenYear);
        $this->db->where('MONTH(created_at)', $givenMonth);
        $count = count($this->db->get('billings')->result_array());
        
        return $count;
    }

    public function count_shoot($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);
        
        $this->db->where('fee_type', SHOOT_FEE_TYPE);
        $this->db->where('YEAR(created_at)', $givenYear);
        $this->db->where('MONTH(created_at)', $givenMonth);
        $count = count($this->db->get('billings')->result_array());
        
        return $count;
    }

    public function count_measure($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);
        
        $this->db->where('fee_type', MEASURE_FEE_TYPE);
        $this->db->where('YEAR(created_at)', $givenYear);
        $this->db->where('MONTH(created_at)', $givenMonth);
        $count = count($this->db->get('billings')->result_array());
        
        return $count;
    }

    public function count_call($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);
        
        $this->db->where('fee_type', CALL_FEE_TYPE);
        $this->db->where('YEAR(created_at)', $givenYear);
        $this->db->where('MONTH(created_at)', $givenMonth);
        $count = count($this->db->get('billings')->result_array());
        
        return $count;
    }
}