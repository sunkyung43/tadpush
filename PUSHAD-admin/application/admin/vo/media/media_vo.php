<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Media_vo {

	private $media_id;
	private $media_nm;
	private $media_status_cd;
	private $media_status_nm;
	private $media_category_cd;
	private $media_category_nm;
	private $media_key;
	private $media_secret;
	private $media_desc;
	private $hold_param_cnt;
	private $os_cd;
	private $os_nm;
	private $media_group_id;
	private $media_group_ids;
	private $media_group_nm;
	private $create_dt;
	private $update_dt;
	private $create_account_sq;
	private $auth_param;
	
	

	public function get_media_id() {
		return $this->media_id;
	}
	
	public function set_media_id($media_id) {
		$this->media_id = $media_id;
	}
	
	public function get_media_nm() {
		return $this->media_nm;
	}
	
	public function set_media_nm($media_nm) {
		$this->media_nm = $media_nm;
	}
	
	public function get_media_status_cd() {
		return $this->media_status_cd;
	}
	
	public function set_media_status_cd($media_status_cd) {
		$this->media_status_cd = $media_status_cd;
	}
	
	public function get_media_status_nm() {
		return $this->media_status_nm;
	}
	
	public function set_media_status_nm($media_status_nm) {
		$this->media_status_nm = $media_status_nm;
	}
	
	public function get_media_category_cd() {
		return $this->media_category_cd;
	}
	
	public function set_media_category_cd($media_category_cd) {
		$this->media_category_cd = $media_category_cd;
	}
	
	public function get_media_category_nm() {
		return $this->media_category_nm;
	}
	
	public function set_media_category_nm($media_category_nm) {
		$this->media_category_nm = $media_category_nm;
	}
	
	public function get_media_key() {
		return $this->media_key;
	}
	
	public function set_media_key($media_key) {
		$this->media_key = $media_key;
	}
	
	public function get_media_secret() {
		return $this->media_secret;
	}
	
	public function set_media_secret($media_secret) {
		$this->media_secret = $media_secret;
	}
	
	public function get_os_cd() {
		return $this->os_cd;
	}
	
	public function set_os_cd($os_cd) {
		$this->os_cd = $os_cd;
	}
	
	public function get_os_nm() {
		return $this->os_nm;
	}
	
	public function set_os_nm($os_nm) {
		$this->os_nm = $os_nm;
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
	
	public function get_media_group_id() {
		return $this->media_group_id;
	}
	
	public function set_media_group_id($media_group_id) {
		$this->media_group_id = $media_group_id;
	}
	
	public function get_media_group_ids() {
		return $this->media_group_ids;
	}
	
	public function set_media_group_ids($media_group_ids) {
		$this->media_group_ids = $media_group_ids;
	}
	
	public function get_media_group_nm() {
		return $this->media_group_nm;
	}
	
	public function set_media_group_nm($media_group_nm) {
		$this->media_group_nm = $media_group_nm;
	}
	
	public function get_media_desc() {
		return $this->media_desc;
	}
	
	public function set_media_desc($media_desc) {
		$this->media_desc = $media_desc;
	}
	
	public function get_hold_param_cnt() {
		return $this->hold_param_cnt;
	}
	
	public function set_hold_param_cnt($hold_param_cnt) {
		$this->hold_param_cnt = $hold_param_cnt;
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
	
	public function get_auth_param() {
		return $this->auth_param;
	}
	
	public function set_auth_param($auth_param) {
		$this->auth_param = $auth_param;
	}
	
	
	function __construct() {
	}


}

/* End of file advert_vo.php */
/* Location: ./application/admin/vo/campaign/advert_vo.php */