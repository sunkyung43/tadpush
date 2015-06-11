<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreativeStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_statistics_list($params)
	{
		return $this->fpbatis->doSelectList("creativeStatistics.selectList", $params);
	}
	
	function count_statistics_list($params)
	{
		return $this->fpbatis->doSelectOne("creativeStatistics.countSelectList", $params);
	}

}

/* End of file creativestatistics_model.php */
/* Location: ./application/admin/models/statistics/creativestatistics_model.php */