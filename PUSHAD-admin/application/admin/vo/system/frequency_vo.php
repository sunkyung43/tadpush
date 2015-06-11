<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Frequency_vo {
	private $frequency_sq;
	private $start_dt;
	private $cycle;
	private $frequency_cnt;
	private $create_dt;
	private $create_account_sq;
	private $start_end_dt;
	private $frequency_status_nm;

	function __construct() {
	}

	public function get_frequency_sq() {
		return $this->frequency_sq;
	}

	public function set_frequency_sq($frequency_sq) {
		$this->frequency_sq = $frequency_sq;
	}

	public function get_start_dt() {
		return $this->start_dt;
	}

	public function set_start_dt($start_dt) {
		$this->start_dt = $start_dt;
	}

	public function get_cycle() {
		return $this->cycle;
	}

	public function set_cycle($cycle) {
		$this->cycle = $cycle;
	}

	public function get_frequency_cnt() {
		return $this->frequency_cnt;
	}

	public function set_frequency_cnt($frequency_cnt) {
		$this->frequency_cnt = $frequency_cnt;
	}

	public function get_create_dt() {
		return $this->create_dt;
	}

	public function set_create_dt($create_dt) {
		$this->create_dt = $create_dt;
	}

	public function get_create_account_sq() {
		return $this->create_account_sq;
	}

	public function set_create_account_sq($create_account_sq) {
		$this->create_account_sq = $create_account_sq;
	}

	public function get_start_end_dt() {
		return $this->start_end_dt;
	}

	public function set_start_end_dt($start_end_dt) {
		$this->start_end_dt = $start_end_dt;
	}

	public function get_frequency_status_nm() {
		return $this->frequency_status_nm;
	}

	public function set_frequency_status_nm($frequency_status_nm) {
		$this->frequency_status_nm = $frequency_status_nm;
	}

}

/* End of file frequency_vo.php */
/* Location: ./application/admin/vo/system/frequency_vo.php */