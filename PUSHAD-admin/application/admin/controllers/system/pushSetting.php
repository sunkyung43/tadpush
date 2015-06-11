<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PushSetting extends MY_Controller {
	
	/**
	 *
	 * @var Push_setting_model
	 */
	public $push_setting_model;
	
	/**
	 *
	 * @var Advert_model
	 */
	public $advert_model;

	public function __construct() {
		parent::__construct();
		
		$this->load->model('/system/push_setting_model');
		$this->load->model('/campaign/advert_model');
		
		$this->load_vo('system/frequency_vo');
		$this->load_vo('campaign/advert_vo');
	}

	function index_get() {
		redirect('/system/pushSetting/frequency');
	}

	function frequency_get() {
		$vars = array ();
		
// 		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
// 		$num_links = $this->config->item('list_num_links'); // 페이지 수
// 		$per_page = $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page'); // 페이지당 출력 게시글수
		                                                                                                    
		// 리스트 조회
		$params = array();
// 		$params = array (
// 				'cur_page' => ($cur_page - 1) * $per_page,
// 				'per_page' => $per_page 
// 		);
		$vars['list'] = $this->push_setting_model->select_frequency_list($params);
// 		$vars['total_rows'] = $this->push_setting_model->count_frequency_list($params);
		
		$current_date = date('Y-m-d');
		$list_cnt = count($vars['list']);
		$flag = FALSE;
		for($i = 0; $i < $list_cnt; $i++) {
			$start_end_dt = '';
			if($i > 0) {
				$dt_array = explode('-', $vars['list'][$i - 1]->get_start_dt());
				$last_dt = date('Y-m-d', mktime(0, 0, 0, $dt_array[1], $dt_array[2] - 1, $dt_array[0]));
				$start_end_dt = sprintf('%s ~ %s', $vars['list'][$i]->get_start_dt(), $last_dt);
			}
			if ($vars['list'][$i]->get_start_dt() <= $current_date) {
				if ($flag === FALSE) {
					$flag = true;
					$vars['list'][$i]->set_frequency_status_nm('진행');
					if($i == 0) {
						$start_end_dt = sprintf('%s ~ %s', $vars['list'][$i]->get_start_dt(), '현재');
					}
				} else {
					$vars['list'][$i]->set_frequency_status_nm('종료');
					if($i == 0) {
						$start_end_dt = sprintf('%s ~ %s', $vars['list'][$i]->get_start_dt(), '');
					}
				}
			} else {
				$vars['list'][$i]->set_frequency_status_nm('대기');
				if($i == 0) {
					$start_end_dt = sprintf('%s ~ %s', $vars['list'][$i]->get_start_dt(), '');
				}
			}
			$vars['list'][$i]->set_start_end_dt($start_end_dt);
		}
		
		// 페이징 처리
// 		$config['base_url'] = '/system/pushSetting/frequency';
// 		$config['total_rows'] = $vars['total_rows'];
// 		$config['cur_page'] = $cur_page;
// 		$config['per_page'] = $per_page;
// 		$config['num_links'] = $num_links;
		
// 		$this->paging->init($config);
// 		$vars['paging'] = $this->paging->create_page();
		
		$this->yield = true;
		$this->yield_js = '/web/js/system/pushSetting/frequency_list.js';
		$this->load->view('system/pushSetting/frequency_list_view', $vars);
	}

	function write_get() {
		$vars = array ();
		
		$vars['frequency'] = $this->common_model->select_frequency();
		
		$ad_last_dt = $this->advert_model->select_advert_last_dt();
		$frequency_last_dt = $this->common_model->select_frequency_last_dt();
		$current_dt = date('Y-m-d');
		
		$last_dt = $frequency_last_dt > $ad_last_dt ? $frequency_last_dt : $ad_last_dt;
		$last_dt = $current_dt > $last_dt ? $current_dt : $last_dt;
		
		if ($last_dt == null) {
			$vars['calendar_min_day'] = 8 - date('N');
		} else {
			$dt_array = explode('-', $last_dt);
			$ad_last_time = mktime(0, 0, 0, $dt_array[1], $dt_array[2], $dt_array[0]);
			$current_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			$day = date('z', $ad_last_time - $current_time);
			$day_index = date('N', $ad_last_time - $current_time);
			$vars['calendar_min_day'] = $day + 8 - $day_index;
		}
		
		$this->yield = true;
		$this->yield_js = '/web/js/system/pushSetting/frequency_write.js';
		$this->load->view('system/pushSetting/frequency_write_view', $vars);
	}

	function index_post() {
		$params['cycle'] = $this->post('cycle') ? $this->post('cycle') : ''; 
		$params['frequency_cnt'] = $this->post('frequency_cnt') ? $this->post('frequency_cnt') : ''; 
		$params['start_dt'] = $this->post('start_dt') ? $this->post('start_dt') : ''; 
		$params['create_account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		
		if($params['cycle'] == '' || $params['frequency_cnt'] == '' || $params['start_dt'] == '') {
			$this->ajax_json_response(false, '입력값을 확인하세요.');
		}
		
		// 가장 마지막 광고 일자 확인
		$ad_last_dt = $this->advert_model->select_advert_last_dt();
		if($ad_last_dt >= $params['start_dt']) {
			$this->ajax_json_response(false, '적용일자를 확인하세요.');
		}
		
		// START_DT 중복 확인
		$frequency = $this->push_setting_model->select_frequency(array('start_dt' => $params['start_dt']));
		if($frequency != null) {
			$this->ajax_json_response(false, '해당 일자에 Frequency가 있습니다.');
		}
		
		// DB 트랜잭션 시작
		$this->push_setting_model->trans_start();
		
		$frequency_sq = $this->push_setting_model->insert_frequency($params);
		
		if ($this->push_setting_model->trans_status() === FALSE) {
			$this->push_setting_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}
		
		// isf 연동
		$isf_response = $this->isf->frequency('POST', $frequency_sq);
		if ($isf_response !== TRUE) {
			$this->push_setting_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF Frequency 등록에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->push_setting_model->trans_complete();
		
		$this->ajax_json_response(true, '/system/pushSetting');
	}

	function freezing_get() {
		$vars = array ();
		
		$vars['freezing'] = $this->common_model->select_freezing();
		
		$this->yield = true;
		$this->load->view('system/pushSetting/freezing_list_view', $vars);
	}
	
}

/* End of file pushSetting.php */
/* Location: ./application/admin/controllers/system/pushSetting.php */
