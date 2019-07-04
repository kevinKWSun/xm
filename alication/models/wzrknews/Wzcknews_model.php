<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wzcknews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($id, $admin_id){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id",$id);
        $sql = $this->db->get('storage_output');
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('storage_output');
        return $sql->result_array();
    }
    //所有
    public function get_wzrknews_num($admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('storage_output');
        return $sql;
    }
	//增加
	public function add_wzrknews ($data = array()){
        return $this->db->insert('storage_output',$data);
    }
	//修改
	public function up_wzrknews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('storage_output',$data);
    }
	//查
	public function wzrknews($k, $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('bname', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('storage_output');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k, $admin_id){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('bname', $k);
		}
        $sql = $this->db->count_all_results('storage_output');
        return $sql;
    }

	public function get_wzrknews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('storage_output', $data);
        return $sql;
    }
}

