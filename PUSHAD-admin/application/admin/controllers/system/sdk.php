<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Sdk extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index_get()
	{
		$data = array();
	
		$data['viewer_apk_url'] = $this->config->item('viewer_apk_url');
		$data['opt_out_apk_url'] = $this->config->item('opt_out_apk_url');
	
		$this->yield = true;
		$this->load->view('/system/sdk/apk_download_view', $data);
	}

}

/* End of file sdk.php */
/* Location: ./application/admin/controllers/system/sdk.php */