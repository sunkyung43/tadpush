<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function count_list($query){
		return $this->fpbatis->doSelectOne('device.countSelectList', $query);
	}
	
	function select_list($query){
		return $this->fpbatis->doSelectList('device.selectList', $query);
	}
	
	function select_device_detail($query)
	{
		return $this->fpbatis->doSelectOne('device.selectDeviceDetail', $query);
	}
}

/* End of file device_model.php */
/* Location: ./application/admin/models/system/device_model.php */