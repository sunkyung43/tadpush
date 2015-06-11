<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DeviceStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function count_statistics_list($params)
	{
		return $this->fpbatis->doSelectOne('deviceStatistics.countSelectList', $params);
	}

	function select_statistics_list($params)
	{
		return $this->fpbatis->doSelectList('deviceStatistics.selectList', $params);
	}
}

/* End of file devicestatistics_model.php */
/* Location: ./application/admin/models/statistics/devicestatistics_model.php */