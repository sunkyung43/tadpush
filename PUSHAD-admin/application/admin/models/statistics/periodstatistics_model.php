<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PeriodStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_year_list()
	{
		return $this->fpbatis->doSelectList('period.selectYearList');
	}

	function select_detail_list($query_string){
		return $this->fpbatis->doSelectList('period.selectDetailList', $query_string);
	}
}

/* End of file periodstatistics_model.php */
/* Location: ./application/admin/models/statistics/periodstatistics_model.php */