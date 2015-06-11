<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompanyStatistics_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_exist_company_list()
	{
		return $this->fpbatis->doSelectList('companyStatistics.selectExistCompanyList');	
	}
	
	function select_exist_brand_list($params)
	{
		return $this->fpbatis->doSelectList('companyStatistics.selectExistBrandList',$params);
	}
	
	function select_company_list($params)
	{
		return $this->fpbatis->doSelectList("companyStatistics.selectCompanyList", $params);
	}
	
	function count_select_company_list($params)
	{
		return $this->fpbatis->doSelectOne("companyStatistics.countSelectCompanyList", $params);
	}
	
	function select_brand_list($params)
	{
		return $this->fpbatis->doSelectList("companyStatistics.selectBrandList", $params);
	}
	
	function count_select_brand_list($params)
	{
		return $this->fpbatis->doSelectOne("companyStatistics.countSelectBrandList", $params);
	}

	function select_media_list($params)
	{
		return $this->fpbatis->doSelectList("companyStatistics.selectMediaList", $params);
	}
	
	function count_select_media_list($params)
	{
		return $this->fpbatis->doSelectOne("companyStatistics.countSelectMediaList", $params);
	}
}

/* End of file companystatistics_model.php */
/* Location: ./application/admin/models/statistics/companystatistics_model.php */