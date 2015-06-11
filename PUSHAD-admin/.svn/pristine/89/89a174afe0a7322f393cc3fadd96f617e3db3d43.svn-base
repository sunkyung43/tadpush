<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Target extends MY_Controller {
	
	/**
	 *
	 * @var Target_MediaGroup_model
	 */
	public $target_mediaGroup_model;
	
	/**
	 *
	 * @var Device_model
	 */
	public $device_model;
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( '/system/target_mediaGroup_model' );
		$this->load->model ( '/system/device_model' );
		$this->load->model('/media/media_model');
		$this->load_vo ( 'media/media_vo' );
		$this->load_vo ( 'system/mediaGroup_vo' );
		$this->load_vo ( 'system/device_vo' );
	}
	
	function index_get() {
		redirect ( '/system/target/mediaGroup' );
	}
	
	function mediaGroup_get() {
		$vars = array ();
		$cur_page = $this->get ( 'cur_page' ) ? $this->get ( 'cur_page' ) : 1; // 현재 페이지
		$num_links = $this->config->item ( 'list_num_links' ); // 페이지 수
		$per_page = $this->get ( 'per_page' ) ? $this->get ( 'per_page' ) : 15; // 페이지당 출력 게시글수
		
		$vars ['paging_volume'] = $this->paging->create_page_volume ( $per_page, array (
				15 
		) );
		
		$params = array (
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page 
		);
		$vars ['list'] = $this->target_mediaGroup_model->selectGroupList ( $params );
		$vars['total_rows'] = $this->target_mediaGroup_model->count_group_list($params);
		
		
		$action = array('delete' => '삭제', 'excel' => '엑셀다운로드');
		$vars['action_selectbox'] = $this->ui_component->create_selectbox ( 'action_value', $action, '', '선택', '', 'class=mg_r10' );
		
		// 페이징 처리
		$config['base_url'] = '/system/target/mediaGroup';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		$vars['paging_volume'] = $this->paging->create_page_volume($per_page, array (
				15
		));
		
		$this->yield = true;
		$this->yield_js = '/web/js/system/group_list.js';
		$this->load->view ( 'system/target/mediaGroup/mediaGroup_list_view', $vars );
	}
	
	function mediaGroup_write_get() {
		$vars = array ();
		$media_group_id = $this->get("media_group_id") ? $this->get("media_group_id") : "";
		$vars['type'] = $type = $this->get('type') ?  $this->get ( 'type' ) : 'write';
		$vars['createYN'] = $this->get('createYN') ? $this->get('createYN') : '';
		
		$vars['media_group_desc'] = "";
		$media_group_nm = '';
		$query = array('media_group_id' => $media_group_id);
		if($type == 'detail')
		{
		 	$vars['info'] = $mapping_info = $this->target_mediaGroup_model->selectMappingInfo($query); 
			$vars['list'] = $media_list = $this->target_mediaGroup_model->selectMappingDetailInfo($query);
		
			$vars['media_group_desc'] = $mapping_info->get_media_group_desc();
			$media_group_nm = $mapping_info->get_media_group_nm();
			$group_list = array(
					$media_group_id => $media_group_nm
			);
			$vars['groupList_selectbox'] = $this->ui_component->create_selectbox ( 'media_group_id', $group_list, $media_group_id, '', '', 'class=mg_r10' );
		}
		else
		{
			$group_list = $this->target_mediaGroup_model->selectUnusedGroupList ();
			$vars['groupList_selectbox'] = $this->ui_component->create_selectbox ( 'media_group_id', $group_list, '', '선택해주세요', '', 'class=mg_r10' );
			
		} 
		$this->yield = true;
		$this->yield_js = '/web/js/system/group_write.js';
		$this->load->view ( 'system/target/mediaGroup/mediaGroup_detail_view', $vars );
	}
	
	function mediaGroup_write_post() {
		$param_array = $this->post ();
		$param_array ['update_account_sq'] = $this->session->userdata ( 'ACCOUNT_SQ' );
		$result = $this->_insert_media_info($param_array);
		echo $result;
	}
	
	function _insert_media_info($param_array) {
		
		$result = array ();
		$media_ids = $param_array['media_name_cd'];
		if($media_ids != "")
		{
			$list = explode ( ',', $media_ids );
		}
		$media_group_id = $param_array['media_group_id'];

		// DB 트랜잭션 시작
		$this->target_mediaGroup_model->trans_start();
		
		// desc 업데이트
		$this->target_mediaGroup_model->update_media_group_desc ( $param_array );
		
		//기존매핑 정보
		$before_media_group_list = $this->target_mediaGroup_model->select_media_group_list(array('media_group_id' => $media_group_id));
		
		$chk = array();
		$after = array();
		foreach ($list as $id)
		{
			$val = $this->target_mediaGroup_model->select_media_group_Info(array('media_id' => $id));
			if($val != null)
			{
				$chk[$id] = $val;
			}
			else 
			{
				$chk[$id] = '';
			}
		}
		foreach ($before_media_group_list as $arr)
		{
			if(!isset($chk[$arr['media_id']])){
				$chk[$arr['media_id']] = $arr['media_group_list'];
			}
		}
		
		// 기존 매핑 삭제
		$this->target_mediaGroup_model->delete_media_mapping_info ( $param_array );
		
		//미디어 정보 insert
		foreach ( $list as $media_id ) 
		{
			$mediaGroup_vo = new MediaGroup_vo();
			$mediaGroup_vo->set_media_id($media_id);
			$mediaGroup_vo->set_media_group_id($media_group_id);
			$mediaGroup_vo->set_create_account_sq($this->session->userdata('ACCOUNT_SQ'));
			$mediaGroup_vo->set_update_account_sq($this->session->userdata('ACCOUNT_SQ'));
			
			if($param_array['type'] == 'detail')
			{
				$this->target_mediaGroup_model->insert_media_mapping_info($mediaGroup_vo);
			}
			else
			{
				$media_group_info = $this->target_mediaGroup_model->select_media_group_Info(array('media_id' => $media_id));
				$this->target_mediaGroup_model->insert_media_mapping_info($mediaGroup_vo);
				$after_media_group_info = $this->target_mediaGroup_model->select_media_group_Info(array('media_id' => $media_id));
				$data = $this->_make_history_data($media_id, $media_group_info, $after_media_group_info);
				
				$this->media_model->insert_media_history_info($data);
			}
		}
		unset($media_id);
		//히스토리 등록
		if($param_array['type'] == 'detail')
		{
			foreach ($chk as $name => $value)
			{
				$after_media_group_info = $this->target_mediaGroup_model->select_media_group_Info(array('media_id' => $name));
				if($after_media_group_info != $value)
				{
					$data = $this->_make_history_data($name, $value, $after_media_group_info);
					$this->media_model->insert_media_history_info($data);
				}
			}
		}			
		if ($this->target_mediaGroup_model->trans_status() === FALSE) {
			$this->target_mediaGroup_model->trans_rollback();
			$result = json_encode(array (
					'response_type' => 'false',
					'response_data' => 'DB 등록에 실패하였습니다..'
			));
			return $result;
		}
		
		// DB 트랜잭션 종료
		$this->target_mediaGroup_model->trans_complete();
		$result = json_encode(array (
				'response_type' => 'success',
				'response_data' => '/system/target/mediaGroup_write?type=detail&media_group_id='.$media_group_id
		));
		return $result;
	}
	
	function mediaGroup_delete_delete()
	{
		$param_array = $this->delete();
		
		$group_list = $this->target_mediaGroup_model->select_media_group_list(array('media_group_id' => $param_array['media_group_id']));
		//디비삭제
		$this->target_mediaGroup_model->trans_start();
		// 기존 매핑 삭제
		$this->target_mediaGroup_model->delete_media_mapping_info ( $param_array );
		
		//히스토리 등록
		foreach ($group_list as $media)
		{
			$after_media_group_info = $this->target_mediaGroup_model->select_media_group_Info(array('media_id' => $media['media_id']));
			$data = $this->_make_history_data($media['media_id'], $media['media_group_list'], $after_media_group_info);
			$this->media_model->insert_media_history_info($data);
		}
		
		if ($this->target_mediaGroup_model->trans_status() === FALSE) {
			$this->target_mediaGroup_model->trans_rollback();
			echo json_encode(array (
					'response_type' => 'false',
					'response_data' => 'DB 등록에 실패하였습니다..'
			));
		}
		// DB 트랜잭션 종료
		$this->target_mediaGroup_model->trans_complete();
		echo json_encode(array (
				'response_type' => 'success',
				'response_data' => '/system/target/mediaGroup'
		));
	}
	
	function mediaGroup_excel_get()
	{
		$this->load->library('excel');
		
		$media_group_id = $this->get("media_group_id");
		$query = array(
			'media_group_id' => $media_group_id
		);
		$media_list = $this->target_mediaGroup_model->selectMappingDetailInfo($query);
		$column_list = array (
				'미디어' => 'media_nm',
				'APP ID' => 'media_id'
		);
		$this->excel->export_excel('mediaGroup_list.xls', 'mediaGroup', $column_list, $media_list);
	}
	
	private function  _make_history_data($media_id, $before, $after)
	{
		if($media_id != null)
		{
			$data = array(
					'media_id'		 	=> $media_id,
					'account_sq'	 	=> $this->session->userdata('ACCOUNT_SQ'),
					'history_gb' 	 	=> '그룹설정',
					'modify_before'		=> $before,
					'modify_after'		=> $after,
					'history_comment'	=> ""
			);
		}
		return $data;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function device_get(){
		$vars = array();
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$vars['start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$vars['end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		if($start_dt != '')
		{
			$start_dt = str_replace('-', '', $start_dt);
			$start_dt = substr($start_dt, 0, 6);
		}
		if($end_dt != '')
		{
			$end_dt = str_replace('-', '', $end_dt);
			$end_dt = substr($end_dt, 0, 6);
		}
		
		
		$querystring['search_type'] = $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value'] = $this->get('search_value') ? $this->get('search_value') : '';
		
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'search_type' => $querystring['search_type'],
				'search_value' => $querystring['search_value'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		//search_type_selectbox
		$search_type_list = array (
				'device' => '단말명',
				'maker' => '제조사',
				'model' => '모델명',
				'device_type' => 'Device Type'
		);
		$vars['search_type_selectbox'] = $this->ui_component->create_selectbox('search_type', $search_type_list, $querystring['search_type'], '', '', 'class=mg_r10');
		
		$vars['list'] = $this->device_model->select_list($params);
		$vars['total_rows'] = $this->device_model->count_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/system/target/device';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $querystring;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		$vars['paging_volume'] = $this->paging->create_page_volume($per_page, array (
				15,
				30,
				50,
				100
		));
		$vars['excel_url'] = '/system/target/device_excel?' . $_SERVER['QUERY_STRING'];
		$this->yield = true;
		//$this->yield_js = '/web/js/campaign/campaign_list.js';
		$this->load->view('system/target/device/device_list_view', $vars);
	}
	
	function device_excel_get(){
		$this->load->library('excel');
		
		/* $cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수 */
		
		$querystring['start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		if($start_dt != '')
		{
			$start_dt = str_replace('-', '', $start_dt);
			$start_dt = substr($start_dt, 0, 6);
		}
		if($end_dt != '')
		{
			$end_dt = str_replace('-', '', $end_dt);
			$end_dt = substr($end_dt, 0, 6);
		}
		
		$querystring['search_type'] = $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value'] = $this->get('search_value') ? $this->get('search_value') : '';
		
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'search_type' => $querystring['search_type'],
				'search_value' => $querystring['search_value']
			/* 	,'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page */
		);
		
		$list = $this->device_model->select_list($params);
		
		$column_list = array (
				'No' => 'device_sq',
				'DeviceType' => 'device_type_nm',
				'제조사' => 'maker_nm',
				'단말(브랜드)명' => 'brand_nm',
				'모델명' => 'model_nm',
				'출시년월' => 'release_dt',
				'등록일' => 'create_dt'
		);
		
		$this->excel->export_excel('device_list.xls', 'device', $column_list, $list);
	}
	
	function device_detail_get(){
		$vars = array();
		$param = array('device_sq' => $device_sq = $this->get('device_sq'));		
		$vars['data'] = $this->device_model->select_device_detail($param);
		$this->yield = true;
		$this->load->view('system/target/device/device_detail_view', $vars);
	}
}

/* End of file target.php */
/* Location: ./application/admin/controllers/system/target/target.php */