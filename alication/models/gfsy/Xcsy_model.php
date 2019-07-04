<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Xcsy_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function get_m($a = 'members', $b = 'members_info', $c = 'vet_village', $id, $admin_id){
        $this->db->from("$a");
		if($admin_id){
			$this->db->where("$a.admin_id",$admin_id);
		}
        $this->db->where("$a.id",$id);
        $this->db->where("$a.type",2);
        $this->db->join("$b", "$a.id=$b.uid", 'left');
		$this->db->join("$c", "$a.id=$c.uid", 'left');
        $sql = $this->db->get();
        return $sql->row_array();
    }
    //page每页总数   per_page第几页从第几个下标开始
    public function get_vet_village($page = 10, $per_page = 1, $admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where('type', 2);
        $this->db->limit($page, $per_page);
        $this->db->order_by('id DESC');
        $query=  $this->db->get('members');
        $result = $query->result_array();
        return $result;
    }
    //所有
    public function get_vet_village_num($admin_id){
        if($admin_id){
            $this->db->where('admin_id', $admin_id);
        }
        $this->db->where('type', 2);
        $sql = $this->db->count_all_results('members');
        return $sql;
    }
	//增加
	public function add_vet_village ($data = array()){
        return $this->db->insert('vet_village',$data);
    }
	//修改
	public function up_vet_village($data = array(), $uid){
		$this->db->where('uid', $uid);
        return $this->db->update('vet_village',$data);
    }
	public function get_edu_num($edu, $area) {
		$this->db->where('obtain_area', $area);
		$this->db->where('education', $edu);
		return $this->db->count_all_results('vet_village');
	}
}

