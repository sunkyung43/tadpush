<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PcpMediaReport_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function select_MediaReport_list($params, $cur_page = '', $per_page = '')
	{
		if($cur_page != '' && $per_page != '')
		{
			$params['cur_page'] = ($cur_page - 1) * $per_page;
			$params['per_page'] = $per_page;
		}
		
		$bean_list = $this->fpbatis->doSelectList('pcpMediaReport.selectMediaReportList', $params);
		
		if($cur_page != '' && $per_page != '')
		{
			$total_rows = $this->count_mediaReport_list($params);
		}
		else
		{
			$total_rows = count($bean_list);
		}
		
		$this->generate_row_num($bean_list, $total_rows, $cur_page, $per_page);
		
		return array($total_rows, $bean_list);
	}
	
	function count_mediaReport_list($params)
	{
		return $this->fpbatis->doSelectOne('pcpMediaReport.countMediaReportList', $params);
	}
	
	function select_media_detail($params)
	{
		return $this->fpbatis->doSelectOne('pcpMediaReport.selectMediaDetail', $params);
	}
	
	function select_campaign_list($params, $cur_page = '', $per_page = '')
	{
		if($cur_page != '' && $per_page != '')
		{
			$params['cur_page'] = ($cur_page - 1) * $per_page;
			$params['per_page'] = $per_page;
		}
		
		$bean_list = $this->fpbatis->doSelectList('pcpMediaReport.selectCampaignList', $params);
		
		if($cur_page != '' && $per_page != '')
		{
			$total_rows = $this->count_campaign_list($params);
		}
		else
		{
			$total_rows = count($bean_list);
		}
		
		$this->generate_row_num($bean_list, $total_rows, $cur_page, $per_page);
		
		return array($total_rows, $bean_list);
	}
	
	function select_total_campaign($params)
	{
		return $this->fpbatis->doSelectOne('pcpMediaReport.selectTotalCampaign', $params);
	}
	
	function count_campaign_list($params)
	{
		return $this->fpbatis->doSelectOne('pcpMediaReport.countCampaignList', $params);
	}
	
	function get_status_name($media_status_cd)
	{
		return $this->fpbatis->doSelectOne('pcpMediaReport.selectMediaStatusName', $media_status_cd);
	}
	
	function get_platform_name($platform_cd)
	{
		return $this->fpbatis->doSelectOne('pcpMediaReport.selectMediaPlatformName', $platform_cd);
	}
	
	function get_media_name_list()
	{
		return $this->fpbatis->doSelectList('pcpMediaReport.selectMediaNameList');
	}
}

/* End of file pcpMediaReport_model.php */
/* Location: ./application/admin/models/report/pcpMediaReport_model.php */