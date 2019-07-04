<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wzrknews extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('wzrknews/wzrknews_model', 'yjwzk/synews_model'));
		$this->load->library('pagination');
    }
	//
	public function getchild(){
		$key = $this->uri->segment(3) ? $this->uri->segment(3) : 1;
		$type = $this->uri->segment(4) ? $this->uri->segment(4) : 1;
		$o = '';
		$cy = '';
		$c = '';
		if($type == 1){
			$i = 0;
			foreach(get_wzmc()[$key] as $k => $vc){
				if($i == 0){
					$vk = $k;
					$c = get_dig()[$vk];
				}
				$o .=  "<option value='$k'>$vc</option>";
				$i++;
			}
			foreach(get_company()[$vk] as $k => $vc){
				$cy .=  "<option value='$k'>$vc</option>";
			}
		}elseif($type == 2){
			$o = get_dig()[$key];
			foreach(get_company()[$key] as $k => $vc){
				$cy .=  "<option value='$k'>$vc</option>";
			}
		}
		$data['o'] = $o;
		$data['cy'] = $cy;
		$data['c'] = $c;
		$this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($data))
			->_display();
			exit;
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
        $config['base_url'] = base_url('wzrknews/index');
        $config['total_rows'] = $this->wzrknews_model->get_wzrknews_num($admin_id);
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
        $wzrknews = $this->wzrknews_model->get_ms($per_page, $offset * $per_page, $admin_id);
        $data['wzrknews'] = $wzrknews;
		$this->load->view('wzrknews/wzrknews', $data);
	}
	public function add(){
		if($d = $this->input->post(NULL, true)){
			if(! $d['cate']){
				$info['state'] = 0;
				$info['message'] = '物资类别必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['cate_name']){
				$info['state'] = 0;
				$info['message'] = '物资名称必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['unit']){
				$info['state'] = 0;
				$info['message'] = '单位有误!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['num']){
				$info['state'] = 0;
				$info['message'] = '入库数量必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['manufacturer']){
				$info['state'] = 0;
				$info['message'] = '生产厂家必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['batch_num']){
				$info['state'] = 0;
				$info['message'] = '生产批号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['sign_uint']){
				$info['state'] = 0;
				$info['message'] = '签收单位必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['sign_person']){
				$info['state'] = 0;
				$info['message'] = '签收人必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['input_time']){
				$info['state'] = 0;
				$info['message'] = '入库时间必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['expiry_time']){
				$info['state'] = 0;
				$info['message'] = '有效期时间必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$d['input_time'] = strtotime($d['input_time']);
			$d['expiry_time'] = strtotime($d['expiry_time']);
			$d['admin_id'] = UID;
			$d['add_time'] = time();
			$d['bname'] = get_wzlb()[$d['cate']] . ' ' . get_wzmc()[$d['cate']][$d['cate_name']] . ' ' . get_company()[$d['cate_name']][$d['manufacturer']];
			if($this->wzrknews_model->add_wzrknews($d)){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/wzrknews.html';
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
		$this->load->view('wzrknews/vadd');
	}
	public function edit(){
		$dat['areas'] = $this->area_model->get_area();
		if($d = $this->input->post(NULL, true)){
			if(! $d['cate']){
				$info['state'] = 0;
				$info['message'] = '物资类别必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['cate_name']){
				$info['state'] = 0;
				$info['message'] = '物资名称必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['unit']){
				$info['state'] = 0;
				$info['message'] = '单位有误!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['num']){
				$info['state'] = 0;
				$info['message'] = '入库数量必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['manufacturer']){
				$info['state'] = 0;
				$info['message'] = '生产厂家必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['batch_num']){
				$info['state'] = 0;
				$info['message'] = '生产批号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['sign_uint']){
				$info['state'] = 0;
				$info['message'] = '签收单位必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['sign_person']){
				$info['state'] = 0;
				$info['message'] = '签收人必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['input_time']){
				$info['state'] = 0;
				$info['message'] = '入库时间必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['expiry_time']){
				$info['state'] = 0;
				$info['message'] = '有效期时间必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$d['input_time'] = strtotime($d['input_time']);
			$d['expiry_time'] = strtotime($d['expiry_time']);
			$d['bname'] = get_wzlb()[$d['cate']] . ' ' . get_wzmc()[$d['cate']][$d['cate_name']] . ' ' . get_company()[$d['cate_name']][$d['manufacturer']];
			if($this->wzrknews_model->up_wzrknews($d, $d['id'])){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/wzrknews.html';
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
		$dat['m'] = $this->wzrknews_model->get_m($id, $admin_id);
		$this->load->view('wzrknews/vedit', $dat);
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
        $config['base_url'] = base_url('wzrknews/solor');
        $config['total_rows'] = $this->wzrknews_model->get_solor_num($keywords, $admin_id);
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
        $wzrknews = $this->wzrknews_model->wzrknews($keywords, $admin_id, $per_page, $offset * $per_page);
        $data['wzrknews'] = $wzrknews;
		$this->load->view('wzrknews/wzrknews', $data);
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
				if($this->wzrknews_model->get_wzrknews_lock($data, $ids, $admin_id)){
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
				if($this->wzrknews_model->get_wzrknews_lock($data, $ids, $admin_id)){
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
		$data['ms'] = $this->wzrknews_model->get_m($data['id'], '');
		$this->load->view('wzrknews/show', $data);
	}
	public function lists(){
		if($this->input->post()){
			$keywords = $this->input->post('keywords', TRUE);
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
        $config['base_url'] = base_url('wzrknews/lists');
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
        $wzrknews = $this->synews_model->synews($keywords, $admin_id, $per_page, $offset * $per_page);
        $data['yjwzk'] = $wzrknews;
		$this->load->view('wzrknews/lists', $data);
	}
}