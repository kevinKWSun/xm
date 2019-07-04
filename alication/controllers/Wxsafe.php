<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Wxsafe extends WX_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
		$this->load->helper(array('common', 'url'));
		$this->load->model(array('wx/wxsafe_model', 'user/ausers_model'));
    }
	public function index(){
        $current_page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
		$admin_id = (array)UID;
		$per_page = 10;
        $offset = $current_page;
        $config['base_url'] = base_url('wxsafe/index');
        $config['total_rows'] = $this->wxsafe_model->get_lnum($admin_id);
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
        $lists = $this->wxsafe_model->lists($per_page, $offset * $per_page, $admin_id);
		//print_r($lists);
		// foreach($lists as $k=>$v) {
			// $lists[$k]['name'] = $this->ausers_model->get_ausers_byuid($v['admin_id']);
		// }
		if(!$this->input->is_ajax_request()) {
			$data['lists'] = $lists;
			$this->load->view('wx/saflists', $data);
		} else {
			$info['html'] = '';
			if(!empty($lists)) {
				foreach($lists as $k=>$v) {
					$timstamp = '';
					$info['html'] .= '<tr>';
					$info['html'] .= "<td>".$v['name']['realname']."</td>";
					$timstamp = empty($v['addtime']) ? $timstamp : date('Y-m-d H:i:s', $v['addtime']);
					$info['html'] .= "<td>".$timstamp."</td>";
					$info['html'] .= "<td><a  href='".base_url('wxqd/art/'.$v['id'])."'>查看</a></td>";
					$info['html'] .= '</tr>';
				}
				$info['url'] = base_url('wxsy/index/'.($current_page+1));
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
		$this->load->model(array('user/ausers_model'));
		if($d = $this->input->post(NULL, true)) { 
			if(empty($d['name'])) {
				$info['state'] = 0;
				$info['message'] = '名称不能为空！';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			if(empty($d['longitude']) || empty($d['latitude']) || empty($d['accuracy'])) {
				$info['state'] = 0;
				$info['message'] = '获取地理位置失败，请刷新页面后重新提交!';
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
				'name'		=> $d['name'],
				'longitude' => $d['longitude'],
				'latitude' 	=> $d['latitude'],
				'speed' 	=> $d['speed'] ? $d['speed'] : 0,
				'accuracy' 	=> $d['accuracy'],
				'images'	=> implode(',', $images),
				'remark'	=> $d['remark'],
				'admin_id'	=> UID,
				'addtime'	=> time()
				);
			if(!$id=$this->wxsafe_model->add($insert_data)) {
				$info['state'] = 0;
				$info['message'] = '操作失败!';
				$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($info))
				->_display();
				exit; 
			}
			//推送消息
			// $ausers = $this->ausers_model->get_ausers_byuid(UID);
			// $url = base_url('/wxsafe/art/'.$id);
			// $ret = $this->jssdk->signSend($ausers['authkey'], $ausers['realname'], date('Y-m-d H:i'), '日志', $url);
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
		$this->load->view('wx/safadd', $data);
	}
	/**/
	public function art() {
		$id = $this->uri->segment(3);
		$res = $this->wxsafe_model->get_l($id, UID);
		$res['realname'] = $this->ausers_model->get_ausers_byuid($res['admin_id']);
		$data = array();
		$data['res'] = $res;
		$this->load->view('wx/safart', $data);
	}
}