<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gfsy extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('gfsy/gfsy_model');
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
        $config['base_url'] = base_url('gfsy/index');
        $config['total_rows'] = $this->gfsy_model->get_vet_official_num($admin_id);
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
        $official = $this->gfsy_model->get_vet_official($per_page, $offset * $per_page, $admin_id);
        $data['gfsy'] = $official;
		$this->load->view('gfsy/official', $data);
	}
	public function add(){
		if($d = $this->input->post(NULL, true)){
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
			if(! $d['sex']){
				$info['state'] = 0;
				$info['message'] = '性别必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['university']){
				$info['state'] = 0;
				$info['message'] = '毕业院校必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['major']){
				$info['state'] = 0;
				$info['message'] = '专业必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['education']){
				$info['state'] = 0;
				$info['message'] = '学历必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['approval_time']){
				$info['state'] = 0;
				$info['message'] = '批准时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['cancel']){
				$info['state'] = 0;
				$info['message'] = '注销状态必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($d['cancel'] == 1 && ! $d['cancel_time']){
				$info['state'] = 0;
				$info['message'] = '注销时间必填!';
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
				'aid' => $d['aid'],
				'phone' => $d['phone'],
				'idcard' => $d['idcard'],
				'real_name' => $d['real_name'],
				'reg_time' => time(),
				'reg_ip' => $this->input->ip_address(),
				'type' => 1,
				'admin_id' => UID,
			);
			$this->db->trans_begin();
			$uid = $this->gfsy_model->add_members($member);
			$member_info = array(
				'uid' => $uid,
				'sex' => $d['sex'],
				'address' => $d['address'],
			);
			$this->gfsy_model->add_members_info($member_info);
			$member_vet = array(
				'uid' => $uid,
				'university' => $d['university'],
				'education' => $d['education'],
				'major' => $d['major'],
				'approval_time' => strtotime($d['approval_time']),
				'cancel' => $d['cancel'],
				'cancel_time' => strtotime($d['cancel_time']),
				'remark' => $d['remark'],
			);
			$this->gfsy_model->add_vet_official($member_vet);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/gfsy.html';
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
		$this->load->view('gfsy/oadd');
	}
	public function edit(){
		if($d = $this->input->post(NULL, true)){
			if(! $d['id']){
				$info['state'] = 0;
				$info['message'] = '数据有误!';
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
			if(! $d['sex']){
				$info['state'] = 0;
				$info['message'] = '性别必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['university']){
				$info['state'] = 0;
				$info['message'] = '毕业院校必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['major']){
				$info['state'] = 0;
				$info['message'] = '专业必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['education']){
				$info['state'] = 0;
				$info['message'] = '学历必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['approval_time']){
				$info['state'] = 0;
				$info['message'] = '批准时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['cancel']){
				$info['state'] = 0;
				$info['message'] = '注销状态必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if($d['cancel'] == 1 && ! $d['cancel_time']){
				$info['state'] = 0;
				$info['message'] = '注销时间必填!';
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
				'aid' => $d['aid'],
				'phone' => $d['phone'],
				'idcard' => $d['idcard'],
				'real_name' => $d['real_name'],
				'type' => 1,
			);
			$this->db->trans_begin();
			$this->gfsy_model->up_members($member, $d['id']);
			$member_info = array(
				'sex' => $d['sex'],
				'address' => $d['address'],
			);
			$this->gfsy_model->up_members_info($member_info, $d['id']);
			$member_vet = array(
				'university' => $d['university'],
				'education' => $d['education'],
				'major' => $d['major'],
				'approval_time' => strtotime($d['approval_time']),
				'cancel' => $d['cancel'],
				'cancel_time' => strtotime($d['cancel_time']),
				'remark' => $d['remark'],
			);
			$this->gfsy_model->up_vet_official($member_vet, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/gfsy.html';
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
		$da['m'] = $this->gfsy_model->get_m('members', 'members_info', 'vet_official', $id, $admin_id);
		$this->load->view('gfsy/oedit',$da);
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
        $config['base_url'] = base_url('gfsy/solor');
        $config['total_rows'] = $this->gfsy_model->get_solor_num($keywords, $admin_id);
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
        $gfsy = $this->gfsy_model->solor($keywords, $admin_id, $per_page, $offset * $per_page);
        $data['gfsy'] = $gfsy;
		$this->load->view('gfsy/official', $data);
	}
}