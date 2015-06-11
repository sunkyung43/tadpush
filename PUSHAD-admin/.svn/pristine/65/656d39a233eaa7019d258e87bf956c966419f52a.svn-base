<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class IsfSync extends MY_Controller {
	
	/**
	 *
	 * @var Isf_model
	 */
	public $isf_model;

	public function __construct() {
		parent::__construct();
		
		$this->load->model('isf/isf_model');
		
		$account_sq = $this->session->userdata('ACCOUNT_SQ');
		if ($account_sq != 5000) {
			echo "access denied";
			exit();
		}
	}

	function index_get() {
		$this->yield = true;
		$this->yield_js = '/web/js/task/isf_sync.js';
		$this->load->view('task/isf_sync_view');
	}

	function isfRequest_get() {
		$isf_interface = $this->get('isf_request_interface') ? $this->get('isf_request_interface') : '';
		$isf_method = $this->get('isf_method') ? $this->get('isf_method') : '';
		if ($isf_interface == '' || $isf_method == '') {
			$this->ajax_json_response(false, 'isf_interface or isf_method is empty');
		}
		
		$response = '';
		
		switch ($isf_interface) {
			case 'param' :
				$device_id = $this->get('device_id') ? $this->get('device_id') : '';
				if ($device_id == '') {
					$this->ajax_json_response(false, 'device_id is empty');
				}
				$response = $this->isf->param($isf_method, $device_id);
				break;
			case 'param_media' :
				$device_id = $this->get('device_id') ? $this->get('device_id') : '';
				$media_id = $this->get('media_id') ? $this->get('media_id') : '';
				if ($device_id == '' || $media_id == '') {
					$this->ajax_json_response(false, 'device_id, media_id is empty');
				}
				$response = $this->isf->param_media($isf_method, $device_id, $media_id);
				break;
			case 'media' :
				$media_id = $this->get('media_id') ? $this->get('media_id') : '';
				if ($media_id == '') {
					$this->ajax_json_response(false, 'media_id is empty');
				}
				$response = $this->isf->media($isf_method, $media_id);
				break;
			case 'frequency' :
				$frequency_sq = $this->get('frequency_sq') ? $this->get('frequency_sq') : '';
				if ($frequency_sq == '') {
					$this->ajax_json_response(false, 'frequency_sq is empty');
				}
				$response = $this->isf->frequency($isf_method, $frequency_sq);
				break;
			case 'ad' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->ad($isf_method, $ad_sq);
				break;
			case 'campaign' :
				$campaign_sq = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
				if ($campaign_sq == '') {
					$this->ajax_json_response(false, 'campaign_sq is empty');
				}
				$response = $this->isf->campaign($isf_method, $campaign_sq);
				break;
			case 'count' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->count($ad_sq);
				break;
			case 'reserve' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->reserve($ad_sq);
				break;
			case 'down' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->down($ad_sq);
				break;
			case 'cancel' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->cancel($ad_sq);
				break;
			case 'status' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->status($ad_sq);
				break;
			case 'report' :
				$ad_sq = $this->get('ad_sq') ? $this->get('ad_sq') : '';
				if ($ad_sq == '') {
					$this->ajax_json_response(false, 'ad_sq is empty');
				}
				$response = $this->isf->report($ad_sq);
				break;
			default :
				echo 'isf_interface not found';
				return;
		}
		
		if ($response === TRUE) {
			echo '요청 성공';
		} else if (is_array($response)) {
			print_r($response);
		} else {
			echo $response;
		}
	}

	function isfMetaSync_get() {
		set_time_limit(0);
		
		$isf_interface = $this->get('isf_sync_interface') ? $this->get('isf_sync_interface') : '';
		if ($isf_interface == '') {
			$this->ajax_json_response(false, 'isf_interface or isf_method is empty');
		}
		
		$method = 'POST';
		
		$response = '';
		
		switch ($isf_interface) {
			case 'param' :
				$url = '/meta/param';
				$list = $this->isf_model->select_param_list();
				break;
			case 'param_media' :
				$url = '/meta/param_media';
				$list = $this->isf_model->select_param_media_list();
				break;
			case 'media' :
				$url = '/meta/media';
				$list = $this->isf_model->select_media_list();
				break;
			case 'frequency' :
				$url = '/meta/frequency';
				$list = $this->isf_model->select_frequency_list();
				break;
			case 'ad' :
				$url = '/meta/ad';
				$list = $this->isf_model->select_advert_list();
				break;
			case 'campaign' :
				$url = '/meta/campaign';
				$list = $this->isf_model->select_campaign_list();
				break;
			case 'count' :
			case 'reserve' :
			case 'down' :
			case 'cancel' :
			case 'status' :
			case 'report' :
			default :
				echo 'isf_interface not found';
				return;
		}
		
		$response = $this->_isf_request($url, $method, $list);
		
		if ($response === TRUE) {
			echo '요청 성공';
		} else if (is_array($response)) {
			print_r($response);
		} else {
			echo $response;
		}
	}

	private function _isf_request($url, $method, $list) {
		foreach ( $list as $row ) {
			$response = $this->isf->isf_request($url, $method, $row);
			
			if (!$this->isf->is_success($response)) {
				if (is_array($response)) {
					return $response;
				} else {
					return $response;
				}
			}
		}
		
		return TRUE;
	}

}

/* End of file meta.php */
/* Location: ./application/admin/controllers/test/meta.php */
