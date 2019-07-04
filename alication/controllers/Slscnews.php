<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slscnews extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model(array('slscnews/slscnews_model', 'area/area_model', 'gfsy/gfsy_model'));
		$this->load->helper('url');
		$this->admin_id = IS_ROOT ? UID : 0;
	}
	/*饲料生产企业列表*/
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
        $config['base_url'] = base_url('slscnews/index/' . $keywords);
        $config['total_rows'] = $this->slscnews_model->get_slscnews_num($keywords, $this->admin_id);
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
		$slscnews = $this->slscnews_model->get_ms($per_page, $offset * $per_page, $this->admin_id);
		foreach($slscnews as $k => $v){
			$s = $this->area_model->get_area_byid(1484);
			$c = $this->area_model->get_area_byid($v['reg_city']);
			$t = $this->area_model->get_area_byid($v['reg_county']);
			$slscnews[$k]['reg_area'] = $s['name'] . $c['name'] . $t['name'] . $v['reg_addr'];
		}
        $data['slscnews'] = $slscnews;
		$this->load->view('slscnews/index', $data);
	}
	/*添加编辑基本信息-表单*/
	public function slscadd() {
		if($d = $this->input->post(NULL, true)){
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
				if(! $d['zipcode']) {
					$msg = '邮编必填！';break;
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
				if(! $d['postcode']) {
					$msg = '邮编必填！';break;
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
				if(! $d['origin']) {
					$msg = '有无动物源性产品';break;
				}
				if(! $d['source']) {
					$msg = '动物源性原料来源地';break;
				}
				if(! $d['sale_addr']) {
					$msg = '主要销售地区';break;
				}
				if(! $d['sale_type']) {
					$msg = '销售形式';break;
				}
				if(! $d['varieties']) {
					$msg = '产品品种';break;
				}
				if(! $d['made']) {
					$msg = '有无定制产品';break;
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
				'type' => 8,
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
				'uid' 		=> $uid,
				'name' 		=> $d['name'],
				'license' 	=> $d['license'],
				'license_time' => $d['license_time'] ? strtotime($d['license_time']) : 0,
				'reg' 		=> $d['reg'],
				'reg_time' 	=> $d['reg_time'] ? strtotime($d['reg_time']) : 0,
				'reg_province' => 1484,
				'reg_city' 	=> $d['reg_city'],
				'reg_county' => $d['reg_county'],
				'reg_addr' 	=> $d['reg_addr'],
				'zipcode' 	=> $d['zipcode'],
				'produce_province' => 1484,
				'produce_city' => $d['produce_city'],
				'produce_county' => $d['produce_county'],
				'produce_addr ' => $d['produce_addr'],
				'postcode' 	=> $d['postcode'],
				'lng' 		=> $d['lng'],
				'lat' 		=> $d['lat'],
				'legal_name' => $d['legal_name'],
				'legal_phone' => $d['legal_phone'],
				'super_id' 	=> $d['vet'],
				'origin' 	=> $d['origin'],
				'source' 	=> $d['source'],
				'sale_addr' => $d['sale_addr'],
				'varieties' => $d['varieties'],
				'postcode' 	=> $d['postcode'],
				'made' 		=> $d['made'],
				'admin_id' 	=> UID,
				'add_time' 	=> time(),
				//'remark' => $d['remark']
			);
			$this->slscnews_model->add_slscnews($member_vet);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/slscnews.html';
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
			$data['county'] = $this->area_model->get_area();
			$this->load->view('slscnews/slscadd', $data);
		}
		
	}
	/*添加编辑基本信息-提交*/
	public function slscedit() {
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
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
				if(! $d['zipcode']) {
					$msg = '邮编必填！';break;
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
				if(! $d['postcode']) {
					$msg = '邮编必填！';break;
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
					$msg = '负责人手机号已经存在';break;
				}
				if($mems = $this->gfsy_model->find_members('', $d['charge_idcard'])) {
					$msg = '负责人身份证号已经存在';break;
				}
				if(! $d['vet']) {
					$msg = '监管责任人必填！';break;
				}
				if(! $d['origin']) {
					$msg = '有无动物源性产品';break;
				}
				if(! $d['source']) {
					$msg = '动物源性原料来源地';break;
				}
				if(! $d['sale_addr']) {
					$msg = '主要销售地区';break;
				}
				if(! $d['sale_type']) {
					$msg = '销售形式';break;
				}
				if(! $d['varieties']) {
					$msg = '产品品种';break;
				}
				if(! $d['made']) {
					$msg = '有无定制产品';break;
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
				'type' => 8,
				'pic' => '',
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->up_members($member, $d['id']);
			$member_vet = array(
				'uid' 		=> $d['id'],
				'name' 		=> $d['name'],
				'license' 	=> $d['license'],
				'license_time' => $d['license_time'] ? strtotime($d['license_time']) : 0,
				'reg' 		=> $d['reg'],
				'reg_time' 	=> $d['reg_time'] ? strtotime($d['reg_time']) : 0,
				'reg_province' => 1484,
				'reg_city' 	=> $d['reg_city'],
				'reg_county' => $d['reg_county'],
				'reg_addr' 	=> $d['reg_addr'],
				'zipcode' 	=> $d['zipcode'],
				'produce_province' => 1484,
				'produce_city' => $d['produce_city'],
				'produce_county' => $d['produce_county'],
				'produce_addr ' => $d['produce_addr'],
				'postcode' 	=> $d['postcode'],
				'lng' 		=> $d['lng'],
				'lat' 		=> $d['lat'],
				'legal_name' => $d['legal_name'],
				'legal_phone' => $d['legal_phone'],
				'super_id' 	=> $d['vet'],
				'origin' 	=> $d['origin'],
				'source' 	=> $d['source'],
				'sale_addr' => $d['sale_addr'],
				'varieties' => $d['varieties'],
				'postcode' 	=> $d['postcode'],
				'made' 		=> $d['made'],
				'admin_id' 	=> UID,
				'add_time' 	=> time(),
			);
			$this->slscnews_model->up_slscnews($member_vet, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/slscnews.html';
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
		$dat['m'] = $this->slscnews_model->get_m('members', 'members_info', 'feed_produce', $id, $this->admin_id);
		$dat['m']['vet_name'] = $this->gfsy_model->find_members('', '', $dat['m']['super_id']);
		$this->load->view('slscnews/slscedit', $dat);
	}
	/*查看详情*/
	public function slscdetail() {
		$data['id'] = $this->uri->segment(3);
		$data['m'] = $this->slscnews_model->get_s_bykid($data['id']);
		$data['ms'] = $this->slscnews_model->get_m('members', 'members_info', 'feed_produce', $data['id'], $this->admin_id);
		$m = $this->gfsy_model->find_members('', '', $data['ms']['super_id']);
		$s = $this->area_model->get_area_byid(1484);
		$c = $this->area_model->get_area_byid($data['ms']['reg_city']);
		$t = $this->area_model->get_area_byid($data['ms']['reg_county']);
		$data['ms']['reg_area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['reg_addr'];
		$c = $this->area_model->get_area_byid($data['ms']['produce_city']);
		$t = $this->area_model->get_area_byid($data['ms']['produce_county']);
		$data['ms']['produce_area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['produce_addr'];
		$data['ms']['vname'] = $m['real_name'];
		$this->load->view('slscnews/slscdetail', $data);
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
		$current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
        if($current_page > 0){
            $current_page = $current_page - 1;
        }else if($current_page < 0){
            $current_page = 0;
        }
        $admin_id = '';
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('slscnews/solor');
        $config['total_rows'] = $this->slscnews_model->get_solor_num($keywords, $this->admin_id);
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
        $slscnews = $this->slscnews_model->slscnews($keywords, $this->admin_id, $per_page, $offset * $per_page);
		foreach($slscnews as $k => $v){
			$s = $this->area_model->get_area_byid(1484);
			$c = $this->area_model->get_area_byid($v['reg_city']);
			$t = $this->area_model->get_area_byid($v['reg_county']);
			$slscnews[$k]['reg_area'] = $s['name'] . $c['name'] . $t['name'] . $v['reg_addr'];
		}
        $data['slscnews'] = $slscnews;
		$this->load->view('slscnews/index', $data);
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
				if($this->slscnews_model->get_slscnews_lock($data, $ids, $this->admin_id)){
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
				if($this->slscnews_model->get_slscnews_lock($data, $ids, $this->admin_id)){
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
				if($this->slscnews_model->get_slscnews_lock($data, $ids, $admin_id)){
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
				if($this->slscnews_model->get_slscnews_lock($data, $ids, $admin_id)){
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