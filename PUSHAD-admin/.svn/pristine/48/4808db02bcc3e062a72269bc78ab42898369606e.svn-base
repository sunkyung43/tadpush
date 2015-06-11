<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ParamStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function count_statistics_list($params)
	{
		return $this->fpbatis->doSelectOne('paramStatistics.countSelectList', $params);
	}
	
	function select_statistics_list($params)
	{
		return $this->fpbatis->doSelectList('paramStatistics.selectList', $params);
	}
}

/* End of file paramstatistics_model.php */
/* Location: ./application/admin/models/statistics/paramstatistics_model.php */