<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediaStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_category_list($query)
	{
		return $this->fpbatis->doSelectList('mediaStatistics.selectList', $query);	
	}
	
	function count_media_list($query)
	{
		return $this->fpbatis->doSelectOne('mediaStatistics.countMediaList', $query);
	}
	
	function  select_media_list($query)
	{
		return $this->fpbatis->doSelectList('mediaStatistics.selectMediaList', $query);	
	}

}

/* End of file mediastatistics_model.php */
/* Location: ./application/admin/models/mediastatistics/mediastatistics_model.php */