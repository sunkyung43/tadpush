<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class MY_Controller extends REST_Controller {
	/**
	 *
	 * @var Common_model
	 */
	public $common_model;
	
	/**
	 *
	 * @var CI_Session
	 */
	public $session;
	
	/**
	 *
	 * @var CI_Input
	 */
	public $input;
	
	/**
	 *
	 * @var CI_Loader
	 */
	public $load;
	
	/**
	 *
	 * @var Paging
	 */
	public $paging;
	
	/**
	 *
	 * @var CI_Form_validation
	 */
	public $form_validation;
	
	/**
	 *
	 * @var CI_Lang
	 */
	public $lang;
	
	/**
	 *
	 * @var CI_Config
	 */
	public $config;
	
	/**
	 *
	 * @var Ui_component
	 */
	public $ui_component;
	
	/**
	 *
	 * @var Utility
	 */
	public $utility;
	
	/**
	 *
	 * @var Isf
	 */
	public $isf;

	function __construct() {
		parent::__construct();
		
// 		header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
// 		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// 		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// 		header("Cache-Control: post-check=0, pre-check=0", false);
// 		header("Pragma: no-cache");
		
		if (!($this instanceof Main) 
		&& !($this instanceof Provision) 
		&& !($this instanceof Push) 
		&& !($this instanceof Test) 
		&& !($this instanceof Meta) 
		&& !($this instanceof Target)) {
			$this->logged_in = $this->session->userdata('LOGGED_IN');
			if (!$this->logged_in) {
				redirect('/');
				return;
			}
		}
		
		$method = strtolower($this->input->server('REQUEST_METHOD'));
		
		if ($method == 'get') {
			$_GET = $this->_trim_data($_GET);
			$this->_get_args = $this->_trim_data($this->_get_args);
		} else if ($method == 'post') {
			$_POST = $this->_trim_data($_POST);
			$this->_post_args = $this->_trim_data($this->_post_args);
		} else if ($method == 'put') {
			$this->_put_args = $this->_trim_data($this->_put_args);
		}
	}

	private function _trim_data($array) {
		foreach ( $array as &$val ) {
			if (is_array($val)) {
				$val = $this->_trim_data($val);
			} else {
				$val = trim($val);
			}
		}
		unset($val);
		
		return $array;
	}

	protected function load_vo($path) {
		require_once APPPATH . 'vo/' . $path . '.php';
	}

	public function _remap($object_called, $arguments) {
		try {
			parent::_remap($object_called, $arguments);
		} catch ( Exception $e ) {
			show_error($e);
		}
	}
	
	// 디바이스 엑셀 템플릿 업로드
	function deviceTemplete_post() {
		$param_array = $this->input->post();
		$file_id = $param_array['file_id'] ? $param_array['file_id'] : '';
		
		if ($file_id == '') {
			echo json_encode(array (
					'response_type' => 'fail',
					'response_data' => '파일 업로드 오류(file id empty)' 
			));
			return;
		} else if (!isset($_FILES[$file_id]) || $_FILES[$file_id]['size'] <= 0) {
			echo json_encode(array (
					'response_type' => 'fail',
					'response_data' => '선택된 파일이 없습니다.' 
			));
			return;
		}
		
		$device_model_list = $this->_get_excel_list($file_id);
		
		if ($device_model_list == '' || !$this->is_validate_device_model(explode(',', $device_model_list))) {
			echo json_encode(array (
					'response_type' => 'false',
					'response_data' => '단말 조회 실패' 
			));
			return;
		}
		
		// 응답
		echo json_encode(array (
				'response_type' => 'success',
				'response_data' => $device_model_list 
		));
		return;
	}
	
	// 미디어 엑셀 템플릿 업로드
	function mediaTemplete_post() {
		$param_array = $this->input->post();
		$file_id = $param_array['file_id'] ? $param_array['file_id'] : '';
		
		if ($file_id == '') {
			echo json_encode(array (
					'response_type' => 'fail',
					'response_data' => '파일 업로드 오류(file id empty)' 
			));
			return;
		} else if (!isset($_FILES[$file_id]) || $_FILES[$file_id]['size'] <= 0) {
			echo json_encode(array (
					'response_type' => 'fail',
					'response_data' => '선택된 파일이 없습니다.' 
			));
			return;
		}
		
		$media_list = $this->_get_excel_list($file_id);
		
		if ($media_list == '' || !$this->is_validate_media(explode(',', $media_list))) {
			echo json_encode(array (
					'response_type' => 'false',
					'response_data' => '미디어 조회 실패' 
			));
			return;
		}
		
		$params = array (
				'media_nm_list' => explode(',', $media_list) 
		);
		$media_list = $this->media_model->select_search_media($params);
		
		$media_list_html = $this->ui_component->create_media_list($media_list);
		
		echo json_encode(array (
				'response_type' => 'success',
				'media_count' => count($media_list),
				'media_html' => $media_list_html 
		));
		
		return;
	}
	
	// Device 엑셀 템플릿 다운로드
	function deviceTemplete_get() {
		$this->load->helper('download');
		
		$file_path = $this->config->item('device_template_path') != '' ? $this->config->item('device_template_path') : $_SERVER['DOCUMENT_ROOT'] . '/web/template/device_template.xls';
		$data = file_get_contents($file_path); // Read the file's contents
		$name = 'device_template.xls';
		force_download($name, $data);
	}
	
	// Media 엑셀 템플릿 다운로드
	function mediaTemplete_get() {
		$this->load->helper('download');
		
		$file_path = $this->config->item('media_template_path') != '' ? $this->config->item('media_template_path') : $_SERVER['DOCUMENT_ROOT'] . '/web/template/media_template.xls';
		$data = file_get_contents($file_path); // Read the file's contents
		$name = 'media_template.xls';
		force_download($name, $data);
	}

	protected function _get_excel_list($input_file_name) {
		$result = '';
		$result_list = array ();
		if (isset($_FILES[$input_file_name]) && $_FILES[$input_file_name]['size'] > 0) {
			// 파일 업로드
			$template_path = $this->config->item('excel_template_upload_path') != '' ? $this->config->item('excel_template_upload_path') : $_SERVER['DOCUMENT_ROOT'] . '/web/temp';
			
			$config = array (
					'upload_path' => $template_path,
					'allowed_types' => $this->config->item('excel_template_allowed_types') 
			);
			
			$upload_result = $this->utility->fileUpload($input_file_name, $config); // 업로드
			if ($upload_result['msg'] != 'success') {
				log_message('error', 'excel template upload result : ' . $upload_result['msg']);
				return $result;
			}
			$template_path = $template_path . '/' . $upload_result['file_name'];
			log_message('info', 'excel template upload file path : ' . $template_path);
			
			$this->load->library('excel');
			
			$result_list = $this->excel->get_excel_template_list($template_path);
			
			$result_list = array_unique($result_list);
			
			unlink($template_path);
		}
		
		$result = implode(',', $result_list);
		
		return $result;
	}

	function is_validate_device_model($device_model_list) {
		$select_result = $this->common_model->select_device_model_list($device_model_list);
		foreach ( $device_model_list as $model_nm ) {
			if (!isset($select_result[$model_nm])) {
				return false;
			}
		}
		return true;
	}

	function is_validate_media($media_list) {
		$select_result = $this->media_model->select_media_name_list($media_list);
		foreach ( $media_list as $media_nm ) {
			if (!isset($select_result[$media_nm])) {
				return false;
			}
		}
		return true;
	}

	protected function get_calendar_min_day($apply_time) {
		$calendar_min_day = 0;
		$current_dt = explode('-', date('Y-m-d-H-i'));
		
		$current_time = mktime(0, 0, 0, $current_dt[1], $current_dt[2], $current_dt[0]);
		
		$booking_start_dt = explode('-', date('Y-m-d', mktime($current_dt[3] + 1, $current_dt[4] + $apply_time, 0, $current_dt[1], $current_dt[2], $current_dt[0])));
		$booking_start_time = mktime(0, 0, 0, $booking_start_dt[1], $booking_start_dt[2], $booking_start_dt[0]);
		
		$calendar_min_day = date('z', $booking_start_time - $current_time);
		
		return $calendar_min_day;
	}

	protected function get_calendar_max_day() {
		$current_cycle_end_dt = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + (7 - date('N')), date('Y')));
		$calendar_max_day = 0;
		
		$current_dt = explode('-', date('Y-m-d'));
		$current_time = mktime(0, 0, 0, $current_dt[1], $current_dt[2], $current_dt[0]);
		
		$current_cycle_end_dt = explode('-', $current_cycle_end_dt);
		$end_time = mktime(0, 0, 0, $current_cycle_end_dt[1], $current_cycle_end_dt[2] + (7 * $this->config->item('inventory_max_week')), $current_cycle_end_dt[0]);
		
		$calendar_max_day = date('z', $end_time - $current_time);
		
		return $calendar_max_day;
	}

	protected function get_calendar_min_time($apply_time, $start_dt) {
		$calendar_min_time = 0;
		
		$current_dt = explode('-', date('Y-m-d-H-i'));
		$booking_start_time = mktime($current_dt[3] + 1, $current_dt[4] + $apply_time, 0, $current_dt[1], $current_dt[2], $current_dt[0]);
		$booking_start_dt = date('Y-m-d', $booking_start_time);
		
		if ($start_dt == $booking_start_dt) {
			$calendar_min_time = date('G', $booking_start_time);
		} else if ($start_dt < $booking_start_dt) {
			$calendar_min_time = 24;
		}
		
		return $calendar_min_time;
	}

	protected function is_valid_url($url) {
		return strpos($url, "http://") === 0 || strpos($url, "https://") === 0 || strpos($url, "market://") === 0;
	}

	function generate_carrier(&$list) {
		foreach ( $list as $key => &$row ) {
			if (strtoupper($row['NAME']) == 'ETC') {
				$row['VALUE2'] = 'ETC';
			}
		}
		unset($row);
	}

	function is_freezing($start_dt, $apply_time) {
		$temp = explode(' ', $start_dt);
		$date = explode('-', $temp[0]);
		$time = explode(':', $temp[1]);
		$start_time = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		
		$freezing_time = time() + ($apply_time * 60);
		
		return $start_time <= $freezing_time;
	}

	function ajax_json_response($result, $response_data) {
		if ($result === TRUE) {
			$response_type = 'success';
		} else {
			$response_type = 'false';
		}
		
		echo json_encode(array (
				'response_type' => $response_type,
				'response_data' => $response_data 
		));
		
		exit();
	}

}
// END Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */