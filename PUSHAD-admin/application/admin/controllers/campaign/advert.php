<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Advert extends MY_Controller {
	/**
	 *
	 * @var Campaign_model
	 */
	public $campaign_model;
	
	/**
	 *
	 * @var Advert_model
	 */
	public $advert_model;
	
	/**
	 *
	 * @var Creative_model
	 */
	public $creative_model;
	
	/**
	 *
	 * @var Media_model
	 */
	public $media_model;
	
	/**
	 *
	 * @var Isf_model
	 */
	public $isf_model;

	public function __construct() {
		parent::__construct();
		
		$this->load->model('/campaign/campaign_model');
		$this->load->model('/campaign/advert_model');
		$this->load->model('/campaign/creative_model');
		$this->load->model('/media/media_model');
		$this->load->model('/isf/isf_model');
		
		$this->load_vo('campaign/campaign_vo');
		$this->load_vo('campaign/advert_vo');
		$this->load_vo('campaign/creative_vo');
	}
	
	// GET campaign/advert
	function index_get() {
		$vars = array ();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page'); // 페이지당 출력 게시글수
		
		$querystring['ad_status_cd'] = $this->get('ad_status_cd') ? $this->get('ad_status_cd') : '';
		$querystring['search_type'] = $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value'] = $this->get('search_value') ? $this->get('search_value') : '';
		
		$vars = $querystring;
		
		// 상태 selectbox
		$ad_status_list = array (
				$this->lang->line('ad_status_test') => '검수',
				$this->lang->line('ad_status_stand') => '대기',
				$this->lang->line('ad_status_com') => '완료' 
		);
		$vars['ad_status_selectbox'] = $this->ui_component->create_selectbox('ad_status_cd', $ad_status_list, $querystring['ad_status_cd'], '전체');
		
		// 검색조건 selectbox
		$search_type_list = array (
				'campaign_nm' => '캠페인 명',
				'ad_nm' => '광고 명',
				'adv_company_nm' => '광고주',
				'adv_brand_nm' => '브랜드' 
		);
		$vars['search_type_selectbox'] = $this->ui_component->create_selectbox('search_type', $search_type_list, $querystring['search_type'], '전체');
		
		// 리스트 조회
		$params = array (
				'ad_status_cd' => $querystring['ad_status_cd'],
				'search_type' => $querystring['search_type'],
				'search_value' => $querystring['search_value'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page 
		);
		$vars['list'] = $this->advert_model->select_advert_list($params);
		$vars['total_rows'] = $this->advert_model->count_advert_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/campaign/advert';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $querystring;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		$vars['paging_volume'] = $this->paging->create_page_volume($per_page);
		
		$vars['excel_url'] = '/campaign/advert/excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/advert/advert_list.js';
		$this->load->view('campaign/advert/advert_list_view', $vars);
	}

	function excel_get() {
		$this->load->library('excel');
		
		$ad_status_cd = $this->get('ad_status_cd') ? $this->get('ad_status_cd') : '';
		$search_type = $this->get('search_type') ? $this->get('search_type') : '';
		$search_value = $this->get('search_value') ? $this->get('search_value') : '';
		
		// 리스트 조회
		$params = array (
				'ad_status_cd' => $ad_status_cd,
				'search_type' => $search_type,
				'search_value' => $search_value 
		);
		
		$list = $this->advert_model->select_advert_list($params);
		
		$column_list = array (
				'No' => 'ad_sq',
				'캠페인 명' => 'campaign_nm',
				'광고 명' => 'ad_nm',
				'광고주' => 'adv_company_nm',
				'브랜드' => 'adv_brand_nm',
				'목표건수' => 'push_booking_cnt',
				'발송건수' => 'request_cnt',
				'발송 현황' => 'start_dt',
				'상태' => 'ad_status_nm' 
		);
		
		$this->excel->export_excel('advert_list.xls', 'advert', $column_list, $list);
	}
	
	// GET campaign/advert/write
	function write_get() {
		$campaign_sq = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
		
		if ($campaign_sq == '') {
			redirect('/campaign/campaign');
			return;
		}
		
		$vars = array ();
		// 캠페인 정보
		$params = array (
				'campaign_sq' => $campaign_sq 
		);
		$vars['campaign_vo'] = $this->campaign_model->select_campaign($params);
		
		// 과급 Type 조회
		$bill_array = $this->common_model->select_code_list($this->lang->line('bill_type_ent'));
		$vars['bill_selectbox'] = $this->ui_component->create_selectbox('bill_type_cd', $bill_array, '', '선택해주세요', FALSE);
		
		$freezing_array = $this->common_model->select_freezing();
		
		$vars['calendar_max_week'] = $this->config->item('inventory_max_week');
		$vars['calendar_min_day'] = $this->get_calendar_min_day($freezing_array['apply_time']);
		
		// 발송시간 selectbox
		$vars['time_selectbox'] = $this->ui_component->create_time_selectbox('start_time', ''/*, $calendar_min_time*/);
		
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/advert/advert_write.js';
		$this->load->view('campaign/advert/advert_write_view', $vars);
	}

	function timeSelectbox_get() {
		$start_dt = $this->get('start_dt') ? $this->get('start_dt') : date('Y-m-d');
		$start_time = $this->get('start_time') ? $this->get('start_time') : '';
		
		$freezing_array = $this->common_model->select_freezing();
		
		$min_time = $this->get_calendar_min_time($freezing_array['apply_time'], $start_dt);
		
		$time_selectbox = $this->ui_component->create_time_selectbox('start_time', $start_time, $min_time);
		
		$this->ajax_json_response(true, $time_selectbox);
	}
	
	// POST campaign/advert
	function index_post() {
		$param_array = $this->post();
		$param_array['ad_status_cd'] = $this->lang->line('ad_status_test');
		$param_array['sch_status_cd'] = $this->lang->line('sch_status_ready');
		$param_array['create_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$param_array['update_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$advert_vo = $this->_get_advert_vo($param_array);
		
		// freezing 시간 확인
		$freezing_array = $this->common_model->select_freezing();
		if ($this->is_freezing($advert_vo->get_start_dt(), $freezing_array['apply_time'])) {
			$this->ajax_json_response(false, '발송일자 및 시간을 확인해주세요.');
		}
		
		// 광고명 중복 확인
		$params = array (
				'ad_nm' => $advert_vo->get_ad_nm() 
		);
		if (count($this->advert_model->select_advert_list($params)) > 0) {
			$this->ajax_json_response(false, '동일한 광고명이 존재합니다.');
		}
		
		// DB 트랜잭션 시작
		$this->advert_model->trans_start();
		
		// 광고 등록
		$ad_sq = $this->advert_model->insert_advert($advert_vo);
		$advert_vo->set_ad_sq($ad_sq);
		
		// 히스토리 등록
		$history_array = array ();
		$history_array['campaign_sq'] = $advert_vo->get_campaign_sq();
		$history_array['ad_sq'] = $advert_vo->get_ad_sq();
		$history_array['history_gb'] = '생성';
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$this->campaign_model->insert_history($history_array);
		
		if ($this->advert_model->trans_status() === FALSE) {
			$this->advert_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}
		
		// ISF 광고 메타 연동
		$isf_response = $this->isf->ad('POST', $ad_sq);
		if ($isf_response !== TRUE) {
			$this->advert_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 등록에 실패하였습니다.' . $isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->advert_model->trans_complete();
		
		$this->ajax_json_response(true, '/campaign/advert/detail?ad_sq=' . $ad_sq);
	}
	
	// GET campaign/advert/detail
	function detail_get() {
		$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
		
		if ($ad_sq == '') {
			redirect('/campaign/campaign');
			return;
		}
		
		$vars = array ();
		
		// freezing 시간 계산
		$freezing = $this->common_model->select_freezing();
		$freezing_time = strtotime(date('Y-m-d H:i:s')) + (60 * $freezing['apply_time']);
		$freezing_time = date('Y-m-d H:i:s', $freezing_time);
		
		$vars['advert_vo'] = $this->advert_model->select_advert($ad_sq, $freezing_time);
		
		if (empty($vars['advert_vo'])) {
			redirect('/campaign/campaign');
			return;
		}
		
		// 목록 URL
		$vars['list_type'] = $this->get('list_type') ? $this->get('list_type') : 'campaign';
		if ($vars['list_type'] == 'campaign') {
			$vars['list_url'] = sprintf('/campaign/campaign/detail?campaign_sq=%s', $vars['advert_vo']->get_campaign_sq());
		} else if ($vars['list_type'] == 'advert') {
			$vars['list_url'] = '/campaign/advert';
		}
		
		$vars['campaign_vo'] = $this->campaign_model->select_campaign(array (
				'campaign_sq' => $vars['advert_vo']->get_campaign_sq() 
		));
		$vars['selected_target_list'] = $this->advert_model->select_target_info($ad_sq);
		
		list($start_date, $start_time) = explode(' ', $vars['advert_vo']->get_start_dt());
		$date_array = explode('-', $start_date);
		$time_array = explode(':', $start_time);
		
		$freezing_array = $this->common_model->select_freezing();
		
		$vars['calendar_max_week'] = $this->config->item('inventory_max_week');
		$vars['calendar_min_day'] = $this->get_calendar_min_day($freezing_array['apply_time']);
		
		$calendar_min_date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), date('d') + $vars['calendar_min_day'], date('Y')));
		if ($calendar_min_date > $vars['advert_vo']->get_start_dt()) {
			$vars['calendar_min_day'] = -1 * (int)date('z', mktime(0, 0, 0, date('m'), date('d'), date('Y')) - mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]));
		}
		
		$calendar_min_time = $this->get_calendar_min_time($freezing_array['apply_time'], $start_date);
		if ($calendar_min_time > $time_array[0]) {
			$calendar_min_time = $time_array[0];
		}
		
		// 발송시간 selectbox
		$temp_array = explode(':', $vars['advert_vo']->get_start_time());
		$vars['time_selectbox'] = $this->ui_component->create_time_selectbox('start_time', $temp_array[0] . ':00:00', $calendar_min_time);
		
		// 소재정보 selectbox
		$option_array = $this->common_model->select_code_list($this->lang->line('creative_type_ent'));
		$vars['creative_selectbox'] = $this->ui_component->create_creative_selectbox('creative_type_cd', $option_array, $vars['advert_vo']->get_creative_type_cd(), '선택해주세요', 'javascript:changeCreative(this.value);');
		
		// 지역별(시도) selectbox
		$sido_list = $this->common_model->select_sido_list();
		$vars['target_region_sido_list'] = $this->ui_component->create_selectbox('sido_cd', $sido_list, '', '시 선택', 'javascript:getSigugun()');
		
		// 소재
		$creative_type_cd = $vars['advert_vo']->get_creative_type_cd();
		$vars['creative_vo'] = $this->_select_creative($creative_type_cd, $vars['advert_vo']->get_creative_sq());
		
		$vars = array_merge($vars, $this->_get_landing_radio_ui($vars['creative_vo']));
		
		// 타게팅 정보
		$vars = array_merge($vars, $this->_get_target_ui_data($ad_sq, $vars['selected_target_list']));
		
		$this->yield = true;
		$this->yield_js = array (
				'/web/js/campaign/target.js',
				'/web/js/campaign/advert/advert_detail.js' 
		);
		$this->load->view('campaign/advert/advert_detail_view', $vars);
	}

	function image_post() {
		$param_array = $this->input->post();
		$file_id = $param_array['file_id'] ? $param_array['file_id'] : '';
		
		if ($file_id == '') {
			$this->ajax_json_response(false, '파일 업로드 오류(file id empty)');
		} else if (!isset($_FILES[$file_id]) || $_FILES[$file_id]['size'] <= 0) {
			$this->ajax_json_response(false, '선택된 파일이 없습니다.');
		}
		
		list($image_size, $max_size) = $this->_get_creative_standard_size($param_array['creative_type_cd'], $param_array['file_id']);
		
		$upload_path = $this->config->item('creative_upload_path') != '' ? $this->config->item('creative_upload_path') : $_SERVER['DOCUMENT_ROOT'] . '/web/creative';
		$upload_path .= '/' . date('Y') . date('m');
		
		$config = array (
				'upload_path' => $upload_path,
				'allowed_types' => $this->config->item('creative_allowed_types'),
				'max_size' => $max_size,
				'image_size' => $image_size 
		);
		
		$upload_result = $this->utility->fileUpload($file_id, $config); // 업로드
		
		if ($upload_result['msg'] != 'success') {
			log_message('error', 'upload result : ' . $upload_result['msg']);
			$this->ajax_json_response(false, $upload_result['msg']);
		}
		
		$this->file_name = $this->config->item('content_server_url') . '/' . date('Y') . date('m') . '/' . $upload_result['file_name'];
		log_message('info', 'upload file path : ' . $this->file_name);
		
		// 응답
		$this->ajax_json_response(true, $this->file_name);
		
		return;
	}
	
	// GET campaign/advert/searchMedia (미디어 타게팅)
	function searchMedia_get() {
		$search_media = $this->get('search_media') ? $this->get('search_media') : '';
		
		$media_list = array ();
		if ($search_media != '') {
			$params = array (
					'search_media' => $search_media 
			);
			$media_list = $this->media_model->select_search_media($params);
		}
		$media_list_html = $this->ui_component->create_media_list($media_list);
		
		echo json_encode(array (
				'response_type' => 'success',
				'media_count' => count($media_list),
				'media_html' => $media_list_html 
		));
	}
	
	// GET campaign/advert/sigugunSelectbox
	function sigugunSelectbox_get() {
		$sido_cd = $this->get('sido_cd') ? $this->get('sido_cd') : '';
		
		$sigugun_list = array ();
		if ($sido_cd != '') {
			$sigugun_list = $this->common_model->select_sigugun_list($sido_cd);
		}
		echo $this->ui_component->create_selectbox('sigugun_cd', $sigugun_list, '', '구 선택');
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
	
	// 타게팅 UI 구성을 위한 데이터 가공
	function _get_target_ui_data($ad_sq = FALSE, $selected_target_list = array()) {
		$result = array ();
		
		// OS
		$android_ver_list = $this->common_model->select_code_list_treeview($this->lang->line('device_os_and_ent'), 'name', $ad_sq, $this->lang->line('target_type_os_ver'), $this->lang->line('device_os_and_etc'));
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
		$device_list = $this->common_model->select_device_list_treeview($ad_sq, $this->lang->line('target_type_device'));
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
		if (isset($selected_target_list['MEDIA_NAME'])) {
			$result['target_media_name_list'] = $this->media_model->select_target_media($ad_sq, $this->lang->line('target_type_media_name'));
		}
		
		// 미디어(프리미엄 미디어 그룹)
		$media_group_list = $this->media_model->select_media_group($ad_sq, $this->lang->line('target_type_media_group'));
		$result['target_media_group_list'] = $this->_treeview_encode($media_group_list);
		
		// 미디어(카테고리)
		$media_category_list = $this->common_model->select_code_list_treeview($this->lang->line('media_category_ent'), 'att', $ad_sq, $this->lang->line('target_type_media_category'));
		$result['target_media_category_list'] = $this->_treeview_encode($media_category_list);
		
		// 통신사
		$carrier_list = $this->common_model->select_code_list_treeview($this->lang->line('device_carrier_ent'), 'att', $ad_sq, $this->lang->line('target_type_carrier_cd'), $this->lang->line('device_carrier_etc_att'));
		$result['target_carrier_list'] = $this->_treeview_encode($carrier_list);
		
		// 성별
		$gender_list = $this->common_model->select_code_list_treeview($this->lang->line('gender_ent'), 'value1', $ad_sq, $this->lang->line('target_type_gender'));
		$result['target_gender_list'] = $this->_treeview_encode($gender_list);
		
		// 연령
		$age_list = $this->common_model->select_code_list_treeview($this->lang->line('age_ent'), 'value2', $ad_sq, $this->lang->line('target_type_age'));
		$result['target_age_list'] = $this->_treeview_encode($age_list);
		
		// 지역별
		if (isset($selected_target_list[$this->lang->line('target_type_region')])) {
			$result['target_region_list'] = $this->common_model->select_region_list($ad_sq);
		}
		
		return $result;
	}
	
	// 테스트 발송 팝업
	function pushPopup_get() {
		$vars['ad_sq'] = $this->get('ad_sq') ? $this->get('ad_sq') : '';
		
		$this->yield = true;
		$this->layout = 'popup';
		$this->yield_js = '/web/js/campaign/advert/popup/push_popup.js';
		$this->load->view('campaign/advert/popup/push_popup', $vars);
	}
	
	// PUT campaign/advert
	function index_put() {
		$param_array = $this->put();
		$ad_sq = $param_array['ad_sq'];
		
		$advert_vo_old = $this->advert_model->select_advert($ad_sq);
		$param_array['campaign_sq'] = $advert_vo_old->get_campaign_sq();
		$param_array['ad_status_cd'] = $advert_vo_old->get_ad_status_cd();
		$param_array['sch_status_cd'] = $advert_vo_old->get_sch_status_cd();
		$param_array['update_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		
		if ($advert_vo_old->get_ad_status_cd() != $this->lang->line('ad_status_test')) {
			$param_array['ad_nm'] = $advert_vo_old->get_ad_nm();
		}
		
		$advert_vo_new = $this->_get_advert_vo($param_array);
		
		// freezing 시간 확인
		if ($advert_vo_old->get_ad_status_cd() == $this->lang->line('ad_status_test')) {
			$freezing_array = $this->common_model->select_freezing();
			if ($this->is_freezing($advert_vo_new->get_start_dt(), $freezing_array['apply_time'])) {
				$this->ajax_json_response(false, '발송일자 및 시간을 확인해주세요.');
			}
		}
		
		// 광고명 중복 확인
		$params = array (
				'ad_nm' => $advert_vo_new->get_ad_nm(),
				'not_ad_sq' => $advert_vo_new->get_ad_sq() 
		);
		if (count($this->advert_model->select_advert_list($params)) > 0) {
			$this->ajax_json_response(false, '동일한 광고명이 존재합니다.');
		}
		
		$creative_vo_old = $this->_select_creative($advert_vo_old->get_creative_type_cd(), $advert_vo_old->get_creative_sq());
		$creative_vo_new = $this->_get_creative_vo($param_array);
		
		$target_info_list = array ();
		
		// 젤리빈 타게팅 확인
		$creative_type_cd = $advert_vo_new->get_creative_type_cd();
		if ($creative_type_cd == $this->lang->line('creative_type_jb_default') || $creative_type_cd == $this->lang->line('creative_type_jb_big_text') || $creative_type_cd == $this->lang->line('creative_type_jb_inbox') || $creative_type_cd == $this->lang->line('creative_type_jb_big_picture')) {
			$target_info_list[] = array (
					'ad_sq' => $ad_sq,
					'target_element_cd' => $this->lang->line('target_type_jb'),
					'target_value' => $this->lang->line('support_jb_flag') 
			);
		}
		
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_os_enable', 'os_ver', $this->lang->line('target_type_os_ver')));
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_device_enable', 'model_nm', $this->lang->line('target_type_device')));
		if ($this->put('target_media_type') == 'name') {
			$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_media_enable', 'media_name_cd', $this->lang->line('target_type_media_name')));
		} else if ($this->put('target_media_type') == 'group') {
			$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_media_enable', 'media_group_cd', $this->lang->line('target_type_media_group')));
		} else if ($this->put('target_media_type') == 'category') {
			$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_media_enable', 'media_category_cd', $this->lang->line('target_type_media_category')));
		}
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_carrier_enable', 'carrier_cd', $this->lang->line('target_type_carrier_cd')));
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_gender_enable', 'gender_cd', $this->lang->line('target_type_gender')));
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_age_enable', 'age_rng_cd', $this->lang->line('target_type_age')));
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_region_enable', 'region_sido_cd', $this->lang->line('target_type_region_sido')));
		$target_info_list = array_merge($target_info_list, $this->_get_target_info($ad_sq, 'target_region_enable', 'region_gugun_cd', $this->lang->line('target_type_region_gugun')));
		
		// DB 트랜잭션 시작
		$this->advert_model->trans_start();
		
		// 히스토리 등록
		$target_old = $this->advert_model->select_target_info($ad_sq);
		$history_array = array ();
		$history_array['campaign_sq'] = $advert_vo_new->get_campaign_sq();
		$history_array['ad_sq'] = $advert_vo_new->get_ad_sq();
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$modify_list = $this->_get_diff_advert_history($advert_vo_old, $advert_vo_new, $creative_vo_old, $creative_vo_new, $target_old, $target_info_list);
		foreach ( $modify_list as $row ) {
			$temp_array = array_merge($history_array, $row);
			$this->campaign_model->insert_history($temp_array);
		}
		
		// 기존 소재 삭제 후 삽입
		$this->_delete_creative($advert_vo_old->get_creative_type_cd(), $advert_vo_old->get_creative_sq());
		$creative_sq = $this->_insert_creative($advert_vo_new->get_creative_type_cd(), $creative_vo_new);
		$advert_vo_new->set_creative_sq($creative_sq);
		
		// 기존 타게팅 삭제 후 삽입
		if ($advert_vo_old->get_ad_status_cd() == $this->lang->line('ad_status_test')) {
			$params = array (
					'ad_sq' => $ad_sq 
			);
			$this->advert_model->delete_target_info($params);
			foreach ( $target_info_list as $target_info ) {
				$this->advert_model->insert_target_info($target_info);
			}
		}
		
		// 광고 수정
		$this->advert_model->update_advert($advert_vo_new);
		
		if ($this->advert_model->trans_status() === FALSE) {
			$this->advert_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}
		
		// 광고가 검수일때만 ISF 연동 (대기 상태의 광고 메타 연동 시 M005_01 에러 발생)
		if ($advert_vo_old->get_ad_status_cd() == $this->lang->line('ad_status_test')) {
			// isf 광고 메타 연동
			$isf_response = $this->isf->ad('PUT', $ad_sq);
			if ($isf_response !== TRUE) {
				$this->advert_model->trans_rollback();
				$this->ajax_json_response(false, 'ISF 광고 수정에 실패하였습니다.' . $isf_response['err_msg']);
			}
		}
		
		// DB 트랜잭션 종료
		$this->advert_model->trans_complete();
		
		$list_type = isset($param_array['list_type']) ? $param_array['list_type'] : 'campaign';
		$this->ajax_json_response(true, sprintf('/campaign/advert/detail?list_type=%s&ad_sq=%s', $list_type, $ad_sq));
	}

	function _get_diff_advert_history($advert_vo_old, $advert_vo_new, $creative_vo_old, $creative_vo_new, $target_old, $target_new) {
		$result = array ();
		
		if ($advert_vo_old->get_ad_status_cd() == $this->lang->line('ad_status_test')) {
			if ($advert_vo_old->get_ad_nm() != $advert_vo_new->get_ad_nm()) {
				$result[] = array (
						'history_gb' => '광고명',
						'modify_before' => $advert_vo_old->get_ad_nm(),
						'modify_after' => $advert_vo_new->get_ad_nm() 
				);
			}
			if (str_replace(',', '', $advert_vo_old->get_push_booking_cnt()) != $advert_vo_new->get_push_booking_cnt()) {
				$result[] = array (
						'history_gb' => '발송건수',
						'modify_before' => str_replace(',', '', $advert_vo_old->get_push_booking_cnt()),
						'modify_after' => $advert_vo_new->get_push_booking_cnt() 
				);
			}
			if ($advert_vo_old->get_start_dt() != $advert_vo_new->get_start_dt()) {
				$result[] = array (
						'history_gb' => '발송일',
						'modify_before' => $advert_vo_old->get_start_dt(),
						'modify_after' => $advert_vo_new->get_start_dt() 
				);
			}
		}
		
		if ($advert_vo_old->get_creative_type_cd() != $advert_vo_new->get_creative_type_cd() || !$creative_vo_old->equals($creative_vo_new)) {
			$result[] = array (
					'history_gb' => '소재' 
			);
		}
		
		if ($advert_vo_old->get_ad_status_cd() == $this->lang->line('ad_status_test')) {
			$target_element_cd_list = array (
					$this->lang->line('target_type_jb') => '',
					$this->lang->line('target_type_os_ver') => '',
					$this->lang->line('target_type_device') => '',
					$this->lang->line('target_type_media_name') => '',
					$this->lang->line('target_type_media_group') => '',
					$this->lang->line('target_type_media_category') => '',
					$this->lang->line('target_type_carrier_cd') => '',
					$this->lang->line('target_type_gender') => '',
					$this->lang->line('target_type_age') => '',
					$this->lang->line('target_type_region_sido') => '',
					$this->lang->line('target_type_region_gugun') => '' 
			);
			$temp_target_old = $temp_target_new = $target_element_cd_list;
			foreach ( $target_old as $target_element_cd => $target_value_array ) {
				$temp_target_old[$target_element_cd] = implode(',', $target_value_array);
			}
			
			foreach ( $target_new as $row ) {
				$target_element_cd = $row['target_element_cd'];
				$target_value = $row['target_value'];
				$temp_target_new[$target_element_cd] .= $temp_target_new[$target_element_cd] != '' ? ',' . $target_value : $target_value;
			}
			
			$diff_array_old = array_diff($temp_target_old, $temp_target_new);
			$diff_array_new = array_diff($temp_target_new, $temp_target_old);
			if (!empty($diff_array_old) || !empty($diff_array_new)) {
				
				$result[] = array (
						'history_gb' => '타게팅' 
				);
			}
		}
		
		return $result;
	}
	
	// array to vo
	function _get_advert_vo($param_array) {
		$advert_vo = new Advert_vo();
		
		$advert_vo->set_ad_sq(isset($param_array['ad_sq']) ? $param_array['ad_sq'] : '');
		$advert_vo->set_campaign_sq(isset($param_array['campaign_sq']) ? $param_array['campaign_sq'] : '');
		$advert_vo->set_creative_type_cd(isset($param_array['creative_type_cd']) ? $param_array['creative_type_cd'] : '');
		$advert_vo->set_creative_sq(isset($param_array['creative_sq']) ? $param_array['creative_sq'] : '');
		$advert_vo->set_ad_nm(isset($param_array['ad_nm']) ? $param_array['ad_nm'] : '');
		$advert_vo->set_ad_status_cd(isset($param_array['ad_status_cd']) ? $param_array['ad_status_cd'] : '');
		$advert_vo->set_sch_status_cd(isset($param_array['sch_status_cd']) ? $param_array['sch_status_cd'] : '');
		$advert_vo->set_push_booking_cnt(isset($param_array['push_booking_cnt']) ? str_replace(',', '', $param_array['push_booking_cnt']) : '');
		if (isset($param_array['start_dt']) && isset($param_array['start_time'])) {
			$advert_vo->set_start_dt($param_array['start_dt'] . ' ' . $param_array['start_time']);
		}
		$advert_vo->set_create_account_sq(isset($param_array['create_account_sq']) ? $param_array['create_account_sq'] : '');
		$advert_vo->set_update_account_sq(isset($param_array['update_account_sq']) ? $param_array['update_account_sq'] : '');
		
		return $advert_vo;
	}
	
	// 타게팅 정보 가공 (put 데이터를 array로 가공)
	function _get_target_info($ad_sq, $selectbox_id, $input_id, $target_element_cd) {
		$result = array ();
		if ($this->put($selectbox_id) == true) {
			$input_value = $this->put($input_id);
			if ($input_value != '') {
				$target_value_list = explode(',', $input_value);
				$result = $this->_get_generate_target($ad_sq, $target_element_cd, $target_value_list);
			}
		}
		return $result;
	}

	function _get_generate_target($ad_sq, $target_element_cd, $target_value_list) {
		$result = array ();
		
		$target_value_list = array_unique($target_value_list);
		
		foreach ( $target_value_list as $target_value ) {
			if ($target_value != '') {
				$result[] = array (
						'ad_sq' => $ad_sq,
						'target_element_cd' => $target_element_cd,
						'target_value' => $target_value 
				);
			}
		}
		
		return $result;
	}
	
	// 광고 상태 변경 (발송대기/검수)
	function status_put() {
		$ad_sq = $this->put('ad_sq') ? $this->put('ad_sq') : '';
		$ad_status_cd = $this->put('ad_status_cd') ? $this->put('ad_status_cd') : '';
		
		if ($ad_sq == '') {
			$this->ajax_json_response(false, '광고 시퀀스가 없습니다.');
		}
		
		switch ($ad_status_cd) {
			case $this->lang->line('ad_status_test') :
				echo $this->_ad_status_test($ad_sq);
				break;
			case $this->lang->line('ad_status_stand') :
				echo $this->_ad_status_stand($ad_sq);
				break;
			default :
				$this->ajax_json_response(false, '변경하려는 광고 상태를 알수없습니다.(' . $ad_status_cd . ')');
		}
	}
	
	// 검수 상태로 변경
	function _ad_status_test($ad_sq) {
		$advert_vo = $this->advert_model->select_advert($ad_sq);
		
		// 현재 광고 상태 확인
		if ($advert_vo->get_ad_status_cd() != $this->lang->line('ad_status_stand')) {
			$this->ajax_json_response(false, '광고 상태를 확인하세요.');
		}
		
		$ad_status_cd = $this->lang->line('ad_status_test');
		$sch_status_cd = $this->lang->line('sch_status_ready');
		
		// DB 트랜잭션 시작
		$this->advert_model->trans_start();
		
		// 광고 상태 업데이트
		$advert_vo_new = new Advert_vo();
		$advert_vo_new->set_ad_sq($ad_sq);
		$advert_vo_new->set_ad_status_cd($ad_status_cd);
		$advert_vo_new->set_sch_status_cd($sch_status_cd);
		$advert_vo_new->set_update_account_sq($this->session->userdata('ACCOUNT_SQ'));
		$this->advert_model->update_advert($advert_vo_new);
		
		// 캠페인 수정 (시작, 종료, 발송)
		$this->campaign_model->update_campaign_summary($advert_vo->get_campaign_sq());
		
		// 히스토리 추가
		$history_array = array ();
		$history_array['campaign_sq'] = $advert_vo->get_campaign_sq();
		$history_array['ad_sq'] = $advert_vo->get_ad_sq();
		$history_array['history_gb'] = '상태';
		$history_array['modify_before'] = $advert_vo->get_ad_status_nm();
		$history_array['modify_after'] = $this->common_model->select_code_name($ad_status_cd);
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$campaign_history_sq = $this->campaign_model->insert_history($history_array);
		
		if ($this->advert_model->trans_status() === FALSE) {
			$this->advert_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}

		// DB 트랜잭션 종료
		$this->advert_model->trans_complete();
		
		// isf 타게팅 취소 요청
		$isf_response = $this->isf->cancel($ad_sq);
		if ($isf_response !== TRUE) {
			$this->_ad_status_test_rollback($advert_vo, $campaign_history_sq);
			$this->ajax_json_response(false, 'ISF 타게팅 취소 요청에 실패하였습니다.' . $isf_response['err_msg']);
		}

		// 광고 메타 연동
		$isf_response = $this->isf->ad('PUT', $ad_sq);
		if ($isf_response !== TRUE) {
			$this->ajax_json_response(true, 'ISF 광고 수정에 실패하였습니다.' . $isf_response['err_msg']);
		}
		
		// ISF 캠페인 메타 연동
		$isf_response = $this->isf->campaign('PUT', $advert_vo->get_campaign_sq());
		if ($isf_response !== TRUE) {
			$this->ajax_json_response(true, 'ISF 등록에 실패하였습니다.' . $isf_response['err_msg']);
		}
		
		$this->ajax_json_response(true, '변경 되었습니다.');
	}

	function _ad_status_test_rollback($advert_vo, $campaign_history_sq) {
		$this->advert_model->update_advert($advert_vo);
		$this->campaign_model->update_campaign_summary($advert_vo->get_campaign_sq());
		$this->campaign_model->delete_history($campaign_history_sq);
	}
	
	// 발송대기 상태로 변경
	function _ad_status_stand($ad_sq) {
		$advert_vo = $this->advert_model->select_advert($ad_sq);
		
		// 현재 광고 상태 확인
		if ($advert_vo->get_ad_status_cd() != $this->lang->line('ad_status_test')) {
			$this->ajax_json_response(false, '광고 상태를 확인하세요.');
		}
		
		// validate 확인 (광고 소재)
		if ($advert_vo->get_creative_type_cd() == '' || $advert_vo->get_creative_sq() == '') {
			$this->ajax_json_response(false, '소재 정보 입력이 필요합니다.');
		}
		$creative_vo = $this->_select_creative($advert_vo->get_creative_type_cd(), $advert_vo->get_creative_sq());
		if (empty($creative_vo) || $creative_vo->get_creative_sq() == '') {
			$this->ajax_json_response(false, '소재 정보 입력이 필요합니다.');
		}
		
		// freezing 시간 확인
		$freezing_array = $this->common_model->select_freezing();
		if ($this->is_freezing($advert_vo->get_start_dt(), $freezing_array['apply_time'])) {
			$this->ajax_json_response(false, '발송일자 및 시간을 확인해주세요.');
		}
		
		$ad_status_cd = $this->lang->line('ad_status_stand');
		$sch_status_cd = $this->lang->line('sch_status_booking');
		
		// DB 트랜잭션 시작
		$this->advert_model->trans_start();
		
		// 광고 상태 업데이트
		$advert_vo_new = new Advert_vo();
		$advert_vo_new->set_ad_sq($ad_sq);
		$advert_vo_new->set_ad_status_cd($ad_status_cd);
		$advert_vo_new->set_sch_status_cd($sch_status_cd);
		$advert_vo_new->set_update_account_sq($this->session->userdata('ACCOUNT_SQ'));
		$this->advert_model->update_advert($advert_vo_new);
		
		// 캠페인 수정 (시작, 종료, 발송)
		$this->campaign_model->update_campaign_summary($advert_vo->get_campaign_sq());
		
		// 히스토리 추가
		$history_array = array ();
		$history_array['campaign_sq'] = $advert_vo->get_campaign_sq();
		$history_array['ad_sq'] = $advert_vo->get_ad_sq();
		$history_array['history_gb'] = '상태';
		$history_array['modify_before'] = $advert_vo->get_ad_status_nm();
		$history_array['modify_after'] = $this->common_model->select_code_name($ad_status_cd);
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$campaign_history_sq = $this->campaign_model->insert_history($history_array);
		
		// 리포트,통계를 위한 미디어,통신사 코드 추가
		$params = array (
				'ad_sq' => $ad_sq 
		);
		
		$params['target_element_cd'] = $this->lang->line('target_type_media');
		$this->advert_model->delete_target_info($params);
		
		$params['target_element_cd'] = $this->lang->line('target_type_carrier');
		$this->advert_model->delete_target_info($params);
		
		$params['target_element_cd'] = $this->lang->line('target_type_region');
		$this->advert_model->delete_target_info($params);
		
		$params['target_element_cd'] = $this->lang->line('target_type_vendor');
		$this->advert_model->delete_target_info($params);
		
		$target_info_list = $this->_get_target_report_list($ad_sq);
		foreach ( $target_info_list as $target_info ) {
			$this->advert_model->insert_target_info($target_info);
		}
		
		// DB 결과 확인
		if ($this->advert_model->trans_status() === FALSE) {
			$this->advert_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}

		// DB 트랜잭션 종료
		$this->advert_model->trans_complete();
		
		// ISF 광고 메타 연동
		$isf_response = $this->isf->ad('PUT', $ad_sq);
		if ($isf_response !== TRUE) {
			$this->_ad_status_stand_rollback($advert_vo, $campaign_history_sq);
			$this->ajax_json_response(false, 'ISF 광고 수정에 실패하였습니다.' . $isf_response['err_msg']);
		}
		
		// ISF 캠페인 메타 연동
		$isf_response = $this->isf->campaign('PUT', $advert_vo->get_campaign_sq());
		if ($isf_response !== TRUE) {
			$this->_ad_status_stand_rollback($advert_vo, $campaign_history_sq);
			$this->ajax_json_response(false, 'ISF 등록에 실패하였습니다.' . $isf_response['err_msg']);
		}
		
		// ISF 타게팅 요청
		$isf_response = $this->isf->reserve($ad_sq);
		if ($isf_response !== TRUE) {
			$this->_ad_status_stand_rollback($advert_vo, $campaign_history_sq);
			if (isset($isf_response['SVC_ERR_CD']) && $isf_response['SVC_ERR_CD'] == 'T002_04') {
				$this->ajax_json_response(false, '발송 모수가 부족합니다. 광고를 수정해주세요.');
			} else {
				$this->ajax_json_response(false, 'ISF 타게팅 요청에 실패하였습니다.' . $isf_response['err_msg']);
			}
		}
		
		$this->ajax_json_response(true, '변경 되었습니다.');
	}

	function _ad_status_stand_rollback($advert_vo, $campaign_history_sq) {
		$this->advert_model->update_advert($advert_vo);
		$this->campaign_model->update_campaign_summary($advert_vo->get_campaign_sq());
		$this->campaign_model->delete_history($campaign_history_sq);
		
		$params = array (
				'ad_sq' => $advert_vo->get_ad_sq()
		);
		
		$params['target_element_cd'] = $this->lang->line('target_type_media');
		$this->advert_model->delete_target_info($params);
		
		$params['target_element_cd'] = $this->lang->line('target_type_carrier');
		$this->advert_model->delete_target_info($params);
		
		$params['target_element_cd'] = $this->lang->line('target_type_region');
		$this->advert_model->delete_target_info($params);
		
		$params['target_element_cd'] = $this->lang->line('target_type_vendor');
		$this->advert_model->delete_target_info($params);
		
	}
	
	function _get_target_report_list($ad_sq) {
		$target_info_list = array ();
		
		$region_list = array ();
		
		$target_array = $this->isf_model->select_target($ad_sq);
		foreach ( $target_array as $row ) {
			if ($row['target_element_cd'] == $this->lang->line('target_type_media')) {
				$target_info_list = array_merge($target_info_list, $this->_get_generate_target($ad_sq, $this->lang->line('target_type_media'), explode(',', $row['target_value'])));
			} else if ($row['target_element_cd'] == $this->lang->line('target_type_carrier')) {
				$target_info_list = array_merge($target_info_list, $this->_get_generate_target($ad_sq, $this->lang->line('target_type_carrier'), explode(',', $row['target_value'])));
			} else if ($row['target_element_cd'] == $this->lang->line('target_type_region_sido')) {
				$sido_list = explode(',', $row['target_value']);
				foreach ( $sido_list as $sido_cd ) {
					$region_list = array_merge($region_list, $this->common_model->select_sigugun_list($sido_cd, 'target'));
				}
			} else if ($row['target_element_cd'] == $this->lang->line('target_type_region_gugun')) {
				$region_list = array_merge($region_list, explode(',', $row['target_value']));
			} else if ($row['target_element_cd'] == $this->lang->line('target_type_device')) {
				$params = array (
						'model_nm_list' => explode(',', $row['target_value']) 
				);
				$vendor_list = $this->common_model->select_vendor_list($params);
				$target_info_list = array_merge($target_info_list, $this->_get_generate_target($ad_sq, $this->lang->line('target_type_vendor'), $vendor_list));
			}
		}
		
		$target_info_list = array_merge($target_info_list, $this->_get_generate_target($ad_sq, $this->lang->line('target_type_region'), $region_list));
		
		return $target_info_list;
	}

	function adListPopup_get() {
		$vars = array ();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page'); // 페이지당 출력 게시글수
		
		$querystring['start_dt'] = $this->get('start_dt') ? $this->get('start_dt') : '';
		
		$vars = $querystring;
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $querystring['start_dt'] . ' 00:00:00',
				'search_end_dt' => $querystring['start_dt'] . ' 23:59:59',
				'ad_status_cd_array' => array (
						$this->lang->line('ad_status_stand'),
						$this->lang->line('ad_status_send') 
				),
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page 
		);
		$vars['list'] = $this->advert_model->select_advert_list($params);
		$vars['total_rows'] = $this->advert_model->count_advert_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/campaign/advert/adListPopup';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $querystring;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		
		$this->yield = true;
		$this->layout = 'popup';
		$this->yield_js = '/web/js/campaign/advert/popup/advert_list_popup.js';
		$this->load->view('campaign/advert/popup/advert_list_popup', $vars);
	}
	
	// GET campaign/advert/creative
	function creative_get() {
		$creative_type_cd = $this->get('creative_type_cd') ? $this->get('creative_type_cd') : '';
		
		$vars['creative_vo'] = new Creative_vo();
		
		$vars = array_merge($vars, $this->_get_landing_radio_ui($vars['creative_vo']));
		
		switch ($creative_type_cd) {
			case $this->lang->line('creative_type_text') :
				$this->load->view('campaign/advert/creative/creative_text_layer', $vars);
				break;
			case $this->lang->line('creative_type_image') :
				$this->load->view('campaign/advert/creative/creative_image_layer', $vars);
				break;
			case $this->lang->line('creative_type_popup_text_banner') :
				$this->load->view('campaign/advert/creative/creative_popup_text_banner_layer', $vars);
				break;
			case $this->lang->line('creative_type_popup_text') :
				$this->load->view('campaign/advert/creative/creative_popup_text_layer', $vars);
				break;
			case $this->lang->line('creative_type_popup_image_banner') :
				$this->load->view('campaign/advert/creative/creative_popup_image_banner_layer', $vars);
				break;
			case $this->lang->line('creative_type_popup_image') :
				$this->load->view('campaign/advert/creative/creative_popup_image_layer', $vars);
				break;
			case $this->lang->line('creative_type_jb_default') :
				$this->load->view('campaign/advert/creative/creative_jb_default_layer', $vars);
				break;
			case $this->lang->line('creative_type_jb_big_text') :
				$this->load->view('campaign/advert/creative/creative_jb_big_text_layer', $vars);
				break;
			case $this->lang->line('creative_type_jb_inbox') :
				$this->load->view('campaign/advert/creative/creative_jb_inbox_layer', $vars);
				break;
			case $this->lang->line('creative_type_jb_big_picture') :
				$this->load->view('campaign/advert/creative/creative_jb_big_picture_layer', $vars);
				break;
		}
	}

	function _get_creative_standard_size($creative_type_cd, $file_id) {
		if ($file_id == 'large_icon_image_file') {
			$image_size = $this->config->item('large_icon_image_size');
			$max_size = $this->config->item('large_icon_max_size');
		} else if ($file_id == 'banner_image_file') {
			$image_size = $this->config->item($creative_type_cd . '_banner_image_size');
			$max_size = $this->config->item($creative_type_cd . '_banner_max_size');
		} else if ($file_id == 'popup_image_file') {
			$image_size = $this->config->item($creative_type_cd . '_popup_image_size');
			$max_size = $this->config->item($creative_type_cd . '_popup_max_size');
		}
		return array (
				$image_size,
				$max_size 
		);
	}
	
	// array to vo
	function _get_creative_vo($param_array) {
		$creative_vo = new Creative_vo();
		
		$creative_vo->set_ticket_text(isset($param_array['ticket_text']) ? $param_array['ticket_text'] : '');
		$creative_vo->set_large_icon_image(isset($param_array['large_icon_image']) ? $param_array['large_icon_image'] : '');
		$creative_vo->set_content_title(isset($param_array['content_title']) ? $param_array['content_title'] : '');
		$creative_vo->set_content_text(isset($param_array['content_text']) ? $param_array['content_text'] : '');
		$creative_vo->set_sub_text(isset($param_array['sub_text']) ? $param_array['sub_text'] : '');
		$creative_vo->set_banner_image(isset($param_array['banner_image']) ? $param_array['banner_image'] : '');
		$creative_vo->set_summary_text(isset($param_array['summary_text']) ? $param_array['summary_text'] : '');
		
		$creative_vo->set_popup_title(isset($param_array['popup_title']) ? $param_array['popup_title'] : '');
		$creative_vo->set_popup_content_text(isset($param_array['popup_content_text']) ? $param_array['popup_content_text'] : '');
		$creative_vo->set_landing_button_title(isset($param_array['landing_button_title']) ? $param_array['landing_button_title'] : '');
		$creative_vo->set_popup_image(isset($param_array['popup_image']) ? $param_array['popup_image'] : '');
		
		if (isset($param_array['landing_type_cd'])) {
			$creative_vo->set_landing_type_cd($param_array['landing_type_cd'] ? $param_array['landing_type_cd'] : '');
			if ($param_array['landing_type_cd'] == $this->lang->line('landing_type_web') || $param_array['landing_type_cd'] == $this->lang->line('landing_type_web_view')) {
				$creative_vo->set_landing_type_url($param_array['landing_type_url'] ? $param_array['landing_type_url'] : '');
			} else if ($param_array['landing_type_cd'] == $this->lang->line('landing_type_app_dl')) {
				$creative_vo->set_tst_dl_url($param_array['tst_dl_url'] ? $param_array['tst_dl_url'] : '');
				$creative_vo->set_mar_dl_url($param_array['mar_dl_url'] ? $param_array['mar_dl_url'] : '');
				$creative_vo->set_alt_url($param_array['alt_url'] ? $param_array['alt_url'] : '');
			} else if ($param_array['landing_type_cd'] == $this->lang->line('landing_type_run')) {
				$creative_vo->set_and_run_url($param_array['and_run_url'] ? $param_array['and_run_url'] : '');
				$creative_vo->set_tst_dl_url($param_array['tst_dl_url'] ? $param_array['tst_dl_url'] : '');
				$creative_vo->set_mar_dl_url($param_array['mar_dl_url'] ? $param_array['mar_dl_url'] : '');
				$creative_vo->set_alt_url($param_array['alt_url'] ? $param_array['alt_url'] : '');
			}
		}
		
		if (isset($param_array['action1_landing_type_cd']) && $param_array['action1_landing_type_cd'] != '') {
			$creative_vo->set_action1_landing_type_cd($param_array['action1_landing_type_cd'] ? $param_array['action1_landing_type_cd'] : '');
			$creative_vo->set_action1_text($param_array['action1_text'] ? $param_array['action1_text'] : '');
			if ($param_array['action1_landing_type_cd'] == $this->lang->line('landing_type_web') || $param_array['action1_landing_type_cd'] == $this->lang->line('landing_type_web_view')) {
				$creative_vo->set_action1_landing_type_url($param_array['action1_landing_type_url'] ? $param_array['action1_landing_type_url'] : '');
			} else if ($param_array['action1_landing_type_cd'] == $this->lang->line('landing_type_app_dl')) {
				$creative_vo->set_action1_tst_dl_url($param_array['action1_tst_dl_url'] ? $param_array['action1_tst_dl_url'] : '');
				$creative_vo->set_action1_mar_dl_url($param_array['action1_mar_dl_url'] ? $param_array['action1_mar_dl_url'] : '');
				$creative_vo->set_action1_alt_url($param_array['action1_alt_url'] ? $param_array['action1_alt_url'] : '');
			} else if ($param_array['action1_landing_type_cd'] == $this->lang->line('landing_type_run')) {
				$creative_vo->set_action1_and_run_url($param_array['action1_and_run_url'] ? $param_array['action1_and_run_url'] : '');
				$creative_vo->set_action1_tst_dl_url($param_array['action1_tst_dl_url'] ? $param_array['action1_tst_dl_url'] : '');
				$creative_vo->set_action1_mar_dl_url($param_array['action1_mar_dl_url'] ? $param_array['action1_mar_dl_url'] : '');
				$creative_vo->set_action1_alt_url($param_array['action1_alt_url'] ? $param_array['action1_alt_url'] : '');
			}
		}
		
		if (isset($param_array['action2_landing_type_cd']) && $param_array['action2_landing_type_cd'] != '') {
			$creative_vo->set_action2_landing_type_cd($param_array['action2_landing_type_cd'] ? $param_array['action2_landing_type_cd'] : '');
			$creative_vo->set_action2_text($param_array['action2_text'] ? $param_array['action2_text'] : '');
			if ($param_array['action2_landing_type_cd'] == $this->lang->line('landing_type_web') || $param_array['action2_landing_type_cd'] == $this->lang->line('landing_type_web_view')) {
				$creative_vo->set_action2_landing_type_url($param_array['action2_landing_type_url'] ? $param_array['action2_landing_type_url'] : '');
			} else if ($param_array['action2_landing_type_cd'] == $this->lang->line('landing_type_app_dl')) {
				$creative_vo->set_action2_tst_dl_url($param_array['action2_tst_dl_url'] ? $param_array['action2_tst_dl_url'] : '');
				$creative_vo->set_action2_mar_dl_url($param_array['action2_mar_dl_url'] ? $param_array['action2_mar_dl_url'] : '');
				$creative_vo->set_action2_alt_url($param_array['action2_alt_url'] ? $param_array['action2_alt_url'] : '');
			} else if ($param_array['action2_landing_type_cd'] == $this->lang->line('landing_type_run')) {
				$creative_vo->set_action2_and_run_url($param_array['action2_and_run_url'] ? $param_array['action2_and_run_url'] : '');
				$creative_vo->set_action2_tst_dl_url($param_array['action2_tst_dl_url'] ? $param_array['action2_tst_dl_url'] : '');
				$creative_vo->set_action2_mar_dl_url($param_array['action2_mar_dl_url'] ? $param_array['action2_mar_dl_url'] : '');
				$creative_vo->set_action2_alt_url($param_array['action2_alt_url'] ? $param_array['action2_alt_url'] : '');
			}
		}
		
		if (isset($param_array['action3_landing_type_cd']) && $param_array['action3_landing_type_cd'] != '') {
			$creative_vo->set_action3_landing_type_cd($param_array['action3_landing_type_cd'] ? $param_array['action3_landing_type_cd'] : '');
			$creative_vo->set_action3_text($param_array['action3_text'] ? $param_array['action3_text'] : '');
			if ($param_array['action3_landing_type_cd'] == $this->lang->line('landing_type_web') || $param_array['action3_landing_type_cd'] == $this->lang->line('landing_type_web_view')) {
				$creative_vo->set_action3_landing_type_url($param_array['action3_landing_type_url'] ? $param_array['action3_landing_type_url'] : '');
			} else if ($param_array['action3_landing_type_cd'] == $this->lang->line('landing_type_app_dl')) {
				$creative_vo->set_action3_tst_dl_url($param_array['action3_tst_dl_url'] ? $param_array['action3_tst_dl_url'] : '');
				$creative_vo->set_action3_mar_dl_url($param_array['action3_mar_dl_url'] ? $param_array['action3_mar_dl_url'] : '');
				$creative_vo->set_action3_alt_url($param_array['action3_alt_url'] ? $param_array['action3_alt_url'] : '');
			} else if ($param_array['action3_landing_type_cd'] == $this->lang->line('landing_type_run')) {
				$creative_vo->set_action3_and_run_url($param_array['action3_and_run_url'] ? $param_array['action3_and_run_url'] : '');
				$creative_vo->set_action3_tst_dl_url($param_array['action3_tst_dl_url'] ? $param_array['action3_tst_dl_url'] : '');
				$creative_vo->set_action3_mar_dl_url($param_array['action3_mar_dl_url'] ? $param_array['action3_mar_dl_url'] : '');
				$creative_vo->set_action3_alt_url($param_array['action3_alt_url'] ? $param_array['action3_alt_url'] : '');
			}
		}
		
		$creative_vo->set_inbox_text_line_1(isset($param_array['inbox_text_line_1']) ? $param_array['inbox_text_line_1'] : '');
		$creative_vo->set_inbox_text_line_2(isset($param_array['inbox_text_line_2']) ? $param_array['inbox_text_line_2'] : '');
		$creative_vo->set_inbox_text_line_3(isset($param_array['inbox_text_line_3']) ? $param_array['inbox_text_line_3'] : '');
		$creative_vo->set_inbox_text_line_4(isset($param_array['inbox_text_line_4']) ? $param_array['inbox_text_line_4'] : '');
		$creative_vo->set_inbox_text_line_5(isset($param_array['inbox_text_line_5']) ? $param_array['inbox_text_line_5'] : '');
		$creative_vo->set_inbox_text_line_6(isset($param_array['inbox_text_line_6']) ? $param_array['inbox_text_line_6'] : '');
		$creative_vo->set_inbox_text_line_7(isset($param_array['inbox_text_line_7']) ? $param_array['inbox_text_line_7'] : '');
		
		return $creative_vo;
	}

	function _get_landing_radio_ui($creative_vo) {
		$result = array ();
		
		$landing_type_cd = $creative_vo->get_landing_type_cd() != '' ? $creative_vo->get_landing_type_cd() : $this->lang->line('landing_type_web');
		$radio_array = $this->common_model->select_code_list($this->lang->line('landing_type_ent'), 'value1');
		$result['landing_type_radio'] = $this->ui_component->create_radio_button('landing_type_cd', $radio_array, 'landing_type_radio', $landing_type_cd);
		
		$action1_landing_type_cd = $creative_vo->get_action1_landing_type_cd();
		$result['action1_landing_type_radio'] = $this->ui_component->create_radio_button('action1_landing_type_cd', $radio_array, 'landing_type_radio', $action1_landing_type_cd, '선택 안함');
		
		$action2_landing_type_cd = $creative_vo->get_action2_landing_type_cd();
		$result['action2_landing_type_radio'] = $this->ui_component->create_radio_button('action2_landing_type_cd', $radio_array, 'landing_type_radio', $action2_landing_type_cd, '선택 안함');
		
		$action3_landing_type_cd = $creative_vo->get_action3_landing_type_cd();
		$result['action3_landing_type_radio'] = $this->ui_component->create_radio_button('action3_landing_type_cd', $radio_array, 'landing_type_radio', $action3_landing_type_cd, '선택 안함');
		
		return $result;
	}
	
	// 소재 조회
	function _select_creative($creative_type_cd, $creative_sq) {
		switch ($creative_type_cd) {
			case $this->lang->line('creative_type_text') :
				return $this->creative_model->select_creative_text($creative_sq);
			case $this->lang->line('creative_type_image') :
				return $this->creative_model->select_creative_image($creative_sq);
			case $this->lang->line('creative_type_popup_text_banner') :
				return $this->creative_model->select_creative_popup_text_banner($creative_sq);
			case $this->lang->line('creative_type_popup_text') :
				return $this->creative_model->select_creative_popup_text($creative_sq);
			case $this->lang->line('creative_type_popup_image_banner') :
				return $this->creative_model->select_creative_popup_image_banner($creative_sq);
			case $this->lang->line('creative_type_popup_image') :
				return $this->creative_model->select_creative_popup_image($creative_sq);
			case $this->lang->line('creative_type_jb_default') :
				return $this->creative_model->select_creative_jb_default($creative_sq);
			case $this->lang->line('creative_type_jb_big_text') :
				return $this->creative_model->select_creative_jb_big_text($creative_sq);
			case $this->lang->line('creative_type_jb_inbox') :
				return $this->creative_model->select_creative_jb_inbox($creative_sq);
			case $this->lang->line('creative_type_jb_big_picture') :
				return $this->creative_model->select_creative_jb_big_picture($creative_sq);
			default :
				return new Creative_vo();
		}
	}
	
	// 소재 등록
	function _insert_creative($creative_type_cd, $creative_vo) {
		switch ($creative_type_cd) {
			case $this->lang->line('creative_type_text') :
				return $this->creative_model->insert_creative_text($creative_vo);
			case $this->lang->line('creative_type_image') :
				return $this->creative_model->insert_creative_image($creative_vo);
			case $this->lang->line('creative_type_popup_text_banner') :
				return $this->creative_model->insert_creative_popup_text_banner($creative_vo);
			case $this->lang->line('creative_type_popup_text') :
				return $this->creative_model->insert_creative_popup_text($creative_vo);
			case $this->lang->line('creative_type_popup_image_banner') :
				return $this->creative_model->insert_creative_popup_image_banner($creative_vo);
			case $this->lang->line('creative_type_popup_image') :
				return $this->creative_model->insert_creative_popup_image($creative_vo);
			case $this->lang->line('creative_type_jb_default') :
				return $this->creative_model->insert_creative_jb_default($creative_vo);
			case $this->lang->line('creative_type_jb_big_text') :
				return $this->creative_model->insert_creative_jb_big_text($creative_vo);
			case $this->lang->line('creative_type_jb_inbox') :
				return $this->creative_model->insert_creative_jb_inbox($creative_vo);
			case $this->lang->line('creative_type_jb_big_picture') :
				return $this->creative_model->insert_creative_jb_big_picture($creative_vo);
		}
	}
	
	// 소재 삭제
	function _delete_creative($creative_type_cd, $creative_sq) {
		switch ($creative_type_cd) {
			case $this->lang->line('creative_type_text') :
				return $this->creative_model->delete_creative_text($creative_sq);
			case $this->lang->line('creative_type_image') :
				return $this->creative_model->delete_creative_image($creative_sq);
			case $this->lang->line('creative_type_popup_text_banner') :
				return $this->creative_model->delete_creative_popup_text_banner($creative_sq);
			case $this->lang->line('creative_type_popup_text') :
				return $this->creative_model->delete_creative_popup_text($creative_sq);
			case $this->lang->line('creative_type_popup_image_banner') :
				return $this->creative_model->delete_creative_popup_image_banner($creative_sq);
			case $this->lang->line('creative_type_popup_image') :
				return $this->creative_model->delete_creative_popup_image($creative_sq);
			case $this->lang->line('creative_type_jb_default') :
				return $this->creative_model->delete_creative_jb_default($creative_sq);
			case $this->lang->line('creative_type_jb_big_text') :
				return $this->creative_model->delete_creative_jb_big_text($creative_sq);
			case $this->lang->line('creative_type_jb_inbox') :
				return $this->creative_model->delete_creative_jb_inbox($creative_sq);
			case $this->lang->line('creative_type_jb_big_picture') :
				return $this->creative_model->delete_creative_jb_big_picture($creative_sq);
		}
	}

}

/* End of file advert.php */
/* Location: ./application/admin/controllers/campaign/advert.php */
