<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Measure_model extends CI_Model{
    protected $table = 'prod_measures';

    protected $allowedFields = [
        'prod_id',
        'content',
        'created_at'
    ];

    public function save_measure($prod_id, $content) {
        $current_time = date('Y-m-d H:i:s', time());
        $data = array(
            'prod_id' => $prod_id,
            'content' => $content,
            'created_at' => $current_time
        );
        $this->db->set($data);
        $this->db->insert('prod_measures', $data);
    }

    public function get_prod_measure_by_prod_id($prod_id) {
        $this->db->where('prod_id', $prod_id);
        $prod_measures = $this->db->get('prod_measures')->result_array();

        $html = '';

        if (count($prod_measures) > 0) {
            $html .= '<ul>';
            $html .= '<li><b>商品寸法</b></li>';

            foreach($prod_measures as $prod_measure) {
                $html .= '<li>'.$prod_measure['content'].'</li>';
            }

            $html .= '</ul>';
        }

        return $html;
    }

    public function get_prod_measure_by_prod_id_for_domestic($prod_id) {
        $this->db->where('prod_id', $prod_id);
        $prod_measures = $this->db->get('prod_measures')->result_array();

        $html = '';

        if (count($prod_measures) > 0) {
            $html .= '<ul>';

            foreach($prod_measures as $prod_measure) {
                $html .= '<li>'.$prod_measure['content'].'</li>';
            }

            $html .= '</ul>';
        }

        return $html;
    }
}