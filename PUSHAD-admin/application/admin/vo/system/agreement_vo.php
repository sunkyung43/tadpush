<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Agreement_vo {
	private $mdn;
	private $terms_bit;
	private $agreement_nm;
	private $device_id;
	private $log_dt;
	private $carrier;
	private $carrier_nm;
	private $provision_ver;
	private $media_id;
	private $media_nm;
	private $revoke_account_sq;
	private $user_id;
	private $path_cd;
	private $path_nm;

	function __construct() {
	}

	public function get_mdn() {
		return $this->mdn;
	}

	public function set_mdn($mdn) {
		$this->mdn = $mdn;
	}

	public function get_terms_bit() {
		return $this->terms_bit;
	}

	public function set_terms_bit($terms_bit) {
		$this->terms_bit = $terms_bit;
	}

	public function get_device_id() {
		return $this->device_id;
	}

	public function set_device_id($device_id) {
		$this->device_id = $device_id;
	}

	public function get_carrier() {
		return $this->carrier;
	}

	public function set_carrier($carrier) {
		$this->carrier = $carrier;
	}

	public function get_media_id() {
		return $this->media_id;
	}

	public function set_media_id($media_id) {
		$this->media_id = $media_id;
	}

	public function get_provision_ver() {
		return $this->provision_ver;
	}

	public function set_provision_ver($provision_ver) {
		$this->provision_ver = $provision_ver;
	}

	public function get_log_dt() {
		return $this->log_dt;
	}

	public function set_log_dt($log_dt) {
		$this->log_dt = $log_dt;
	}

	public function get_revoke_account_sq() {
		return $this->revoke_account_sq;
	}

	public function set_revoke_account_sq($revoke_account_sq) {
		$this->revoke_account_sq = $revoke_account_sq;
	}

	public function get_media_nm() {
		return $this->media_nm;
	}

	public function set_media_nm($media_nm) {
		$this->media_nm = $media_nm;
	}

	public function get_user_id() {
		return $this->user_id;
	}

	public function set_user_id($user_id) {
		$this->user_id = $user_id;
	}

	public function get_path_cd() {
		return $this->path_cd;
	}

	public function set_path_cd($path_cd) {
		$this->path_cd = $path_cd;
	}

	public function get_path_nm() {
		return $this->path_nm;
	}

	public function set_path_nm($path_nm) {
		$this->path_nm = $path_nm;
	}

	public function get_agreement_nm() {
		return $this->agreement_nm;
	}

	public function set_agreement_nm($agreement_nm) {
		$this->agreement_nm = $agreement_nm;
	}

	public function get_carrier_nm() {
		return $this->carrier_nm;
	}

	public function set_carrier_nm($carrier_nm) {
		$this->carrier_nm = $carrier_nm;
	}

}

/* End of file agreement_vo.php */
/* Location: ./application/admin/vo/system/agreement_vo.php */