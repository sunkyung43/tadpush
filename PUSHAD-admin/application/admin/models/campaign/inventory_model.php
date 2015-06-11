<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Inventory_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_inventory_summary($params) {
		return $this->fpbatis->doSelectOne('inventory.selectInventorySummary', $params);
	}

	function select_inventory_list($params) {
		return $this->fpbatis->doSelectList('inventory.selectInventoryList', $params);
	}

}
/* End of file inventory_model.php */
/* Location: ./application/admin/models/campaign/inventory_model.php */