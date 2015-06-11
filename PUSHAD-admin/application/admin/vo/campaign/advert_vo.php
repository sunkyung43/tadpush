<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Advert_vo {
	private $ad_sq;
	private $campaign_sq;
	private $creative_type_cd;
	private $creative_sq;
	private $ad_nm;
	private $ad_status_cd;
	private $sch_status_cd;
	private $push_booking_cnt;
	private $request_cnt;
	private $start_dt;
	private $start_date;
	private $start_time;
	private $start_end_dt;
	private $create_dt;
	private $update_dt;
	private $create_account_sq;
	private $update_account_sq;
	private $ad_status_nm;
	private $sch_status_nm;
	private $freezing;
	private $campaign_nm;
	private $adv_company_nm;
	private $adv_brand_nm;

	function __construct() {
	}

	public function get_ad_sq() {
		return $this->ad_sq;
	}

	public function set_ad_sq($ad_sq) {
		$this->ad_sq = $ad_sq;
	}

	public function get_campaign_sq() {
		return $this->campaign_sq;
	}

	public function set_campaign_sq($campaign_sq) {
		$this->campaign_sq = $campaign_sq;
	}

	public function get_creative_type_cd() {
		return $this->creative_type_cd;
	}

	public function set_creative_type_cd($creative_type_cd) {
		$this->creative_type_cd = $creative_type_cd;
	}

	public function get_creative_sq() {
		return $this->creative_sq;
	}

	public function set_creative_sq($creative_sq) {
		$this->creative_sq = $creative_sq;
	}

	public function get_ad_nm() {
		return $this->ad_nm;
	}

	public function set_ad_nm($ad_nm) {
		$this->ad_nm = $ad_nm;
	}

	public function get_ad_status_cd() {
		return $this->ad_status_cd;
	}

	public function set_ad_status_cd($ad_status_cd) {
		$this->ad_status_cd = $ad_status_cd;
	}

	public function get_sch_status_cd() {
		return $this->sch_status_cd;
	}

	public function set_sch_status_cd($sch_status_cd) {
		$this->sch_status_cd = $sch_status_cd;
	}

	public function get_push_booking_cnt() {
		return $this->push_booking_cnt;
	}

	public function set_push_booking_cnt($push_booking_cnt) {
		$this->push_booking_cnt = $push_booking_cnt;
	}

	public function get_request_cnt() {
		return $this->request_cnt;
	}

	public function set_request_cnt($request_cnt) {
		$this->request_cnt = $request_cnt;
	}

	public function get_start_dt() {
		return $this->start_dt;
	}

	public function set_start_dt($start_dt) {
		$this->start_dt = $start_dt;
	}

	public function get_start_date() {
		return $this->start_date;
	}

	public function set_start_date($start_date) {
		$this->start_date = $start_date;
	}

	public function get_start_time() {
		return $this->start_time;
	}

	public function set_start_time($start_time) {
		$this->start_time = $start_time;
	}

	public function get_start_end_dt() {
		return $this->start_end_dt;
	}

	public function set_start_end_dt($start_end_dt) {
		$this->start_end_dt = $start_end_dt;
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

	public function get_ad_status_nm() {
		return $this->ad_status_nm;
	}

	public function set_ad_status_nm($ad_status_nm) {
		$this->ad_status_nm = $ad_status_nm;
	}

	public function get_sch_status_nm() {
		return $this->sch_status_nm;
	}

	public function set_sch_status_nm($sch_status_nm) {
		$this->sch_status_nm = $sch_status_nm;
	}

	public function get_freezing() {
		return $this->freezing;
	}

	public function set_freezing($freezing) {
		$this->freezing = $freezing;
	}

	public function get_campaign_nm() {
		return $this->campaign_nm;
	}

	public function set_campaign_nm($campaign_nm) {
		$this->campaign_nm = $campaign_nm;
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

}

/* End of file advert_vo.php */
/* Location: ./application/admin/vo/campaign/advert_vo.php */