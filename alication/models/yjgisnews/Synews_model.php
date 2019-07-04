<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Synews_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function getreport($k, $page = 10, $per_page = 1){
		if($k){
			$this->db->or_like('suspected', $k);
			$this->db->or_like('symptom', $k);
			$this->db->or_like('addr', $k);
			$this->db->or_like('tel', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('report');
        $result = $query->result_array();
        return $result;
	}
	public function getreport_sum($k){
		if($k){
			$this->db->or_like('suspected', $k);
			$this->db->or_like('symptom', $k);
			$this->db->or_like('addr', $k);
			$this->db->or_like('tel', $k);
		}
		$sql = $this->db->count_all_results('report');
        return $sql;
	}
	public function getfarm($k, $page = 10, $per_page = 1){
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('addr', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('farm');
        $result = $query->result_array();
        return $result;
	}
	public function getfarm_sum($k){
		if($k){
			$this->db->or_like('name', $k);
			$this->db->or_like('addr', $k);
		}
		$sql = $this->db->count_all_results('farm');
        return $sql;
	}
	//
	public function get_m($id, $admin_id = ''){
		if($admin_id){
			$this->db->where("admin_id",$admin_id);
		}
        $this->db->where("id",$id);
        $sql = $this->db->get('deploy');
        return $sql->row_array();
    }
	//增加
	public function add_synews ($data = array()){
        return $this->db->insert('deploy',$data);
    }
	//修改
	public function up_synews($data = array(), $id){
		$this->db->where('id', $id);
        return $this->db->update('deploy',$data);
    }
	//查
	public function synews($k = '', $admin_id = '', $page = 10, $per_page = 1){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('sname', $k);
			$this->db->or_like('yname', $k);
		}
		$this->db->limit($page, $per_page);
        $query=  $this->db->get('deploy');
        $result = $query->result_array();
        return $result;
	}
    //所有
    public function get_solor_num($k = '', $admin_id = ''){
		if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
		if($k){
			$this->db->or_like('sname', $k);
			$this->db->or_like('yname', $k);
		}
        $sql = $this->db->count_all_results('deploy');
        return $sql;
    }
	public function get_synews_lock($data, $ids = array(), $admin_id = ''){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where_in('id', $ids);
        $sql = $this->db->update('deploy', $data);
        return $sql;
    }
	public function get_farms($id){
        $this->db->where("uid",$id);
        $sql = $this->db->get('farm');
        return $sql->row_array();
    }
}

