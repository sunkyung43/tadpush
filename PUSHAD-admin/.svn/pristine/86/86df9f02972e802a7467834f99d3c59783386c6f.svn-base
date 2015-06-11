<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Push_Setting_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_frequency_list($params) {
		return $this->fpbatis->doSelectList('pushSetting.selectFrequencyList', $params);
	}
	
	function count_frequency_list($params) {
		return $this->fpbatis->doSelectOne('pushSetting.countFrequencyList', $params);
	}
	
	function select_frequency($params) {
		return $this->fpbatis->doSelectOne('pushSetting.selectFrequencyList', $params);
	}
	
	function insert_frequency($params) {
		return $this->fpbatis->doInsert('pushSetting.insertFrequency', $params);
	}
}
/* End of file push_setting_model.php */
/* Location: ./application/admin/models/system/push_setting_model.php */