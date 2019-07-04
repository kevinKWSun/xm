<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Scmessage extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('scmessage/scmessage_model', 'area/area_model', 'gfsy/gfsy_model'));
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->admin_id = IS_ROOT ? UID : 0;
    }
	public function index(){
        $current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
        if($current_page > 0){
            $current_page = $current_page - 1;
        }else if($current_page < 0){
            $current_page = 0;
        }
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('scmessage/index');
        $config['total_rows'] = $this->scmessage_model->get_scmessage_num($this->admin_id);
        $config['per_page'] = $per_page;
		$config['page_query_string'] = FALSE;
		$config['first_link'] = '首页'; // 第一页显示   
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页'; // 下一页显示   
		$config['prev_link'] = '上一页'; // 上一页显示   
		$config['cur_tag_open'] = ' <span class="current">'; // 当前页开始样式   
		$config['cur_tag_close'] = '</span>';   
		$config['num_links'] = 10;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config); 
        $data['totals'] = $config['total_rows'];
        $data['page'] = $this->pagination->create_links();
        $data['p'] = $current_page;
        $scmessage = $this->scmessage_model->get_ms($per_page, $offset * $per_page, $this->admin_id);
		foreach($scmessage as $k => $v){
			//$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($v['reg_city']);
			$t = $this->area_model->get_area_byid($v['reg_county']);
			$scmessage[$k]['reg'] = $c['name'] . $t['name'] . $v['reg_addr'];
			$c = $this->area_model->get_area_byid($v['produce_city']);
			$t = $this->area_model->get_area_byid($v['produce_county']);
			$scmessage[$k]['produce'] = $c['name'] . $t['name'] . $v['produce_addr'];
			$gfsy = $this->gfsy_model->find_members('','',$v['super_id']);
			$scmessage[$k]['super_name'] = $gfsy['real_name'];
		}
        $data['scmessage'] = $scmessage;
		$this->load->view('scmessage/index', $data);
	}
	public function scadd() {
		if($d = $this->input->post(NULL, true)) {
			$msg = '';
			do {
				if(! $d['name']) {
					$msg = '企业名称必填！';break;
				}
				if(! $d['license']) {
					$msg = '生产许可证编号必填！';break;
				}
				if(! $d['license_time']) {
					$msg = '生产许可证有效期必填！';break;
				}
				if(! $d['gmp']) {
					$msg = '兽药GMP证编号必填！';break;
				}
				if(! $d['gmp_time']) {
					$msg = '兽药GMP证有效期必填！';break;
				}
				if(! $d['gmp_time']) {
					$msg = '工商执照注册号必填！';break;
				}
				if(! $d['reg']) {
					$msg = '工商执照注册号必填！';break;
				}
				if(! $d['reg_time']) {
					$msg = '成立日期必填！';break;
				}
				if(! $d['reg_city']) {
					$msg = '注册城市必填！';break;
				}
				if(! $d['reg_county']) {
					$msg = '注册区县必填！';break;
				}
				if(! $d['reg_addr']) {
					$msg = '注册地址必填！';break;
				}
				if(! $d['produce_city']) {
					$msg = '生产城市必填！';break;
				}
				if(! $d['produce_county']) {
					$msg = '生产区县必填！';break;
				}
				if(! $d['produce_addr']) {
					$msg = '生产地址必填！';break;
				}
				if(! $d['lng'] || ! $d['lat']) {
					$msg = '经纬度必填！';break;
				}
				if(! $d['legal_name']) {
					$msg = '法人姓名必填！';break;
				}
				if(! $d['legal_phone']) {
					$msg = '联系电话必填！';break;
				}
				if(! $d['charge_id']) {
					$msg = '负责人必填！';break;
				}
				if(! $d['tel']) {
					$msg = '负责人联系电话必填！';break;
				}
				if(! $d['charge_idcard']) {
					$msg = '负责人身份证必填！';break;
				}
				if($this->gfsy_model->find_members($d['tel'], '')){
					$msg = '负责人手机号已经存在！';break;
				}
				if($this->gfsy_model->find_members('', $d['charge_idcard'])){
					$msg = '负责人身份证号已经存在！';break;
				}
				if(! $d['vet']) {
					$msg = '监管责任人必填！';break;
				}
			} while(false);
			if(!empty($msg)) {
				$info['state'] = 0;
				$info['message'] = $msg;
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$member = array(
				'phone' => $d['tel'],
				'idcard' => $d['charge_idcard'],
				'real_name' => $d['charge_id'],
				'reg_time' => time(),
				'reg_ip' => $this->input->ip_address(),
				'type' => 6,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->add_members($member);
			$member_info = array(
				'uid' => $uid,
			);
			$this->gfsy_model->add_members_info($member_info);
			$scmessage_data = array();
			$scmessage_data['uid']			= $uid;
			$scmessage_data['name']			= $d['name'];
			$scmessage_data['license']		= $d['license'];
			$scmessage_data['license_time']	= $d['license_time'] ? strtotime($d['license_time']) : 0;
			$scmessage_data['gmp']			= $d['gmp'];
			$scmessage_data['gmp_time']		= $d['gmp_time'] ? strtotime($d['gmp_time']) : 0;
			$scmessage_data['reg']			= $d['reg'];
			$scmessage_data['reg_time']		= $d['reg_time'] ? strtotime($d['reg_time']) : 0;
			$scmessage_data['reg_province']	= 1534;
			$scmessage_data['reg_city']		= $d['reg_city'];
			$scmessage_data['reg_county']	= $d['reg_county'];
			$scmessage_data['reg_addr']		= $d['reg_addr'];
			$scmessage_data['zipcode']		= $d['zipcode'];
			$scmessage_data['produce_province']= 1534;
			$scmessage_data['produce_city']	= $d['produce_city'];
			$scmessage_data['produce_county']= $d['produce_county'];
			$scmessage_data['produce_addr']	= $d['produce_addr'];
			$scmessage_data['postcode']	 	= $d['postcode'];
			$scmessage_data['lng']	 		= round($d['lng'], 4);
			$scmessage_data['lat']			= round($d['lng'], 4);
			$scmessage_data['legal_name']	= $d['legal_name'];
			$scmessage_data['legal_phone']	= intval($d['legal_phone']);
			$scmessage_data['super_id']		= intval($d['vet']);
			$scmessage_data['admin_id']		= $this->admin_id;
			$scmessage_data['super_id']		= time();
			$this->scmessage_model->add_scmessage($scmessage_data);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/scmessage/index.html';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}else{
				$this->db->trans_rollback();
				$info['state'] = 0;
				$info['message'] = '操作失败,刷新后重试!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
		} else {
			$data = array();
			$data['city'] = 1534;
			$data['city_name'] = $this->area_model->get_area_byid($data['city']);
			$data['county'] = $this->area_model->get_area($data['city']);
			$this->load->view('scmessage/scadd', $data);
		}
	}
	/* 编辑 */
	public function scedit() {
		if($d = $this->input->post(NULL, true)) {
			$msg = '';
			do {
				if(! $d['id']) {
					$msg = '数据错误！';break;
				}
				if(! $d['name']) {
					$msg = '企业名称必填！';break;
				}
				if(! $d['license']) {
					$msg = '生产许可证编号必填！';break;
				}
				if(! $d['license_time']) {
					$msg = '生产许可证有效期必填！';break;
				}
				if(! $d['gmp']) {
					$msg = '兽药GMP证编号必填！';break;
				}
				if(! $d['gmp_time']) {
					$msg = '兽药GMP证有效期必填！';break;
				}
				if(! $d['gmp_time']) {
					$msg = '工商执照注册号必填！';break;
				}
				if(! $d['reg']) {
					$msg = '工商执照注册号必填！';break;
				}
				if(! $d['reg_time']) {
					$msg = '成立日期必填！';break;
				}
				if(! $d['reg_city']) {
					$msg = '注册城市必填！';break;
				}
				if(! $d['reg_county']) {
					$msg = '注册区县必填！';break;
				}
				if(! $d['reg_addr']) {
					$msg = '注册地址必填！';break;
				}
				if(! $d['produce_city']) {
					$msg = '生产城市必填！';break;
				}
				if(! $d['produce_county']) {
					$msg = '生产区县必填！';break;
				}
				if(! $d['produce_addr']) {
					$msg = '生产地址必填！';break;
				}
				if(! $d['lng'] || ! $d['lat']) {
					$msg = '经纬度必填！';break;
				}
				if(! $d['legal_name']) {
					$msg = '法人姓名必填！';break;
				}
				if(! $d['legal_phone']) {
					$msg = '联系电话必填！';break;
				}
				if(! $d['charge_id']) {
					$msg = '负责人必填！';break;
				}
				if(! $d['tel']) {
					$msg = '负责人联系电话必填！';break;
				}
				if(! $d['charge_idcard']) {
					$msg = '负责人身份证必填！';break;
				}
				if($mems = $this->gfsy_model->find_members($d['tel'], '')){
					if($mems['id'] !== $d['id']) {
						$msg = '负责人手机号已经存在！'.$mems['id'];break;
					}
					
				}
				if($mems = $this->gfsy_model->find_members('', $d['charge_idcard'])){
					if($mems['id'] !== $d['id']) {
						$msg = '负责人身份证号已经存在！';break;
					}
				}
				if(! $d['vet']) {
					$msg = '监管责任人必填！';break;
				}
			} while(false);
			if(!empty($msg)) {
				$info['state'] = 0;
				$info['message'] = $msg;
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$member = array(
				'phone' => $d['tel'],
				'idcard' => $d['charge_idcard'],
				'real_name' => $d['charge_id'],
				'reg_time' => time(),
				'reg_ip' => $this->input->ip_address(),
				'type' => 6,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->up_members($member, $d['id']);
			$member_info = array(
				'uid' => $d['id'],
			);
			$this->gfsy_model->up_members_info($member_info, $d['id']);
			$scmessage_data = array();
			$scmessage_data['uid']			= $d['id'];
			$scmessage_data['name']			= $d['name'];
			$scmessage_data['license']		= $d['license'];
			$scmessage_data['license_time']	= $d['license_time'] ? strtotime($d['license_time']) : 0;
			$scmessage_data['gmp']			= $d['gmp'];
			$scmessage_data['gmp_time']		= $d['gmp_time'] ? strtotime($d['gmp_time']) : 0;
			$scmessage_data['reg']			= $d['reg'];
			$scmessage_data['reg_time']		= $d['reg_time'] ? strtotime($d['reg_time']) : 0;
			$scmessage_data['reg_province']	= 1534;
			$scmessage_data['reg_city']		= $d['reg_city'];
			$scmessage_data['reg_county']	= $d['reg_county'];
			$scmessage_data['reg_addr']		= $d['reg_addr'];
			$scmessage_data['zipcode']		= $d['zipcode'];
			$scmessage_data['produce_province']= 1534;
			$scmessage_data['produce_city']	= $d['produce_city'];
			$scmessage_data['produce_county']= $d['produce_county'];
			$scmessage_data['produce_addr']	= $d['produce_addr'];
			$scmessage_data['postcode']	 	= $d['postcode'];
			$scmessage_data['lng']	 		= round($d['lng'], 4);
			$scmessage_data['lat']			= round($d['lng'], 4);
			$scmessage_data['legal_name']	= $d['legal_name'];
			$scmessage_data['legal_phone']	= $d['legal_phone'];
			$scmessage_data['super_id']		= intval($d['vet']);
			$scmessage_data['admin_id']		= $this->admin_id;
			$scmessage_data['add_time']		= time();
			$this->scmessage_model->up_scmessage($scmessage_data, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/scmessage/index.html';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}else{
				$this->db->trans_rollback();
				$info['state'] = 0;
				$info['message'] = '操作失败,刷新后重试!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
		} else {
			$data = array();
			$data['id'] = $this->uri->segment(3);
			$data['city'] = 1534;
			$data['city_name'] = $this->area_model->get_area_byid($data['city']);
			$data['county'] = $this->area_model->get_area($data['city']);
			$data['sc'] = $this->scmessage_model->get_m('members', 'members_info', 'vet_produce', $data['id'], $this->admin_id);
			$data['super'] = $this->gfsy_model->find_members('', '', $data['sc']['super_id']);
			$this->load->view('scmessage/scedit', $data);
		}
	}
	public function scdetail() {
		$data['id'] = $this->uri->segment(3);
		$data['ms'] = $this->scmessage_model->get_m('members', 'members_info', 'vet_produce', $data['id'], $this->admin_id);
		$m = $this->gfsy_model->find_members('', '', $data['ms']['super_id']);
		$c = $this->area_model->get_area_byid($data['ms']['reg_city']);
		$t = $this->area_model->get_area_byid($data['ms']['reg_county']);
		$data['ms']['reg_area'] =  $c['name'] . $t['name'] . $data['ms']['reg_addr'];
		$c = $this->area_model->get_area_byid($data['ms']['produce_city']);
		$t = $this->area_model->get_area_byid($data['ms']['produce_county']);
		$data['ms']['produce_area'] = $c['name'] . $t['name'] . $data['ms']['produce_addr'];
		$data['ms']['surper_name'] = $m['real_name'];
		$this->load->view('scmessage/scdetail', $data);
	}
	public function solor() {
		$keywords = $this->input->post_get('keywords', TRUE);
		if($this->input->post()){
			if(! $keywords){
				$info['state'] = 0;
				$info['message'] = '请输入关键字!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}else{
				$info['state'] = 1;
				$info['message'] = urldecode($keywords);
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
		}
		$keywords = urldecode($this->input->get('query', TRUE));
		$current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
        if($current_page > 0){
            $current_page = $current_page - 1;
        }else if($current_page < 0){
            $current_page = 0;
        }
        $admin_id = '';
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('scmessage/solor');
        $config['total_rows'] = $this->scmessage_model->get_solor_num($keywords, $this->admin_id);
        $config['per_page'] = $per_page;
		$config['page_query_string'] = FALSE;
		$config['first_link'] = '首页'; // 第一页显示   
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页'; // 下一页显示   
		$config['prev_link'] = '上一页'; // 上一页显示   
		$config['cur_tag_open'] = ' <span class="current">'; // 当前页开始样式   
		$config['cur_tag_close'] = '</span>';   
		$config['num_links'] = 10;
		$config['uri_segment'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config); 
        $data['totals'] = $config['total_rows'];
        $data['page'] = $this->pagination->create_links();
        $data['p'] = $current_page;
        $scmessage = $this->scmessage_model->scmessage($keywords, $this->admin_id, $per_page, $offset * $per_page);
		foreach($scmessage as $k => $v){
			$c = $this->area_model->get_area_byid($v['reg_city']);
			$t = $this->area_model->get_area_byid($v['reg_county']);
			$scmessage[$k]['reg'] = $c['name'] . $t['name'] . $v['reg_addr'];
			$c = $this->area_model->get_area_byid($v['produce_city']);
			$t = $this->area_model->get_area_byid($v['produce_county']);
			$scmessage[$k]['produce'] = $c['name'] . $t['name'] . $v['produce_addr'];
			$gfsy = $this->gfsy_model->find_members('','',$v['super_id']);
			$scmessage[$k]['super_name'] = $gfsy['real_name'];
		}
        $data['scmessage'] = $scmessage;
		$this->load->view('scmessage/index', $data);
	}
	public function lock(){
		if($this->input->post()){
			$ids = $this->input->post_get('ids', TRUE);
			$ids = explode(',', substr($ids, 0, -1));
			if(! $ids){
				$info['state'] = 0;
				$info['message'] = '数据有误!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
			    exit;
			}else{
				$data['status'] = 3;
				$data['up_id'] = UID;
				$data['stop'] = time();
				$admin_id = '';
				if($this->scmessage_model->get_scmessage_lock($data, $ids, $this->admin_id)){
					$info['state'] = 1;
					$info['message'] = '操作成功!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}else{
					$info['state'] = 0;
					$info['message'] = '操作失败,请刷新后重试!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}
			}
		}
	}
	//解锁
	public function unlock(){
		if($this->input->post()){
			$ids = $this->input->post_get('ids', TRUE);
			$ids = explode(',', substr($ids, 0, -1));
			if(! $ids){
				$info['state'] = 0;
				$info['message'] = '数据有误!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
			    exit;
			}else{
				$data['status'] = 1;
				$data['up_id'] = UID;
				$data['stop'] = time();
				$admin_id = '';
				if($this->scmessage_model->get_scmessage_lock($data, $ids, $this->admin_id)){
					$info['state'] = 1;
					$info['message'] = '操作成功!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}else{
					$info['state'] = 0;
					$info['message'] = '操作失败,请刷新后重试!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}
			}
		}
	}
	public function sh(){
		if($this->input->post()){
			$ids = $this->input->post_get('ids', TRUE);
			$ids = explode(',', substr($ids, 0, -1));
			if(! $ids){
				$info['state'] = 0;
				$info['message'] = '数据有误!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
			    exit;
			}else{
				$data['status'] = 1;
				$data['up_id'] = UID;
				$data['up_time'] = time();
				$admin_id = '';
				if($this->scmessage_model->get_scmessage_lock($data, $ids, $admin_id)){
					$info['state'] = 1;
					$info['message'] = '操作成功!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}else{
					$info['state'] = 0;
					$info['message'] = '操作失败,请刷新后重试!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}
			}
		}
	}
	public function desh(){
		if($this->input->post()){
			$ids = $this->input->post_get('ids', TRUE);
			$ids = explode(',', substr($ids, 0, -1));
			if(! $ids){
				$info['state'] = 0;
				$info['message'] = '数据有误!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
			    exit;
			}else{
				$data['status'] = 2;
				$data['up_id'] = UID;
				$data['up_time'] = time();
				$admin_id = '';
				if($this->scmessage_model->get_scmessage_lock($data, $ids, $admin_id)){
					$info['state'] = 1;
					$info['message'] = '操作成功!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}else{
					$info['state'] = 0;
					$info['message'] = '操作失败,请刷新后重试!';
					$this->output
					    ->set_content_type('application/json', 'utf-8')
					    ->set_output(json_encode($info))
						->_display();
				    exit;
				}
			}
		}
	}
	
}