<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Push extends MY_Controller {
	
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
	 * @var Json
	 */
	public $json;
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('/campaign/advert_model');
		$this->load->model('/campaign/creative_model');
		
		$this->load_vo('campaign/advert_vo');
		$this->load_vo('campaign/creative_vo');
		
		$this->load->library('json');
	}

	function index_post() {
		$ad_sq = $this->post('ad_sq') ? $this->post('ad_sq') : '';
		$mdn = $this->post('mdn') ? str_replace('-', '', $this->post('mdn')) : '';
		
		if ($ad_sq == '' || $mdn == '') {
			$this->ajax_json_response(false, '필수 파라미터 없음.');
		}
		
		$push_target = $this->common_model->select_push_target(des_encrypt($mdn));
		if ($push_target == null) {
			$this->ajax_json_response(false, '타게팅 가능한 매체가 없습니다.');
		}
		
		// 광고
		$advert_vo = $this->advert_model->select_advert($ad_sq);
		if ($advert_vo == null) {
			$this->ajax_json_response(false, '광고가 없습니다.');
		}
		
		// 소재
		$creative_type_cd = $advert_vo->get_creative_type_cd();
		$creative_sq = $advert_vo->get_creative_sq();
		if ($creative_type_cd == '' || $creative_sq == '') {
			$this->ajax_json_response(false, '소재가 없습니다.');
		}
		
		$creative = $this->_select_creative($creative_type_cd, $creative_sq);
		if ($creative == null) {
			$this->ajax_json_response(false, '소재가 없습니다.');
		}
		
		$push_message = $this->_generate_ad_message($advert_vo->get_campaign_sq(), $advert_vo->get_ad_sq(), $push_target['media_id'], $push_target['media_category_cd'], $advert_vo->get_creative_type_cd(), $creative);
		
		$response = $this->_push($push_target['auth_param'], $push_target['pp_id'], $push_message);
		
		if($response === TRUE) {
			$this->ajax_json_response(true, '발송 하였습니다.');
		} else {
			$this->ajax_json_response(false, $response);
		}
	}

	function preview_get() {
		$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';

		log_message('INFO', sprintf("[DEVICE][REQ][AD_SQ=%s]", $ad_sq));
		
		if ($ad_sq == '') {
			log_message('INFO', sprintf("[DEVICE][RES][FAIL][MSG=%s]", 'ad_sq is empty'));
			$this->ajax_json_response(false, 'ad_sq is empty');
		}
		
		// 광고
		$advert_vo = $this->advert_model->select_advert($ad_sq);
		if ($advert_vo == null) {
			log_message('INFO', sprintf("[DEVICE][RES][FAIL][MSG=%s]", 'AD is empty'));
			$this->ajax_json_response(false, 'AD is empty');
		}
		
		// 소재
		$creative_type_cd = $advert_vo->get_creative_type_cd();
		$creative_sq = $advert_vo->get_creative_sq();
		if ($creative_type_cd == '' || $creative_sq == '') {
			log_message('INFO', sprintf("[DEVICE][RES][FAIL][MSG=%s]", 'Creative is empty'));
			$this->ajax_json_response(false, 'Creative is empty');
		}
		
		$creative = $this->_select_creative($creative_type_cd, $creative_sq);
		if ($creative == null) {
			log_message('INFO', sprintf("[DEVICE][RES][FAIL][MSG=%s]", 'Creative is empty'));
			$this->ajax_json_response(false, 'Creative is empty');
		}
		
		$json = $this->_generate_ad_message('', '', '', '', $creative_type_cd, $creative);
		
		log_message('INFO', sprintf("[DEVICE][RES][SUCC][JSON=\n%s\n]", prettyPrint($json)));
		
		echo $json;
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

	function _push($auth_param, $pp_id, $json) {
		$url = $this->config->item('push_planet_url') . '/push/message?version=2';
		$method = 'POST';
		$content_type = 'Content-Type: application/x-www-form-urlencoded';
// 		$content_type = 'Content-Type: multipart/form-data';
// 		$content_type = 'Content-Type: application/json';
		$auth = 'Authorization: Basic ' . $auth_param;
		
		$header = array (
				$content_type,
				$auth 
		);
		
		$body = sprintf('reliability=true&target=%s&extra=%s', $pp_id, $json);
		
		log_message('INFO', sprintf("[PP][REQ][METHOD=%s][URL=%s][PP_ID=%s][HEADER=%s][JSON=\n%s\n]", $method, $url, $pp_id, implode(',', $header), prettyPrint($json)));
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->config->item('curl_connect_timeout'));
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->config->item('curl_execute_timeout'));
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		$error_no = curl_errno($ch);
		$error_msg = curl_error($ch);
		
		curl_close($ch);
		
		if ($response === FALSE) {
			log_message('ERROR', sprintf('[PP][RES][FAIL][ERR_NO=%s][ERR_MSG=%s][METHOD=%s][URL=%s]', $error_no, $error_msg, $method, $url));
			return sprintf('(%s:%s)', 'REQ_ERR', $error_msg); 
		}
		
		if ($http_code == 200 || $http_code == 201 || $http_code == 206) {
			log_message('INFO', sprintf("[PP][RES][SUCC][HTTP_CODE=%s][METHOD=%s][URL=%s][RESPONSE=\n%s\n]", $http_code, $method, $url, prettyPrint($response)));
			return TRUE;
		} else {
			log_message('ERROR', sprintf("[PP][RES][FAIL][HTTP_CODE=%s][METHOD=%s][URL=%s][RESPONSE=\n%s\n]", $http_code, $method, $url, prettyPrint($response)));
			$json = $this->json->json_decode($response);
			return sprintf('발송 실패 하였습니다.(http_code=%s,pp_code=%s,pp_msg=%s)', $http_code, $json['statusCode'], $json['message']);
		}
	}

	function _generate_ad_message($campaign_sq, $ad_sq, $media_id, $media_category_cd, $creative_type_cd, $creative) {
		$json_array = array();

		$params = array ();
		$params['x_bypass'] = sprintf('cps=%s&ads=%s&mdi=%s&mcc=%s', $campaign_sq, $ad_sq, $media_id, $media_category_cd);
		$params['c_type'] = sprintf('%d', substr($creative_type_cd, 7, 2));
		$params['m_media_id'] = $media_id;
		$params['k_pilot'] = 'Y';
		$params['c_data'] = $this->_generate_creative_message($creative_type_cd, $creative);

		$json_array['ad_push_data'] = $this->json->json_encode($params);
		
		
		return $this->json->json_encode($json_array);
	}

	function _generate_creative_message($creative_type_cd, $creative) {
		switch ($creative_type_cd) {
			case $this->lang->line('creative_type_text') :
				return $this->_creative_text($creative);
			case $this->lang->line('creative_type_image') :
				return $this->_creative_image($creative);
			case $this->lang->line('creative_type_popup_text_banner') :
				return $this->_creative_popup_text_banner($creative);
			case $this->lang->line('creative_type_popup_text') :
				return $this->_creative_popup_text($creative);
			case $this->lang->line('creative_type_popup_image_banner') :
				return $this->_creative_popup_image_banner($creative);
			case $this->lang->line('creative_type_popup_image') :
				return $this->_creative_popup_image($creative);
			case $this->lang->line('creative_type_jb_default') :
				return $this->_creative_jb_default($creative);
			case $this->lang->line('creative_type_jb_big_text') :
				return $this->_creative_jb_big_text($creative);
			case $this->lang->line('creative_type_jb_inbox') :
				return $this->_creative_jb_inbox($creative);
			case $this->lang->line('creative_type_jb_big_picture') :
				return $this->_creative_jb_big_picture($creative);
			default :
				return '';
		}
	}

	function _creative_text($creative) {
		$params = array ();
		
		$params['icon'] = $creative->get_large_icon_image();
		$params['title'] = $creative->get_ticket_text();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		return $this->json->json_encode($params);
	}

	function _creative_image($creative) {
		$params = array ();
		
		$params['title'] = $creative->get_ticket_text();
		$params['image_url'] = $creative->get_banner_image();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		return $this->json->json_encode($params);
	}

	function _creative_popup_text_banner($creative) {
		$params = array ();
		
		$params['icon'] = $creative->get_large_icon_image();
		$params['title'] = $creative->get_ticket_text();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		$params['dialog_title'] = $creative->get_popup_title();
		$params['dialog_button_text'] = $creative->get_landing_button_title();
		$params['dialog_content'] = $creative->get_popup_content_text();
		
		return $this->json->json_encode($params);
	}

	function _creative_popup_text($creative) {
		$params = array ();
		
		$params['dialog_title'] = $creative->get_popup_title();
		$params['dialog_button_text'] = $creative->get_landing_button_title();
		$params['dialog_content'] = $creative->get_popup_content_text();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		return $this->json->json_encode($params);
	}

	function _creative_popup_image_banner($creative) {
		$params = array ();
		
		$params['icon'] = $creative->get_large_icon_image();
		$params['title'] = $creative->get_ticket_text();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		$params['dialog_image_url'] = $creative->get_popup_image();
		$params['dialog_button_text'] = $creative->get_landing_button_title();
		
		return $this->json->json_encode($params);
	}

	function _creative_popup_image($creative) {
		$params = array ();
		
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		$params['dialog_image_url'] = $creative->get_popup_image();
		$params['dialog_button_text'] = $creative->get_landing_button_title();
		
		return $this->json->json_encode($params);
	}

	function _creative_jb_default($creative) {
		$params = array ();
		
		$params['title'] = $creative->get_ticket_text();
		$params['icon'] = $creative->get_large_icon_image();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		$action_info = $this->_get_action_landing_info($creative);
		if (!empty($action_info)) {
			$params['action_info'] = $action_info;
		}
		
		return $this->json->json_encode($params);
	}

	function _creative_jb_big_text($creative) {
		$params = array ();
		
		$params['title'] = $creative->get_ticket_text();
		$params['icon'] = $creative->get_large_icon_image();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['detail_text'] = $creative->get_sub_text();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		if ($creative->get_summary_text() != '') {
			$params['detail_summary'] = $creative->get_summary_text();
		}
		$action_info = $this->_get_action_landing_info($creative);
		if (!empty($action_info)) {
			$params['action_info'] = $action_info;
		}
		
		return $this->json->json_encode($params);
	}

	function _creative_jb_inbox($creative) {
		$params = array ();
		
		$params['title'] = $creative->get_ticket_text();
		$params['icon'] = $creative->get_large_icon_image();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['detail_list'] = $this->_get_inbox_detail_list($creative);
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		if ($creative->get_summary_text() != '') {
			$params['detail_summary'] = $creative->get_summary_text();
		}
		$action_info = $this->_get_action_landing_info($creative);
		if (!empty($action_info)) {
			$params['action_info'] = $action_info;
		}
		
		return $this->json->json_encode($params);
	}

	function _creative_jb_big_picture($creative) {
		$params = array ();
		
		$params['title'] = $creative->get_ticket_text();
		$params['icon'] = $creative->get_large_icon_image();
		$params['detail_title'] = $creative->get_content_title();
		$params['detail_comment'] = $creative->get_content_text();
		$params['image_url'] = $creative->get_banner_image();
		$params['landing_type'] = $creative->get_landing_type_cd();
		$params['landing_info'] = $this->_get_landing_info($creative);
		
		if ($creative->get_summary_text() != '') {
			$params['detail_summary'] = $creative->get_summary_text();
		}
		$action_info = $this->_get_action_landing_info($creative);
		if (!empty($action_info)) {
			$params['action_info'] = $action_info;
		}
		
		return $this->json->json_encode($params);
	}

	function _get_landing_info($creative, $action_num = 0) {
		$params = array ();
		
		if ($action_num == 0) {
			$landing_type_cd = $creative->get_landing_type_cd();
			if ($landing_type_cd == $this->lang->line('landing_type_web') || $landing_type_cd == $this->lang->line('landing_type_web_view')) {
				$params['landing_url'] = $creative->get_landing_type_url();
			} else if ($landing_type_cd == $this->lang->line('landing_type_app_dl')) {
				$params['download_info'] = $this->_get_download_info($creative);
			} else if ($landing_type_cd == $this->lang->line('landing_type_run')) {
				$params['app_info'] = $this->_get_app_info($creative);
				$params['download_info'] = $this->_get_download_info($creative);
			}
		} else if ($action_num == 1) {
			$landing_type_cd = $creative->get_action1_landing_type_cd();
			if ($landing_type_cd == $this->lang->line('landing_type_web') || $landing_type_cd == $this->lang->line('landing_type_web_view')) {
				$params['landing_url'] = $creative->get_action1_landing_type_url();
			} else if ($landing_type_cd == $this->lang->line('landing_type_app_dl')) {
				$params['download_info'] = $this->_get_download_info($creative, $action_num);
			} else if ($landing_type_cd == $this->lang->line('landing_type_run')) {
				$params['app_info'] = $this->_get_app_info($creative, $action_num);
				$params['download_info'] = $this->_get_download_info($creative, $action_num);
			}
		} else if ($action_num == 2) {
			$landing_type_cd = $creative->get_action2_landing_type_cd();
			if ($landing_type_cd == $this->lang->line('landing_type_web') || $landing_type_cd == $this->lang->line('landing_type_web_view')) {
				$params['landing_url'] = $creative->get_action2_landing_type_url();
			} else if ($landing_type_cd == $this->lang->line('landing_type_app_dl')) {
				$params['download_info'] = $this->_get_download_info($creative, $action_num);
			} else if ($landing_type_cd == $this->lang->line('landing_type_run')) {
				$params['app_info'] = $this->_get_app_info($creative, $action_num);
				$params['download_info'] = $this->_get_download_info($creative, $action_num);
			}
		} else if ($action_num == 3) {
			$landing_type_cd = $creative->get_action3_landing_type_cd();
			if ($landing_type_cd == $this->lang->line('landing_type_web') || $landing_type_cd == $this->lang->line('landing_type_web_view')) {
				$params['landing_url'] = $creative->get_action3_landing_type_url();
			} else if ($landing_type_cd == $this->lang->line('landing_type_app_dl')) {
				$params['download_info'] = $this->_get_download_info($creative, $action_num);
			} else if ($landing_type_cd == $this->lang->line('landing_type_run')) {
				$params['app_info'] = $this->_get_app_info($creative, $action_num);
				$params['download_info'] = $this->_get_download_info($creative, $action_num);
			}
		}
		
		return $this->json->json_encode($params);
	}

	function _get_download_info($creative, $action_num = 0) {
		$params = array ();
		
		if ($action_num == 0) {
			$params['tstore'] = $creative->get_tst_dl_url();
			$params['market'] = $creative->get_mar_dl_url();
			
			if ($creative->get_alt_url() != '') {
				$params['alternative'] = $creative->get_alt_url();
			}
		} else if ($action_num == 1) {
			$params['tstore'] = $creative->get_action1_tst_dl_url();
			$params['market'] = $creative->get_action1_mar_dl_url();
			
			if ($creative->get_action1_alt_url() != '') {
				$params['alternative'] = $creative->get_action1_alt_url();
			}
		} else if ($action_num == 2) {
			$params['tstore'] = $creative->get_action2_tst_dl_url();
			$params['market'] = $creative->get_action2_mar_dl_url();
			
			if ($creative->get_action2_alt_url() != '') {
				$params['alternative'] = $creative->get_action2_alt_url();
			}
		} else if ($action_num == 3) {
			$params['tstore'] = $creative->get_action3_tst_dl_url();
			$params['market'] = $creative->get_action3_mar_dl_url();
			
			if ($creative->get_action3_alt_url() != '') {
				$params['alternative'] = $creative->get_action3_alt_url();
			}
		}
		
		return $this->json->json_encode($params);
	}

	function _get_app_info($creative, $action_num = 0) {
		$params = array ();
		
		if ($action_num == 0) {
			$params['android'] = $creative->get_and_run_url();
		} else if ($action_num == 1) {
			$params['android'] = $creative->get_action1_and_run_url();
		} else if ($action_num == 2) {
			$params['android'] = $creative->get_action2_and_run_url();
		} else if ($action_num == 3) {
			$params['android'] = $creative->get_action3_and_run_url();
		}
		
		return $this->json->json_encode($params);
	}

	function _get_action_landing_info($creative) {
		$params = array ();
		
		if ($creative->get_action1_landing_type_cd() != '') {
			$action_landing = array ();
			
			$action_landing['action_name'] = $creative->get_action1_text();
			$action_landing['landing_type'] = $creative->get_action1_landing_type_cd();
			$action_landing['landing_info'] = $this->_get_landing_info($creative, 1);
			
			$params[] = $action_landing;
		}
		
		if ($creative->get_action2_landing_type_cd() != '') {
			$action_landing = array ();
			
			$action_landing['action_name'] = $creative->get_action2_text();
			$action_landing['landing_type'] = $creative->get_action2_landing_type_cd();
			$action_landing['landing_info'] = $this->_get_landing_info($creative, 2);
			
			$params[] = $action_landing;
		}
		
		if ($creative->get_action3_landing_type_cd() != '') {
			$action_landing = array ();
			
			$action_landing['action_name'] = $creative->get_action3_text();
			$action_landing['landing_type'] = $creative->get_action3_landing_type_cd();
			$action_landing['landing_info'] = $this->_get_landing_info($creative, 3);
			
			$params[] = $action_landing;
		}
		
		return $this->json->json_encode($params);
	}

	function _get_inbox_detail_list($creative) {
		$params = array ();
		
		$params[] = $creative->get_inbox_text_line_1();
		
// 		if($creative->get_inbox_text_line_2() != '') {
			$params[] = $creative->get_inbox_text_line_2();
// 		}
		
// 		if($creative->get_inbox_text_line_3() != '') {
			$params[] = $creative->get_inbox_text_line_3();
// 		}
		
// 		if($creative->get_inbox_text_line_4() != '') {
			$params[] = $creative->get_inbox_text_line_4();
// 		}
		
// 		if($creative->get_inbox_text_line_5() != '') {
			$params[] = $creative->get_inbox_text_line_5();
// 		}
		
// 		if($creative->get_inbox_text_line_6() != '') {
			$params[] = $creative->get_inbox_text_line_6();
// 		}
		
// 		if($creative->get_inbox_text_line_7() != '') {
			$params[] = $creative->get_inbox_text_line_7();
// 		}
		
		return $this->json->json_encode($params);
	}

}

/* End of file push.php */
/* Location: ./application/admin/controllers/campaign/push.php */
