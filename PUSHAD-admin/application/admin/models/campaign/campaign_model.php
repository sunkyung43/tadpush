<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Campaign_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function insert_campaign($campaign_vo) {
		return $this->fpbatis->doInsert('campaign.insertCampaign', $campaign_vo);
	}

	function update_campaign($campaign_vo) {
		return $this->fpbatis->doUpdate('campaign.updateCampaign', $campaign_vo);
	}

	function count_campaign_list($params) {
		return $this->fpbatis->doSelectOne('campaign.countCampaignList', $params);
	}

	function select_campaign_list($params) {
		return $this->fpbatis->doSelectList('campaign.selectCampaignList', $params);
	}

	function select_campaign($params) {
		return $this->fpbatis->doSelectOne('campaign.selectCampaignList', $params);
	}

	function delete_campaign($campaign_sq) {
		return $this->fpbatis->doDelete('campaign.deleteCampaign', $campaign_sq);
	}

	function update_campaign_summary($campaign_sq) {
		return $this->fpbatis->doUpdate('campaign.updateCampaignSummary', $campaign_sq);
	}
	
	function insert_history($history_array) {
		return $this->fpbatis->doInsert('campaign.insertHistory', $history_array);
	}
	
	function delete_history($campaign_history_sq) {
		return $this->fpbatis->doDelete('campaign.deleteHistory', $campaign_history_sq);
	}

	function count_history_list($params) {
		return $this->fpbatis->doSelectOne('campaign.countHistoryList', $params);
	}

	function select_history_list($params) {
		return $this->fpbatis->doSelectList('campaign.selectHistoryList', $params);
	}

	function update_history($history_vo) {
		return $this->fpbatis->doUpdate('campaign.updateHistory', $history_vo);
	}
}

/* End of file campaign_model.php */
/* Location: ./application/admin/models/campaign/campaign_model.php */