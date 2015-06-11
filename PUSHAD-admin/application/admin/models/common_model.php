<?php

class Common_model extends MY_Model {

	function __construct() {
		parent::__construct();
	}

	function select_code_list($ent, $key_column = 'att') {
		$result = array ();
		
		$params = array('ent' => $ent, 'key_column' => $key_column);
		$row_array = $this->fpbatis->doSelectList('common.selectCodeList', $params);
		
		foreach ( $row_array as $row ) {
			$result[$row['key']] = $row['name'];
		}
		
		return $result;
	}

	function select_code_name($att)
	{
		return $this->fpbatis->doSelectOne('common.selectCodeName', $att);
	}
	
	function select_adv_company_list($params) {
		return $this->fpbatis->doSelectList('common.selectAdvCompanyList', $params);
	}

	function select_adv_brand_list($params) {
		return $this->fpbatis->doSelectList('common.selectAdvBrandList', $params);
	}
	
	function insert_report_account($params) {
		return $this->fpbatis->doInsert('common.insertReportAccount', $params);
	}
	
	function select_code_list_treeview($ent, $key_column = '', $ad_sq = FALSE, $target_element_cd = FALSE, $not_att = '') {
		$params = array ();
		$params['ent'] = $ent;
		$params['key_column'] = $key_column;
		$params['not_att'] = $not_att;
		if($ad_sq !== FALSE) {
			$params['ad_sq'] = $ad_sq;
			$params['target_element_cd'] = $target_element_cd;
		}
		return $this->fpbatis->doSelectList('common.selectCodeListTreeview', $params);
	}

	function select_device_model_list($device_model_list) {
		$result = array ();
		
		$row_array = $this->fpbatis->doSelectList('common.selectDeviceModelList', $device_model_list);
		
		foreach($row_array as $row)
		{
			$result[$row['mweb_model_nm']] = $row['mweb_model_nm'];
		}
		
		return $result;
	}
	
	function select_device_list_treeview($ad_sq, $target_element_cd) {
		$params = array (
				'ad_sq' => $ad_sq,
				'target_element_cd' => $target_element_cd 
		);
		
		return $this->fpbatis->doSelectList('common.selectDeviceListTreeview', $params);
	}

	function select_sido_list() {
		$result = array ();
		
		$row_array = $this->fpbatis->doSelectList('common.selectSidoList', '##');
		
		foreach ( $row_array as $row ) {
			$result[$row['sido_cd']] = $row['sido_nm'];
		}
		
		return $result;
	}

	function select_sigugun_list($sido_cd, $result_type = 'selectbox') {
		$result = array ();
		
		$row_array = $this->fpbatis->doSelectList('common.selectSigugunList', $sido_cd);
		
		if($result_type == 'selectbox') {
			foreach ( $row_array as $row ) {
				$result[$row['sigugun_cd']] = $row['sigugun_nm'];
			}
		} else if 	($result_type == 'target') {
			foreach ( $row_array as $row ) {
				$result[] = $row['sigugun_cd'];
			}
		}
			
		return $result;
	}

	function select_region_list($ad_sq) {
		$params = array (
				'ad_sq' => $ad_sq
		);
		
		return $this->fpbatis->doSelectList('common.selectRegionList', $params);
	}
	
	function select_search_region($params) {
		return $this->fpbatis->doSelectList('common.selectSearchRegion', $params);
	}

	function select_freezing(){
		return $this->fpbatis->doSelectOne('common.selectFreezing');
	}
	
	function select_frequency($params = array()) {
		return $this->fpbatis->doSelectOne('common.selectFrequency', $params);
	}
	
	function select_frequency_last_dt() {
		return $this->fpbatis->doSelectOne('common.selectFrequencyLastDt');
	}
	
	function count_param_list() {
		return $this->fpbatis->doSelectOne('common.countParamList');
	}
	
	function select_carrier_target_value($carrier_cd_list) {
		return $this->fpbatis->doSelectOne('common.selectCarrierTargetValue', $carrier_cd_list);
	}
	
	function select_push_target($mdn) {
		return $this->fpbatis->doSelectOne('common.selectPushTarget', $mdn);
	}
	
	function select_vendor_list($params) {
		return $this->fpbatis->doSelectList('common.selectVendorList', $params);
	}
}