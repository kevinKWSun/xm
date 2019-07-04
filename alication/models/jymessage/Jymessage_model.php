<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jymessage_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id, $a = 'members', $b = 'vet_deal'){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.type",7);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get();
        return $sql->result_array();
    }
	public function get_jymessage_num($admin_id) {
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('vet_deal');
        return $sql;
	}
	public function add_jymessage($data = array()) {
		 return $this->db->insert('vet_deal',$data);
	}
	public function get_m($a = 'members', $b = 'members_info', $c = 'vet_deal', $id, $admin_id){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.id",$id);
        $this->db->where("$a.type",7);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->join("$c", "$a.id=$c.uid", 'left');
        $sql = $this->db->get();
        return $sql->row_array();
    }
	//修改
	public function up_jymessage($data = array(), $id){
		$this->db->where('uid', $id);
        return $this->db->update('vet_deal',$data);
    }
	public function get_s_bykid() {
		
	}
    public function get_solor_num($k, $admin_id){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('reg_addr', $k);
		}
        $sql = $this->db->count_all_results('vet_deal');
        return $sql;
    }
	public function jymessage($k, $admin_id = '', $page = 10, $per_page = 1, $a = 'members', $b = 'vet_deal'){
		$this->db->from("$b");
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('deal_addr', $k);
		}
		if($admin_id){
            $this->db->where("$b.admin_id", $admin_id);
        }
		$this->db->join("$a", "$b.uid=$a.id", 'left');
		$this->db->limit($page, $per_page);
        $query=  $this->db->get();
        $result = $query->result_array();
        return $result;
	}
	/* 锁定 */
	public function get_jymessage_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('uid', $ids);
        $sql = $this->db->update('vet_deal', $data);
        return $sql;
    }
	public function get_company_num($area) {
		$this->db->where("deal_county", $area);
		return $this->db->count_all_results('vet_deal');
	}
}

