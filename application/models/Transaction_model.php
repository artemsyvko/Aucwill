<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    protected $table = 'transactions';

    protected $allowedFields = [
        'member_id',
        'fee_type',
        'fee_amount',
        'paid_month',
        'created_at'
    ];

    public function createTransaction($member_id, $fee_type, $fee_amount, $paid_month)
    {
        $current_time = date('Y-m-d H:i:s', time());
        $data = array(
            'member_id' => $member_id,
            'fee_type' => $fee_type,
            'fee_amount' => $fee_amount,
            'paid_month' => $paid_month,
            'created_at' => $current_time
        );
        return $this->db->insert('transactions', $data);
    }

    public function is_paid_this_month($member_id, $month)
    {
        $this->db->where('member_id', $member_id);

        list($givenYear, $givenMonth) = explode('-', $month);        
        $givenYear = date('Y');
        $givenMonth = date('m');

        $this->db->where('YEAR(paid_month)', $givenYear);
        $this->db->where('MONTH(paid_month)', $givenMonth);

        $is_paid = count($this->db->get('transactions')->result_array()) > 0 ? 1 : 0;

        return $is_paid;
    }

    public function get_membership_transaction($member_id)
    {
        $this->db->where('member_id', $member_id);
        $this->db->where('fee_type', MEMBERSHIP_FEE_TYPE);

        $membership_transaction = $this->db->get('transactions')->result_array();

        return $membership_transaction;
    }
}