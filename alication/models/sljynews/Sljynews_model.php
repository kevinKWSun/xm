<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sljynews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id = 0){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('feed_deal');
		
        return $sql->result_array();
    }
	public function get_sljynews_num($admin_id) {
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('feed_deal');
        return $sql;
	}
	public function add_sljynews($data = array()) {
		 return $this->db->insert('feed_deal',$data);
	}
	public function get_m($id, $admin_id){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id", $id);
        $sql = $this->db->get('feed_deal');
        return $sql->row_array();
    }
	//修改
	public function up_sljynews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('feed_deal',$data);
    }
    public function get_solor_num($k, $admin_id){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('reg_addr', $k);
		}
        $sql = $this->db->count_all_results('feed_deal');
        return $sql;
    }
	public function sljynews($k, $admin_id = '', $page = 10, $per_page = 1){
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('reg_addr', $k);
		}
		if($admin_id){
            $this->db->where("admin_id", $admin_id);
        }
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('feed_deal');
        $result = $query->result_array();
        return $result;
	}
	/* 锁定 */
	public function get_sljynews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('feed_deal', $data);
        return $sql;
    }
	public function get_company_num($area) {
		$this->db->where("reg_county", $area);
		return $this->db->count_all_results('feed_deal');
	}
}

