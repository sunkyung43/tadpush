<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Isf_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_param($device_id) {
		return $this->fpbatis->doSelectOne('isf.selectParam', $device_id);
	}
	
	function select_param_media($params) {
		return $this->fpbatis->doSelectOne('isf.selectParamMedia', $params);
	}
	
	function select_media($media_id) {
		return $this->fpbatis->doSelectOne('isf.selectMedia', $media_id);
	}
	
	function select_frequency($frequency_sq) {
		return $this->fpbatis->doSelectOne('isf.selectFrequency', $frequency_sq);
	}
	
	function select_advert($ad_sq) {
		return $this->fpbatis->doSelectOne('isf.selectAdvert', $ad_sq);
	}

	function select_campaign($campaign_sq) {
		return $this->fpbatis->doSelectOne('isf.selectCampaign', $campaign_sq);
	}

	function select_target($ad_sq) {
		$this->fpbatis->doUpdate('isf.setGroupConcatMaxLength', 4096);
		return $this->fpbatis->doSelectList('isf.selectTarget', $ad_sq);
	}
	
	function select_param_list() {
		return $this->fpbatis->doSelectList('isf.selectParamList');
	}
	
	function select_param_media_list() {
		return $this->fpbatis->doSelectList('isf.selectParamMediaList');
	}
	
	function select_media_list() {
		return $this->fpbatis->doSelectList('isf.selectMediaList');
	}
	
	function select_frequency_list() {
		return $this->fpbatis->doSelectList('isf.selectFrequencyList');
	}
	
	function select_advert_list() {
		return $this->fpbatis->doSelectList('isf.selectAdvertList');
	}

	function select_campaign_list() {
		return $this->fpbatis->doSelectList('isf.selectCampaignList');
	}
}
/* End of file isf_model.php */
/* Location: ./application/admin/models/isf/isf_model.php */