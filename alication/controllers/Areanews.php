<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Areanews extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('area/area_model');
    }
	public function index(){
		$areas = $this->area_model->get_area();
		foreach($areas as $k => $s){
			$areas[$k]['childs'] = $this->area_model->get_area($s['id']);
		}
		$data['areas'] = $areas;
		$data['area'] = $areas;
		//$this->parser->parse('admin', $data);
		$this->load->view('area/index', $data);
	}
	public function solor(){
		if($s = $this->input->post(NULL, TRUE)){
			$kw = $s['keywords'];
			$pid = $s['pid'];
			if(! $kw && ! $pid){
				$info['state'] = 1;
				$info['message'] = '关键词或所属地区不能为空!';
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($info))
					->_display();
					exit;
			}else{
				$info['state'] = 1;
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($info))
					->_display();
					exit;
			}
		}else{
			$name = $this->uri->segment(3);
			$pid = $this->uri->segment(4);
			$pid = $pid ? $pid : 1534;
			$areas = $this->area_model->get_solor($name, $pid);
			foreach($areas as $k => $s){
				$areas[$k]['childs'] = $this->area_model->get_area($s['id']);
			}
			$data['areas'] = $areas;
			$area = $this->area_model->get_area();
			$data['area'] = $area;
			$this->load->view('area/index', $data);
		}
	}
	public function add(){
		if($add = $this->input->post(NULL, TRUE)){
			$id = $this->uri->segment(3);
			$name = explode(',', substr($add['title'], 0, -1));
			foreach($name as $k => $v){
				if(! $v){
					$info['state'] = 0;
					$info['message'] = '必填,监管站名称!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
				}
				if($this->area_model->get_area_bytitle($v, $id) > 0){
					$info['state'] = 0;
					$info['message'] = '监管站名称已存在!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
				}
				$data[$k] = array(
					'name' => $name[$k],
					'pid' => $id,
					'type' => 3
				);
			}
			if($this->area_model->addall_area($data)){
				$info['state'] = 1;
					$info['message'] = '操作成功!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
			}else{
				$info['state'] = 0;
					$info['message'] = '操作失败!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
			}
		}else{
			$data['id'] = $this->uri->segment(3);
			$this->load->view('area/add', $data);
		}
	}
	public function edit(){
		if($add = $this->input->post(NULL, TRUE)){
			$id = $this->uri->segment(3);
			$name = substr($add['title'], 0, -1);
			if(! $name){
				$info['state'] = 0;
				$info['message'] = '必填,监管站名称!';
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($info))
					->_display();
					exit;
			}
			$a = $this->area_model->get_area_byid($id);
			if($a['name'] != $name && $this->area_model->get_area_bytitle($name) > 0){
				$info['state'] = 0;
				$info['message'] = '监管站名称已存在!';
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($info))
					->_display();
					exit;
			}
			$data = array(
				'name' => $name,
				'type' => 3
			);
			if($this->area_model->modify_area($data, $id)){
				$info['state'] = 1;
					$info['message'] = '操作成功!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
			}else{
				$info['state'] = 0;
					$info['message'] = '操作失败!';
					$this->output
						->set_content_type('application/json', 'utf-8')
						->set_output(json_encode($info))
						->_display();
						exit;
			}
		}else{
			$id = $this->uri->segment(3);
			$data = $this->area_model->get_area_byid($id);
			$this->load->view('area/edit', $data);
		}
	}
}