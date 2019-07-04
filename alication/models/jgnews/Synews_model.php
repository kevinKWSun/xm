<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Synews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($id, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id",$id);
        $sql = $this->db->get('mechanism');
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('mechanism');
        return $sql->result_array();
    }
    //所有
    public function get_synews_num($admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('mechanism');
        return $sql;
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('mechanism',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('mechanism',$data);
    }
	//查
	public function synews($k, $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('num', $k);
			$this->db->or_like('addr', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('mechanism');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k, $admin_id = ''){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('num', $k);
			$this->db->or_like('addr', $k);
		}
        $sql = $this->db->count_all_results('mechanism');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('mechanism', $data);
        return $sql;
    }
	public function get_by_num($num, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("num",$num);
        $sql = $this->db->get('mechanism');
        return $sql->row_array();
    }
	public function get_type_num($type, $area) {
		$this->db->where('type', $type);
		$this->db->where('addr_c', $area);
		return $this->db->count_all_results('mechanism');
	}
	public function get_point_num($area) {
		$this->db->where('point', 1);
		$this->db->where('addr_c', $area);
		return $this->db->count_all_results('mechanism');
	}
}

