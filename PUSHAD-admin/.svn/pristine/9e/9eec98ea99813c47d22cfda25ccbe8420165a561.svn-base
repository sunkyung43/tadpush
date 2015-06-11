<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Test_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function update_advert_start_dt($ad_sq, $start_dt) {
		if ($ad_sq == '' || $start_dt == '') {
			return;
		}
		
		$this->db->set('START_DT', $start_dt);
		$this->db->set('UPDATE_DT', 'now()', FALSE);
		$this->db->set('UPDATE_ACCOUNT_SQ', $this->session->userdata('ACCOUNT_SQ'));
		$this->db->where('AD_SQ', $ad_sq);
		$this->db->update('PS_SVC_AD');
	}

	function insert_campaign_history($history_array) {
		return $this->fpbatis->doInsert('campaign.insertHistory', $history_array);
	}
	
	function update_campaign_summary($campaign_sq) {
		return $this->fpbatis->doUpdate('campaign.updateCampaignSummary', $campaign_sq);
	}
}

/* End of file test_model.php */
/* Location: ./application/admin/models/test/test_model.php */