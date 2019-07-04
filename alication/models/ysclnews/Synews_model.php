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
        $sql = $this->db->get('vehicle');
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('vehicle');
        return $sql->result_array();
    }
    //所有
    public function get_synews_num($admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('vehicle');
        return $sql;
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('vehicle',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('vehicle',$data);
    }
	//查
	public function synews($k, $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('num', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('vehicle');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k, $admin_id){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('num', $k);
		}
        $sql = $this->db->count_all_results('vehicle');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('vehicle', $data);
        return $sql;
    }
	public function synews_nyname($k){
		$this->db->where('num', $k);
        $query=  $this->db->get('vehicle');
        $result = $query->row_array();
        return $result;
	}
	//批量插
	public function addall_s($data = array()){
        $sql = $this->db->insert_batch('vehicle_c',$data);
        return $sql;
    }
	//删除
	public function del_s($kid){
		$this->db->where('kid', $kid);
        $sql = $this->db->delete('vehicle_c');
        return $sql;
    }
	//一条
	public function get_s_bys($kid){
        $this->db->where('kid', $kid);
        $sql = $this->db->get('vehicle_c');
        $result = $sql->row_array();
        return $result;
    }
	//所有
	public function get_s_bykid($kid){
        $this->db->where('kid', $kid);
        $sql = $this->db->get('vehicle_c');
        $result = $sql->result_array();
        return $result;
    }
}

