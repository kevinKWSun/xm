<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wxlogin extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->model('user/login_model');
    }
	public function index() {
		$this->load->helper(array('form', 'url', 'common', 'cookie'));
		$oid = $this->input->cookie('openid');
		$this->load->library('session');
		if($d = $this->input->post(NULL, true)) {
			$data['name'] = trim($d['admin_name']);
			$data['password'] = trim($d['admin_pass']);
			if(! $data['name']){
				$info['state'] = 0;
				$info['message'] = '请输入登录名!';
				$this->output
			    ->set_content_type('application/json', 'utf-8')
			    ->set_output(json_encode($info))
				->_display();
			    exit;
			}
			$data['name'] = urlencode($data['name']);
			if(! $data['password']){
				$info['state'] = 0;
				$info['message'] = '请输入密码!';
				$this->output
			    ->set_content_type('application/json', 'utf-8')
			    ->set_output(json_encode($info))
				->_display();
			    exit;
			}
			$result = $this->login_model->get_user($data['name']);
	        if($result['pwd'] != suny_encrypt($data['password'],'3ed1lio0')){
	        	$info['state'] = 0;
				$info['message'] = '登录名或密码不正确!';
				$this->output
			    ->set_content_type('application/json', 'utf-8')
			    ->set_output(json_encode($info))
				->_display();
			    exit;
	        }
	        if($result['type'] != 1){
	        	$info['state'] = 0;
				$info['message'] = '已被锁定,请联系管理员!';
				$this->output
			    ->set_content_type('application/json', 'utf-8')
			    ->set_output(json_encode($info))
				->_display();
			    exit;
	        }
			//需要网页调试，可开启注释行
			// $oid = $result['authkey'];
			// $this->input->set_cookie('openid',$oid,  30 * 24 * 3600);
			if(empty($result['authkey'])) {
				$this->login_model->update_authkey($result['id'], $oid);
			} else {
				if($oid != $result['authkey']) {
					$info['state'] = 0;
					$info['message'] = '登录名或密码不正确';
					$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($info))
					->_display();
					exit;
				}
			}
			$info['state'] = 1;
			$info['message'] = '登录成功!';
			$info['url'] = base_url('/wx');
			$array = array(
                'uid' => $result['id']
            );
            $this->session->set_userdata($array);
			$this->output
		    ->set_content_type('application/json', 'utf-8')
		    ->set_output(json_encode($info))
			->_display();
		    exit;
		}
		//需要网页调试，可开启注释行
		// if($oid) {
			// $result = $this->login_model->get_by_authkey($oid);
			// if(isset($result['id']) && $result['id'] > 0){
				// $array = array(
					// 'uid' => $result['id']
				// );
				// $this->session->set_userdata($array);
				// redirect(base_url('wx'), 'refresh');
			// } else {
				// $this->load->view('wx/login');
			// }
		// } else {
			// $this->load->view('wx/login');
		// }
		
		
		if($oid) {
			$result = $this->login_model->get_by_authkey($oid);
			if(isset($result['id']) && $result['id'] > 0){
				$array = array(
					'uid' => $result['id']
				);
				$this->session->set_userdata($array);
				redirect(base_url('wx'), 'refresh');
			}
		} else {
			$d = $this->input->get(NULL, true);
			if(isset($d['code']) && $d['code']){
				$ch = curl_init();
				$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx13084487467c28a7&secret=f6626060bab944974744968cdc0b1d20&code='.$d['code'].'&grant_type=authorization_code';
				curl_setopt($ch, CURLOPT_URL, "$url");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				$output  = curl_exec($ch);
				curl_close($ch);
				$r = (array) json_decode($output,true);
				if(isset($r['errmsg']) && $r['errmsg']){
					header("Location:/wxlogin");
				}else{
					$openid = $r['openid'];
					$this->input->set_cookie('openid',$openid, 30 * 24 * 3600);
				}
			}else{
				$urls = urlencode($this->config->item('base_url') . '/wxlogin');
				$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx13084487467c28a7&redirect_uri='.$urls.'&response_type=code&scope=snsapi_base&state=1#wechat_redirect';
				header("Location:$url");
			}
		}
		$this->load->view('wx/login');
	}
	public function error(){
		$this->load->helper('url');
		$this->load->view('wx/error');
	}
}