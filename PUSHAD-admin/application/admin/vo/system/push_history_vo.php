<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Push_history_vo {
	private $row_num;
	private $mdn;
	private $device_id;
	private $start_dt;
	private $campaign_nm;
	private $ad_nm;
	private $media_nm;
	private $success_yn;

	function __construct() {
	}

	public function get_row_num() {
		return $this->row_num;
	}

	public function set_row_num($row_num) {
		$this->row_num = $row_num;
	}

	public function get_mdn() {
		return $this->mdn;
	}

	public function set_mdn($mdn) {
		$this->mdn = $mdn;
	}

	public function get_device_id() {
		return $this->device_id;
	}

	public function set_device_id($device_id) {
		$this->device_id = $device_id;
	}

	public function get_start_dt() {
		return $this->start_dt;
	}

	public function set_start_dt($start_dt) {
		$this->start_dt = $start_dt;
	}

	public function get_campaign_nm() {
		return $this->campaign_nm;
	}

	public function set_campaign_nm($campaign_nm) {
		$this->campaign_nm = $campaign_nm;
	}

	public function get_ad_nm() {
		return $this->ad_nm;
	}

	public function set_ad_nm($ad_nm) {
		$this->ad_nm = $ad_nm;
	}

	public function get_media_nm() {
		return $this->media_nm;
	}

	public function set_media_nm($media_nm) {
		$this->media_nm = $media_nm;
	}

	public function get_success_yn() {
		return $this->success_yn;
	}

	public function set_success_yn($success_yn) {
		$this->success_yn = $success_yn;
	}

}

/* End of file push_history_vo.php */
/* Location: ./application/admin/vo/system/push_history_vo.php */