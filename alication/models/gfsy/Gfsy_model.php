<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gfsy_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($a = 'members', $b = 'members_info', $c = 'vet_official', $id, $admin_id){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.id",$id);
        $this->db->where("$a.type",1);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->join("$c", "$a.id=$c.uid", 'left');
        $sql = $this->db->get();
        return $sql->row_array();
    }
    //page每页总数   per_page第几页从第几个下标开始
    public function get_vet_official($page = 10, $per_page = 1, $admin_id, $type = 1){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        if($type){
			$this->db->where('type', $type);
		}
        $this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $query=  $this->db->get('members');
        $result = $query->result_array();
        return $result;
    }
    //所有
    public function get_vet_official_num($admin_id, $type = 1){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        if($type){
			$this->db->where('type', $type);
		}
        $sql = $this->db->count_all_results('members');
        return $sql;
    }
	//增加
	public function add_vet_official($data = array()){
        $sql = $this->db->insert('vet_official',$data);
        return $sql;
    }
	public function add_members($data = array()){
        $this->db->insert('members',$data);
        $sql = $this->db->insert_id();
        return $sql;
    }
	public function add_members_info($data = array()){
        $sql = $this->db->insert('members_info',$data);
        return $sql;
    }
	//修改
	public function up_vet_official($data = array(), $uid){
		$this->db->where('uid', $uid);
        return $this->db->update('vet_official',$data);
    }
	public function up_members($data = array(), $uid){
		$this->db->where('id', $uid);
        return $this->db->update('members',$data);
    }
	public function up_members_info($data = array(), $uid){
		$this->db->where('uid', $uid);
        return $this->db->update('members_info',$data);
    }
	//查询基本信息是否存在
	public function find_members($phone, $idcard, $id = '', $aid = ''){
		if($phone){
			$this->db->where('phone', $phone);
		}
		if($idcard){
			$this->db->where('idcard', $idcard);
		}
		if($id){
			$this->db->where('id', $id);
		}
		if($aid) {
			$this->db->where('aid', $aid);
		}
        $query=  $this->db->get('members');
        $sql = $query->row_array();
        return $sql;
    }
	//查
	public function solor($k, $admin_id = '', $page = 10, $per_page = 1, $type = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_where('phone', $k);
			$this->db->or_where('idcard', $k);
			$this->db->or_where('real_name', $k);
			if($type){
				$this->db->where('type', $type);
			}
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('members');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k, $admin_id, $type = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_where('phone', $k);
			$this->db->or_where('idcard', $k);
			$this->db->or_where('real_name', $k);
			if($type){
				$this->db->where('type', $type);
			}
		}
        $sql = $this->db->count_all_results('members');
        return $sql;
    }
}

