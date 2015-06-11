<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PcpCampaignReport_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function select_campaignReport_list($params, $cur_page = '', $per_page = '')
	{
		if($cur_page != '' && $per_page != '')
		{
			$params['cur_page'] = ($cur_page - 1) * $per_page;
			$params['per_page'] = $per_page;
		}
		
		$bean_list = $this->fpbatis->doSelectList('pcpCampaignReport.selectCampaignReportList', $params);
		
		if($cur_page != '' && $per_page != '')
		{
			$total_rows = $this->count_campaignReport_list($params);
		}
		else
		{
			$total_rows = count($bean_list);
		}
		
		$this->generate_row_num($bean_list, $total_rows, $cur_page, $per_page);
		
		return array($total_rows, $bean_list);
	}
	
	function select_campaign_detail($params)
	{
		return $this->fpbatis->doSelectOne('pcpCampaignReport.selectCampaignDetail', $params);
	}
	
	function select_tot_ad($searchStartDate = '', $searchEndDate = '', $ad_sq = '', $ad_report_type = '', $campaign_sq)
	{
		$params = array('searchStartDate' => $searchStartDate,
						'searchEndDate' => $searchEndDate,
						'ad_sq' => $ad_sq,
						'ad_report_type' => $ad_report_type,
						'campaign_sq' => $campaign_sq);
		
		return $this->fpbatis->doSelectOne('pcpCampaignReport.selectAdTotalDetail', $params);
	}
	
	function select_tot_media($searchStartDate = '', $searchEndDate = '', $ad_sq = '', $ad_report_type = '', $campaign_sq)
	{
		$params = array('searchStartDate' => $searchStartDate,
						'searchEndDate' => $searchEndDate,
						'ad_sq' => $ad_sq,
						'ad_report_type' => $ad_report_type,
						'campaign_sq' => $campaign_sq);
		
		return $this->fpbatis->doSelectOne('pcpCampaignReport.selectMediaTotalDetail', $params);
	}
	
	function select_ad_detail($params)
	{
		return $this->fpbatis->doSelectList('pcpCampaignReport.selectAdDetail', $params);
	}
	
	function select_media_detail($params)
	{
		return $this->fpbatis->doSelectList('pcpCampaignReport.selectMediaDetail', $params);
	}
	
	function count_campaignReport_list($params)
	{
		return $this->fpbatis->doSelectOne('pcpCampaignReport.countCampaignReportList', $params);
	}
	
	function select_ad_name_list($campaign_sq)
	{
		$result = array();
		
		$row_array  = $this->fpbatis->doSelectList('pcpCampaignReport.selectAdNameList', $campaign_sq);
		
		foreach($row_array as $row)
		{
			$result[$row['ad_sq']] = $row['ad_nm'];
		}
		
		return $result;
	}
	
	function get_status_name($ad_status_cd)
	{
		return $this->fpbatis->doSelectOne('pcpCampaignReport.selectadStatusName', $ad_status_cd);
	}
	
	function select_isf_list($params)
	{
		return $this->fpbatis->doSelectList('pcpCampaignReport.selectIsfList', $params);
	}
	
	function select_target_list($params)
	{
		return $this->fpbatis->doSelectList('pcpCampaignReport.selectTargetList', $params);
	}
	
}

/* End of file report_model.php */
/* Location: ./application/admin/models/report/report_model.php */