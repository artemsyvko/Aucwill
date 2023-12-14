<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_billing_view_model extends CI_Model
{
    public function get_billing_view_data()
    {
        return $this->db->get('user_billings_view')->result_array();
    }
}