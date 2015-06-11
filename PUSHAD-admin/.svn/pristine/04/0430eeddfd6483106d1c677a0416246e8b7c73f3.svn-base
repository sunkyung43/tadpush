<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Provision_model extends MY_Model {

	function __construct() 
	{
		parent::__construct();
	}
	
	function select_provision($params) {
		return $this->fpbatis->doSelectOne('provision.selectProvision', $params);
	}
	
	function select_provision_list() {
		return $this->fpbatis->doSelectList('provision.selectProvisionList');
	}
	
	function select_exist_ver($params)
	{
		return $this->fpbatis->doSelectOne('provision.selectExistVer', $params);
	}
	
	function update_provision_status($params)
	{
		$this->fpbatis->doUpdate('provision.updateProvisionStatus', $params);
	}
	
	function insert_provision_info($params)
	{
		$this->fpbatis->doInsert('provision.insertProvisionInfo', $params);
	}
	
	function select_provision_detail_info($params)
	{
		return $this->fpbatis->doSelectOne('provision.selectProvisionDetailInfo', $params);
	}
}
/* End of file provision_model.php */
/* Location: ./application/admin/models/system/provision_model.php */