<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Campaign_vo {
	private $row_num;
	private $campaign_sq;
	private $campaign_nm;
	private $campaign_status_cd;
	private $adv_company_sq;
	private $adv_account_sq;
	private $start_dt;
	private $end_dt;
	private $tot_push_booking_cnt;
	private $campaign_desc;
	private $report_id;
	private $report_password;
	private $create_dt;
	private $update_dt;
	private $create_account_sq;
	private $update_account_sq;
	private $adv_company_nm;
	private $adv_brand_nm;
	private $tot_request_cnt;
	private $tot_test_cnt;
	private $tot_ready_cnt;
	private $tot_complete_cnt;
	private $tot_campaign_dt;
	private $tot_booking_and_request_cnt;
	private $tot_ad_cnt;

	function __construct() {
	}

	public function get_row_num() {
		return $this->row_num;
	}

	public function set_row_num($row_num) {
		$this->row_num = $row_num;
	}

	public function get_campaign_sq() {
		return $this->campaign_sq;
	}

	public function set_campaign_sq($campaign_sq) {
		$this->campaign_sq = $campaign_sq;
	}

	public function get_campaign_nm() {
		return $this->campaign_nm;
	}

	public function set_campaign_nm($campaign_nm) {
		$this->campaign_nm = $campaign_nm;
	}

	public function get_campaign_status_cd() {
		return $this->campaign_status_cd;
	}

	public function set_campaign_status_cd($campaign_status_cd) {
		$this->campaign_status_cd = $campaign_status_cd;
	}

	public function get_adv_company_sq() {
		return $this->adv_company_sq;
	}

	public function set_adv_company_sq($adv_company_sq) {
		$this->adv_company_sq = $adv_company_sq;
	}

	public function get_adv_account_sq() {
		return $this->adv_account_sq;
	}

	public function set_adv_account_sq($adv_account_sq) {
		$this->adv_account_sq = $adv_account_sq;
	}

	public function get_start_dt() {
		return $this->start_dt;
	}

	public function set_start_dt($start_dt) {
		$this->start_dt = $start_dt;
	}

	public function get_end_dt() {
		return $this->end_dt;
	}

	public function set_end_dt($end_dt) {
		$this->end_dt = $end_dt;
	}

	public function get_tot_push_booking_cnt() {
		return $this->tot_push_booking_cnt;
	}

	public function set_tot_push_booking_cnt($tot_push_booking_cnt) {
		$this->tot_push_booking_cnt = $tot_push_booking_cnt;
	}

	public function get_campaign_desc() {
		return $this->campaign_desc;
	}

	public function set_campaign_desc($campaign_desc) {
		$this->campaign_desc = $campaign_desc;
	}

	public function get_report_id() {
		return $this->report_id;
	}

	public function set_report_id($report_id) {
		$this->report_id = $report_id;
	}

	public function get_report_password() {
		return $this->report_password;
	}

	public function set_report_password($report_password) {
		$this->report_password = $report_password;
	}

	public function get_create_dt() {
		return $this->create_dt;
	}

	public function set_create_dt($create_dt) {
		$this->create_dt = $create_dt;
	}

	public function get_update_dt() {
		return $this->update_dt;
	}

	public function set_update_dt($update_dt) {
		$this->update_dt = $update_dt;
	}

	public function get_create_account_sq() {
		return $this->create_account_sq;
	}

	public function set_create_account_sq($create_account_sq) {
		$this->create_account_sq = $create_account_sq;
	}

	public function get_update_account_sq() {
		return $this->update_account_sq;
	}

	public function set_update_account_sq($update_account_sq) {
		$this->update_account_sq = $update_account_sq;
	}

	public function get_adv_company_nm() {
		return $this->adv_company_nm;
	}

	public function set_adv_company_nm($adv_company_nm) {
		$this->adv_company_nm = $adv_company_nm;
	}

	public function get_adv_brand_nm() {
		return $this->adv_brand_nm;
	}

	public function set_adv_brand_nm($adv_brand_nm) {
		$this->adv_brand_nm = $adv_brand_nm;
	}

	public function get_tot_request_cnt() {
		return $this->tot_request_cnt;
	}

	public function set_tot_request_cnt($tot_request_cnt) {
		$this->tot_request_cnt = $tot_request_cnt;
	}

	public function get_tot_test_cnt() {
		return $this->tot_test_cnt;
	}

	public function set_tot_test_cnt($tot_test_cnt) {
		$this->tot_test_cnt = $tot_test_cnt;
	}

	public function get_tot_ready_cnt() {
		return $this->tot_ready_cnt;
	}

	public function set_tot_ready_cnt($tot_ready_cnt) {
		$this->tot_ready_cnt = $tot_ready_cnt;
	}

	public function get_tot_complete_cnt() {
		return $this->tot_complete_cnt;
	}

	public function set_tot_complete_cnt($tot_complete_cnt) {
		$this->tot_complete_cnt = $tot_complete_cnt;
	}

	public function get_tot_campaign_dt() {
		return $this->tot_campaign_dt;
	}

	public function set_tot_campaign_dt($tot_campaign_dt) {
		$this->tot_campaign_dt = $tot_campaign_dt;
	}

	public function get_tot_booking_and_request_cnt() {
		return $this->tot_booking_and_request_cnt;
	}

	public function set_tot_booking_and_request_cnt($tot_booking_and_request_cnt) {
		$this->tot_booking_and_request_cnt = $tot_booking_and_request_cnt;
	}

	public function get_tot_ad_cnt() {
		return $this->tot_ad_cnt;
	}

	public function set_tot_ad_cnt($tot_ad_cnt) {
		$this->tot_ad_cnt = $tot_ad_cnt;
	}

}

/* End of file campaign_vo.php */
/* Location: ./application/admin/vo/campaign/campaign_vo.php */