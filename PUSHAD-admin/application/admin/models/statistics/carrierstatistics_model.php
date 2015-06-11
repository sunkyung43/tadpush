<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CarrierStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_list($query){
		return $this->fpbatis->doSelectList('carrier.selectList', $query);
	}
}

/* End of file carrierstatistics_model.php */
/* Location: ./application/admin/models/statistics/carrierstatistics_model.php */