<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Isf {
	/**
	 *
	 * @var MY_Controller
	 */
	public $CI;
	
	/**
	 *
	 * @var Isf_model
	 */
	public $isf_model;
	
	/**
	 *
	 * @var Json
	 */
	public $json;
	
	public $isf_url;
	public $version;
	
	public $connect_timeout;
	public $execute_timeout;
	
	public $res_succ_cd;
	public $res_svc_err_cd;
	
	public $disable_isf;
	public $disable_support_jb;

	function __construct() {
		$this->CI = &get_instance();
		
		$this->CI->load->model('/isf/isf_model');
		$this->isf_model = $this->CI->isf_model;

		$this->CI->load->library('json');
		$this->json = $this->CI->json;
		
		$this->isf_url = $this->CI->config->item('isf_url');
		$this->version = $this->CI->config->item('isf_api_version');
		
		$this->connect_timeout = $this->CI->config->item('curl_connect_timeout');
		$this->execute_timeout = $this->CI->config->item('curl_execute_timeout');
		
		$this->res_succ_cd = $this->CI->lang->line('isf_succ_cd');
		$this->res_svc_err_cd = $this->CI->lang->line('isf_svc_err_cd');
		
		$this->disable_isf = $this->CI->config->item('disable_isf');
		$this->disable_support_jb = $this->CI->config->item('disable_support_jb');
	}

	function param($method, $device_id) {
		$url = '/meta/param';
		$method = strtoupper($method);
		
		switch ($method) {
			case "GET" :
			case "DELETE" :
				$param_array = array (
						'DEVICE_ID' => $device_id 
				);
				break;
			case "POST" :
			case "PUT" :
				$param_array = $this->isf_model->select_param($device_id);
				break;
		}
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else if ($method == 'GET') {
			return $response;
		} else {
			return TRUE;
		}
	}

	function param_media($method, $device_id, $media_id) {
		$url = '/meta/param_media';
		$method = strtoupper($method);
		
		switch ($method) {
			case "GET" :
			case "DELETE" :
				$param_array = array (
						'device_id' => $device_id,
						'media_id' => $media_id 
				);
				break;
			case "POST" :
			case "PUT" :
				$param_array = $this->isf_model->select_param_media(array (
						'device_id' => $device_id,
						'media_id' => $media_id 
				));
				break;
		}
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else if ($method == 'GET') {
			return $response;
		} else {
			return TRUE;
		}
	}

	function media($method, $media_id) {
		$url = '/meta/media';
		$method = strtoupper($method);
		
		switch ($method) {
			case "GET" :
			case "DELETE" :
				$param_array = array (
						'MEDIA_ID' => $media_id 
				);
				break;
			case "POST" :
			case "PUT" :
				$param_array = $this->isf_model->select_media($media_id);
				break;
		}
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else if ($method == 'GET') {
			return $response;
		} else {
			return TRUE;
		}
	}

	function frequency($method, $frequency_sq) {
		$url = '/meta/frequency';
		$method = strtoupper($method);
		
		switch ($method) {
			case "GET" :
			case "DELETE" :
				$param_array = array (
						'FREQUENCY_SQ' => $frequency_sq 
				);
				break;
			case "POST" :
			case "PUT" :
				$param_array = $this->isf_model->select_frequency($frequency_sq);
				break;
		}
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else if ($method == 'GET') {
			return $response;
		} else {
			return TRUE;
		}
	}

	function ad($method, $ad_sq) {
		$url = '/meta/ad';
		$method = strtoupper($method);
		
		switch ($method) {
			case "GET" :
			case "DELETE" :
				$param_array = array (
						'AD_SQ' => $ad_sq 
				);
				break;
			case "POST" :
			case "PUT" :
				$param_array = $this->isf_model->select_advert($ad_sq);
				break;
		}
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else if ($method == 'GET') {
			return $response;
		} else {
			return TRUE;
		}
	}

	function campaign($method, $campaign_sq) {
		$url = '/meta/campaign';
		$method = strtoupper($method);
		
		switch ($method) {
			case "GET" :
			case "DELETE" :
				$param_array = array (
						'CAMPAIGN_SQ' => $campaign_sq 
				);
				break;
			case "POST" :
			case "PUT" :
				$param_array = $this->isf_model->select_campaign($campaign_sq);
				break;
		}
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else if ($method == 'GET') {
			return $response;
		} else {
			return TRUE;
		}
	}

	function count($param) {
		if ($this->disable_isf === TRUE) {
			return array (
					'TRS_NO' => '201310291516002965701646633',
					'RES_CD' => 'S100',
					'SVC_ERR_CD' => '',
					'COUNT' => '500000',
					'GENDER_AGE_COUNT' => array (
							array (
									'GENDER_CD' => 'M',
									'AGE_RNG_CD' => '1419',
									'GA_USER_COUNT' => '20000' 
							),
							array (
									'GENDER_CD' => 'M',
									'AGE_RNG_CD' => '0013',
									'GA_USER_COUNT' => '10000' 
							),
							array (
									'GENDER_CD' => 'F',
									'AGE_RNG_CD' => '0013',
									'GA_USER_COUNT' => '30000' 
							),
							array (
									'GENDER_CD' => 'F',
									'AGE_RNG_CD' => '1419',
									'GA_USER_COUNT' => '40000' 
							),
							array (
									'GENDER_CD' => '#',
									'AGE_RNG_CD' => '0013',
									'GA_USER_COUNT' => '40000' 
							),
							array (
									'GENDER_CD' => 'M',
									'AGE_RNG_CD' => '####',
									'GA_USER_COUNT' => '40000' 
							) 
					),
					'ADDR_COUNT' => array (
							array (
									'ADDR_DO_CD' => '26',
									'ADDR_USER_COUNT' => '20000' 
							),
							array (
									'ADDR_DO_CD' => '11',
									'ADDR_USER_COUNT' => '10000' 
							),
							array (
									'ADDR_DO_CD' => '27',
									'ADDR_USER_COUNT' => '30000' 
							) 
					) 
			);
		}
		
		$url = '/target/param/count';
		$method = "GET";
		
		if (!is_array($param)) {
			$advert_array = $this->isf_model->select_advert($param);
			$target_array = $this->isf_model->select_target($param);
			
			$param = $this->_generate_count_data($advert_array, $target_array);
		}
		
		$response = $this->isf_request($url, $method, $param);
		
		return $response;
	}

	function reserve($ad_sq) {
		$url = '/target/param/reserve';
		$method = "GET";
		
		$advert_array = $this->isf_model->select_advert($ad_sq);
		$target_array = $this->isf_model->select_target($ad_sq);
		
		$param_array = $this->_generate_reserve_data($advert_array, $target_array);
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else {
			return TRUE;
		}
	}

	function down($ad_sq) {
		$url = '/target/param/down';
		$method = "GET";
		
		$param_array = array (
				'AD_SQ' => $ad_sq 
		);
		
		$response = $this->isf_request($url, $method, $param_array);
		
		return $response;
	}

	function cancel($ad_sq) {
		$url = '/target/ad/cancel';
		$method = "GET";
		
		$param_array = array (
				'AD_SQ' => $ad_sq 
		);
		
		$response = $this->isf_request($url, $method, $param_array);
		
		if (!$this->is_success($response)) {
			return $response;
		} else {
			return TRUE;
		}
	}

	function status($ad_sq) {
		$url = '/target/ad/status';
		$method = "GET";
		
		$param_array = array (
				'AD_SQ' => $ad_sq 
		);
		
		$response = $this->isf_request($url, $method, $param_array);
		
		return $response;
	}

	function report($ad_sq) {
		$url = '/report/ad';
		$method = 'GET';
		
		$param_array = array (
				'AD_SQ' => $ad_sq 
		);
		
		$response = $this->isf_request($url, $method, $param_array);
		
		return $response;
	}

	private function _generate_count_data($advert_array, $target_array) {
		$result = array ();
		
		$result['START_DT'] = substr($advert_array['start_dt'], 0, 10);
		
		$result['OS_CD'] = $this->CI->lang->line('os_android');
		
		foreach ( $target_array as $row ) {
			if ($row['target_element_cd'] == $this->CI->lang->line('target_type_media')) {
				$row['target_value'] = implode(',', array_unique(explode(',', $row['target_value'])));
			}
			$result[$row['target_element_cd']] = $row['target_value'];
		}
		
		return $result;
	}

	private function _generate_reserve_data($advert_array, $target_array) {
		$result = array ();
		
		$result['AD_SQ'] = $advert_array['ad_sq'];
// 		$result['START_DT'] = $advert_array['start_dt'];
// 		$result['PUSH_BOOKING_CNT'] = $advert_array['push_booking_cnt'];
		
		$result['OS_CD'] = $this->CI->lang->line('os_android');
		
		foreach ( $target_array as $row ) {
			if ($row['target_element_cd'] == $this->CI->lang->line('target_type_media')) {
				$row['target_value'] = implode(',', array_unique(explode(',', $row['target_value'])));
			}
			$result[$row['target_element_cd']] = $row['target_value'];
		}
		
		if($this->disable_support_jb === TRUE) {
			if(isset($result[$this->CI->lang->line('target_type_jb')])) {
				unset($result[$this->CI->lang->line('target_type_jb')]);
			}
		}
		
		return $result;
	}

	function isf_request($request_url, $method, $param_array = array(), $body = '') {
		if (empty($param_array)) {
			return array (
					'err_msg' => sprintf('(%s:%s)', 'POC_ERR', 'ISF 요청 파라미터가 없습니다.')
			);
		}
		
		$header = array (
				'Content-type: application/json; charset=utf-8',
				'Accept-Language: en',
				'x-skpop-appId: PUSHAD' 
		);
		
		$json = '';
		if (!empty($param_array)) {
			$encoded_param_array = array ();
			foreach ( $param_array as $key => $val ) {
				$encoded_param_array[strtoupper($key)] = urlencode($val);
			}
			
			$json = $this->json->json_encode($encoded_param_array);
		}
		
		$trs_no = date('YmdHis') . random_string('numeric', '13');
		
		$querystring = sprintf('?version=%s&trs_no=%s&params=%s', $this->version, $trs_no, $json);
		
		$request_url = sprintf('%s%s', $this->isf_url, $request_url);
		
		$url = sprintf('%s%s', $request_url, $querystring);
		
		log_message('INFO', sprintf("[ISF][REQ][TRS_NO=%s][METHOD=%s][URL=%s][JSON=\n%s\n]", $trs_no, $method, $request_url, prettyPrint($this->json->json_encode($param_array))));
		
		if ($this->disable_isf === TRUE) {
			log_message('INFO', sprintf('[ISF][RES][DUMMY_RESPONSE]'));
			return array (
					'TRS_NO' => '201310291516002965701646633',
					'RES_CD' => 'S100' 
			);
		}
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		if ($body != '') {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->execute_timeout);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		$error_no = curl_errno($ch);
		$error_msg = curl_error($ch);
		
		curl_close($ch);
		
		if ($response === FALSE) {
			log_message('ERROR', sprintf('[ISF][RES][FAIL][ERR_NO=%s][ERR_MSG=%s][METHOD=%s][URL=%s]', $error_no, $error_msg, $method, $request_url));
			return array (
					'err_msg' => sprintf('(%s:%s)', 'REQ_ERR', $error_msg) 
			);
		}
		
		if ($http_code != 200 && $http_code != 201) {
			log_message('ERROR', sprintf('[ISF][RES][FAIL][HTTP_CODE=%s][METHOD=%s][URL=%s][RESPONSE=%s]', $http_code, $method, $request_url, $response));
			return array (
					'err_msg' => sprintf('(%s:%s)', 'HTTP_CODE', $http_code) 
			);
		}
		
		// 타게팅 파일다운로드 예외처리
		$target_down_url = sprintf('%s%s', $this->isf_url, '/target/param/down');
		if($request_url == $target_down_url) {
			log_message('INFO', sprintf("[ISF][RES][SUCC][HTTP_CODE=%s][METHOD=%s][URL=%s][RESPONSE=\n%s\n]", $http_code, $method, $request_url, $response));
			return $response;
		}
		
		$json = $this->json->json_decode($response);
		
		if (!$this->is_success($json)) {
			log_message('ERROR', sprintf("[ISF][RES][FAIL][HTTP_CODE=%s][METHOD=%s][URL=%s][RESPONSE=\n%s\n]", $http_code, $method, $request_url, prettyPrint($response)));
			if (isset($json['SVC_ERR_CD']) && $json['SVC_ERR_CD'] != '') {
				$json['err_msg'] = sprintf('(%s:%s)', $json['SVC_ERR_CD'], $json['SVC_ERR_MSG']);
			} else {
				$json['err_msg'] = sprintf('(%s:%s)', $json['RES_CD'], $json['RES_MSG']);
			}
		} else {
			log_message('INFO', sprintf("[ISF][RES][SUCC][HTTP_CODE=%s][METHOD=%s][URL=%s][RESPONSE=\n%s\n]", $http_code, $method, $request_url, prettyPrint($response)));
		}
		
		return $json;
	}

	function is_success($response) {
		if (isset($response['err_msg']) || $response['RES_CD'] != $this->res_succ_cd) {
			return false;
		}
		
		return true;
	}

}