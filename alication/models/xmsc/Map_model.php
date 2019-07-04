<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Map_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_area($id){
        $this->db->where('pid', $id);
        $query=  $this->db->get('area');
        $result = $query->result_array();
        return $result;
    }
    public function get_area_id($id){
        $this->db->where('id', $id);
        $query=  $this->db->get('area');
        $result = $query->row_array();
        return $result;
    }
}

