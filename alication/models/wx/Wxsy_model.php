<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wxsy_model extends CI_model {
	public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	public function add($data) {
		$this->db->insert('scatter_record', $data);
		$sql = $this->db->insert_id();
		return $sql;
	}
	public function lists($page = 10, $per_page = 1, $admin_id = array()) {
		$this->db->where_in('admin_id', $admin_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit($page, $per_page);
		$sql = $this->db->get('scatter_record');
		return $sql->result_array();
	}
	public function get_lnum($admin_id = array()){
		$this->db->where_in('admin_id', $admin_id);
        return  $this->db->count_all_results('scatter_record');
    }
	public function get_l($id, $admin_id){
		$this->db->where("admin_id",$admin_id);
        $this->db->where("id",$id);
        $sql = $this->db->get('scatter_record');
        return $sql->row_array();
    }
}