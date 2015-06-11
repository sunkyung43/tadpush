<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Inventory extends MY_Controller {
	/**
	 *
	 * @var Inventory_model
	 */
	public $inventory_model;
	
	/**
	 *
	 * @var Advert_model
	 */
	public $advert_model;
	
	/**
	 *
	 * @var Media_model
	 */
	public $media_model;
	
	/**
	 *
	 * @var Excel
	 */
	public $excel;

	public function __construct() {
		parent::__construct();
		
		$this->load->model('/campaign/inventory_model');
		$this->load->model('/campaign/advert_model');
		$this->load->model('/media/media_model');
		
		$this->load_vo('campaign/advert_vo');
	}

	function index_get() {
		$vars = array ();
		
		$param_cnt = $this->common_model->count_param_list();
		
		$year = date('Y');
		$month = date('m');
		$current_day = date('d');
		$cycle_start_day = date('d') - date('N') + 1;
		
		$vars['calendar_max_week'] = $this->config->item('inventory_max_week');
		
		$vars['summary'] = $this->_get_inventory_summary($param_cnt, $year, $month, $cycle_start_day);
		
		$vars['list'] = $this->_get_inventory_list($param_cnt, $year, $month, $current_day, $vars['summary']['tot_remain_cnt']);
		
		$vars['excel_url'] = '/campaign/inventory/excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/inventory/inventory_list.js';
		$this->load->view('campaign/inventory/inventory_list_view', $vars);
	}

	function excel_get() {
		$this->load->library('excel');
		
		$param_cnt = $this->common_model->count_param_list();
		
		$year = date('Y');
		$month = date('m');
		$current_day = date('d');
		$cycle_start_day = date('d') - date('N') + 1;
		
		$summary = $this->_get_inventory_summary($param_cnt, $year, $month, $cycle_start_day);
		
		$list = $this->_get_inventory_list($param_cnt, $year, $month, $current_day, $summary['tot_remain_cnt']);
		
		$column_list = array (
				'날짜' => 'date',
				'대기 광고(건)' => 'ad_cnt',
				'예약 모수(건)' => 'push_booking_cnt',
				'가용 모수(건)' => 'remain_cnt' 
		);
		
		$this->excel->export_excel('inventory_list.xls', 'inventory', $column_list, $list);
	}
	
	// 인벤토리현황 타게팅 팝업
	function target_get() {
		$vars = array ();
		
		$selected_target_list = array ();
		
		if ($this->get('os_ver')) {
			$selected_target_list[$this->lang->line('target_type_os_ver')] = $this->get('os_ver');
		}
		
		if ($this->get('model_nm')) {
			$selected_target_list[$this->lang->line('target_type_device')] = $this->get('model_nm');
		}
		
		if ($this->get('carrier_cd')) {
			$selected_target_list[$this->lang->line('target_type_carrier_cd')] = $this->get('carrier_cd');
		}
		
		if ($this->get('gender_cd')) {
			$selected_target_list[$this->lang->line('target_type_gender')] = $this->get('gender_cd');
		}
		
		if ($this->get('age_rng_cd')) {
			$selected_target_list[$this->lang->line('target_type_age')] = $this->get('age_rng_cd');
		}
		
		if ($this->get('region_sido_cd')) {
			$selected_target_list[$this->lang->line('target_type_region')] = $this->get('region_sido_cd');
		}
		
		if ($this->get('region_gugun_cd')) {
			if (isset($selected_target_list[$this->lang->line('target_type_region')]) && !empty($selected_target_list[$this->lang->line('target_type_region')])) {
				$selected_target_list[$this->lang->line('target_type_region')] .= ',' . $this->get('region_gugun_cd');
			} else {
				$selected_target_list[$this->lang->line('target_type_region')] = $this->get('region_gugun_cd');
			}
		}
		
		if ($this->get('media_name_cd')) {
			$selected_target_list[$this->lang->line('target_type_media_name')] = $this->get('media_name_cd') ? $this->get('media_name_cd') : '';
		} else if ($this->get('media_group_cd')) {
			$selected_target_list[$this->lang->line('target_type_media_group')] = $this->get('media_group_cd') ? $this->get('media_group_cd') : '';
		} else if ($this->get('media_category_cd')) {
			$selected_target_list[$this->lang->line('target_type_media_category')] = $this->get('media_category_cd') ? $this->get('media_category_cd') : '';
		}
		
		$vars['selected_target_list'] = $selected_target_list;
		
		// 지역별(시도) selectbox
		$sido_list = $this->common_model->select_sido_list();
		$vars['target_region_sido_list'] = $this->ui_component->create_selectbox('sido_cd', $sido_list, '', '시 선택', 'javascript:getSigugun()');
		
		$vars = array_merge($vars, $this->_get_target_ui_data($selected_target_list));
		
		$this->yield = true;
		$this->layout = 'popup';
		$this->yield_js = array (
				'/web/js/campaign/target.js',
				'/web/js/campaign/inventory/popup/target_popup.js' 
		);
		$this->load->view('campaign/inventory/popup/target_popup', $vars);
	}
	
	// 타게팅 UI 구성을 위한 데이터 가공
	function _get_target_ui_data($selected_target_list = array()) {
		$result = array ();
		
		// OS
		$android_ver_list = $this->common_model->select_code_list_treeview($this->lang->line('device_os_and_ent'), 'name', FALSE, $this->lang->line('target_type_os_ver'), $this->lang->line('device_os_and_etc'));
		if (isset($selected_target_list[$this->lang->line('target_type_os_ver')])) {
			$this->_check_treeview($android_ver_list, $selected_target_list[$this->lang->line('target_type_os_ver')]);
		}
		$os_list = array (
				"title" => "OS",
				"expand" => true,
				"children" => array (
						"title" => "Android",
						"expand" => true,
						"children" => $android_ver_list 
				) 
		);
		$result['target_os_list'] = $this->_treeview_encode($os_list);
		
		// 디바이스
		$device_list = $this->common_model->select_device_list_treeview(FALSE, $this->lang->line('target_type_device'));
		if (isset($selected_target_list[$this->lang->line('target_type_device')])) {
			$this->_check_treeview($device_list, $selected_target_list[$this->lang->line('target_type_device')]);
		}
		$groupping_device_list = array ();
		foreach ( $device_list as $row ) {
			$temp = $row;
			unset($temp['maker_nm']);
			unset($temp['device_type_nm']);
			$groupping_device_list[$row['maker_nm']][$row['device_type_nm']][] = $temp;
		}
		$temp_maker = array ();
		foreach ( $groupping_device_list as $maker_nm => $maker_list ) {
			foreach ( $maker_list as $type_nm => $type_list ) {
				$temp_type[] = array (
						"title" => $type_nm,
						"children" => $type_list 
				);
			}
			$temp_maker[] = array (
					"title" => $maker_nm,
					"children" => $temp_type 
			);
			$temp_type = array ();
		}
		$target_device_list = array (
				"title" => "디바이스",
				"expand" => true,
				"children" => $temp_maker 
		);
		$result['target_device_list'] = $this->_treeview_encode($target_device_list);
		
		// 미디어(미디어)
		if (isset($selected_target_list[$this->lang->line('target_type_media_name')])) {
			$params = array (
					'media_id_list' => explode(',', $selected_target_list[$this->lang->line('target_type_media_name')]) 
			);
			$result['target_media_name_list'] = $this->media_model->select_search_media($params);
		}
		
		// 미디어(프리미엄 미디어 그룹)
		$media_group_list = $this->media_model->select_media_group(FALSE, $this->lang->line('target_type_media_group'));
		if (isset($selected_target_list[$this->lang->line('target_type_media_group')])) {
			$this->_check_treeview($media_group_list, $selected_target_list[$this->lang->line('target_type_media_group')]);
		}
		$result['target_media_group_list'] = $this->_treeview_encode($media_group_list);
		
		// 미디어(카테고리)
		$media_category_list = $this->common_model->select_code_list_treeview($this->lang->line('media_category_ent'), 'att', FALSE, $this->lang->line('target_type_media_category'));
		if (isset($selected_target_list[$this->lang->line('target_type_media_category')])) {
			$this->_check_treeview($media_category_list, $selected_target_list[$this->lang->line('target_type_media_category')]);
		}
		$result['target_media_category_list'] = $this->_treeview_encode($media_category_list);
		
		// 통신사
		$carrier_list = $this->common_model->select_code_list_treeview($this->lang->line('device_carrier_ent'), 'att', FALSE, $this->lang->line('target_type_carrier_cd'));
		if (isset($selected_target_list[$this->lang->line('target_type_carrier_cd')])) {
			$this->_check_treeview($carrier_list, $selected_target_list[$this->lang->line('target_type_carrier_cd')]);
		}
		$result['target_carrier_list'] = $this->_treeview_encode($carrier_list);
		
		// 성별
		$gender_list = $this->common_model->select_code_list_treeview($this->lang->line('gender_ent'), 'value1', FALSE, $this->lang->line('target_type_gender'));
		if (isset($selected_target_list[$this->lang->line('target_type_gender')])) {
			$this->_check_treeview($gender_list, $selected_target_list[$this->lang->line('target_type_gender')]);
		}
		$result['target_gender_list'] = $this->_treeview_encode($gender_list);
		
		// 연령
		$age_list = $this->common_model->select_code_list_treeview($this->lang->line('age_ent'), 'value2', FALSE, $this->lang->line('target_type_age'));
		if (isset($selected_target_list[$this->lang->line('target_type_age')])) {
			$this->_check_treeview($age_list, $selected_target_list[$this->lang->line('target_type_age')]);
		}
		$result['target_age_list'] = $this->_treeview_encode($age_list);
		
		// 지역별
		if (isset($selected_target_list[$this->lang->line('target_type_region')])) {
			$region_list = explode(',', $selected_target_list[$this->lang->line('target_type_region')]);
			foreach($region_list as &$region_cd) {
				if(strlen($region_cd) == 2) {
					$region_cd .= '000';
				}
			}
			unset($region_cd);
			$params = array('sigugun_list' => $region_list);
			$result['target_region_list'] = $this->common_model->select_search_region($params);
		}
		
		return $result;
	}

	function _check_treeview(&$row_array, $selected_list) {
		$selected_list = explode(',', $selected_list);
		foreach ( $row_array as &$row ) {
			if (array_search($row['key'], $selected_list) !== FALSE) {
				$row['select'] = 'true';
			}
		}
		unset($row);
	}
	
	// dynatree 데이터로 가공
	function _treeview_encode($array) {
		$result = json_encode($array);
		$result = str_replace('"key"', 'key', $result);
		$result = str_replace('"title"', 'title', $result);
		$result = str_replace('"select"', 'select', $result);
		$result = str_replace('"expand"', 'expand', $result);
		$result = str_replace('"children"', 'children', $result);
		$result = str_replace('"true"', 'true', $result);
		$result = str_replace('"false"', 'false', $result);
		return $result;
	}

	function remain_get() {
		$remain_array = $this->_get_remain_data();
		
		$this->yield = true;
		$this->layout = 'popup';
		$this->load->view('campaign/inventory/popup/remain_popup', $remain_array);
	}

	function _get_remain_data() {
		$params = array ();
		
		$params['start_dt'] = $this->get('start_dt') ? $this->get('start_dt') : '';
		$params[$this->lang->line('target_type_os_cd')] = $this->lang->line('os_android');
		$params[$this->lang->line('target_type_os_ver')] = $this->get('os_ver') ? $this->get('os_ver') : '';
		$params[$this->lang->line('target_type_device')] = $this->get('model_nm') ? $this->get('model_nm') : '';
		$params[$this->lang->line('target_type_gender')] = $this->get('gender_cd') ? $this->get('gender_cd') : '';
		$params[$this->lang->line('target_type_age')] = $this->get('age_rng_cd') ? $this->get('age_rng_cd') : '';
		$params[$this->lang->line('target_type_region_sido')] = $this->get('region_sido_cd') ? $this->get('region_sido_cd') : '';
		$params[$this->lang->line('target_type_region_gugun')] = $this->get('region_gugun_cd') ? $this->get('region_gugun_cd') : '';
		$params[$this->lang->line('target_type_carrier')] = '';
		$params[$this->lang->line('target_type_media')] = '';
		
		if ($this->get('carrier_cd')) {
			$params[$this->lang->line('target_type_carrier')] = $this->common_model->select_carrier_target_value(explode(',', $this->get('carrier_cd')));
		}
		
		if ($this->get('media_name_cd')) {
			$params[$this->lang->line('target_type_media')] = $this->get('media_name_cd');
		} else if ($this->get('media_group_cd')) {
			$params[$this->lang->line('target_type_media')] = $this->media_model->select_media_group_target_value(explode(',', $this->get('media_group_cd')));
		} else if ($this->get('media_category_cd')) {
			$params[$this->lang->line('target_type_media')] = $this->media_model->select_media_category_target_value(explode(',', $this->get('media_category_cd')));
		}
		
		$count_result = $this->isf->count($params);
		
		$remain_array = $this->_generate_remain_data($count_result);
		
		return $remain_array;
	}

	function _generate_remain_data($count_result) {
		if (isset($count_result['err_msg'])) {
			return array (
					'err_msg' => 'ISF 요청에 실패하였습니다.' . $count_result['err_msg'] 
			);
		}
		
		$result = array ();
		
		// 전체 가용모수
		$result['COUNT'] = $count_result['COUNT'];
		
		// 성, 연령
		$result['GENDER_M_COUNT'] = 0;
		$result['GENDER_F_COUNT'] = 0;
		$result['GENDER_#_COUNT'] = 0;
		foreach ( $count_result['GENDER_AGE_COUNT'] as $age_array ) {
			$gender_cd = $age_array['GENDER_CD'];
			$age_rng_cd = $age_array['AGE_RNG_CD'];
			
			// 성
			$gender_count_key = sprintf('GENDER_%s_COUNT', $gender_cd);
			$result[$gender_count_key] += $age_array['GA_USER_COUNT'];
			
			// 연령
			$result['GENDER_AGE_COUNT'][$age_rng_cd][$gender_cd]['TITLE'] = sprintf('%s세 ~ %s세', substr($age_rng_cd, 0, 2), substr($age_rng_cd, 2, 2));
			$result['GENDER_AGE_COUNT'][$age_rng_cd][$gender_cd]['COUNT'] = $age_array['GA_USER_COUNT'];
		}
		unset($result['GENDER_AGE_COUNT']['####']);
		ksort($result['GENDER_AGE_COUNT']);
		
		// 지역
		$sido_list = $this->common_model->select_sido_list();
		foreach ( $count_result['ADDR_COUNT'] as $addr_array ) {
			$sido_cd = $addr_array['ADDR_DO_CD'];
			if (isset($sido_list[$sido_cd])) {
				$result['ADDR_COUNT'][$sido_cd]['TITLE'] = $sido_list[$sido_cd];
			} else {
				$result['ADDR_COUNT'][$sido_cd]['TITLE'] = '알수없음';
			}
			$result['ADDR_COUNT'][$sido_cd]['COUNT'] = $addr_array['ADDR_USER_COUNT'];
		}
		ksort($result['ADDR_COUNT']);
		
		return $result;
	}

	function _get_inventory_summary($param_cnt, $year, $month, $day) {
		$result = array ();
		
		$frequency_array = $this->common_model->select_frequency();
		
		$result['cycle'] = (int)$frequency_array['cycle'];
		$result['frequency_cnt'] = (int)$frequency_array['frequency_cnt'];
		
		$cycle_start_time = mktime(0, 0, 0, $month, $day, $year);
		$cycle_end_time = mktime(23, 59, 59, $month, $day + 6, $year);
		
		$result['cycle_start_dt'] = date('Y-m-d', $cycle_start_time);
		$result['cycle_end_dt'] = date('Y-m-d', $cycle_end_time);
		
		$params = array (
				'start_dt' => date('Y-m-d H:i:s', $cycle_start_time),
				'end_dt' => date('Y-m-d H:i:s', $cycle_end_time) 
		);
		
		$summary_array = $this->inventory_model->select_inventory_summary($params);
		
		$result['tot_param_cnt'] = $param_cnt * $frequency_array['frequency_cnt'];
		$result['tot_request_cnt'] = (int)$summary_array['tot_request_cnt'];
		$result['tot_push_booking_cnt'] = (int)$summary_array['tot_push_booking_cnt'];
		$result['tot_remain_cnt'] = $result['tot_param_cnt'] - $result['tot_push_booking_cnt'] - $result['tot_request_cnt'];
		
		if ($result['tot_remain_cnt'] < 0) {
			$result['tot_remain_cnt'] = 0;
		}
		
		$result['search_dt'] = date('Y-m-d H:i');
		
		return $result;
	}

	function _get_inventory_list($param_cnt, $year, $month, $day, $tot_remain_cnt) {
		$result = array ();
		
		$day_index = date('N', mktime(0, 0, 0, $month, $day, $year));
		
		$start_day = $day;
		$end_day = $day + (7 - $day_index);
		
		// 현재 주기
		$result = array_merge($result, $this->_get_cycle_list($param_cnt, $year, $month, $start_day, $end_day, $tot_remain_cnt));
		$start_day = $end_day + 1;
		$end_day = $start_day + 6;
		
		// 미래 4주
		$inventory_max_week = $this->config->item('inventory_max_week');
		for($week = 0; $week < $inventory_max_week; $week++) {
			$result = array_merge($result, $this->_get_cycle_list($param_cnt, $year, $month, $start_day, $end_day));
			$start_day = $end_day + 1;
			$end_day = $start_day + 6;
		}
		
		return $result;
	}

	function _get_cycle_list($param_cnt, $year, $month, $start_day, $end_day, $tot_remain_cnt = FALSE) {
		$result = array ();
		
		$start_time = mktime(0, 0, 0, $month, $start_day, $year);
		$end_time = mktime(23, 59, 59, $month, $end_day, $year);
		
		$start_dt = date('Y-m-d H:i:s', $start_time);
		$end_dt = date('Y-m-d H:i:s', $end_time);
		
		$params = array (
				'start_dt' => $start_dt 
		);
		$frequency_array = $this->common_model->select_frequency($params);
		
		$cycle = (int)$frequency_array['cycle'];
		$frequency_cnt = (int)$frequency_array['frequency_cnt'];
		
		$params = array (
				'start_dt' => $start_dt,
				'end_dt' => $end_dt 
		);
		$inventory_list = $this->inventory_model->select_inventory_list($params);
		
		$tot_param_cnt = $param_cnt * $frequency_cnt;
		if ($tot_remain_cnt === FALSE) {
			$tot_booking_cnt = 0;
			$tot_request_cnt = 0;
			foreach ( $inventory_list as $row ) {
				$tot_booking_cnt += $row['push_booking_cnt'];
				$tot_request_cnt += $row['request_cnt'];
			}
			$tot_remain_cnt = $tot_param_cnt - $tot_booking_cnt - $tot_request_cnt;
		}
		
		if ($tot_remain_cnt < 0) {
			$tot_remain_cnt = 0;
		}
		
		foreach ( $inventory_list as $row ) {
			$date_array = explode('-', $row['start_dt']);
			$day_string = $this->_get_day_string(date('N', mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0])));
			$date = sprintf('%s(%s)', $row['start_dt'], $day_string);
			
			if ($row['ad_cnt'] > 0) {
				$remain_cnt = $param_cnt - $row['push_booking_cnt'] - $row['request_cnt'];
				
				if ($cycle == '7') {
					$remain_cnt = $remain_cnt < $tot_remain_cnt ? $remain_cnt : $tot_remain_cnt;
				}
				
				if ($remain_cnt < 0) {
					$remain_cnt = 0;
				}
				
				$result[$row['start_dt']] = array (
						'date' => $date,
						'start_dt' => $row['start_dt'],
						'ad_cnt' => $row['ad_cnt'],
						'push_booking_cnt' => $row['push_booking_cnt'],
						'remain_cnt' => $remain_cnt 
				);
			} else {
				$result[$row['start_dt']] = array (
						'date' => $date,
						'start_dt' => $row['start_dt'],
						'ad_cnt' => '-',
						'push_booking_cnt' => '-',
						'remain_cnt' => '-' 
				);
			}
		}
		
		return $result;
	}

	function _get_day_string($day_index) {
		switch ($day_index) {
			case 1 :
				return '월';
			case 2 :
				return '화';
			case 3 :
				return '수';
			case 4 :
				return '목';
			case 5 :
				return '금';
			case 6 :
				return '토';
			case 7 :
				return '일';
			default :
				return '알수없음';
		}
	}

}

/* End of file inventory.php */
/* Location: ./application/admin/controllers/campaign/inventory.php */
