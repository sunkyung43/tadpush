<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Agreement_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_agreement($mdn) {
		$params = array (
				'mdn' => $mdn,
				'skt_values' => $this->lang->line('device_carrier_skt'),
				'kt_values' => $this->lang->line('device_carrier_kt'),
				'lgu_values' => $this->lang->line('device_carrier_lgu')
		);
		return $this->fpbatis->doSelectOne('agreement.selectAgreement', $params);
	}

	function select_param_media_sdk_ver($params) {
		return $this->fpbatis->doSelectOne('agreement.selectParamMediaSdkVer', $params);
	}

}
/* End of file agreement_model.php */
/* Location: ./application/admin/models/system/agreement_model.php */