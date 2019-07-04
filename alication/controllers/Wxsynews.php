<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wxsynews extends WX_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('synews/synews_model', 'area/area_model', 'gfsy/gfsy_model'));
		$this->load->library('pagination');
    }
	public function index(){
        $current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $admin_id = UID;
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('wxsynews/index');
        $config['total_rows'] = $this->synews_model->get_synews_num($admin_id);
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
		$data['total'] = ceil($data['totals']/$per_page);
		$data['c'] = 'index';
		$data['keywords'] = '';
        $lists = $this->synews_model->get_ms($per_page, $offset * $per_page, $admin_id);
		if(! $this->input->is_ajax_request()) {
			$data['lists'] = $lists;
			$this->load->view('wx/synews', $data);
		} else {
			$info['html'] = '';
			if(!empty($lists)) {
				foreach($lists as $k=>$v) {
					$timstamp = '';
					$info['html'] .= '<tr>';
					$info['html'] .= "<td><input id='ck' ids='".$v['id']."' name='ck' type='checkbox' value='true' /></td>";
					$info['html'] .= "<td>".$v['num']."</td>";
					$info['html'] .= "<td>";
					if($v['status']!=1){
						$info['html'] .= "<a class='layui-btn layui-btn-small' href='".base_url('wxsynews/edit/'.$v['id'])."'>编辑</a>";
					}
					$info['html'] .= "<a class='layui-btn layui-btn-small' href='".base_url('wxsynews/sedit/'.$v['id'])."'>详细</a>";
					$info['html'] .= "<a class='layui-btn layui-btn-small' href='".base_url('wxsynews/show/'.$v['id'])."'>查看</a></td>";
					$info['html'] .= '</tr>';
				}
				$info['url'] = base_url('wxsynews/index/'.($current_page+1));
				if($current_page+1 == $data['total']) {
					$info['flag'] = true;
				}
			}
			$this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($info))
			->_display();
			exit; 
		}
	}
	public function add(){
		$params = array('appId'=>'wx13084487467c28a7','appSecret'=>'f6626060bab944974744968cdc0b1d20');
		$this->load->library('jssdk', $params);
		$signPackage = $this->jssdk->getSignPackage();
		$dat = array();
		if(is_array($dat)) {
			$dat['signPackage'] = $signPackage;
		}
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
			if(! $d['addr_c']){
				$info['state'] = 0;
				$info['message'] = '区域必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr_t']){
				$info['state'] = 0;
				$info['message'] = '地点必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr']){
				$info['state'] = 0;
				$info['message'] = '具体地址必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['num']){
				$info['state'] = 0;
				$info['message'] = '禽场名称必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['lng'] || ! $d['lat']){
				$info['state'] = 0;
				$info['message'] = '经纬度必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['real_name']){
				$info['state'] = 0;
				$info['message'] = '真实姓名必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['idcard']){
				$info['state'] = 0;
				$info['message'] = '身份证号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['phone']){
				$info['state'] = 0;
				$info['message'] = '联系手机必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['card']){
				$info['state'] = 0;
				$info['message'] = '一卡通号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['camera']){
				$info['state'] = 0;
				$info['message'] = '摄像头必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['vet']){
				$info['state'] = 0;
				$info['message'] = '监管兽医必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->gfsy_model->find_members($d['phone'], '')){
				$info['state'] = 0;
				$info['message'] = '手机号已经存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->gfsy_model->find_members('', $d['idcard'])){
				$info['state'] = 0;
				$info['message'] = '身份证号已经存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$d['pic'] = rtrim($d['pic'], ',');
			if(! $d['pic']){
				$info['state'] = 0;
				$info['message'] = '身份证号及一卡通必上传!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$member = array(
				'phone' => $d['phone'],
				'idcard' => $d['idcard'],
				'real_name' => $d['real_name'],
				'reg_time' => time(),
				'reg_ip' => $this->input->ip_address(),
				'type' => 3,
				'pic' => $d['pic'],
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->add_members($member);
			$member_info = array(
				'uid' => $uid,
				//'sex' => $d['sex'],
				//'address' => $d['address'],
			);
			$this->gfsy_model->add_members_info($member_info);
			$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($d['addr_c']);
			$t = $this->area_model->get_area_byid($d['addr_t']);
			$member_vet = array(
				'uid' => $uid,
				'num' => $d['num'],
				'addr_s' => 1534,
				'addr_c' => $d['addr_c'],
				'addr_t' => $d['addr_t'],
				'addr' => $d['addr'],
				'lng' => $d['lng'],
				'lat' => $d['lat'],
				'card' => $d['card'],
				'vet' => $d['vet'],
				'camera' => $d['camera'],
				'admin_id' => UID,
				'add_time' => time(),
				'remark' => $d['remark']
			);
			$this->synews_model->add_synews($member_vet);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/wxsynews.html';
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
		}
		$this->load->view('wx/vadd', $dat);
	}
	public function edit(){
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
			if(! $d['addr_c']){
				$info['state'] = 0;
				$info['message'] = '区域必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr_t']){
				$info['state'] = 0;
				$info['message'] = '地点必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr']){
				$info['state'] = 0;
				$info['message'] = '具体地址必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['num']){
				$info['state'] = 0;
				$info['message'] = '禽场名称必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['lng'] || ! $d['lat']){
				$info['state'] = 0;
				$info['message'] = '经纬度必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['real_name']){
				$info['state'] = 0;
				$info['message'] = '真实姓名必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['idcard']){
				$info['state'] = 0;
				$info['message'] = '身份证号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['phone']){
				$info['state'] = 0;
				$info['message'] = '联系手机必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['card']){
				$info['state'] = 0;
				$info['message'] = '一卡通号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['camera']){
				$info['state'] = 0;
				$info['message'] = '摄像头必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['vet']){
				$info['state'] = 0;
				$info['message'] = '监管兽医必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$mp = $this->gfsy_model->find_members($d['phone'], '');
			if($mp && $mp['id'] != $d['id']){
				$info['state'] = 0;
				$info['message'] = '手机号已经存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$mi = $this->gfsy_model->find_members('', $d['idcard']);
			if($mi && $mi['id'] != $d['id']){
				$info['state'] = 0;
				$info['message'] = '身份证号已经存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$d['pic'] = rtrim($d['pic'], ',');
			if(! $d['pic']){
				$info['state'] = 0;
				$info['message'] = '身份证号及一卡通必上传!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$member = array(
				'phone' => $d['phone'],
				'idcard' => $d['idcard'],
				'real_name' => $d['real_name'],
				'pic' => $d['pic'],
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$this->gfsy_model->up_members($member, $d['id']);
			$member_info = array(
				'sex' => 0,
				//'address' => $d['address'],
			);
			$this->gfsy_model->up_members_info($member_info, $d['id']);
			$member_vet = array(
				'num' => $d['num'],
				'addr_c' => $d['addr_c'],
				'addr_t' => $d['addr_t'],
				'addr' => $d['addr'],
				'lng' => $d['lng'],
				'lat' => $d['lat'],
				'card' => $d['card'],
				'vet' => $d['vet'],
				'camera' => $d['camera'],
				'remark' => $d['remark']
			);
			$this->synews_model->up_synews($member_vet, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/wxsynews.html';
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
		}
		$id = $this->uri->segment(3);
		$admin_id = '';
		$dat['m'] = $this->synews_model->get_m('members', 'members_info', 'scatter', $id, $admin_id);
		$this->load->view('wx/vedit', $dat);
	}
	public function solor(){
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
		$current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $admin_id = UID;
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('wxsynews/solor');
        $config['total_rows'] = $this->synews_model->get_solor_num($keywords, $admin_id);
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
		$data['total'] = ceil($data['totals']/$per_page);
        $data['p'] = $current_page;
		$data['c'] = 'index';
		$data['keywords'] = $keywords;
        $lists = $this->synews_model->synews($keywords, $admin_id, $per_page, $offset * $per_page);
		if(! $this->input->is_ajax_request()) {
			$data['lists'] = $lists;
			$this->load->view('wx/synews', $data);
		} else {
			$info['html'] = '';
			if(!empty($lists)) {
				foreach($lists as $k=>$v) {
					$timstamp = '';
					$info['html'] .= '<tr>';
					$info['html'] .= "<td><input id='ck' ids='".$v['id']."' name='ck' type='checkbox' value='true' /></td>";
					$info['html'] .= "<td>".$v['num']."</td>";
					$info['html'] .= "<td>";
					if($v['status']!=1){
						$info['html'] .= "<a class='layui-btn layui-btn-small' href='".base_url('wxsynews/edit/'.$v['id'])."'>编辑</a>";
					}
					$info['html'] .= "<a class='layui-btn layui-btn-small' href='".base_url('wxsynews/sedit/'.$v['id'])."'>详细</a>";
					$info['html'] .= "<a class='layui-btn layui-btn-small' href='".base_url('wxsynews/show/'.$v['id'])."'>查看</a></td>";
					$info['html'] .= '</tr>';
				}
				$info['url'] = base_url('wxsynews/index/'.($current_page+1)).'?query='.$keywords;
				if($current_page+1 == $data['total']) {
					$info['flag'] = true;
				}
			}
			$this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($info))
			->_display();
			exit; 
		}
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
				if($this->synews_model->get_synews_lock($data, $ids, $admin_id)){
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
				if($this->synews_model->get_synews_lock($data, $ids, $admin_id)){
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
				if($this->synews_model->get_synews_lock($data, $ids, $admin_id)){
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
				if($this->synews_model->get_synews_lock($data, $ids, $admin_id)){
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
	public function sedit(){
		if($d = $this->input->post(NULL, TRUE)){
			$kid = $d['id'];
			$breed = explode(',', rtrim($d['breed'], ','));
			$types = explode(',', rtrim($d['types'], ','));
			$stock = explode(',', rtrim($d['stock'], ','));
			$unit = explode(',', rtrim($d['unit'], ','));
			$c = count($breed);
			$b = count(array_unique($breed));
			if($c > 0){
				if($c != $b){
					$info['state'] = 0;
						$info['message'] = '畜禽种类不能重复!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
				}
				foreach($breed as $k => $v){
					if(! $v){
						$info['state'] = 0;
						$info['message'] = '必选,畜禽种类!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
					}/* 
					if($this->synews_model->get_s_bys($kid, $v)){
						$info['state'] = 0;
						$info['message'] = '畜禽种类已存在!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
					} */
					if(! $stock[$k]){
						$info['state'] = 0;
						$info['message'] = '存栏数量必须大于0!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
					}
					$data[$k] = array(
						'kid' => $kid,
						'breed' => $v,
						'types' => $types[$k],
						'stock' => $stock[$k],
						'unit' => $unit[$k],
						'admin_id' => UID,
						'add_time' => time()
					);
				}
				$this->db->trans_begin();
				//如果存在删除全部
				if($this->synews_model->get_s_bykid($kid)){
					$this->synews_model->del_s($kid);
				}
				//重新插入全部
				$this->synews_model->addall_s($data);
				if($this->db->trans_status() === TRUE){
					$this->db->trans_commit();
					$info['state'] = 1;
					$info['message'] = '操作成功!';
					$info['url'] = '/wxsynews.html';
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
			}else{
				$info['state'] = 0;
				$info['message'] = '请先完善必填项!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
		}
		$data['id'] = $this->uri->segment(3);
		$data['breed'] = $this->config->item('breed');
		$data['unit'] = $this->config->item('unit');
		$data['variety'] = $this->config->item('variety');
		$data['m'] = $this->synews_model->get_s_bykid($data['id']);
		$this->load->view('wx/addall', $data);
	}
	public function show(){
		$data['id'] = $this->uri->segment(3);
		$data['breed'] = $this->config->item('breed');
		$data['unit'] = $this->config->item('unit');
		$data['variety'] = $this->config->item('variety');
		$data['m'] = $this->synews_model->get_s_bykid($data['id']);
		$data['ms'] = $this->synews_model->get_m('members', 'members_info', 'scatter', $data['id'], '');
		$m = $this->gfsy_model->find_members('', '', $data['ms']['vet']);
		$s = $this->area_model->get_area_byid(1534);
		$c = $this->area_model->get_area_byid($data['ms']['addr_c']);
		$t = $this->area_model->get_area_byid($data['ms']['addr_t']);
		$data['ms']['area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['addr'];
		$data['ms']['vname'] = $m['real_name'];
		$this->load->view('wx/show', $data);
	}
}