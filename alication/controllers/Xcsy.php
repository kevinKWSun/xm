<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Xcsy extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('gfsy/xcsy_model', 'area/area_model', 'gfsy/gfsy_model'));
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
        $config['total_rows'] = $this->xcsy_model->get_vet_village_num($admin_id);
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
        $village = $this->xcsy_model->get_vet_village($per_page, $offset * $per_page, $admin_id);
        $data['xcsy'] = $village;
		$this->load->view('gfsy/village', $data);
	}
	public function add(){
		$dat['areas'] = $this->area_model->get_area();
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
			if(! $d['pic']){
				$info['state'] = 0;
				$info['message'] = '照片必须上传!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['reg_num']){
				$info['state'] = 0;
				$info['message'] = '登记证号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['regs_time']){
				$info['state'] = 0;
				$info['message'] = '登记时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['obtain_area']){
				$info['state'] = 0;
				$info['message'] = '从业区域必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['obtain_place']){
				$info['state'] = 0;
				$info['message'] = '从业地点必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['move_station']){
				$info['state'] = 0;
				$info['message'] = '基层动监站必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['induction_time']){
				$info['state'] = 0;
				$info['message'] = '基层动监站时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['opinion']){
				$info['state'] = 0;
				$info['message'] = '区市意见必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['option_time']){
				$info['state'] = 0;
				$info['message'] = '区市意见时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['education']){
				$info['state'] = 0;
				$info['message'] = '学历必填!';
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
				'type' => 2,
				'admin_id' => UID,
				'pic' => $d['pic'],
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
				'reg_num' => $d['reg_num'],
				'regs_time' => strtotime($d['regs_time']),
				'obtain_area' => $d['obtain_area'],
				'obtain_place' => $d['obtain_place'],
				'move_station' => $d['move_station'],
				'induction_time' => strtotime($d['induction_time']),
				'opinion' => $d['opinion'],
				'option_time' => strtotime($d['option_time']),
				'pic' => $d['pic'],
				'major' => $d['major'],
				'education' => $d['education'],
				'university' => $d['university'],
			);
			$this->xcsy_model->add_vet_village($member_vet);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/xcsy.html';
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
		$this->load->view('gfsy/vadd', $dat);
	}
	public function edit(){
		$da['areas'] = $this->area_model->get_area();
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
			if(! $d['pic']){
				$info['state'] = 0;
				$info['message'] = '照片必须上传!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['reg_num']){
				$info['state'] = 0;
				$info['message'] = '登记证号必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['regs_time']){
				$info['state'] = 0;
				$info['message'] = '登记时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['obtain_area']){
				$info['state'] = 0;
				$info['message'] = '从业区域必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['obtain_place']){
				$info['state'] = 0;
				$info['message'] = '从业地点必选!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['move_station']){
				$info['state'] = 0;
				$info['message'] = '基层动监站必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['induction_time']){
				$info['state'] = 0;
				$info['message'] = '基层动监站时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['opinion']){
				$info['state'] = 0;
				$info['message'] = '区市意见必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['option_time']){
				$info['state'] = 0;
				$info['message'] = '区市意见时间必填!';
				$this->output
				    ->set_content_type('application/json', 'utf-8')
				    ->set_output(json_encode($info))
					->_display();
				    exit;
			}
			if(! $d['education']){
				$info['state'] = 0;
				$info['message'] = '学历必填!';
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
				'type' => 2,
				'admin_id' => UID,
				'pic' => $d['pic'],
			);
			$this->db->trans_begin();
			$this->gfsy_model->up_members($member, $d['id']);
			$member_info = array(
				'sex' => $d['sex'],
				'address' => $d['address'],
			);
			$this->gfsy_model->up_members_info($member_info, $d['id']);
			$member_vet = array(
				'reg_num' => $d['reg_num'],
				'regs_time' => strtotime($d['regs_time']),
				'obtain_area' => $d['obtain_area'],
				'obtain_place' => $d['obtain_place'],
				'move_station' => $d['move_station'],
				'induction_time' => strtotime($d['induction_time']),
				'opinion' => $d['opinion'],
				'option_time' => strtotime($d['option_time']),
				'pic' => $d['pic'],
				'major' => $d['major'],
				'education' => $d['education'],
				'university' => $d['university'],
			);
			$this->xcsy_model->up_vet_village($member_vet, $d['id']);
			if($this->db->trans_status() === TRUE){
				$this->db->trans_commit();
				$info['state'] = 1;
				$info['message'] = '操作成功!';
				$info['url'] = '/xcsy.html';
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
		$da['m'] = $this->xcsy_model->get_m('members', 'members_info', 'vet_village', $id, $admin_id);
		$this->load->view('gfsy/vedit',$da);
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
				$info['message'] = $keywords;
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
        $config['base_url'] = base_url('xcsy/solor');
        $config['total_rows'] = $this->gfsy_model->get_solor_num($keywords, $admin_id, 2);
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
        $xcsy = $this->gfsy_model->solor($keywords, $admin_id, $per_page, $offset * $per_page, 2);
        $data['xcsy'] = $xcsy;
		$this->load->view('gfsy/village', $data);
	}
	public function getarea(){
		$id = $this->uri->segment(3);
		$c = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
		if(! $id){
			echo "<option value='0'>请先添加分类</option>";
		}else{
			$a = $this->area_model->get_area($id);
			if($a){
				foreach($a as $v){
					$id = $v['id'];
					$name = $v['name'];
					if($c == $id){
						echo "<option value='$id' selected>$name</option>";
					}else{
						echo "<option value='$id'>$name</option>";
					}
				}
			}else{
				echo "<option value='0'>请先添加分类</option>";
			}
		}
	}
}