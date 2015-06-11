<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OsStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function select_statistics_list($params)
	{
		return $this->fpbatis->doSelectList('osStatistics.selectList', $params);
	}
}

/* End of file osstatistics_model.php */
/* Location: ./application/admin/models/statistics/osstatistics_model.php */