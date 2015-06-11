<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . 'third_party/FPBatis/fpbatis.php';

class MY_Model extends CI_Model {
	/**
	 *
	 * @var CI_DB_active_record
	 */
	private $db;
	
	/**
	 *
	 * @var FPBatis
	 */
	public $fpbatis;

	function __construct() {
		parent::__construct();
		
		include (APPPATH . 'config/' . ENVIRONMENT . '/database.php');
		
		try {
			if (file_exists('config/' . ENVIRONMENT . '/sqlMap.xml')) {
				$this->fpbatis = new FPBatis('config/' . ENVIRONMENT . '/sqlMap.xml');
			} else {
				$this->fpbatis = new FPBatis('config/sqlMap.xml');
			}
		} catch ( Exception $e ) {
			show_error($e->getMessage());
			exit();
		}
	}

	public function trans_start() {
		$this->fpbatis->trans_start();
	}

	public function trans_complete() {
		$this->fpbatis->trans_complete();
	}

	public function trans_status() {
		return $this->fpbatis->trans_status();
	}

	public function trans_rollback() {
		$this->fpbatis->trans_rollback();
	}

	public function trans_commit() {
		$this->fpbatis->trans_commit();
	}

	function generate_row_num($bean_list, $total_rows = 0, $cur_page = 0, $per_page = 0) {
		if (!is_array($bean_list) || $total_rows <= 0) {
			return;
		}
		
		$row_num_start = $total_rows - (($cur_page - 1) * $per_page);
		foreach ( $bean_list as $bean ) {
			$bean->set_row_num($row_num_start);
			$row_num_start--;
		}
	}

	function generate_row_num_excel($bean_list, $total_rows = 0) {
		if (!is_array($bean_list) || $total_rows <= 0) {
			return;
		}
		
		$row_num_start = $total_rows;
		foreach ( $bean_list as $bean ) {
			$bean->set_row_num($row_num_start);
			$row_num_start--;
		}
	}

	protected function array_to_beanList($result_array, $class_name) {
		$bean_list = array ();
		
		if (!class_exists($class_name)) {
			log_message('error', "$class_name class is not exists");
			return $bean_list;
		}
		
		if (!is_array($result_array) || count($result_array) <= 0) {
			return $bean_list;
		}
		
		foreach ( $result_array as $index => $row ) {
			$bean = new $class_name();
			foreach ( $row as $key => $val ) {
				$method = 'set_' . strtolower($key);
				if (method_exists($bean, $method)) {
					$bean->$method($val);
				} else {
					log_message('error', "$method method is not exists");
				}
			}
			$bean_list[] = $bean;
		}
		return $bean_list;
	}

	protected function row_to_bean($row, $class_name) {
		$bean = null;
		
		if (!class_exists($class_name)) {
			log_message('error', "$class_name class is not exists");
			return $bean;
		}
		
		$bean = new $class_name();
		
		if (!is_array($row) || count($row) <= 0) {
			return $bean;
		}
		
		foreach ( $row as $key => $val ) {
			$method = 'set_' . strtolower($key);
			if (method_exists($bean, $method)) {
				$bean->$method($val);
			} else {
				log_message('error', "$method method is not exists");
			}
		}
		
		return $bean;
	}

	protected function generate_start_dt($start_dt) {
		return $start_dt . ' 00:00:00';
	}

	protected function generate_end_dt($end_dt) {
		return $end_dt . ' 23:59:59';
	}

	protected function generate_start_month($start_dt) {
		list($year, $month) = explode('-', $start_dt);
		return date('Y-m-d H:i:s', mktime(0, 0, 0, $month, 1, $year));
	}

	protected function generate_end_month($end_dt) {
		list($year, $month) = explode('-', $end_dt);
		return date('Y-m-d H:i:s', mktime(23, 59, 59, $month + 1, 0, $year));
	}

}
// END Model class

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */