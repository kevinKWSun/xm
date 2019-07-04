<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Yznews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($a = 'members', $b = 'members_info', $c = 'farm', $id, $admin_id){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.id",$id);
        $this->db->where("$a.type",5);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->join("$c", "$a.id=$c.uid", 'left');
        $sql = $this->db->get();
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id, $a = 'members', $b = 'farm'){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.type",5);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get();
        return $sql->result_array();
    }
	//获取列表
	public function get_yznews($admin_id, $page = 10,	$per_page = 1, $keywords = '') {
		if(!empty($keywords)) {
			$this->db->like('name', $keywords);
		}
		if($admin_id > 1) {
			$this->db->where('admin_id', $admin_id);
		}
		$this->db->where('status', 1);
        $this->db->limit($page, $per_page);
        $this->db->order_by('add_time DESC');
        $query=  $this->db->get('farm');
        $result = $query->result_array();
        return $result;
		
	}
	//获取总条数
	public function get_farm_num($keywords, $admin_id) {
		if(!empty($keywords)) {
			$this->db->like('name', $keywords);
		}
		if($admin_id > 1) {
			$this->db->where('admin_id', $admin_id);
		}
		$this->db->where('status', 1);
		$sql = $this->db->count_all_results('farm');
		return $sql;
	}
	//增加
	public function add_yznews ($data = array()){
        return $this->db->insert('farm',$data);
    }
	//修改
	public function up_yznews($data = array(), $id){
		$this->db->where('uid', $id);
        return $this->db->update('farm',$data);
    }
	/* 锁定 */
	public function get_yznews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('uid', $ids);
        $sql = $this->db->update('farm', $data);
        return $sql;
    }
	//查
	public function yznews($k, $admin_id = '', $page = 10, $per_page = 1, $a = 'members', $b = 'farm'){
		$this->db->from("$b");
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('addr', $k);
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
	//所有
    public function get_solor_num($k, $admin_id){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('addr', $k);
		}
        $sql = $this->db->count_all_results('farm');
        return $sql;
    }
	public function addall_s($data = array()){
        $sql = $this->db->insert_batch('farm_stock',$data);
        return $sql;
    }
	//删除
	public function del_s($kid){
		$this->db->where('kid', $kid);
        $sql = $this->db->delete('farm_stock');
        return $sql;
    }
	//一条
	public function get_s_bys($kid, $breed){
        $this->db->where('kid', $kid);
		$this->db->where('breed', $breed);
        $sql = $this->db->get('farm_stock');
        $result = $sql->row_array();
        return $result;
    }
	//所有
	public function get_s_bykid($kid){
        $this->db->where('kid', $kid);
        $sql = $this->db->get('farm_stock');
        $result = $sql->result_array();
        return $result;
    }
	public function get_tj($area, $cate = '') {
		$res = $this->get_uid_byarea($area);
		if(!empty($res)) {
			$select_uid = array();
			foreach($res as $k=>$v) {
				array_push($select_uid, $v['uid']);
			}
		}
		if(!empty($select_uid)) {
			$this->db->where('breed', $cate);
			$this->db->where_in('kid', $select_uid);
			$this->db->select_sum('stock');
			$query = $this->db->get('farm_stock');
			$result = $query->row_array();
			$num = $result['stock'];
		}
		return (isset($num) && !empty($num)) ? $num : 0;
	}
	public function get_uid_byarea($area) {
		$this->db->from("farm");
		$this->db->select("uid");
		$this->db->where("addr_county", $area);
		$sql = $this->db->get();
		return $sql->result_array();
	}
	public function get_members_one($aid){
		$this->db->where("aid", $aid);
		$sql = $this->db->get('members');
		return $sql->row_array();
	}
	public function get_farm_one($uid){
		$this->db->where("uid", $uid);
		$sql = $this->db->get('farm');
		return $sql->row_array();
	}
}

