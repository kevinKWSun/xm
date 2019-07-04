<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jymessage extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('jymessage/jymessage_model', 'area/area_model', 'gfsy/gfsy_model'));
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
        $config['base_url'] = base_url('jymessage/index');
        $config['total_rows'] = $this->jymessage_model->get_jymessage_num($this->admin_id);
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
        $jymessage = $this->jymessage_model->get_ms($per_page, $offset * $per_page, $this->admin_id);
		foreach($jymessage as $k => $v){
			$s = $this->area_model->get_area_byid($v['reg_province']);
			$c = $this->area_model->get_area_byid($v['reg_city']);
			$t = $this->area_model->get_area_byid($v['reg_county']);
			$jymessage[$k]['reg'] = $s['name'] . $c['name'] . $t['name'] . $v['reg_addr'];
			$c = $this->area_model->get_area_byid($v['deal_city']);
			$t = $this->area_model->get_area_byid($v['deal_county']);
			$jymessage[$k]['deal'] = $c['name'] . $t['name'] . $v['deal_addr'];
		}
        $data['jymessage'] = $jymessage;
		$this->load->view('jymessage/index', $data);
	}
	public function jyadd() {
		if($d = $this->input->post(NULL, true)) {
			$msg = '';
			do {
				if(! $d['name']) {
					$msg = '企业名称必填！';break;
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
				if(! $d['estab_time']) {
					$msg = '成立时间必填！';break;
				}
				if(! $d['produce_city']) {
					$msg = '经营城市必填！';break;
				}
				if(! $d['produce_county']) {
					$msg = '经营区县必填！';break;
				}
				if(! $d['produce_addr']) {
					$msg = '经营地址必填！';break;
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
				if(! $d['license']) {
					$msg = '兽药许可证编号必填！';break;
				}
				if(! $d['license_begin']) {
					$msg = '发证时间必填！';break;
				}
				if(! $d['license_time']) {
					$msg = '有效期必填！';break;
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
				'type' => 7,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->add_members($member);
			$member_info = array(
				'uid' => $uid,
			);
			$this->gfsy_model->add_members_info($member_info);
			$jymessage_data = array();
			$jymessage_data['uid']			= $uid;
			$jymessage_data['name']			= $d['name'];
			$jymessage_data['estab_time']	= $d['estab_time'] ? strtotime($d['estab_time']) : 0;
			$jymessage_data['reg_province']	= 1484;
			$jymessage_data['reg_city']		= $d['reg_city'];
			$jymessage_data['reg_county']	= $d['reg_county'];
			$jymessage_data['reg_addr']		= $d['reg_addr'];
			$jymessage_data['deal_province']= 1484;
			$jymessage_data['deal_city']	= $d['produce_city'];
			$jymessage_data['deal_county']	= $d['produce_county'];
			$jymessage_data['deal_addr']	= $d['produce_addr'];
			$jymessage_data['lng']	 		= round($d['lng'], 4);
			$jymessage_data['lat']			= round($d['lng'], 4);
			$jymessage_data['legal_name']	= $d['legal_name'];
			$jymessage_data['legal_phone']	= intval($d['legal_phone']);
			$jymessage_data['license']		= $d['license'];
			$jymessage_data['license_time']	= $d['license_time'] ? strtotime($d['license_time']) : 0;
			$jymessage_data['license_begin']= $d['license_begin'] ? strtotime($d['license_begin']) : 0;
			$jymessage_data['pic']			= $d['pic'];
			$jymessage_data['admin_id']		= $this->admin_id;
			$jymessage_data['add_time']		= time();
			$this->jymessage_model->add_jymessage($jymessage_data);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/jymessage/index.html';
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
			$this->load->view('jymessage/jyadd', $data);
		}
	}
	/* 编辑 */
	public function jyedit() {
		if($d = $this->input->post(NULL, true)) {
			$msg = '';
			do {
				if(! $d['id']) {
					$msg = '数据错误！';break;
				}
				if(! $d['name']) {
					$msg = '企业名称必填！';break;
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
				if(! $d['estab_time']) {
					$msg = '成立时间必填！';break;
				}
				if(! $d['produce_city']) {
					$msg = '经营城市必填！';break;
				}
				if(! $d['produce_county']) {
					$msg = '经营区县必填！';break;
				}
				if(! $d['produce_addr']) {
					$msg = '经营地址必填！';break;
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
				if(! $d['license']) {
					$msg = '兽药许可证编号必填！';break;
				}
				if(! $d['license_begin']) {
					$msg = '发证时间必填！';break;
				}
				if(! $d['license_time']) {
					$msg = '有效期必填！';break;
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
				'type' => 7,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->up_members($member, $d['id']);
			$jymessage_data = array();
			$jymessage_data['name']			= $d['name'];
			$jymessage_data['estab_time']	= $d['estab_time'] ? strtotime($d['estab_time']) : 0;
			$jymessage_data['reg_province']	= 1484;
			$jymessage_data['reg_city']		= $d['reg_city'];
			$jymessage_data['reg_county']	= $d['reg_county'];
			$jymessage_data['reg_addr']		= $d['reg_addr'];
			$jymessage_data['deal_province']= 1484;
			$jymessage_data['deal_city']	= $d['produce_city'];
			$jymessage_data['deal_county']	= $d['produce_county'];
			$jymessage_data['deal_addr']	= $d['produce_addr'];
			$jymessage_data['lng']	 		= round($d['lng'], 4);
			$jymessage_data['lat']			= round($d['lng'], 4);
			$jymessage_data['legal_name']	= $d['legal_name'];
			$jymessage_data['legal_phone']	= intval($d['legal_phone']);
			$jymessage_data['license']		= $d['license'];
			$jymessage_data['license_time']	= $d['license_time'] ? strtotime($d['license_time']) : 0;
			$jymessage_data['license_begin']= $d['license_begin'] ? strtotime($d['license_begin']) : 0;
			$jymessage_data['pic']			= $d['pic'];
			$jymessage_data['admin_id']		= $this->admin_id;
			$jymessage_data['add_time']		= time();
			$this->jymessage_model->up_jymessage($jymessage_data, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/jymessage/index.html';
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
			$data['jy'] = $this->jymessage_model->get_m('members', 'members_info', 'vet_deal', $data['id'], $this->admin_id);
			$this->load->view('jymessage/jyedit', $data);
		}
	}
	public function jydetail() {
		$data['id'] = $this->uri->segment(3);
		$data['ms'] = $this->jymessage_model->get_m('members', 'members_info', 'vet_deal', $data['id'], $this->admin_id);
		$s = $this->area_model->get_area_byid($data['ms']['reg_province']);
		$c = $this->area_model->get_area_byid($data['ms']['reg_city']);
		$t = $this->area_model->get_area_byid($data['ms']['reg_county']);
		$data['ms']['reg_area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['reg_addr'];
		$c = $this->area_model->get_area_byid($data['ms']['deal_city']);
		$t = $this->area_model->get_area_byid($data['ms']['deal_county']);
		$data['ms']['deal_area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['deal_addr'];
		
		$this->load->view('jymessage/jydetail', $data);
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
        $config['base_url'] = base_url('jymessage/solor');
        $config['total_rows'] = $this->jymessage_model->get_solor_num($keywords, $this->admin_id);
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
        $jymessage = $this->jymessage_model->jymessage($keywords, $this->admin_id, $per_page, $offset * $per_page);
		foreach($jymessage as $k => $v){
			$s = $this->area_model->get_area_byid($v['reg_province']);
			$c = $this->area_model->get_area_byid($v['deal_city']);
			$t = $this->area_model->get_area_byid($v['deal_county']);
			$jymessage[$k]['deal'] = $s['name'] . $c['name'] . $t['name'] . $v['deal_addr'];
		}
        $data['jymessage'] = $jymessage;
		$this->load->view('jymessage/index', $data);
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
				if($this->jymessage_model->get_jymessage_lock($data, $ids, $this->admin_id)){
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
				if($this->jymessage_model->get_jymessage_lock($data, $ids, $this->admin_id)){
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
				if($this->jymessage_model->get_jymessage_lock($data, $ids, $admin_id)){
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
				if($this->jymessage_model->get_jymessage_lock($data, $ids, $admin_id)){
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