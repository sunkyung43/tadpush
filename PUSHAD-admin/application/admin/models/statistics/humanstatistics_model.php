<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HumanStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_gender_list($params)
	{
		return $this->fpbatis->doSelectList('humanStatistics.selectGenderList', $params);
	}

	function select_age_list($params)
	{
		return $this->fpbatis->doSelectList('humanStatistics.selectAgeList', $params);
	}
	
}

/* End of file humanstatistics_model.php */
/* Location: ./application/admin/models/statistics/humanstatistics_model.php */