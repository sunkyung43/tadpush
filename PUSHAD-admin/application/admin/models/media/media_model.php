<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function count_media_list($params)
	{
		return  $this->fpbatis->doSelectOne('media.countMediaList', $params);
	}
	
	function select_media_list($params)
	{
		return  $this->fpbatis->doSelectList('media.selectMediaList', $params);
	}

	function select_search_media($params)
	{
		return $this->fpbatis->doSelectList('media.selectSearchMedia', $params);
	}
	
	function select_target_media($ad_sq, $target_element_cd)
	{
		$params = array('ad_sq' => $ad_sq, 'target_element_cd' => $target_element_cd);
		return $this->fpbatis->doSelectList('media.selectTargetMedia', $params);
	}
	
	function select_media_group($ad_sq, $target_element_cd)
	{
		$params = array('ad_sq' => $ad_sq, 'target_element_cd' => $target_element_cd);
	
		return $this->fpbatis->doSelectList('media.selectMediaGroup', $params);
	}
	
	function select_media_name_list($media_name_list)
	{
		$result = array ();
		
		$row_array = $this->fpbatis->doSelectList('media.selectMediaNameList', $media_name_list);
		
		foreach($row_array as $row)
		{
			$result[$row['media_nm']] = $row;
		}
		
		return $result;
	}
	
	function select_used_media_group($media_id)
	{
		return $this->fpbatis->doSelectList("media.selectUsedMediaGroup", $media_id);
	}
	
	function select_media_detail_info($media_id)
	{
		return $this->fpbatis->doSelectOne("media.selectMediaDetailInfo", $media_id);
	}
	
	function insert_media_info($query_data){
		return $this->fpbatis->doInsert("media.insertMediaInfo", $query_data);
	}
	
	function insert_media_history_info($query_data){
		return $this->fpbatis->doInsert("media.insertMediaHistoryInfo", $query_data);
	}
	
	function update_media_info($query)
	{
		return $this->fpbatis->doUpdate("media.updateMediaInfo", $query);
	}
	
	function delete_media_info($query)
	{
		return $this->fpbatis->doUpdate("media.deleteMediaInfo", $query);
	}
	
	function select_media_history_list($params)
	{
		return $this->fpbatis->doSelectList("media.selectMediaHistory", $params);
	}
	
	function count_media_history_list($params)
	{
		return $this->fpbatis->doSelectOne("media.countMediaHistory", $params);
	}

	function select_media_group_target_value($media_group_cd_list) {
		return $this->fpbatis->doSelectOne('media.selectMediaGroupTargetValue', $media_group_cd_list);
	}
	
	function select_media_category_target_value($media_category_cd_list) {
		return $this->fpbatis->doSelectOne('media.selectMediaCategoryTargetValue', $media_category_cd_list);
	}
	
}
/* End of file media_model.php */
/* Location: ./application/admin/models/media/media_model.php */