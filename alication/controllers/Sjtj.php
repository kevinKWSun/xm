<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sjtj extends MY_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model(array('area/area_model'));
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->admin_id = IS_ROOT ? UID : 0;
    }
	public function index() {
		$data['type'] = (int)$this->uri->segment(3);
		$data['cate'] = array(
			'1' => '兽医',
			'2' => '规模化养殖场',
			'3' => '散养户',
			'4' => '兽药企业',
			'5' => '饲料企业',
			'6' => '物资',
			'7' => '诊疗机构',
			'8' => '屠宰企业',
			'9' => '无害化处理厂',
			'10' => '奶站',
			//'11' => '运输车辆'
		);
		if(empty($data['type'])) {
			$data['type'] = 2;
		}
		$data['nav'] = '';
		foreach($data['cate'] as $k => $v) {
			$data['nav'] .= '<a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/sjtj/index/' . $k . '.html">' . $v . '</a>';
		}
		$data['html'] = '<div class="layui-form-item"><center>';
		$data['html'] .= isset($data['cate'][$data['type']]) ? $data['cate'][$data['type']] : '';
		$data['html'] .= '数据统计</center></div><table class="layui-table layui-tables" lay-skin="line" boder="1"><tbody>';
		$res_area = $this->area_model->get_area();
		//print_r($res_area);
		$res_cate = $this->config->item('breed');
		switch($data['type']) {
			case 1://兽医
				$this->load->model(array('gfsy/gfsy_model', 'gfsy/xcsy_model'));
				$edu = $this->config->item('education');
				//print_r($edu);
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="3"><div id="theadTrSlashd"><span class="theadTrSlashds1">类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$data['html'] .= '<tr><td colspan="7">乡村兽医</td></tr>';
				$table_content = array();
				$colum_num = array();
				for($i = 0; $i< count($edu); $i++) {
					$colum_num[$i+1] = 0;
				}
				$total = 0;
				foreach($edu as $k=>$v) {
					$table_content[0][$k] = $v;
				}
				$table_content[0][$k+1] = '小计';
				foreach($res_area as $k => $v) {
					$table_content[$k+2][0] = $v['name'];
					foreach($edu as $key => $value) {
						$table_content[$k+2][$key] = $this->xcsy_model->get_edu_num($key, $v['id']);
						$colum_num[$key] += $table_content[$k+2][$key];
						$total += $table_content[$k+2][$key];
					}
					$table_content[$k+2][$key+1] = array_sum($table_content[$k+2]);
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '<td>'. $total .'</td>';
				$data['html'] .= '</tr>';
				
			break;
			case 2://规模化养殖场
				$this->load->model('yznews/yznews_model');
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">畜禽种类</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$colum_num = array();
				for($i = 0; $i< count($res_cate); $i++) {
					$colum_num[$i+2] = 0;
				}
				$total = 0;
				$table_content[0][1] = '总数';
				foreach($res_cate as $key => $value) {
					$table_content[0][$key+1] = $value;
				}
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = 0;
					foreach($res_cate as $ke => $va) {
						$tmp = 0;
						$tmp = $this->yznews_model->get_tj($v['id'], $ke);
						$table_content[$k+1][$ke+2] = $tmp;
						$table_content[$k+1][1] += $tmp;//行总数
						$colum_num[$ke+1] += $tmp;//列总数
						$total += $tmp;
					}
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				$data['html'] .= '<td>'. $total .'</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 3://散养户
				$this->load->model(array('synews/synews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">畜禽种类</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$colum_num = array();
				for($i = 0; $i< count($res_cate); $i++) {
					$colum_num[$i+2] = 0;
				}
				$total = 0;
				$table_content[0][1] = '总数';
				foreach($res_cate as $key => $value) {
					$table_content[0][$key+1] = $value;
				}
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = 0;
					foreach($res_cate as $ke => $va) {
						$tmp = 0;
						$tmp = $this->synews_model->get_tj($v['id'], $ke);
						$table_content[$k+1][$ke+2] = $tmp;
						$table_content[$k+1][1] += $tmp;//行总数
						$colum_num[$ke+1] += $tmp;//列总数
						$total += $tmp;
					}
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				$data['html'] .= '<td>'. $total .'</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 4://兽药企业
				$this->load->model(array('scmessage/scmessage_model', 'jymessage/jymessage_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">企业类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$colum_num = array();
				for($i = 0; $i< 2; $i++) {
					$colum_num[$i+2] = 0;
				}
				$total = 0;
				$table_content[0][1] = '总数';
				$table_content[0][2] = '生产';
				$table_content[0][3] = '经营';
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = 0;
					$tmp = $this->scmessage_model->get_company_num($v['id']);
					$table_content[$k+1][2] = $tmp;
					$table_content[$k+1][1] += $tmp;//行总数
					$colum_num[2] += $tmp;//列总数
					$total += $tmp;
					$tmp = $this->jymessage_model->get_company_num($v['id']);
					$table_content[$k+1][3] = $tmp;
					$table_content[$k+1][1] += $tmp;//行总数
					$colum_num[3] += $tmp;//列总数
					$total += $tmp;
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				$data['html'] .= '<td>'. $total .'</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 5://饲料企业
				$this->load->model(array('sljynews/sljynews_model', 'slscnews/slscnews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">企业类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$colum_num = array();
				for($i = 0; $i< 2; $i++) {
					$colum_num[$i+2] = 0;
				}
				$total = 0;
				$table_content[0][1] = '总数';
				$table_content[0][2] = '生产';
				$table_content[0][3] = '经营';
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = 0;
					$tmp = $this->slscnews_model->get_company_num($v['id']);
					$table_content[$k+1][2] = $tmp;
					$table_content[$k+1][1] += $tmp;//行总数
					$colum_num[2] += $tmp;//列总数
					$total += $tmp;
					$tmp = $this->sljynews_model->get_company_num($v['id']);
					$table_content[$k+1][3] = $tmp;
					$table_content[$k+1][1] += $tmp;//行总数
					$colum_num[3] += $tmp;//列总数
					$total += $tmp;
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				$data['html'] .= '<td>'. $total .'</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 6://物资
				$this->load->model(array('wzrknews/wzrknews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">产品名称</span><span class="theadTrSlashds2">物资类别</span> </div></td></tr>';
				$table_content = array();
				$total = 0;
				$table_content[0][1] = '产品名称';
				$table_content[0][2] = '单位';
				$table_content[0][3] = '总数';
				foreach($res_area as $k => $v) {
					$table_content[0][$k+4] = $v['name'];
				}
				//展示部分物资类别
				$wz_cate = array(1,3,4,5,6,8);
				$wz_lb = get_wzlb();
				$wz_mc = get_wzmc();
				$wz_dig = get_dig();
				foreach($wz_mc as $k => $v) {
					if(!in_array($k, $wz_cate)) {
						continue;
					}
					foreach($v as $key =>$value){
						$table_content[$key][0] = $k;
						$table_content[$key][1] = $value;
						$table_content[$key][2] = $wz_dig[$key];
						$table_content[$key][3] = 0;
						foreach($res_area as $ke => $va) {
							$tmp = $this->wzrknews_model->get_cate_num($key, $va['id']);
							//$output = $this->wzcknews_model->get_cate_num($key, $va['id']);
							//$tmp = $input - $output;
							$table_content[$key][$ke+4] = $tmp;
							$table_content[$key][3] += $tmp;//行总数
							$total += $tmp;
						}
					}
				}

				//print_r($table_content);
				$i = 0;
				$tem_var = 0;
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							if($k == 0) {
								if($v == $tem_var) {
									continue;
								} else {
									$tem_var = $v;
									$data['html'] .= '<td rowspan="' . count($wz_mc[$v]) . '">'. $wz_lb[$v] .'</td>';
								}
							} else {
								$data['html'] .= '<td>'. $v .'</td>';
							}
						}
					$data['html'] .= '</tr>';
				}
			break;
			case 7://诊疗机构
				$this->load->model(array('jgnews/synews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">机构类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$total = 0;
				$colum_num = array();
				$i = 0;
				for($i=0; $i< 4; $i++) {
					$colum_num[$i+1] = 0;
				}
				$table_content[0][1] = '动物医院';
				$table_content[0][2] = '动物诊所';
				$table_content[0][3] = '小计';
				$table_content[0][4] = '狂犬病定点门诊';
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = $this->synews_model->get_type_num(1, $v['id']);
					$colum_num[1] += $table_content[$k+1][1];
					$table_content[$k+1][2] = $this->synews_model->get_type_num(2, $v['id']);
					$colum_num[2] += $table_content[$k+1][2];
					$table_content[$k+1][3] = $table_content[$k+1][1] + $table_content[$k+1][2];
					$colum_num[3] += $table_content[$k+1][3];
					$table_content[$k+1][4] = $this->synews_model->get_point_num($v['id']);
					$colum_num[4] += $table_content[$k+1][4];

				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 8://屠宰企业
				$this->load->model(array('qyjbnews/synews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">企业类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$total = 0;
				$colum_num = array();
				$i = 0;
				for($i=0; $i< 4; $i++) {
					$colum_num[$i+1] = 0;
				}
				$table_content[0][1] = '定点屠宰场';
				$table_content[0][2] = '小型屠宰场';
				$table_content[0][3] = '小计';
				$table_content[0][4] = '年屠宰能力';
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = $this->synews_model->get_spcial_num(1, $v['id']);
					$colum_num[1] += $table_content[$k+1][1];
					$table_content[$k+1][2] = $this->synews_model->get_spcial_num(2, $v['id']);
					$colum_num[2] += $table_content[$k+1][2];
					$table_content[$k+1][3] = $table_content[$k+1][1] + $table_content[$k+1][2];
					$colum_num[3] += $table_content[$k+1][3];
					$table_content[$k+1][4] = $this->synews_model->get_volum_num($v['id']);
					$colum_num[4] += $table_content[$k+1][4];

				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 9://无害化处理厂
				$this->load->model(array('clcnews/synews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">企业类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$total = 0;
				$colum_num = array();
				$i = 0;
				for($i=0; $i< 2; $i++) {
					$colum_num[$i+1] = 0;
				}
				$table_content[0][1] = '处理厂数量';
				$table_content[0][2] = '日处理能力';
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = $this->synews_model->get_clc_num($v['id']);
					$colum_num[1] += $table_content[$k+1][1];
					$table_content[$k+1][2] = $this->synews_model->get_volum_num($v['id']);
					$colum_num[2] += $table_content[$k+1][2];
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			case 10://奶站
				$this->load->model(array('nzglnews/synews_model'));
				$data['html'] .= '<tr><td id="thSlashd" style="padding:0px;" rowspan="2"><div id="theadTrSlashd"><span class="theadTrSlashds1">企业类型</span><span class="theadTrSlashds2">行政区划</span> </div></td></tr>';
				$table_content = array();
				$total = 0;
				$colum_num = array();
				$i = 0;
				for($i=0; $i< 2; $i++) {
					$colum_num[$i+1] = 0;
				}
				$table_content[0][1] = '收购站数量';
				$table_content[0][2] = '日收奶量';
				foreach($res_area as $k => $v) {
					$table_content[$k+1][0] = $v['name'];
					$table_content[$k+1][1] = $this->synews_model->get_nz_num($v['id']);
					$colum_num[1] += $table_content[$k+1][1];
					$table_content[$k+1][2] = $this->synews_model->get_yield_num($v['id']);
					$colum_num[2] += $table_content[$k+1][2];
				}
				//print_r($table_content);
				foreach($table_content as $key => $value) {
					$data['html'] .= '<tr>';
						foreach($value as $k=>$v) {
							$data['html'] .= '<td>'. $v .'</td>';
						}
					$data['html'] .= '</tr>';
				}
				$data['html'] .= '<tr>';
				$data['html'] .= '<td>合计</td>';
				foreach($colum_num as $k=>$v) {
					$data['html'] .= '<td>'. $v .'</td>';
				}
				$data['html'] .= '</tr>';
			break;
			// case 11://运输车辆
				// $data['html'] .= '<tr><td>运输车辆</td></tr>';
			// break;
			default:
			
		}
		$data['html'] .= '</tbody></table></div>';
		$this->load->view('sjtj/index', $data);
	}
	
}