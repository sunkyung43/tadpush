<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class SearchAgreement extends MY_Controller {
	/**
	 *
	 * @var Agreement_model
	 */
	public $agreement_model;

	function __construct() {
		parent::__construct();
		
		$this->load->model('/system/agreement_model');
		
		$this->load_vo('system/agreement_vo');
	}

	function index_get() {
		$vars['mdn'] = $this->get('mdn') ? $this->get('mdn') : '';
		$vars['agreement_vo'] = null;
		
		if ($vars['mdn'] != '') {
			$vars['agreement_vo'] = $this->agreement_model->select_agreement(des_encrypt($vars['mdn']));
			
			if (!empty($vars['agreement_vo'])) {
				$vars['agreement_vo']->set_mdn(des_decrypt($vars['agreement_vo']->get_mdn()));
			}
		}
		
		if (empty($vars['agreement_vo'])) {
			$vars['agreement_vo'] = new Agreement_vo();
		}
		
		$this->yield = true;
		$this->yield_js = '/web/js/system/searchAgreement/search_agreement_detail.js';
		$this->load->view('/system/agreement/agreement_detail_view', $vars);
	}

	function recant_put() {
		// 약관 철회
		$mdn = $this->put('mdn');
		$device_id = $this->put('device_id');
		$carrier = $this->put('carrier');
		$media_id = $this->put('media_id');
		
		$params = array (
				'device_id' => $device_id,
				'media_id' => $media_id 
		);
		
		$sdk_ver = $this->agreement_model->select_param_media_sdk_ver($params);
		
		// 약관 상태 조회
		$u_terms = $this->_get_provision_select($device_id, $media_id, $sdk_ver);
		
		if ($u_terms === FALSE) {
			$this->ajax_json_response(false, '로그서버 약관 상태 조회에 실패했습니다.');
		}
		
		if ($u_terms < 8) {
			$u_terms = 0;
		} else {
			$u_terms = $u_terms - 8;
		}
		
		// 약관 철회 요청
		if (!$this->_provision_agree($device_id, $mdn, $carrier, $sdk_ver, $u_terms)) {
			$this->ajax_json_response(false, '로그서버 약관 철회 요청에 실패했습니다.');
		}
		
		$this->ajax_json_response(true, '동의가 철회 되었습니다.');
	}

	function _get_provision_select($device_id, $media_id, $sdk_ver) {
		$url = $this->config->item('param_server_provision_select');
		
		$method = 'POST';
		
		$connect_timeout = $this->config->item('curl_connect_timeout');
		$execute_timeout = $this->config->item('curl_execute_timeout');
		
		// $pp_select_data = array("d_uid" => "deb3286c-71d5-3891-bff6-16b2e14c925a", "m_media_id" => "300100" , "m_sdk_ver" => "1.0.0.0");
		$pp_select_data = array (
				"d_uid" => $device_id,
				"m_media_id" => $media_id,
				"m_sdk_ver" => $sdk_ver 
		);
		
		$post_data = json_encode($pp_select_data);
		
		log_message('INFO', sprintf('[LOG_SERVER][REQ][METHOD=%s][URL=%s][BODY=%s]', $method, $url, $post_data));
		
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $execute_timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		$error_no = curl_errno($ch);
		$error_msg = curl_error($ch);
		
		curl_close($ch);
		
		if ($response === FALSE) {
			log_message('ERROR', sprintf('[LOG_SERVER][RES][FAIL][ERR_NO=%s][ERR_MSG=%s][URL=%s][BODY=%s]', $error_no, $error_msg, $url, $post_data));
			return FALSE;
		}
		
		if ($http_code != 200) {
			log_message('ERROR', sprintf('[LOG_SERVER][RES][FAIL][HTTP_CODE=%s][URL=%s][BODY=%s][RESPONSE=%s]', $http_code, $url, $post_data, $response));
			return FALSE;
		}
		
		$response_object = json_decode($response);
		
		if ($response_object->ret_code != '200') {
			log_message('ERROR', sprintf('[LOG_SERVER][RES][FAIL][RET_CODE=%s][URL=%s][BODY=%s][RESPONSE=%s]', $response_object->ret_code, $url, $post_data, $response));
			return FALSE;
		}
		
		log_message('INFO', sprintf('[LOG_SERVER][RES][SUCC][HTTP_CODE=%s][URL=%s][BODY=%s][RESPONSE=%s]', $http_code, $url, $post_data, $response));
		
		return $response_object->u_terms;
	}

	function _provision_agree($device_id, $mdn, $carrier, $sdk_ver, $u_terms) {
		$url = $this->config->item('param_server_provision_agree');
		
		$method = 'POST';
		
		$connect_timeout = $this->config->item('curl_connect_timeout');
		$execute_timeout = $this->config->item('curl_execute_timeout');
		
		$pp_array_data = array (
				'd_uid' => $device_id,
				'm_media_id' => '999999999',
				'm_sdk_ver' => $sdk_ver,
				'u_terms' => strval($u_terms),
				'x_channel' => '2',
				'u_phone_number' => des_encrypt($mdn),
				'u_network_operator' => strval($carrier),
				'x_user_sq' => strval($this->session->userdata('ACCOUNT_SQ')),
				'x_note' => '' 
		);
		
		$post_data = json_encode($pp_array_data);
		
		log_message('INFO', sprintf('[LOG_SERVER][REQ][METHOD=%s][URL=%s][BODY=%s]', $method, $url, $post_data));
		
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $execute_timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		$error_no = curl_errno($ch);
		$error_msg = curl_error($ch);
		
		curl_close($ch);
		
		if ($response === FALSE) {
			log_message('ERROR', sprintf('[LOG_SERVER][RES][FAIL][ERR_NO=%s][ERR_MSG=%s][URL=%s][BODY=%s]', $error_no, $error_msg, $url, $post_data));
			return FALSE;
		}
		
		if ($http_code != 200) {
			log_message('ERROR', sprintf('[LOG_SERVER][RES][FAIL][HTTP_CODE=%s][URL=%s][BODY=%s][RESPONSE=%s]', $http_code, $url, $post_data, $response));
			return FALSE;
		}
		
		log_message('INFO', sprintf('[LOG_SERVER][RES][SUCC][HTTP_CODE=%s][URL=%s][BODY=%s][RESPONSE=%s]', $http_code, $url, $post_data, $response));
		
		return TRUE;
	}

}

/* End of file agreement.php */
/* Location: ./application/admin/controllers/system/agreement.php */