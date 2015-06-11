<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Provision extends MY_Controller {
	/**
	 *
	 * @var Provision_model
	 */
	public $provision_model;

	function __construct() {
		parent::__construct();
		
		$this->load->model('/system/provision_model');
	}

	function index_get() {
		$params = array('pro_status_cd' => $this->lang->line('pro_status_enable'));
		$provision = $this->provision_model->select_provision($params);

		$this->yield = false;
		$this->load->view('/system/provision/provision_view', $provision);
	}

}

/* End of file provision.php */
/* Location: ./application/admin/controllers/system/provision.php */