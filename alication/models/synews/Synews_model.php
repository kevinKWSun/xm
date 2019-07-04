<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Synews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($a = 'members', $b = 'members_info', $c = 'scatter', $id, $admin_id){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.id",$id);
        $this->db->where("$a.type",3);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->join("$c", "$a.id=$c.uid", 'left');
        $sql = $this->db->get();
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id, $a = 'members', $b = 'scatter'){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.type",3);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get();
        return $sql->result_array();
    }
    /* //page每页总数   per_page第几页从第几个下标开始
    public function get_synews($page = 10, $per_page = 1, $admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $query=  $this->db->get('scatter');
        $result = $query->result_array();
        return $result;
    } */
    //所有
    public function get_synews_num($admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('scatter');
        return $sql;
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('scatter',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('uid', $id);
        return $this->db->update('scatter',$data);
    }
	//查
	public function synews($k, $admin_id = '', $page = 10, $per_page = 1, $a = 'members', $b = 'scatter'){
		$this->db->from("$b");
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('num', $k);
			$this->db->or_like('addr', $k);
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
			$this->db->or_like('num', $k);
			$this->db->or_like('addr', $k);
		}
        $sql = $this->db->count_all_results('scatter');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('uid', $ids);
        $sql = $this->db->update('scatter', $data);
        return $sql;
    }
	//批量
	public function addall_s($data = array()){
        $sql = $this->db->insert_batch('scatter_stock',$data);
        return $sql;
    }
	//删除
	public function del_s($kid){
		$this->db->where('kid', $kid);
        $sql = $this->db->delete('scatter_stock');
        return $sql;
    }
	//一条
	public function get_s_bys($kid, $breed){
        $this->db->where('kid', $kid);
		$this->db->where('breed', $breed);
        $sql = $this->db->get('scatter_stock');
        $result = $sql->row_array();
        return $result;
    }
	//所有
	public function get_s_bykid($kid){
        $this->db->where('kid', $kid);
        $sql = $this->db->get('scatter_stock');
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
			$query = $this->db->get('scatter_stock');
			$result = $query->row_array();
			$num = $result['stock'];
		}
		return (isset($num) && !empty($num)) ? $num : 0;
	}
	public function get_uid_byarea($area) {
		$this->db->from("scatter");
		$this->db->select("uid");
		$this->db->where("addr_c", $area);
		$sql = $this->db->get();
		return $sql->result_array();
	}
}

