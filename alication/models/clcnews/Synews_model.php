<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Synews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($id, $admin_id){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $sql = $this->db->get('innoc_treat');
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('innoc_treat');
        return $sql->result_array();
    }
    //所有
    public function get_synews_num($admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('innoc_treat');
        return $sql;
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('innoc_treat',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('innoc_treat',$data);
    }
	//查
	public function synews($k, $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('addr', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('innoc_treat');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k, $admin_id){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('addr', $k);
		}
        $sql = $this->db->count_all_results('innoc_treat');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('innoc_treat', $data);
        return $sql;
    }
	public function synews_nyname($k){
		$this->db->where('name', $k);
        $query=  $this->db->get('innoc_treat');
        $result = $query->row_array();
        return $result;
	}
	public function get_clc_num($area) {
		$this->db->where('addr_c', $area);
		return $this->db->count_all_results('innoc_treat');
	}
	public function get_volum_num($area) {
		$this->db->where('addr_c', $area);
		$this->db->select_sum('volum');
		$query = $this->db->get('innoc_treat');
		$result = $query->row_array();
		$num = $result['volum'];
		return !empty($num) ? $num : 0;
	}
}

