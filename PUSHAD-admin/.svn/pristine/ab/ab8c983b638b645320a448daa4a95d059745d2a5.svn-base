<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Push_agreement_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_param_list() {
		$params = array (
				'skt_values' => $this->lang->line('device_carrier_skt'),
				'kt_values' => $this->lang->line('device_carrier_kt'),
				'lgu_values' => $this->lang->line('device_carrier_lgu') 
		);
		
		return $this->fpbatis->doSelectList('pushAgreement.selectParamList', $params);
	}

	function select_idle_list() {
		$params = array (
				'skt_values' => $this->lang->line('device_carrier_skt'),
				'kt_values' => $this->lang->line('device_carrier_kt'),
				'lgu_values' => $this->lang->line('device_carrier_lgu')
		);
		
		return $this->fpbatis->doSelectList('pushAgreement.selectIdleList', $params);
	}

	function select_cancel_list() {
		$params = array (
				'skt_values' => $this->lang->line('device_carrier_skt'),
				'kt_values' => $this->lang->line('device_carrier_kt'),
				'lgu_values' => $this->lang->line('device_carrier_lgu')
		);
		
		return $this->fpbatis->doSelectList('pushAgreement.selectCancelList', $params);
	}

}
/* End of file push_agreement_model.php */
/* Location: ./application/admin/models/system/push_agreement_model.php */