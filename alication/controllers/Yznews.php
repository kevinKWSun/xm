<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Yznews extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model(array('yznews/yznews_model', 'area/area_model', 'gfsy/gfsy_model'));
		$this->load->helper('url');
		$this->admin_id = IS_ROOT ? UID : 0;
	}
	/*规模化养殖场列表*/
	public function index() {
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
		$keywords = $this->uri->segment(3);
		$current_page = $this->uri->segment(4) ? $this->uri->segment(4) : 1;
        if($current_page > 0){
            $current_page = $current_page - 1;
        }else if($current_page < 0){
            $current_page = 0;
        }
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('yznews/index/' . $keywords);
        $config['total_rows'] = $this->yznews_model->get_farm_num($keywords, $this->admin_id);
        $config['per_page'] = $per_page;
		$config['page_query_string'] = FALSE;
		$config['first_link'] = '首页'; // 第一页显示   
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页'; // 下一页显示   
		$config['prev_link'] = '上一页'; // 上一页显示   
		$config['cur_tag_open'] = ' <span class="current">'; // 当前页开始样式   
		$config['cur_tag_close'] = '</span>';   
		$config['num_links'] = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config); 
        $data['totals'] = $config['total_rows'];
        $data['page'] = $this->pagination->create_links();
        $data['p'] = $current_page;
		$yznews = $this->yznews_model->get_ms($per_page, $offset * $per_page, $this->admin_id);
		foreach($yznews as $k => $v){
			$m = $this->gfsy_model->find_members('', '', $v['vet']);
			$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($v['addr_city']);
			$t = $this->area_model->get_area_byid($v['addr_county']);
			$yznews[$k]['area'] = $s['name'] . $c['name'] . $t['name'] . $v['addr'];
			$yznews[$k]['vname'] = $m['real_name'];
		}
        $data['yznews'] = $yznews;
		$this->load->view('yznews/index', $data);
	}
	/*添加编辑基本信息-表单*/
	public function yznewsadd() {
		if($d = $this->input->post(NULL, true)){
			if(! $d['addr_city']){
				$info['state'] = 0;
				$info['message'] = '区域必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr_county']){
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
			if(! $d['name']){
				$info['state'] = 0;
				$info['message'] = '禽场名称必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(empty($d['cate'])) {
				$info['state'] = 0;
				$info['message'] = '养殖种类必填!';
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
			if(! $d['legal_name']){
				$info['state'] = 0;
				$info['message'] = '法人姓名必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['phone']){
				$info['state'] = 0;
				$info['message'] = '法人手机必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['charge_id']){
				$info['state'] = 0;
				$info['message'] = '负责人姓名必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['tel']){
				$info['state'] = 0;
				$info['message'] = '负责人联系电话必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['charge_idcard']){
				$info['state'] = 0;
				$info['message'] = '负责人身份证号必填!';
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
			if(! $d['prevent_num']){
				$info['state'] = 0;
				$info['message'] = '防疫合格证必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['prevent_num']){
				$info['state'] = 0;
				$info['message'] = '防疫合格证必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['issuing_time']){
				$info['state'] = 0;
				$info['message'] = '发放时间必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->gfsy_model->find_members($d['tel'], '')){
				$info['state'] = 0;
				$info['message'] = '手机号已经存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->gfsy_model->find_members('', $d['charge_idcard'])){
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
				$info['message'] = '厂容厂貌必上传!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['aid']){
				$info['state'] = 0;
				$info['message'] = '请绑定登录账号!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->gfsy_model->find_members('', '', '', $d['aid'])){
				$info['state'] = 0;
				$info['message'] = '登录账号已绑定其他用户!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$member = array(
				'aid' 	=> $d['aid'],
				'phone' => $d['tel'],
				'idcard' => $d['charge_idcard'],
				'real_name' => $d['charge_id'],
				'reg_time' => time(),
				'reg_ip' => $this->input->ip_address(),
				'type' => 5,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->add_members($member);
			$member_info = array(
				'uid' => $uid,
			);
			$this->gfsy_model->add_members_info($member_info);
			$member_vet = array(
				'uid' => $uid,
				'name' => $d['name'],
				'cate' => implode(',', $d['cate']),
				'addr_province' => 1484,
				'addr_city' => $d['addr_city'],
				'addr_county' => $d['addr_county'],
				'addr' => $d['addr'],
				'lng' => $d['lng'],
				'lat' => $d['lat'],
				'legal_name' => $d['legal_name'],
				'legal_phone' => $d['phone'],
				'vet' => $d['vet'],
				'point' => $d['point'],
				'prevent_num' => $d['prevent_num'],
				'issuing_time' => strtotime($d['issuing_time']),
				'pic' => $d['pic'],
				'admin_id' => UID,
				'add_time' => time(),
				//'remark' => $d['remark']
			);
			$this->yznews_model->add_yznews($member_vet);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/yznews.html';
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
			$data['cate']	= $this->config->item('breed');
			$this->load->view('yznews/yznewsadd', $data);
		}
		
	}
	/*添加编辑基本信息-提交*/
	public function yznewsedit() {
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
			if(! $d['addr_city']){
				$info['state'] = 0;
				$info['message'] = '区域必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr_county']){
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
			if(! $d['name']){
				$info['state'] = 0;
				$info['message'] = '禽场名称必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['cate']){
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
			if(! $d['legal_name']){
				$info['state'] = 0;
				$info['message'] = '法人姓名必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['phone']){
				$info['state'] = 0;
				$info['message'] = '法人手机必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['charge_id']){
				$info['state'] = 0;
				$info['message'] = '负责人姓名必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['tel']){
				$info['state'] = 0;
				$info['message'] = '负责人联系电话必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['charge_idcard']){
				$info['state'] = 0;
				$info['message'] = '负责人身份证号必填!';
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
			if(! $d['prevent_num']){
				$info['state'] = 0;
				$info['message'] = '防疫合格证必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['prevent_num']){
				$info['state'] = 0;
				$info['message'] = '防疫合格证必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['issuing_time']){
				$info['state'] = 0;
				$info['message'] = '发放时间必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($mems = $this->gfsy_model->find_members($d['tel'], '')){
				if($mems['id'] !== $d['id']) {
					$info['state'] = 0;
					$info['message'] = '手机号已经存在!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
				}
				
			}
			if($mems = $this->gfsy_model->find_members('', $d['charge_idcard'])){
				if($mems['id'] !== $d['id']) {
					$info['state'] = 0;
					$info['message'] = '身份证号已经存在!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
				}
			}
			$d['pic'] = rtrim($d['pic'], ',');
			if(! $d['pic']){
				$info['state'] = 0;
				$info['message'] = '厂容厂貌必上传!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['aid']){
				$info['state'] = 0;
				$info['message'] = '请绑定登录账号!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$aid = $this->gfsy_model->find_members('', '', '', $d['aid']);
			if($aid && $aid['id'] != $d['id']){
				$info['state'] = 0;
				$info['message'] = '登录账号已绑定其他用户!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$member = array(
				'aid'	=> $d['aid'],
				'phone' => $d['tel'],
				'idcard' => $d['charge_idcard'],
				'real_name' => $d['charge_id'],
				'reg_time' => time(),
				'reg_ip' => $this->input->ip_address(),
				'type' => 5,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->up_members($member, $d['id']);
			$member_vet = array(
				'uid' => $d['id'],
				'name' => $d['name'],
				'cate' => implode(',', $d['cate']),
				'addr_province' => 1534,
				'addr_city' => $d['addr_city'],
				'addr_county' => $d['addr_county'],
				'addr' => $d['addr'],
				'lng' => $d['lng'],
				'lat' => $d['lat'],
				'legal_name' => $d['legal_name'],
				'legal_phone' => $d['phone'],
				'vet' => $d['vet'],
				'point' => $d['point'],
				'prevent_num' => $d['prevent_num'],
				'issuing_time' => strtotime($d['issuing_time']),
				'pic' => $d['pic'],
				'admin_id' => UID,
				'add_time' => time(),
				//'remark' => $d['remark']
			);
			$this->yznews_model->up_yznews($member_vet, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/yznews.html';
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
		$dat['city'] = 1534;
		$dat['city_name'] = $this->area_model->get_area_byid($dat['city']);
		$dat['county'] = $this->area_model->get_area($dat['city']);
		$dat['m'] = $this->yznews_model->get_m('members', 'members_info', 'farm', $id, $this->admin_id);
		$dat['m']['cate'] = explode(',', $dat['m']['cate']);
		$dat['m']['vet_name'] = $this->gfsy_model->find_members('', '', $dat['m']['vet']);
		$dat['cate'] = $this->config->item('breed');
		$this->load->view('yznews/yznewsedit', $dat);
	}
	/*查看详情*/
	public function yznewsdetail() {
		$data['id'] = $this->uri->segment(3);
		$data['breed'] = $this->config->item('breed');
		$data['unit'] = $this->config->item('unit');
		$data['variety'] = $this->config->item('variety');
		$data['m'] = $this->yznews_model->get_s_bykid($data['id']);
		$data['ms'] = $this->yznews_model->get_m('members', 'members_info', 'farm', $data['id'], $this->admin_id);
		$data['ms']['cate'] = explode(',', $data['ms']['cate']);
		$data['cate']	= $this->config->item('breed');
		$m = $this->gfsy_model->find_members('', '', $data['ms']['vet']);
		$s = $this->area_model->get_area_byid(1534);
		$c = $this->area_model->get_area_byid($data['ms']['addr_city']);
		$t = $this->area_model->get_area_byid($data['ms']['addr_county']);
		$data['ms']['area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['addr'];
		$data['ms']['vname'] = $m['real_name'];
		$this->load->view('yznews/yznewsdetail', $data);
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
		$keywords = urldecode($this->input->get('query'));
		$current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
        if($current_page > 0){
            $current_page = $current_page - 1;
        }else if($current_page < 0){
            $current_page = 0;
        }
        $admin_id = '';
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('yznews/solor');
        $config['total_rows'] = $this->yznews_model->get_solor_num($keywords, $this->admin_id);
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
        $yznews = $this->yznews_model->yznews($keywords, $this->admin_id, $per_page, $offset * $per_page);
		foreach($yznews as $k => $v){
			$m = $this->gfsy_model->find_members('', '', $v['vet']);
			$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($v['addr_city']);
			$t = $this->area_model->get_area_byid($v['addr_county']);
			$yznews[$k]['area'] = $s['name'] . $c['name'] . $t['name'] . $v['addr'];
			$yznews[$k]['vname'] = $m['real_name'];
		}
        $data['yznews'] = $yznews;
		$this->load->view('yznews/index', $data);
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
				if($this->yznews_model->get_yznews_lock($data, $ids, $this->admin_id)){
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
				if($this->yznews_model->get_yznews_lock($data, $ids, $this->admin_id)){
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
				if($this->yznews_model->get_yznews_lock($data, $ids, $admin_id)){
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
				if($this->yznews_model->get_yznews_lock($data, $ids, $admin_id)){
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
	public function stock(){
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
					} 
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
				if($this->yznews_model->get_s_bykid($kid)){
					$this->yznews_model->del_s($kid);
				}
				//重新插入全部
				$this->yznews_model->addall_s($data);
				if($this->db->trans_status() === TRUE){
					$this->db->trans_commit();
					$info['state'] = 1;
					$info['message'] = '操作成功!';
					$info['url'] = '/yznews.html';
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
		$data['m'] = $this->yznews_model->get_s_bykid($data['id']);
		$this->load->view('yznews/addall', $data);
	}
	/* 统计 */
	public function tj() {
		
	}
}