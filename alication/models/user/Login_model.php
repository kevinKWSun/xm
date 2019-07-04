<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_user($name){
    	$this->db->where('name',$name);
        $this->db->select('id,pwd,type,status,authkey');
        $query=  $this->db->get('user');
        $result = $query->row_array();
        return $result;
    }
	public function get_by_authkey($oid){
    	$this->db->where('authkey',$oid);
        $this->db->select('id,pwd,type,status,authkey');
        $query=  $this->db->get('user');
        $result = $query->row_array();
        return $result;
    }
	public function update_authkey($id, $authkey){
    	$this->db->where('id',$id);
		$this->db->set('authkey', $authkey); 
        return $this->db->update('user'); 
    }
}

