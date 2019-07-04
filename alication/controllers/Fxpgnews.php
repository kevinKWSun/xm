<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fxpgnews extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('yjgisnews/synews_model', 'wghnews/wghnews_model', 'area/area_model'));
		$this->load->library('pagination');
    }
	public function index(){
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
		$per_page = 100;
        $offset = $current_page;
        $config['base_url'] = base_url('fxpgnews/index');
        $config['total_rows'] = $this->wghnews_model->get_solor_num($keywords, $admin_id);
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
        $synews = $this->wghnews_model->synews($keywords, $admin_id, $per_page, $offset * $per_page);
        foreach($synews as $k => $v){
			$s = $this->area_model->get_area_byid(1534);
			$c = $this->area_model->get_area_byid($v['addr_c']);
			$t = $this->area_model->get_area_byid($v['addr_t']);
			$synews[$k]['area'] = $s['name'] . $c['name'] . $t['name'];
		}
        $data['manager'] = $synews;
		$this->load->view('wghnews/index', $data);
	}
	public function pie(){
		$area = $this->area_model->get_area();
		foreach($area as $v){
			$c = $v['name'];
			$data['farm'][$c] = $this->wghnews_model->getfarm($v['id']);
		}
		$this->load->view('wghnews/pie', $data);
	}
	public function map(){
		$area = $this->area_model->get_area();
		foreach($area as $v){
			$c = $v['name'];
			$data['farm'][$c] = $this->wghnews_model->getfarm($v['id']);
			if($data['farm'][$c]){
				foreach($data['farm'][$c] as $k => $vs){
					if(isset($vs['uid'])){
						$data['farm'][$c][$k]['stock'] = $this->wghnews_model->getfarmstocks($vs['uid']);
					}else{
						$data['farm'][$c][$k]['stock'] = 0;
					}
				}
			}
		}
		$this->load->view('wghnews/map', $data);
	}
	public function zhu(){
		$area = $this->area_model->get_area();
		foreach($area as $v){
			$c = $v['name'];
			$data['farm'][$c] = $this->wghnews_model->getfarm($v['id']);
		}
		$this->load->view('wghnews/zhu', $data);
	}
}