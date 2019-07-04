<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sljynews extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('sljynews/sljynews_model', 'area/area_model'));
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
        $config['base_url'] = base_url('sljynews/index');
        $config['total_rows'] = $this->sljynews_model->get_sljynews_num($this->admin_id);
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
        $sljynews = $this->sljynews_model->get_ms($per_page, $offset * $per_page, $this->admin_id);
		foreach($sljynews as $k => $v){
			$s = $this->area_model->get_area_byid($v['reg_province']);
			$c = $this->area_model->get_area_byid($v['reg_city']);
			$t = $this->area_model->get_area_byid($v['reg_county']);
			$sljynews[$k]['reg'] = $s['name'] . $c['name'] . $t['name'] . $v['reg_addr'];
		}
        $data['sljynews'] = $sljynews;
		$this->load->view('sljynews/index', $data);
	}
	public function sljyadd() {
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
				if(! $d['lng'] || ! $d['lat']) {
					$msg = '经纬度必填！';break;
				}
				if(! $d['legal_name']) {
					$msg = '法人姓名必填！';break;
				}
				if(! $d['legal_phone']) {
					$msg = '联系电话必填！';break;
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
			$sljynews_data = array();
			$sljynews_data['name']			= $d['name'];
			$sljynews_data['reg_province']	= 1484;
			$sljynews_data['reg_city']		= $d['reg_city'];
			$sljynews_data['reg_county']	= $d['reg_county'];
			$sljynews_data['reg_addr']		= $d['reg_addr'];
			$sljynews_data['lng']	 		= round($d['lng'], 4);
			$sljynews_data['lat']			= round($d['lng'], 4);
			$sljynews_data['zipcode']		= $d['zipcode'];
			$sljynews_data['cang']			= $d['cang'];
			$sljynews_data['license']		= $d['license'];
			$sljynews_data['license_time']	= $d['license_time'] ? strtotime($d['license_time']) : 0;
			$sljynews_data['license_begin']= $d['license_begin'] ? strtotime($d['license_begin']) : 0;
			$sljynews_data['legal_name']	= $d['legal_name'];
			$sljynews_data['legal_phone']	= intval($d['legal_phone']);
			$sljynews_data['estab_time']	= $d['estab_time'] ? strtotime($d['estab_time']) : 0;
			$sljynews_data['admin_id']		= $this->admin_id;
			$sljynews_data['add_time']		= time();
			if($this->sljynews_model->add_sljynews($sljynews_data)){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/sljynews/index.html';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}else{
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
			$this->load->view('sljynews/sljyadd', $data);
		}
	}
	/* 编辑 */
	public function sljyedit() {
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
				if(! $d['lng'] || ! $d['lat']) {
					$msg = '经纬度必填！';break;
				}
				if(! $d['legal_name']) {
					$msg = '法人姓名必填！';break;
				}
				if(! $d['legal_phone']) {
					$msg = '联系电话必填！';break;
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
			$sljynews_data = array();
			$sljynews_data['name']			= $d['name'];
			$sljynews_data['reg_province']	= 1484;
			$sljynews_data['reg_city']		= $d['reg_city'];
			$sljynews_data['reg_county']	= $d['reg_county'];
			$sljynews_data['reg_addr']		= $d['reg_addr'];
			$sljynews_data['lng']	 		= round($d['lng'], 4);
			$sljynews_data['lat']			= round($d['lng'], 4);
			$sljynews_data['zipcode']		= $d['zipcode'];
			$sljynews_data['cang']			= $d['cang'];
			$sljynews_data['license']		= $d['license'];
			$sljynews_data['license_time']	= $d['license_time'] ? strtotime($d['license_time']) : 0;
			$sljynews_data['license_begin']= $d['license_begin'] ? strtotime($d['license_begin']) : 0;
			$sljynews_data['legal_name']	= $d['legal_name'];
			$sljynews_data['legal_phone']	= intval($d['legal_phone']);
			$sljynews_data['estab_time']	= $d['estab_time'] ? strtotime($d['estab_time']) : 0;
			$sljynews_data['admin_id']		= $this->admin_id;
			$sljynews_data['add_time']		= time();
			if($this->sljynews_model->up_sljynews($sljynews_data, $d['id'])){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/sljynews/index.html';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}else{
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
			$data['cljy'] = $this->sljynews_model->get_m($data['id'], $this->admin_id);
			$this->load->view('sljynews/sljyedit', $data);
		}
	}
	public function sljydetail() {
		$data['id'] = $this->uri->segment(3);
		$data['ms'] = $this->sljynews_model->get_m($data['id'], $this->admin_id);
		$s = $this->area_model->get_area_byid($data['ms']['reg_province']);
		$c = $this->area_model->get_area_byid($data['ms']['reg_city']);
		$t = $this->area_model->get_area_byid($data['ms']['reg_county']);
		$data['ms']['reg_area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['reg_addr'];
		$this->load->view('sljynews/sljydetail', $data);
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
        $config['base_url'] = base_url('sljynews/solor');
        $config['total_rows'] = $this->sljynews_model->get_solor_num($keywords, $this->admin_id);
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
        $sljynews = $this->sljynews_model->sljynews($keywords, $this->admin_id, $per_page, $offset * $per_page);
		foreach($sljynews as $k => $v){
			$s = $this->area_model->get_area_byid($v['reg_province']);
			$c = $this->area_model->get_area_byid($v['deal_city']);
			$t = $this->area_model->get_area_byid($v['deal_county']);
			$sljynews[$k]['deal'] = $s['name'] . $c['name'] . $t['name'] . $v['deal_addr'];
		}
        $data['sljynews'] = $sljynews;
		$this->load->view('sljynews/index', $data);
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
				if($this->sljynews_model->get_sljynews_lock($data, $ids, $this->admin_id)){
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
				if($this->sljynews_model->get_sljynews_lock($data, $ids, $this->admin_id)){
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
				if($this->sljynews_model->get_sljynews_lock($data, $ids, $admin_id)){
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
				if($this->sljynews_model->get_sljynews_lock($data, $ids, $admin_id)){
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