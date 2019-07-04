<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Yclnews extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('ysclnews/synews_model');
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
        $config['base_url'] = base_url('yclnews/index');
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
        $data['synews'] = $synews;
		$this->load->view('ysclnews/synews', $data);
	}
	public function add(){
		if($d = $this->input->post(NULL, true)){
			unset($d['userfile']);
			if(! $d['num']){
				$info['state'] = 0;
				$info['message'] = '车牌号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$n = $this->synews_model->synews_nyname($d['num']);
			if($n){
				$info['state'] = 0;
				$info['message'] = '车牌号已存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['permit']){
				$info['state'] = 0;
				$info['message'] = '准运证编号填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['issuing']){
				$info['state'] = 0;
				$info['message'] = '发证机关必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['super']){
				$info['state'] = 0;
				$info['message'] = '乡镇监管责任人必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['uintxz']){
				$info['state'] = 0;
				$info['message'] = '乡镇监管责任单位必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['supers']){
				$info['state'] = 0;
				$info['message'] = '县级监管责任人必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['uintxj']){
				$info['state'] = 0;
				$info['message'] = '县级监管责任单位必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$d['admin_id'] = UID;
			$d['add_time'] = time();
			if($this->synews_model->add_synews($d)){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/yclnews.html';
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
		$this->load->view('ysclnews/vadd');
	}
	public function edit(){
		if($d = $this->input->post(NULL, true)){
			unset($d['userfile']);
			if(! $d['num']){
				$info['state'] = 0;
				$info['message'] = '车牌号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			$n = $this->synews_model->synews_nyname($d['num']);
			if($n && $n['id'] != $d['id']){
				$info['state'] = 0;
				$info['message'] = '车牌号已存在!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['permit']){
				$info['state'] = 0;
				$info['message'] = '准运证编号填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['issuing']){
				$info['state'] = 0;
				$info['message'] = '发证机关必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['super']){
				$info['state'] = 0;
				$info['message'] = '乡镇监管责任人必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['uintxz']){
				$info['state'] = 0;
				$info['message'] = '乡镇监管责任单位必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['supers']){
				$info['state'] = 0;
				$info['message'] = '县级监管责任人必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['uintxj']){
				$info['state'] = 0;
				$info['message'] = '县级监管责任单位必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($this->synews_model->up_synews($d,$d['id'])){
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/yclnews.html';
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
		$this->load->view('ysclnews/vedit', $dat);
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
        $config['base_url'] = base_url('yclnews/solor');
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
        $data['synews'] = $synews;
		$this->load->view('ysclnews/synews', $data);
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
	public function addall(){
		if($d = $this->input->post(NULL, TRUE)){
			$kid = $d['id'];
			$breed = explode(',', rtrim($d['breed'], ','));
			$types = explode(',', rtrim($d['types'], ','));
			$stock = explode(',', rtrim($d['stock'], ','));
			$c = count($stock);
			$b = count(array_unique($stock));
			if($c > 0){
				if($c != $b){
					$info['state'] = 0;
						$info['message'] = '往来名称不能重复!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
				}
				foreach($breed as $k => $v){
					if(! $stock[$k]){
						$info['state'] = 0;
						$info['message'] = '必填,往来名称!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
					}
					if(! $types[$k]){
						$info['state'] = 0;
						$info['message'] = '必填,往来类型!';
						$this->output
						    ->set_content_type('application/json', 'utf-8')
						    ->set_output(json_encode($info))
							->_display();
						    exit;
					}
					if(! $v){
						$info['state'] = 0;
						$info['message'] = '必选,运输车类型!';
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
					$info['url'] = '/yclnews.html';
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
		$data['m'] = $this->synews_model->get_s_bykid($data['id']);
		$this->load->view('ysclnews/addall', $data);
	}
	public function show(){
		$data['id'] = $this->uri->segment(3);
		$data['ms'] = $this->synews_model->get_m($data['id'], '');
		$data['c'] = $this->synews_model->get_s_bykid($data['id']);
		$this->load->view('ysclnews/show', $data);
	}
}