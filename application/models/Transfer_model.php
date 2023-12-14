<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_model extends CI_Model
{
    protected $table = 'transfers';

    protected $allowedFields = [
        'id',
        'company_name'
    ];

    public function get_transfers()
    {
        return $this->db->get('transfers')->result_array();
    }

    public function get_transter_name_by_id($transfer_id)
    {
        $filter = array(
            'id' => $transfer_id,
        );
        return $this->db->get_where('transfers', $filter)->row_array();
    }
}