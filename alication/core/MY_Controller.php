<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper(array('common', 'url'));
        $this->load->library(array('parser', 'auth'));
        if(defined('UID')) return ;
	    define('UID',is_login());
		if( ! UID){
		   $url = base_url('login.html');
		   redirect($url);
		}
        define('IS_ROOT', is_administrator());
        if(! IS_ROOT){
            $a = $this->uri->segment(1);
            $b = $this->uri->segment(2);
            if($b){
                if($b == 'index'){
                    $rule  = strtolower('/' . $a);
                }else{
                    $rule  = strtolower('/' . $a . '/' .$b);
                }
            }else{
                $rule  = strtolower('/' . $a);
            }
            if (! $this->checkRule($rule) && $rule != '/adminr/center' && $rule != '/adminr' && $rule != '/menus'){
                exit('<center><font color=red size=+2>403_未授权访问,请联系相关人员!</font></center>');
            }
        }
    }
    /**
     * 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     */
    final protected function checkRule($rule, $type=1, $mode='url'){
        if(! $this->auth->check($rule, UID, $type, $mode)){
            return false;
        }
        return true;
    }
}
class WX_Controller extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model('user/login_model');
		$this->load->helper(array('common', 'url', 'cookie'));
        $this->load->library(array('parser', 'auth'));
		$oid = $this->input->cookie('openid');
		if(! isset($oid) || empty($oid)) {
			$url = base_url('wxlogin');
		    redirect($url);
		}
        if(defined('UID')) return;
		$result = $this->login_model->get_by_authkey($oid);
	    define('UID',is_login());
		if( ! UID || $result['id'] != UID){
			$url = base_url('wxlogin');
		    redirect($url);
		}
        define('IS_ROOT', is_administrator());
        if(! IS_ROOT){
            $a = $this->uri->segment(1);
            $b = $this->uri->segment(2);
            if($b){
                if($b == 'index'){
                    $rule  = strtolower('/' . $a);
                } else {
                    $rule  = strtolower('/' . $a . '/' .$b);
                }
            }else{
                $rule  = strtolower('/' . $a);
            }
            if (! $this->checkRule($rule) && $rule != '/adminr/center' && $rule != '/adminr' && $rule != '/menus'){
                //exit('<center><font color=red size=+2>403_未授权访问!</font></center>');
				$url = base_url('wxlogin/error');
				redirect($url);
            }
        }
    }
	/**
     * 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     */
    final protected function checkRule($rule, $type=1, $mode='url'){
        if(! $this->auth->check($rule, UID, $type, $mode)){
            return false;
        }
        return true;
    }
}