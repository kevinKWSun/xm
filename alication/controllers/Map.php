<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Map extends MY_Controller {
	public function __construct() {
        parent::__construct();
        //$this->load->library('pagination');
        $this->load->model('xmsc/map_model');
        //$this->load->helper('url');
    }
    //地图坐标
	public function index(){
		$this->load->view('xmsc/map');
	}
	//获取地区
	public function getarea(){
		$pid = $this->uri->segment(3) ? $this->uri->segment(3) : 1497;
		$c = $this->uri->segment(4);
		$type = $this->map_model->get_area_id($pid);
		$type = $type['type'] + 1;
		$area = $this->map_model->get_area($pid);
		if($area){
			echo '<div class="layui-input-inline"><select name="quiz" lay-filter="select" rel="'.$type.'"><option value="0">请选择</option>';
			foreach($area as $v){
				$id = $v['id'];
				$name = $v['name'];
				if($c == $id){
					echo "<option value='$id' selected>$name</option>";
				}else{
					echo "<option value='$id'>$name</option>";
				}
			}
			echo '</select>';
		}
	}
	//地图坐标
	public function getmap(){
		$data['l'] = $this->uri->segment(3)?$this->uri->segment(3):0;
		$data['w'] = $this->uri->segment(4)?$this->uri->segment(4):0;
		$this->load->view('map/getmap',$data);
	}
}