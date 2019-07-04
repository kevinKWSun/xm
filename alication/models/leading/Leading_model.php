<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Leading_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_leading($page = 10, $per_page = 1, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('leading_unit');
        return $sql->result_array();
    }
    //所有
    public function get_leading_num($admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('leading_unit');
        return $sql;
    }
	//增加
	public function add_leading ($data = array()){
        return $this->db->insert('leading_unit',$data);
    }
	//修改
	public function up_leading($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('leading_unit',$data);
    }
	//查
	public function so_leading($k, $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('uname', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('leading_unit');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k, $admin_id = ''){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('uname', $k);
		}
        $sql = $this->db->count_all_results('leading_unit');
        return $sql;
    }
	public function get_leading_byid($id, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id",$id);
        $sql = $this->db->get('leading_unit');
        return $sql->row_array();
    }
	public function get_leading_byname($name, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("uname",$name);
        $sql = $this->db->get('leading_unit');
        return $sql->row_array();
    }
	public function get_leading_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('leading_unit', $data);
        return $sql;
    }
}