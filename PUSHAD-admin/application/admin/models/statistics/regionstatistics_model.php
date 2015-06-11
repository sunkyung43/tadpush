<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RegionStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_exist_sido_list($params)
	{
		return $this->fpbatis->doSelectList('regionStatistics.selectExistSidoList', $params);
	}
	function select_exist_sigugun_list($sido_cd)
	{
		return $this->fpbatis->doSelectList('regionStatistics.selectExistSigugunList', $sido_cd);
	}
	
	function select_sido_list($params)
	{
		return $this->fpbatis->doSelectList('regionStatistics.selectSidoList', $params);
	}
	
	function select_sigugun_list($params)
	{
		return $this->fpbatis->doSelectList('regionStatistics.selectSigugunList', $params);
	}
	
	function count_sigugun_list($params)
	{
		return $this->fpbatis->doSelectOne('regionStatistics.countSigugunList', $params);
	}
}

/* End of file regionstatistics_model.php */
/* Location: ./application/admin/models/statistics/regionstatistics_model.php */