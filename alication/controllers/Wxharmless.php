<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wxharmless extends WX_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->library('pagination');
		$this->load->helper(array('common', 'url'));
		$this->load->model(array('yznews/yznews_model', 'wx/harm_model', 'user/ausers_model'));
    }
	//列表
	public function index(){
		$current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        // if($current_page > 0){
            // $current_page = $current_page - 1;
        // }else if($current_page < 0){
            // $current_page = 0;
        // }
		$admin_id = (array)UID;
		$per_page = 10;
        $offset = $current_page;
        $config['base_url'] = base_url('wxharmless/index');
        $config['total_rows'] = $this->harm_model->get_lnum($admin_id);
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
		$data['total'] = ceil($data['totals']/$per_page);
        $data['page'] = $this->pagination->create_links();
        $data['p'] = $current_page;
        $lists = $this->harm_model->lists($per_page, $offset * $per_page, $admin_id);
		if(! $this->input->is_ajax_request()) {
			$data['lists'] = $lists;
			$this->load->view('wx/harm/harm', $data);
		} else {
			$info['html'] = '';
			if(!empty($lists)) {
				foreach($lists as $k=>$v) {
					$timstamp = '';
					$info['html'] .= '<tr>';
					$info['html'] .= "<td>".$v['hname']."</td>";
					$timstamp = empty($v['add_time']) ? $timstamp : date('Y-m-d H:i', $v['add_time']);
					$info['html'] .= "<td>".$timstamp."</td>";
					$info['html'] .= "<td><a  href='".base_url('wxharmless/show/'.$v['id'])."'>查看</a></td>";
					$info['html'] .= '</tr>';
				}
				$info['url'] = base_url('wxharmless/index/'.($current_page+1));
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
	//新增
	public function add(){
		$params = array('appId'=>'wx13084487467c28a7','appSecret'=>'f6626060bab944974744968cdc0b1d20');
		$this->load->library('jssdk', $params);
		$this->load->model(array('user/ausers_model'));
		if($d = $this->input->post(NULL, true)) { 
			if(empty($d['lng']) || empty($d['lat'])) {
				$info['state'] = 0;
				$info['message'] = '获取地理位置失败，请刷新页面后重新提交!';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			if(! $d['hname']){
				$info['state'] = 0;
				$info['message'] = '无法找到养殖场信息!';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			if(! $d['remark']){
				$info['state'] = 0;
				$info['message'] = '必填,申报信息!';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			if(empty($d['img'])) {
				$info['state'] = 0;
				$info['message'] = '请拍照！';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			$params = array(
				'foldername' => 'uploads/sign',
				'media_id'	 => ''
				);
			
			foreach($d['img'] as $v) {
				$params['media_id'] = $v;
				$resImg = $this->jssdk->getImg($params);
				if(empty($resImg)) {
					$info['state'] = 0;
					$info['message'] = '拍照图片保存失败！';
					$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($info))
					->_display();
					exit; 
				}
				$images[] = $this->jssdk->getImg($params);
			}
			$insert_data = array(
				'hname' => $d['hname'],
				'yid' => UID,
				'lng' => $d['lng'],
				'lat' 	=> $d['lat'],
				'images'	=> implode(',', $images),
				'con'	=> $d['remark'],
				'admin_id'	=> UID,
				'add_time'	=> time()
			);
			if(! $id=$this->harm_model->add($insert_data)) {
				$info['state'] = 0;
				$info['message'] = '操作失败!';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			//推送消息
			$ausers = $this->ausers_model->get_ausers_byuid(UID);
			$url = base_url('/wxharmless/show/'.$id);
			$ret = $this->jssdk->signSends($ausers['authkey'], $ausers['realname'], date('Y-m-d H:i'), '无害化', $url);
			$info['state'] = 1;
			$info['message'] = '操作成功！';
			$this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($info))
			->_display();
			exit; 
		}
		$signPackage = $this->jssdk->getSignPackage();
		$data = array();
		if(is_array($data)) {
			$data['signPackage'] = $signPackage;
		}
		$members = $this->yznews_model->get_members_one(UID);
		$farm = $this->yznews_model->get_farm_one($members['id']);
		$data['fname'] = $farm['name'];
		$this->load->view('wx/harm/add', $data);
	}
	//流转
	public function edit(){
		
	}
	//查看
	public function show(){
		$id = $this->uri->segment(3);
		$res = $this->harm_model->get_l($id, UID);
		//$res['realname'] = $this->ausers_model->get_ausers_byuid($res['admin_id']);
		$data = array();
		$data['res'] = $res;
		$this->load->view('wx/harm/show', $data);
	}
}