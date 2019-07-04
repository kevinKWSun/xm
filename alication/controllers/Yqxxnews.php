<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Yqxxnews extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('yqxxnews/synews_model', 'area/area_model'));
		$this->load->library('pagination');
    }
	public function index(){
        $current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
        if($current_page > 0){
            $current_page = $current_page - 1;
        }else if($current_page < 0){
            $current_page = 0;
        }
        $admin_id = '';
		$per_page = 8;
        $offset = $current_page;
        $config['base_url'] = base_url('synews/index');
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
        $synews = $this->synews_model->get_ms($per_page, $offset * $per_page, $admin_id);
		foreach($synews as $k => $v){
			$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($v['addr_c']);
			$t = $this->area_model->get_area_byid($v['addr_t']);
			$synews[$k]['area'] = $s['name'] . $c['name'] . $t['name'] . $v['addr'];
		}
        $data['synews'] = $synews;
		$this->load->view('yqxxnews/synews', $data);
	}
	public function add(){
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
			if(! $d['lng'] || ! $d['lat']){
				$info['state'] = 0;
				$info['message'] = '经纬度必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
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
			$d['times'] = strtotime($d['times']);
			if(! $d['times']){
				$info['state'] = 0;
				$info['message'] = '报告时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr']){
				$info['state'] = 0;
				$info['message'] = '疫情地点必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			
			if(! $d['suspected']){
				$info['state'] = 0;
				$info['message'] = '疑似疫病必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['type']){
				$info['state'] = 0;
				$info['message'] = '发病种类必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$d['admin_id'] = UID;
			$d['add_time'] = time();
			if($this->synews_model->add_synews($d)){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/yqxxnews.html';
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
		}
		$this->load->view('yqxxnews/vadd', $dat);
	}
	public function edit(){
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
			if(! $d['lng'] || ! $d['lat']){
				$info['state'] = 0;
				$info['message'] = '经纬度必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
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
			$d['times'] = strtotime($d['times']);
			if(! $d['times']){
				$info['state'] = 0;
				$info['message'] = '报告时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['addr']){
				$info['state'] = 0;
				$info['message'] = '疫情地点必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			
			if(! $d['suspected']){
				$info['state'] = 0;
				$info['message'] = '疑似疫病必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['type']){
				$info['state'] = 0;
				$info['message'] = '发病种类必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->synews_model->up_synews($d, $d['id'])){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/yqxxnews.html';
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
		}
		$id = $this->uri->segment(3);
		$admin_id = '';
		$dat['m'] = $this->synews_model->get_m($id, $admin_id);
		$this->load->view('yqxxnews/vedit', $dat);
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
        $config['base_url'] = base_url('yqxxnews/solor');
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
        $data['p'] = $current_page;
        $synews = $this->synews_model->synews($keywords, $admin_id, $per_page, $offset * $per_page);
        foreach($synews as $k => $v){
			$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($v['addr_c']);
			$t = $this->area_model->get_area_byid($v['addr_t']);
			$synews[$k]['area'] = $s['name'] . $c['name'] . $t['name'] . $v['addr'];
		}
        $data['synews'] = $synews;
		$this->load->view('yqxxnews/synews', $data);
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
	public function show(){
		$data['id'] = $this->uri->segment(3);
		$data['ms'] = $this->synews_model->get_m($data['id'], '');
		$s = $this->area_model->get_area_byid(1534);
		$c = $this->area_model->get_area_byid($data['ms']['addr_c']);
		$t = $this->area_model->get_area_byid($data['ms']['addr_t']);
		$data['ms']['area'] = $s['name'] . $c['name'] . $t['name'] . $data['ms']['addr'];
		$this->load->view('yqxxnews/show', $data);
	}
}