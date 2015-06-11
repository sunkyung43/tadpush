<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class History_vo {
	private $campaign_history_sq;
	private $campaign_sq;
	private $ad_sq;
	private $history_gb;
	private $modify_before;
	private $modify_after;
	private $account_sq;
	private $create_dt;
	private $history_comment;
	private $campaign_nm;
	private $ad_nm;
	private $user_nm;

	function __construct() {
	}

	public function get_campaign_history_sq() {
		return $this->campaign_history_sq;
	}

	public function set_campaign_history_sq($campaign_history_sq) {
		$this->campaign_history_sq = $campaign_history_sq;
	}

	public function get_campaign_sq() {
		return $this->campaign_sq;
	}

	public function set_campaign_sq($campaign_sq) {
		$this->campaign_sq = $campaign_sq;
	}

	public function get_ad_sq() {
		return $this->ad_sq;
	}

	public function set_ad_sq($ad_sq) {
		$this->ad_sq = $ad_sq;
	}

	public function get_history_gb() {
		return $this->history_gb;
	}

	public function set_history_gb($history_gb) {
		$this->history_gb = $history_gb;
	}

	public function get_modify_before() {
		return $this->modify_before;
	}

	public function set_modify_before($modify_before) {
		$this->modify_before = $modify_before;
	}

	public function get_modify_after() {
		return $this->modify_after;
	}

	public function set_modify_after($modify_after) {
		$this->modify_after = $modify_after;
	}

	public function get_account_sq() {
		return $this->account_sq;
	}

	public function set_account_sq($account_sq) {
		$this->account_sq = $account_sq;
	}

	public function get_create_dt() {
		return $this->create_dt;
	}

	public function set_create_dt($create_dt) {
		$this->create_dt = $create_dt;
	}

	public function get_history_comment() {
		return $this->history_comment;
	}

	public function set_history_comment($history_comment) {
		$this->history_comment = $history_comment;
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

	public function get_user_nm() {
		return $this->user_nm;
	}

	public function set_user_nm($user_nm) {
		$this->user_nm = $user_nm;
	}

}

/* End of file history_vo.php */
/* Location: ./application/admin/vo/campaign/history_vo.php */