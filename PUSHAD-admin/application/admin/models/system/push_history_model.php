<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Push_history_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_push_history_list($params) {
		return $this->fpbatis->doSelectList('pushHistory.selectPushHistoryList', $params);
	}
	
	function count_push_history_list($params) {
		return $this->fpbatis->doSelectOne('pushHistory.countPushHistoryList', $params);
	}
}
/* End of file push_history_model.php */
/* Location: ./application/admin/models/system/push_history_model.php */