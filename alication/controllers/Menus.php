<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menus extends MY_Controller {
	public function index(){
		$this->load->model(array('auth/admin_model', 'auth/auth_model'));
		$this->load->helper('common');
		$id = intval(isset($_GET['pid'])) ? intval($_GET['pid']) : 14;
		if(! $id){
			$rule = '';
		}else{
			$rule = $this->admin_model->getrule_bypid($id);
		}
		$l = array();
		$r = $this->auth_model->getrules('xm_auth_group_access','xm_auth_group', UID);
		if($r){
			$rs = explode(',', $r[0]['rules']);
		}else{
			$rs = array();
		}
		if($rule){
			foreach($rule as $k => $v){
				if(! IS_ROOT){
					if(! in_array($v['id'], $rs)){
						continue;
					}
				}
				$l[$k]['title'] = $v['title'];
				$l[$k]['icon'] = 'fa fa-file-text-o';
				$l[$k]['href'] = $v['name']?$v['name']:'/404';
				$c = $this->admin_model->getrule_bypid($v['id']);
				if($c){
					if($k == 0){
						$l[$k]['icon'] = 'fa fa-folder-open-o';
					}else{
						$l[$k]['icon'] = 'fa fa-folder-o';
					}
					foreach($c as $kc => $vc){
						if(! IS_ROOT){
							if(! in_array($vc['id'], $rs)){
								continue;
							}
						}
						$l[$k]['children'][$kc] = array(
							'title' => $vc['title'],
							'icon' => 'fa fa-file-text-o',
							'href' => $vc['name']?$vc['name']:'/404'
						);
						$d = $this->admin_model->getrule_bypid($vc['id']);
						if($d){
							if($k ==0 && $kc == 0){
								$l[$k]['children'][$kc]['icon'] = 'fa fa-folder-open-o';
							}else{
								$l[$k]['children'][$kc]['icon'] = 'fa fa-folder-o';
							}
							foreach($d as $kd => $vd){
								if(! IS_ROOT){
									if(! in_array($vd['id'], $rs)){
										continue;
									}
								}
								$l[$k]['children'][$kc]['children'][$kd] = array(
									'title' => $vd['title'],
									'icon' => 'fa fa-file-text-o',
									'href' => $vd['name']?$vd['name']:'/404'
								);
								$e = $this->admin_model->getrule_bypid($vd['id']);
								if($e){
									$l[$k]['children'][$kc]['children'][$kd]['icon'] = 'fa fa-folder-o';
									foreach ($e as $ke => $ve) {
										if(! IS_ROOT){
											if(! in_array($ve['id'], $rs)){
												continue;
											}
										}
										$l[$k]['children'][$kc]['children'][$kd]['children'][$ke] = array(
											'title' => $ve['title'],
											'icon' => 'fa fa-file-text-o',
											'href' => $ve['name']?$ve['name']:'/404'
										);
									}
								}
							}
						}
					}
				}
			}
		}//p($l);
		$data = array(
			'state' => 1,
			'message' => 'Success!',
			'data' => $l
		);
		$this->output
		    ->set_content_type('application/json', 'utf-8')
		    ->set_output(json_encode($data))
			->_display();
		    exit;
	}
}