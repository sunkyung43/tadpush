<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediaGroup_vo
{
	private $media_group_id;
	private $media_group_nm;
	private $media_group_desc;
	private $media_cnt;
	private $create_dt;
	private $update_dt;
	
	private $media_group_mapping_sq;
	private $media_id;
	private $media_nm;
	
	private $create_account_sq;
	private $update_account_sq;

	
	function __construct() {
	}
	
	public function get_media_group_id()
	{
	    return $this->media_group_id;
	}

	public function set_media_group_id($media_group_id)
	{
	    $this->media_group_id = $media_group_id;
	}

	public function get_media_group_nm()
	{
	    return $this->media_group_nm;
	}

	public function set_media_group_nm($media_group_nm)
	{
	    $this->media_group_nm = $media_group_nm;
	}

	public function get_media_group_desc()
	{
	    return $this->media_group_desc;
	}

	public function set_media_group_desc($media_group_desc)
	{
	    $this->media_group_desc = $media_group_desc;
	}

	public function get_media_cnt()
	{
	    return $this->media_cnt;
	}

	public function set_media_cnt($media_cnt)
	{
	    $this->media_cnt = $media_cnt;
	}

	public function get_create_dt()
	{
	    return $this->create_dt;
	}

	public function set_create_dt($create_dt)
	{
	    $this->create_dt = $create_dt;
	}
	
	public function get_update_dt()
	{
		return $this->update_dt;
	}
	
	public function set_update_dt($update_dt)
	{
		$this->update_dt = $update_dt;
	}
	
	public function get_media_group_mapping_sq()
	{
		return $this->media_group_mapping_sq;
	}
	
	public function set_media_group_mapping_sq($media_group_mapping_sq)
	{
		$this->media_group_mapping_sq = $media_group_mapping_sq;
	}
	
	public function get_media_id()
	{
		return $this->media_id;
	}
	
	public function set_media_id($media_id)
	{
		$this->media_id = $media_id;
	}
	
	public function get_media_nm()
	{
		return $this->media_nm;
	}
	
	public function set_media_nm($media_nm)
	{
		$this->media_nm = $media_nm;
	}
	
	public function get_create_account_sq()
	{
		return $this->create_account_sq;
	}
	
	public function set_create_account_sq($create_account_sq)
	{
		$this->create_account_sq = $create_account_sq;
	}
	
	public function get_update_account_sq()
	{
		return $this->update_account_sq;
	}
	
	public function set_update_account_sq($update_account_sq)
	{
		$this->update_account_sq = $update_account_sq;
	}
	
}

/* End of file mediaGroup_vo.php */
/* Location: ./application/admin/vo/system/mediaGroup_vo.php */