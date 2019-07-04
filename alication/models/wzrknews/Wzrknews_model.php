<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wzrknews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($id, $admin_id){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id",$id);
        $sql = $this->db->get('storage_input');
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('storage_input');
        return $sql->result_array();
    }
    //所有
    public function get_wzrknews_num($admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('storage_input');
        return $sql;
    }
	//增加
	public function add_wzrknews ($data = array()){
        return $this->db->insert('storage_input',$data);
    }
	//修改
	public function up_wzrknews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('storage_input',$data);
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
        $query=  $this->db->get('storage_input');
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
        $sql = $this->db->count_all_results('storage_input');
        return $sql;
    }

	public function get_wzrknews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('storage_input', $data);
        return $sql;
    }
	//获取物资类别数量
	public function get_cate_num($cate, $area) {
		$res = $this->get_library($area);
		if(!empty($res)) {
			$select_uid = array();
			foreach($res as $k=>$v) {
				array_push($select_uid, $v['id']);
			}
		}
		if(!empty($select_uid)) {
			$this->db->where('cate_name', $cate);
			$this->db->where_in('sign_uint_id', $select_uid);
			$this->db->select_sum('num');
			$query = $this->db->get('storage_input');
			$result = $query->row_array();
			$num = $result['num'];
		}
		return (isset($num) && !empty($num)) ? $num : 0;
	}
	//应急物资库所在区域
	public function get_library($area) {
		$this->db->from("library");
		$this->db->select("id");
		$this->db->where("addr_c", $area);
		$sql = $this->db->get();
		return $sql->result_array();
	}
}

