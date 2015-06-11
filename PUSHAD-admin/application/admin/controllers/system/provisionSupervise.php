<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class ProvisionSupervise extends MY_Controller {
	/**
	 *
	 * @var Provision_model
	 */
	public $provision_model;

	function __construct() {
		parent::__construct();
		
		$this->load->model('/system/provision_model');
	}

	function index_get()
	{
		$vars['list'] = $this->provision_model->select_provision_list();
		
		$params = array('pro_status_cd' => $this->lang->line('pro_status_enable'));
		$vars['provision'] = $this->provision_model->select_provision($params);

		$this->yield = true;
		$this->load->view('/system/provision/provision_list_view', $vars);
	}
	
	function write_get()
	{
		$this->yield = true;
		$this->load->view('/system/provision/provision_write_view');
	}
	
	function write_post()
	{
		$param_array = $this->post();
		$param_array['provision_status_cd'] = $this->lang->line('pro_status_enable');
		
		// DB 트랜잭션 시작
		$this->provision_model->trans_start();
		//기존 약관 배포중지 처리
		$this->provision_model->update_provision_status(array('provision_status_cd' => $this->lang->line('pro_status_disable')));
		$this->provision_model->insert_provision_info($param_array);
		if ($this->provision_model->trans_status() === FALSE) {
			$this->provision_model->trans_rollback();
			$this->ajax_json_response(false, 'DB 등록에 실패하였습니다.');
		}
		// DB 트랜잭션 종료
		$this->provision_model->trans_complete();
		$this->ajax_json_response(true, '/system/provisionSupervise');
	}
	
	function exist_ver_get()
	{
		$params = array('provision_ver' => $this->get('provision_ver'));
		$result = $this->provision_model->select_exist_ver($params);
		if($result > 0)
		{	
			$this->response(array('response_type' => 'false', 'response_data' => '중복데이터가 있습니다.'));
			return;
		}
	}
	
	function detail_get()
	{
		$vars = array();
		$params = array('provision_sq' => $this->get('provision_sq'));
		$vars['data'] = $this->provision_model->select_provision_detail_info($params);
		
		$this->yield = true;
		$this->load->view('/system/provision/provision_detail_view', $vars);
	}
	
}

/* End of file provisionSupervise.php */
/* Location: ./application/admin/controllers/system/provisionSupervise.php */