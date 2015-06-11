<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Advert_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function insert_advert($advert_vo) {
		return $this->fpbatis->doInsert('advert.insertAdvert', $advert_vo);
	}

	function update_advert($advert_vo) {
		return $this->fpbatis->doUpdate('advert.updateAdvert', $advert_vo);
	}

	function select_advert_list($params) {
		return $this->fpbatis->doSelectList('advert.selectAdvertList', $params);
	}

	function count_advert_list($params) {
		return $this->fpbatis->doSelectOne('advert.countAdvertList', $params);
	}

	function select_advert($ad_sq, $freezing_time = '') {
		$params = array (
				'ad_sq' => $ad_sq 
		);
		if ($freezing_time != '') {
			$params['freezing_time'] = $freezing_time;
		}
		return $this->fpbatis->doSelectOne('advert.selectAdvertList', $params);
	}

	function select_target_info($ad_sq) {
		$result = array ();
		
		$params = array (
				'ad_sq' => $ad_sq 
		);
		
		$row_array = $this->fpbatis->doSelectList('advert.selectTargetInfo', $params);
		
		foreach ( $row_array as $row ) {
			$result[$row['target_element_cd']][] = $row['target_value'];
		}
		
		return $result;
	}

	function delete_target_info($params) {
		return $this->fpbatis->doDelete('advert.deleteTargetInfo', $params);
	}

	function insert_target_info($target_info) {
		return $this->fpbatis->doInsert('advert.insertTargetInfo', $target_info);
	}

	function select_advert_last_dt() {
		return $this->fpbatis->doSelectOne('advert.selectAdvertLastDt');
	}

}
/* End of file advert_model.php */
/* Location: ./application/admin/models/campaign/advert_model.php */