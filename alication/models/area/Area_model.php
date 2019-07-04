<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Area_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_area($pid = 1534){
        $this->db->where('pid', $pid);
        $query=  $this->db->get('area');
        $result = $query->result_array();
        return $result;
    }
	public function get_solor($name = NULL, $pid = 1534){
		if($name){
			$this->db->like('name', $name);
		}
        $this->db->where('pid', $pid);
        $query=  $this->db->get('area');
        $result = $query->result_array();
        return $result;
    }
    //增加
    /* public function add_area($data = array()){
        $sql = $this->db->insert('area',$data);
        return $sql;
    } */
    //编辑
    public function modify_area($data = array(), $id){
        $this->db->where('id', $id);
        $sql = $this->db->update('area', $data);
        return $sql;
    }
    //id查
    public function get_area_byid($id){
        $this->db->where('id', $id);
        $sql = $this->db->get('area');
        $result = $sql->row_array();
        return $result;
    }
    //title查
    public function get_area_bytitle($title, $pid = 0){
        $this->db->where('name', $title);
		if($pid){
			$this->db->where('pid', $pid);
		}
        $result = $this->db->count_all_results('area');
        return $result;
    }
    //批量增加
    public function addall_area($data = array()){
        $sql = $this->db->insert_batch('area',$data);
        return $sql;
    }
}

