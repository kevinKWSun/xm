<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wghnews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($id, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id",$id);
        $sql = $this->db->get('grid');
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('grid');
        return $sql->result_array();
    }
    //所有
    public function get_synews_num($admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('grid');
        return $sql;
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('grid',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('grid',$data);
    }
	//查
	public function synews($k, $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('num', $k);
			$this->db->or_like('name', $k);
			$this->db->or_like('tunit', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('grid');
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
			$this->db->or_like('name', $k);
			$this->db->or_like('tunit', $k);
		}
        $sql = $this->db->count_all_results('grid');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('grid', $data);
        return $sql;
    }
	public function get_by_num($num, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("num",$num);
        $sql = $this->db->get('grid');
        return $sql->row_array();
    }
	//养殖场数据展示
	public function getfarm($city = ''){
		if($city){
			$this->db->where("addr_county",$city);
		}
		$sql = $this->db->get('farm');
        return $sql->result_array();
	}
	//养殖场附属数据展示
	public function getfarmstocks($kid = ''){
		$this->db->select('breed, stock');
		if($kid){
			$this->db->where("kid",$kid);
		}
		$sql = $this->db->get('farm_stock');
        return $sql->result_array();
	}
}

