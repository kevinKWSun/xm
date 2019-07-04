<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adminr extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('auth/admin_model', 'auth/auth_model', 'user/ausers_model'));
    }
	public function index(){
		$data = array(
		    'indextitle' => '系统主页',
		);
		$r = $this->auth_model->getrules('xm_auth_group_access','xm_auth_group', UID);
		if($r){
			$rs = explode(',', $r[0]['rules']);
		}else{
			$rs = array();
		}
		$rule = $this->admin_model->getrule();
		foreach($rule as $k => $v){
			if(! IS_ROOT){
				if(! in_array($v['id'], $rs)){
					unset($rule[$k]);
					continue;
				}
			}
		}
		$data['rule'] = $rule;
		$user = $this->ausers_model->get_ausers_byuid(UID);
		$data['name'] = $user['name'];
		$data['rname'] = $user['realname'];
		//$this->parser->parse('admin', $data);
		$this->load->view('user/admin', $data);
	}
	public function modify(){
		if($this->input->post()){
			$user = $this->ausers_model->get_ausers_byuid(UID);
			$pd0 = trim($this->input->post_get('pd0', TRUE));
			$pd = trim($this->input->post_get('pd', TRUE));
			$pd2 = trim($this->input->post_get('pd2', TRUE));
			if(! is_password($pd0)){
				$info['state'] = 0;
				$info['message'] = '原密码(包含字母和数字,至少6位)!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(suny_encrypt($pd,'3ed1lio0') != $user['pwd']){
				$info['state'] = 0;
				$info['message'] = '原密码不正确!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! is_password($pd)){
				$info['state'] = 0;
				$info['message'] = '新密码(包含字母和数字,至少6位)!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($pd != $pd2){
				$info['state'] = 0;
				$info['message'] = '两次密码不一致!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$data['pwd'] = suny_encrypt($pd,'3ed1lio0');
			if($this->ausers_model->modify_ausers($data, UID)){
				$info['state'] = 1;
				$info['message'] = '修改成功!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}else{
				$info['state'] = 0;
				$info['message'] = '修改失败,请刷新后重试!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			
		}
		$this->load->view('user/modify');
	}
	public function logout(){
		$this->session->unset_userdata('uid');
		$url = base_url('login.html');
		redirect($url);
	}
	public function center(){
		$user = $this->ausers_model->get_ausers_byuid(UID);
		$data['name'] = $user['name'];
		$data['rname'] = $user['realname'];
		$this->load->view('user/centers', $data);
	}
}