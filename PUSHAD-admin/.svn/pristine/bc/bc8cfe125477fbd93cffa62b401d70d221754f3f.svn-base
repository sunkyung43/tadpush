<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Campaign extends MY_Controller {
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

	public function __construct() {
		parent::__construct();
		
		$this->load->model('/campaign/campaign_model');
		$this->load->model('/campaign/advert_model');
		
		$this->load_vo('campaign/campaign_vo');
		$this->load_vo('campaign/advert_vo');
		$this->load_vo('campaign/history_vo');
	}

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
		$vars['list'] = $this->campaign_model->select_campaign_list($params);
		$vars['total_rows'] = $this->campaign_model->count_campaign_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/campaign/campaign';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $querystring;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		$vars['paging_volume'] = $this->paging->create_page_volume($per_page);
		
		$vars['excel_url'] = '/campaign/campaign/excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/campaign/campaign_list.js';
		$this->load->view('campaign/campaign/campaign_list_view', $vars);
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
		
		$list = $this->campaign_model->select_campaign_list($params);
		
		$column_list = array (
				'No' => 'campaign_sq',
				'캠페인 명' => 'campaign_nm',
				'광고주' => 'adv_company_nm',
				'브랜드' => 'adv_brand_nm',
				'기간' => 'tot_campaign_dt',
				'진행현황(진행/목표)' => 'tot_booking_and_request_cnt',
				'검수' => 'tot_test_cnt',
				'대기' => 'tot_ready_cnt',
				'완료' => 'tot_complete_cnt' 
		);
		
		$this->excel->export_excel('campaign_list.xls', 'campaign', $column_list, $list);
	}

	function write_get() {
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/campaign/campaign_write.js';
		$this->load->view('campaign/campaign/campaign_write_view');
	}

	function index_post() {
		$param_array = $this->post();
		
		$param_array['create_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$param_array['update_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$param_array['report_id'] = date('YmdHis');
		$campaign_vo = $this->_get_campaign_vo($param_array);
		$campaign_vo->set_campaign_status_cd($this->lang->line('campaign_status_enable'));
		
		// 캠페인명 중복확인
		$params = array('campaign_nm' => $campaign_vo->get_campaign_nm());
		if(count($this->campaign_model->select_campaign_list($params)) > 0) {
			$this->ajax_json_response(false, '동일한 캠페인명이 존재합니다.');
		}
		
		// DB 트랜잭션 시작
		$this->campaign_model->trans_start();
		
		$campaign_sq = $this->campaign_model->insert_campaign($campaign_vo);
		
		// 히스토리 등록
		$history_array = array ();
		$history_array['campaign_sq'] = $campaign_sq;
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$history_array['history_gb'] = '생성';
		$this->campaign_model->insert_history($history_array);
		
		if ($this->campaign_model->trans_status() === FALSE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}
		
		// isf 연동
		$isf_response = $this->isf->campaign('POST', $campaign_sq);
		if ($isf_response !== TRUE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 캠페인 등록에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->campaign_model->trans_complete();
		
		$this->ajax_json_response(true, '/campaign/campaign/detail?campaign_sq=' . $campaign_sq);
	}

	function index_put() {
		$param_array = $this->put();
		$campaign_sq = $param_array['campaign_sq'];
		
		$params = array (
				'campaign_sq' => $campaign_sq 
		);
		$campaign_vo_old = $this->campaign_model->select_campaign($params);
		
		$param_array['update_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$campaign_vo_new = $this->_get_campaign_vo($param_array);
		
		// 캠페인명 중복확인
		$params = array('campaign_nm' => $campaign_vo_new->get_campaign_nm(), 'not_campaign_sq' => $campaign_vo_new->get_campaign_sq());
		if(count($this->campaign_model->select_campaign_list($params)) > 0) {
			$this->ajax_json_response(false, '동일한 캠페인명이 존재합니다.');
		}
		
		// DB 트랜잭션 시작
		$this->campaign_model->trans_start();
		
		$this->campaign_model->update_campaign($campaign_vo_new);
		
		// 히스토리 등록
		$history_array = array ();
		$history_array['campaign_sq'] = $campaign_sq;
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$modify_list = $this->_get_diff_campaign_history($campaign_vo_old, $campaign_vo_new);
		foreach ( $modify_list as $row ) {
			$temp_array = array_merge($history_array, $row);
			$this->campaign_model->insert_history($temp_array);
		}
		
		if ($this->campaign_model->trans_status() === FALSE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 수정에 실패하였습니다.');
		}
		
		// isf 연동
		$isf_response = $this->isf->campaign('PUT', $campaign_sq);
		if ($isf_response !== TRUE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 캠페인 수정에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->campaign_model->trans_complete();
		
		$this->ajax_json_response(true, '/campaign/campaign/detail?campaign_sq=' . $campaign_sq);
	}

	function index_delete() {
		$campaign_sq = $this->delete('campaign_sq') ? $this->delete('campaign_sq') : '';
		if ($campaign_sq == '') {
			$this->ajax_json_response(false, '캠페인을 선택하세요.');
		}
		
		$params = array (
				'campaign_sq' => $campaign_sq 
		);
		
		// 등록된 광고 검사
		$advert_list = $this->advert_model->select_advert_list($params);
		
		if (count($advert_list) > 0) {
			$this->ajax_json_response(false, '등록된 광고가 있습니다.');
		}
		
		$campaign_vo = new Campaign_vo();
		$campaign_vo->set_campaign_sq($campaign_sq);
		$campaign_vo->set_campaign_status_cd($this->lang->line('campaign_status_delete'));
		$campaign_vo->set_update_account_sq($this->session->userdata('ACCOUNT_SQ'));
		
		// DB 트랜잭션 시작
		$this->campaign_model->trans_start();
		
		// 캠페인 삭제
		$this->campaign_model->update_campaign($campaign_vo);
		
		// 히스토리 등록
		$history_array = array ();
		$history_array['campaign_sq'] = $campaign_sq;
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$history_array['history_gb'] = '삭제';
		$this->campaign_model->insert_history($history_array);
		
		if ($this->campaign_model->trans_status() === FALSE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 삭제에 실패하였습니다.');
		}
		
		// isf 연동
		$isf_response = $this->isf->campaign('DELETE', $campaign_sq);
		if ($isf_response !== TRUE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 캠페인 삭제에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->campaign_model->trans_complete();
		
		$this->ajax_json_response(true, '삭제하였습니다.');
	}

	function detail_get() {
		$campaign_sq = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
		
		if ($campaign_sq == '') {
			redirect('/campaign/campaign');
			return;
		}
		
		$vars = array ();
		
		$params = array ();
		
		$params['campaign_sq'] = $campaign_sq;
		$vars['campaign_vo'] = $this->campaign_model->select_campaign($params);

		// freezing 시간 계산
		$freezing = $this->common_model->select_freezing();
		$freezing_time = strtotime(date('Y-m-d H:i:s')) + (60 * $freezing['apply_time']);
		$freezing_time = date('Y-m-d H:i:s', $freezing_time);
		
		$params['freezing_time'] = $freezing_time;
		$vars['list'] = $this->advert_model->select_advert_list($params);
		
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/campaign/campaign_detail.js';
		$this->load->view('campaign/campaign/campaign_detail_view', $vars);
	}

	function history_get() {
		$vars = array ();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page'); // 페이지당 출력 게시글수
		
		$vars['campaign_sq'] = $querystring['campaign_sq'] = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
		$querystring['list_type'] = $this->get('list_type') ? $this->get('list_type') : '';
		
		// 항목 선택 selectbox
		$list_type_list = array (
				'campaign' => '캠페인',
				'advert' => '광고' 
		);
		$vars['list_type_selectbox'] = $this->ui_component->create_selectbox('list_type', $list_type_list, $querystring['list_type'], '전체', 'javascript:changeListType();');
		
		// 리스트 조회
		$params = array (
				'campaign_sq' => $querystring['campaign_sq'],
				'list_type' => $querystring['list_type'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page 
		);
		
		$vars['list'] = $this->campaign_model->select_history_list($params);
		$vars['total_rows'] = $this->campaign_model->count_history_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/campaign/campaign/history';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $querystring;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		
		$this->yield = true;
		$this->layout = 'popup';
		$this->yield_js = '/web/js/campaign/campaign/popup/history_popup.js';
		$this->load->view('campaign/campaign/popup/history_popup', $vars);
	}

	function history_put() {
		$campaign_history_sq = $this->put('campaign_history_sq') ? $this->put('campaign_history_sq') : '';
		$history_comment = $this->put('history_comment') ? $this->put('history_comment') : '';
		
		if ($campaign_history_sq == '') {
			$this->ajax_json_response(false, 'campaign_history_sq가 없습니다.');
		}
		
		$history_vo = new History_vo();
		$history_vo->set_campaign_history_sq($campaign_history_sq);
		$history_vo->set_history_comment($history_comment);
		
		// DB 트랜잭션 시작
		$this->campaign_model->trans_start();
		
		$this->campaign_model->update_history($history_vo);
		
		if ($this->campaign_model->trans_status() === FALSE) {
			$this->campaign_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 수정에 실패하였습니다.');
		}
		
		// DB 트랜잭션 종료
		$this->campaign_model->trans_complete();
		
		$this->ajax_json_response(true, '저장 하였습니다.');
	}

	function edit_get() {
		$campaign_sq = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
		
		if ($campaign_sq == '') {
			redirect('/campaign/campaign');
			return;
		}
		
		$vars = array ();
		
		$params = array (
				'campaign_sq' => $campaign_sq 
		);
		
		$vars['campaign_vo'] = $this->campaign_model->select_campaign($params);
		
		$params = array (
				'adv_company_sq' => $vars['campaign_vo']->get_adv_company_sq() 
		);
		
		$adv_brand_list = $this->common_model->select_adv_brand_list($params);
		
		$option_array = array ();
		foreach ( $adv_brand_list as $row ) {
			$option_array[$row['adv_account_sq']] = $row['adv_brand_nm'];
		}
		
		$vars['adv_brand_selectbox'] = $this->ui_component->create_selectbox('adv_account_sq', $option_array, $vars['campaign_vo']->get_adv_account_sq(), '선택해주세요', 'javascript:changeBrand(this.id);', 'style="width:100px;"');
		
		$this->yield = true;
		$this->yield_js = '/web/js/campaign/campaign/campaign_edit.js';
		$this->load->view('campaign/campaign/campaign_edit_view', $vars);
	}

	function company_get() {
		$adv_company_nm = $this->get('adv_company_nm');
		$maxRows = $this->get('maxRows');
		$params = array (
				'adv_company_nm' => $adv_company_nm,
				'maxRows' => $maxRows,
		);
		$adv_company_list = $this->common_model->select_adv_company_list($params);
		
		echo sprintf('%s({ "items": %s })', $this->input->get('callback'), json_encode($adv_company_list));
	}

	function brand_get() {
		$adv_company_sq = $this->get('adv_company_sq');
		$params = array (
				'adv_company_sq' => $adv_company_sq 
		);
		$adv_brand_list = $this->common_model->select_adv_brand_list($params);
		
		$this->ajax_json_response(true, $adv_brand_list);
	}

	function _get_campaign_vo($param_array) {
		$campaign_vo = new Campaign_vo();
		
		$campaign_vo->set_campaign_sq(isset($param_array['campaign_sq']) ? $param_array['campaign_sq'] : '');
		$campaign_vo->set_campaign_nm(isset($param_array['campaign_nm']) ? $param_array['campaign_nm'] : '');
		$campaign_vo->set_campaign_status_cd(isset($param_array['campaign_status_cd']) ? $param_array['campaign_status_cd'] : '');
		$campaign_vo->set_adv_company_sq(isset($param_array['adv_company_sq']) ? $param_array['adv_company_sq'] : '');
		$campaign_vo->set_adv_account_sq(isset($param_array['adv_account_sq']) ? $param_array['adv_account_sq'] : '');
		$campaign_vo->set_campaign_desc(isset($param_array['campaign_desc']) ? $param_array['campaign_desc'] : '');
		$campaign_vo->set_report_id(isset($param_array['report_id']) ? $param_array['report_id'] : '');
		$campaign_vo->set_report_password(isset($param_array['report_password']) && !empty($param_array['report_password']) ? hash("sha256", $param_array['report_password']) : '');
		$campaign_vo->set_create_account_sq(isset($param_array['create_account_sq']) ? $param_array['create_account_sq'] : '');
		$campaign_vo->set_update_account_sq(isset($param_array['update_account_sq']) ? $param_array['update_account_sq'] : '');
		
		$campaign_vo->set_adv_company_nm(isset($param_array['adv_company_nm']) ? $param_array['adv_company_nm'] : '');
		$campaign_vo->set_adv_brand_nm(isset($param_array['adv_brand_nm']) ? $param_array['adv_brand_nm'] : '');
		
		return $campaign_vo;
	}

	function _get_diff_campaign_history($campaign_vo_old, $campaign_vo_new) {
		$result = array ();
		if ($campaign_vo_old->get_campaign_nm() != $campaign_vo_new->get_campaign_nm()) {
			$result[] = array (
					'history_gb' => '캠페인명',
					'modify_before' => $campaign_vo_old->get_campaign_nm(),
					'modify_after' => $campaign_vo_new->get_campaign_nm() 
			);
		}
		if ($campaign_vo_old->get_adv_company_sq() != $campaign_vo_new->get_adv_company_sq()) {
			$result[] = array (
					'history_gb' => '광고주',
					'modify_before' => $campaign_vo_old->get_adv_company_nm(),
					'modify_after' => $campaign_vo_new->get_adv_company_nm() 
			);
		}
		if ($campaign_vo_old->get_adv_account_sq() != $campaign_vo_new->get_adv_account_sq()) {
			$result[] = array (
					'history_gb' => '브랜드',
					'modify_before' => $campaign_vo_old->get_adv_brand_nm(),
					'modify_after' => $campaign_vo_new->get_adv_brand_nm() 
			);
		}
		if ($campaign_vo_old->get_campaign_desc() != $campaign_vo_new->get_campaign_desc()) {
			$result[] = array (
					'history_gb' => '캠페인설명',
					'modify_before' => $campaign_vo_old->get_campaign_desc(),
					'modify_after' => $campaign_vo_new->get_campaign_desc() 
			);
		}
		if ($campaign_vo_new->get_report_password() != '' && $campaign_vo_old->get_report_password() != $campaign_vo_new->get_report_password()) {
			$result[] = array (
					'history_gb' => '리포트비밀번호',
					'modify_before' => '',
					'modify_after' => '' 
			);
		}
		return $result;
	}

}

/* End of file campaign.php */
/* Location: ./application/admin/controllers/campaign/campaign.php */
