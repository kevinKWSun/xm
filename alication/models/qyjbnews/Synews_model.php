<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Synews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($id, $c = 'members', $a = 'butcher_compay'){
        $this->db->from("$a");
        $this->db->where("$a.id",$id);
		$this->db->join("$c", "$a.vet_id=$c.id", 'left');
		$this->db->select("$a.*");
		$this->db->select("$c.real_name");
		$this->db->select("$c.phone");
		$this->db->select("$c.idcard");
        $sql = $this->db->get();
        return $sql->row_array();
    }
	public function get_ms($page = 10, $per_page = 1, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
		$this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $sql = $this->db->get('butcher_compay');
        return $sql->result_array();
    }
    //所有
    public function get_synews_num($admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $sql = $this->db->count_all_results('butcher_compay');
        return $sql;
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('butcher_compay',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('butcher_compay',$data);
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
        $query =  $this->db->get('butcher_compay');
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
        $sql = $this->db->count_all_results('butcher_compay');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('butcher_compay', $data);
        return $sql;
    }
	public function get_by_num($num, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("num",$num);
        $sql = $this->db->get('butcher_compay');
        return $sql->row_array();
    }
	//兽医
	public function sy($k = '', $page = 10, $per_page = 1){
		$this->db->where_in('type', array(1,2));
		if($k){
			$this->db->or_like('phone', $k);
			$this->db->or_like('idcard', $k);
			$this->db->or_like('real_name', $k);
		}
		$this->db->limit($page, $per_page);
        $query =  $this->db->get('members');
		$result = $query->result_array();
        return $result;
	}
	public function sy_num($k = ''){
		$this->db->where_in('type', array(1,2));
		if($k){
			$this->db->or_like('phone', $k);
			$this->db->or_like('idcard', $k);
			$this->db->or_like('real_name', $k);
		}
		$sql = $this->db->count_all_results('members');
		return $sql;
	}
	public function get_spcial_num($spcial, $area) {
		$this->db->where('species', $spcial);
		$this->db->where('addr_c', $area);
		return $this->db->count_all_results('butcher_compay');
	}
	public function get_volum_num($area) {
		$this->db->where('addr_c', $area);
		$this->db->select_sum('volum');
		$query = $this->db->get('butcher_compay');
		$result = $query->row_array();
		$num = $result['volum'];
		return !empty($num) ? $num : 0;
	}
}

