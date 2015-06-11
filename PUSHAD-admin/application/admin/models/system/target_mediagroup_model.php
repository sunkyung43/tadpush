<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Target_MediaGroup_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function count_group_list($params)
	{
		return $this->fpbatis->doSelectOne('mediaGroup.countGroupList', $params);
	}
	
	function selectGroupList($params)
	{
		return $this->fpbatis->doSelectList('mediaGroup.selectGroupList', $params);
	}
	
	function selectUnusedGroupList()
	{
		$dataList = $this->fpbatis->doSelectList('mediaGroup.selectUnusedGroupList');
		
		foreach ( $dataList as $row ) {
			$result[$row['media_group_id']] = $row['media_group_nm'];
		}
		return $result;
	}
	
	function selectMappingInfo($media_group_id)
	{
		return $this->fpbatis->doSelectOne('mediaGroup.selectMappingInfo', $media_group_id);
	}
	
	function selectMappingDetailInfo($media_group_id)
	{
		return $this->fpbatis->doSelectList('mediaGroup.selectMappingDetailInfo', $media_group_id);
	}
	
	function update_media_group_desc($params)
	{
		$this->fpbatis->doUpdate('mediaGroup.updateMediaGroupInfo', $params);
	}
	
	function delete_media_mapping_info($params)
	{
		$this->fpbatis->doDelete('mediaGroup.deleteMediaGroupMapping', $params);
	}
	
	function insert_media_mapping_info($params)
	{
		$this->fpbatis->doInsert('mediaGroup.insertMediaGroupMapping', $params);
	}
	
	function delete_media_mapping($params)
	{
		$this->fpbatis->doDelete('mediaGroup.deleteMediaMapping', $params);
	}
	
	function select_media_group_list($params)
	{
		return $this->fpbatis->doSelectList('mediaGroup.mediaGroupList', $params);
	}
	
	function select_after_media_group_list($params)
	{
		return $this->fpbatis->doSelectList('mediaGroup.afterMediaGroupList', $params);
	}
	
	function select_media_group_Info($params)
	{
		return $this->fpbatis->doSelectOne('mediaGroup.mediaGroupInfo', $params);
	}
}

/* End of file target_mediaGroup_model.php */
/* Location: ./application/admin/models/system/target_mediaGroup_model */