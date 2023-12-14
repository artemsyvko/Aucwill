<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
    protected $table = 'products';

    protected $allowedFields = [
        'id',
        'prod_name',
        'prod_serial',
        'prod_management_number',
        'prod_price',
        'prod_quantity',
        'prod_quantity_in',
        'prod_quantity_out',
        'prod_quantity_sold',
        'is_brand',
        'req_photo',
        'req_measure',
        'req_call',
        'memo_a',
        'memo_b',
        'member_id',
        'schedule_id',
        'delivery_schedule_id',
        'created_at',
    ];

    public function insertMultiple($member_id, $products)
    {
        $this->db->insert_batch('products', $products);
    }

    public function get_scheduled_products($schedule_id)
    {
        $filter = array(
            'schedule_id' => $schedule_id,
            'is_deleted' => false,
        );
        return $this->db->get_where('products', $filter)->result_array();
    }


    public function delete_scheduled_product($prod_id)
    {
        $id = $prod_id;
        $deleted_product = array(
            'is_deleted' => true
        );

        $this->db->where('id', $id);
        return $this->db->update('products', $deleted_product);
    }


    public function deleteMultiple($schedule_id)
    {
        $this->db->where('schedule_id', $schedule_id);
        $this->db->where('is_deleted', false);
        $data = array(
            'is_deleted' => true,
        );
        $this->db->update('products', $data);
    }

    
    public function delete($prod_id)
    {
        $this->db->where('id', $prod_id);
        $data = array(
            'is_deleted' => true,
        );
        $this->db->update('products', $data);
    }


    public function update_in_schedule_list($prod_id, $column, $value)
    {
        $data = array(
            $column => $value
        );
        $this->db->where('id', $prod_id);
        return $this->db->update('products', $data);
    }


    public function update_product_in_schedule($prod_id, $prod_name, $prod_serial, $prod_quantity_in, $req_photo, $req_measure, $req_call)
    {
        $this->db->where('id', $prod_id);
        $this->db->set('prod_name', $prod_name);
        $this->db->set('prod_serial', $prod_serial);
        $this->db->set('prod_quantity_in', $prod_quantity_in);
        $this->db->set('req_photo', $req_photo);
        $this->db->set('req_measure', $req_measure);
        $this->db->set('req_call', $req_call);
        return $this->db->update('products');
    }

    public function update_checkbox_status($prod_id, $column, $checked)
    {
        $val = 2;
        if($checked == 'true') { $val = 2; }
        if($checked == 'false') { $val = 1; }
        $data = array($column => $val);
        $this->db->where('id', $prod_id);
        return $this->db->update('products', $data);
    }

    public function get_consecutive_product_number($member_id)
    {
        $filter = array(
            'member_id' => $member_id,
            // 'is_deleted' => 0
        );
        $result = $this->db->get_where('products', $filter)->result_array();
        
        return count($result);
    }

    public function get_products_by_member_id ($member_id)
    {
        $filter = array(
            'member_id' => $member_id,
            'is_deleted' => false
        );
        $result =  $this->db->get_where('products', $filter)->result_array();

        return $result;
    }


    public function get_stock_products_by_member_id ($member_id)
    {
        $this->db->where('member_id', $member_id);
        $this->db->where('is_deleted', 0);
        $this->db->where('prod_quantity >', 0);
        $products = $this->db->get('products')->result_array();

        return $products;
    }

    
    public function get_stock_products_by_member_id_for_csv_download ($member_id)
    {
        $this->db->select(['prod_name', 'prod_management_number', 'prod_serial', 'prod_price', 'prod_quantity', 'memo_a', 'memo_b']);
        $this->db->where('member_id', $member_id);
        $this->db->where('is_deleted', 0);
        $this->db->where('prod_quantity >', 0);
        $products = $this->db->get('products')->result_array();

        return $products;
    }

    public function get_prod_serial_by_management_number($prod_management_number)
    {
        $this->db->select(['prod_serial']);
        $this->db->where('prod_management_number', $prod_management_number);
        $products = $this->db->get('products')->result_array();

        return $products;
    }

    public function update_prod_management_number($member_id, $schedule_id, $last_consecutive_product_number)
    {
        $filter = array(
            'member_id' => $member_id,
            'schedule_id' => $schedule_id
        );
        $new_products = $this->db->get_where('products', $filter)->result_array();
        
        foreach($new_products as $key => $product) {
            $this->db->where('id', $product['id']);
            $this->db->set('prod_management_number', $member_id . str_pad($last_consecutive_product_number + $key + 1, 4, '0', STR_PAD_LEFT));
            $this->db->update('products');
        }
    }

    public function update_prod_quantities_after_schedule($schedule_id)
    {
        // Update prod_quantity using prod_quantity_in
        $this->db->set('prod_quantity', 'prod_quantity_in', FALSE);
        $this->db->where('schedule_id', $schedule_id);
        $this->db->update('products');

        // Update prod_quantity_in as 0
        $this->db->set('prod_quantity_in', 0);
        $this->db->where('schedule_id', $schedule_id);
        $this->db->update('products');
    }

    public function get_products_for_images($member_id)
    {
        //  7 day limit
        $this->db->where('member_id', $member_id);
        $this->db->where('created_at >', date('Y-m-d H:i:s', strtotime('-7 days')));
        $this->db->where('is_deleted', 0);
        $this->db->where('req_photo', 2);
        $this->db->where('prod_quantity_in', 0);
        $products = $this->db->get('products')->result_array();

        return $products;
    }

    public function update_product_in_stock($prod_id, $column, $value)
    {
        if($column == 'prod_measure') {
            // $data = array(
            //     'content' => $value
            // );
            // $this->db->where('prod_id', $prod_id);
            // return $this->db->update('prod_measures', $data);
            return true;
        } else {
            $data = array(
                $column => $value
            );
            $this->db->where('id', $prod_id);
            return $this->db->update('products', $data);
        }
    }

    public function get_product_by_id ($prod_id)
    {
        $this->db->where('id', $prod_id);
        return $this->db->get('products')->result_array();
    }

    public function get_prod_quantity_by_id($prod_id)
    {
        $this->db->where('id', $prod_id);
        return $this->db->get('products')->result_array()[0]['prod_quantity'];
    }

    public function prod_quantity_update($prod_id, $prod_quantity, $prod_quantity_out)
    {
        $this->db->where('id', $prod_id);
        $data = array(
            'prod_quantity' => $prod_quantity - $prod_quantity_out,
            'prod_quantity_out' => $prod_quantity_out
        );
        $this->db->update('products', $data);
    }
}