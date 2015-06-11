<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends MY_Controller
{
	/**
	 * @var Media_model
	 */
	public $media_model;

	/**
	 * @var Target_MediaGroup_model
	 */
	public $target_mediaGroup_model;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('/media/media_model');
		$this->load->model('/system/target_mediaGroup_model');
		$this->load_vo('media/media_vo');
		$this->load_vo('system/mediaGroup_vo');
	}

	function index_get()
	{
		$vars = array();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$querystring['media_status_cd'] = $this->get('media_status_cd') ? $this->get('media_status_cd') : '';
		$querystring['flatform_cd'] = $this->get('flatform_cd') ? $this->get('flatform_cd') : '';
		$querystring['media_category_cd'] = $this->get('media_category_cd') ? $this->get('media_category_cd') : '';
		$querystring['search_type'] = $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value'] = $this->get('search_value') ? $this->get('search_value') : '';
		
		$vars = $querystring;
		// 미디어 상태 selectbox
		$media_status_list = array (
				$this->lang->line('media_status_cd_enable') => '활성',
				$this->lang->line('media_status_cd_disable') => '비활성'
		);
		$vars['media_status_selectbox'] = $this->ui_component->create_selectbox('media_status_cd', $media_status_list, $querystring['media_status_cd'], '전체', '', 'class=mg_r10');
		
		// 플랫폼 selectbox
		$flatform_list = array (
				$this->lang->line('os_android') => 'Android',
				$this->lang->line('os_ios') => 'iOS'
		);
		$vars['flatform_selectbox'] = $this->ui_component->create_selectbox('flatform_cd', $flatform_list, $querystring['flatform_cd'], '전체', '', 'class=mg_r10');
		
		// category
		$category_list = $this->common_model->select_code_list($this->lang->line('media_category_ent'));
		$vars['category_selectbox'] = $this->ui_component->create_selectbox('media_category_cd', $category_list, $querystring['media_category_cd'], '전체', '', 'class=mg_r10');
		
		//search_type
		$search_type_list = array(
			'media_nm' => '미디어 명',
			'media_key' => 'APP ID'
		);
		$vars['search_type_selectbox'] = $this->ui_component->create_selectbox('search_type', $search_type_list, $querystring['search_type'], '전체', '', 'class=mg_r10');
		// 리스트 조회
		$params = array (
				'media_status_cd' => $querystring['media_status_cd'],
				'flatform_cd' => $querystring['flatform_cd'],
				'media_category_cd' => $querystring['media_category_cd'],
				'search_type' => $querystring['search_type'],
				'search_value' => $querystring['search_value'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$vars['list'] = $this->media_model->select_media_list($params);
		$vars['total_rows'] = $this->media_model->count_media_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/media/media';
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
		
		$vars['excel_url'] = '/media/media/excel?' . $_SERVER['QUERY_STRING'];
		$this->yield = true;
		$this->yield_js = '/web/js/media/media_list.js';
		$this->load->view('media/media_list_view', $vars);
	}
	
	function index_put()
	{
		$param_array = $this->put();
		$media_id = $param_array['select_media_id'];
		$media_status_cd = $this->lang->line('media_status_cd_delete');
		$update_account_sq = $this->session->userdata('ACCOUNT_SQ');
		$query = array(
			'media_id' 			=> $media_id,
			'media_status_cd' 	=> $media_status_cd,
			'update_account_sq' => $update_account_sq
		);
		// DB 트랜잭션 시작
		$this->media_model->trans_start();
		//상태 업데이트
		$this->media_model->delete_media_info($query);
		//미디어그룹 삭제
		
		$this->target_mediaGroup_model->delete_media_mapping($query);
		
		if ($this->media_model->trans_status() === FALSE) {
			$this->media_model->trans_rollback();
			echo json_encode(array (
					'response_type' => 'false',
					'response_data' => 'DB 등록에 실패하였습니다.'
			));
			return;
		}
		
		// isf 연동
		$isf_response = $this->isf->media('PUT', $media_id);
		if ($isf_response !== TRUE) {
			$this->media_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 매체 삭제에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->media_model->trans_complete();
		
		echo json_encode(array (
				'response_type' => 'success',
				'response_data' => '/media/media'
		));
	}
	
	function excel_get()
	{
		$this->load->library('excel');
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$querystring['media_status_cd'] = $this->get('media_status_cd') ? $this->get('media_status_cd') : '';
		$querystring['flatform_cd'] = $this->get('flatform_cd') ? $this->get('flatform_cd') : '';
		$querystring['media_category_cd'] = $this->get('media_category_cd') ? $this->get('media_category_cd') : '';
		$querystring['search_type'] = $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value'] = $this->get('search_value') ? $this->get('search_value') : '';
		
		// 리스트 조회
		$params = array (
				'media_status_cd' => $querystring['media_status_cd'],
				'flatform_cd' => $querystring['flatform_cd'],
				'media_category_cd' => $querystring['media_category_cd'],
				'search_type' => $querystring['search_type'],
				'search_value' => $querystring['search_value'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$list = $this->media_model->select_media_list($params);
		$column_list = array (
				'No' => 'media_id',
				'등록일' => 'create_dt',
				'미디어' => 'media_nm',
				'APP ID' => 'media_id',
				'플랫폼' => 'os_nm',
				'카테고리' => 'media_category_nm',
				'상태' => 'media_status_nm',
				'최종 수정일' => 'update_dt'
		);
		
		$this->excel->export_excel('media_list.xls', 'media', $column_list, $list);
	}
	
	function detail_get()
	{
		$vars = array();
		$vars['media'] = new Media_vo();
		$media_id = $this->get('media_id') ? $this->get('media_id') : '';
		$vars['type'] = $type = $this->get('type')? $this->get('type') : 'write';
		$vars['isPopup'] = $popupYN = $this->get('popupYN')? $this->get('popupYN') : 'N';
		if($media_id != "")
		{
			$vars['media'] = $this->media_model->select_media_detail_info(array('media_id'=> $media_id));
		}
		//삼태
		$media_status_list = array (
				$this->lang->line('media_status_cd_enable') => '활성',
				$this->lang->line('media_status_cd_disable') => '비활성'
		);
		$vars['media_status_selectbox'] = $this->ui_component->create_selectbox('media_status_cd', $media_status_list, $vars['media']->get_media_status_cd(), '', '', 'class=mg_r10');
		
		// 플랫폼 selectbox
		$flatform_list = array (
				$this->lang->line('os_android') => 'Android'
		);
		$vars['flatform_selectbox'] = $this->ui_component->create_selectbox('flatform_cd', $flatform_list, $vars['media']->get_os_cd(), '', '', 'class=mg_r10');
		
		// category
		$category_list = $this->common_model->select_code_list($this->lang->line('media_category_ent'));
		$vars['category_selectbox'] = $this->ui_component->create_selectbox('category_cd', $category_list, $vars['media']->get_media_category_cd(), '', '', 'class=mg_r10');
		
		//Media_Group_id
		$vars['used_media_group_list'] = $this->media_model->select_used_media_group(array('type'=>$type, 'media_id'=>$media_id));
		
		$this->yield = true;
		if($popupYN == 'Y')
		{
			$this->layout = 'popup';		
		}
		$this->yield_js = '/web/js/media/media_detail.js';
		$this->load->view('media/media_write_view', $vars);
	} 
	
	function detail_popup_get()
	{
		$vars = array();
		$vars['media'] = new Media_vo();
		$media_id = $this->get('media_id') ? $this->get('media_id') : '';
		$vars['type'] = $type = $this->get('type')? $this->get('type') : 'write';
		if($media_id != "")
		{
			$vars['media'] = $this->media_model->select_media_detail_info(array('media_id'=> $media_id));
		}
		//삼태
		$media_status_list = array (
				$this->lang->line('media_status_cd_enable') => '활성',
				$this->lang->line('media_status_cd_disable') => '비활성'
		);
		$vars['media_status_selectbox'] = $this->ui_component->create_selectbox('media_status_cd', $media_status_list, $vars['media']->get_media_status_cd(), '', '', 'class=mg_r10');
		
		// 플랫폼 selectbox
		$flatform_list = array (
				$this->lang->line('os_android') => 'Android'
		);
		$vars['flatform_selectbox'] = $this->ui_component->create_selectbox('flatform_cd', $flatform_list, $vars['media']->get_os_cd(), '', '', 'class=mg_r10');
		
		// category
		$category_list = $this->common_model->select_code_list($this->lang->line('media_category_ent'));
		$vars['category_selectbox'] = $this->ui_component->create_selectbox('category_cd', $category_list, $vars['media']->get_media_category_cd(), '', '', 'class=mg_r10');
		
		//Media_Group_id
		$vars['used_media_group_list'] = $this->media_model->select_used_media_group(array('type'=>$type, 'media_id'=>$media_id));
		
		$this->yield = false;
		$this->yield_js = '/web/js/media/media_detail.js';
		$this->load->view('media/media_write_view', $vars);
	}
	

	function write_post()
	{
		$param_array = $this->post();
		$query_data = $this->_make_query_data($param_array);
		//pp연동
		$response = $this->_push_linkage($query_data);
		//db저장
		$query_data->set_media_id($response['app_id']);
		$query_data->set_media_key($response['app_key']);
		$query_data->set_media_secret($response['app_secret']);
		$query_data->set_auth_param(base64_encode($response['app_key'].":".$response['app_secret']));
		
		// DB 트랜잭션 시작
		$this->media_model->trans_start();
		$this->media_model->insert_media_info($query_data);
		//미디어 그룹 추가

		if($query_data->get_media_group_ids() != null)
		{
			$media_group_data = new MediaGroup_vo();
			$media_group_data->set_media_id($query_data->get_media_id());
			$media_group_data->set_create_account_sq($this->session->userdata('ACCOUNT_SQ'));
			$media_group_data->set_update_account_sq($this->session->userdata('ACCOUNT_SQ'));
			
			foreach ($query_data->get_media_group_ids() as $row)
			{
				$media_group_data->set_media_group_id($row);
				$this->target_mediaGroup_model->insert_media_mapping_info($media_group_data);
			}
		}
		if ($this->media_model->trans_status() === FALSE) {
			$this->media_model->trans_rollback();
			echo json_encode(array (
					'response_type' => 'false',
					'response_data' => 'DB 등록에 실패하였습니다.'
			));
			return;
		}
		
		// isf 연동
		$isf_response = $this->isf->media('POST', $query_data->get_media_id());
		if ($isf_response !== TRUE) {
			$this->media_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 매체 등록에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->media_model->trans_complete();
		
		echo json_encode(array (
				'response_type' => 'success',
				'response_data' => '/media/media/detail?type=detail&media_id='.$response['app_id']
		));
	}
	
	function write_put()
	{
		$param_array = $this->put();
		$query_data = $this->_make_query_data($param_array);
		if($param_array != null)
		{
			if($param_array['before_media_nm'] != $param_array['media_nm'])
			{
				$history_datas[] = $this->_make_history_data($param_array, $param_array['before_media_nm'], $param_array['media_nm'], '미디어 명');
			}
			if($param_array['before_status'] != $param_array['media_status_cd'])
			{
				$history_datas[] = $this->_make_history_data($param_array, $param_array['before_status'], $param_array['media_status_cd'], '상태');
			}
			if($param_array['before_os_cd'] != $param_array['flatform_cd'])
			{
				$history_datas[] = $this->_make_history_data($param_array, $param_array['before_os_cd'], $param_array['flatform_cd'], '플랫폼');
			}
			if($param_array['before_category'] != $param_array['category_cd'])
			{
				$history_datas[] = $this->_make_history_data($param_array, $param_array['before_category'], $param_array['category_cd'], '카테고리');
			}
			if($param_array['before_group_ids'] != $param_array['after_group_ids'])
			{
				$history_datas[] = $this->_make_history_data($param_array, $param_array['before_group_ids'], $param_array['after_group_ids'], '그룹 설정');
			}
			if($param_array['before_media_desc'] != $param_array['media_desc'])
			{
				$history_datas[] = $this->_make_history_data($param_array, $param_array['before_media_desc'], $param_array['media_desc'], '비고');
			}
		}
		
		$query_data->set_media_id($param_array['media_id']);
		//db저장
		// DB 트랜잭션 시작
		$this->media_model->trans_start();
		
		$this->media_model->update_media_info($query_data);
		if(isset($history_datas))
		{
			foreach ($history_datas as $data)
			{
				$this->media_model->insert_media_history_info($data);
			}
		}
		//미디어 그룹 추가
		if($param_array['before_group_ids'] != $param_array['after_group_ids'])
		{
			if($param_array['before_group_ids'] != "")
			{
				$this->target_mediaGroup_model->delete_media_mapping(array('media_id' => $query_data->get_media_id()));
			}
			foreach ($query_data->get_media_group_ids() as $group_id)
			{
				/* VALUES (#media_group_id#, #media_id#, now(), now(), #create_account_sq#, #update_account_sq# ) */
				$query_data->set_media_group_id($group_id);
				$this->target_mediaGroup_model->insert_media_mapping_info($query_data);
			}
		}
		if ($this->media_model->trans_status() === FALSE) {
			$this->media_model->trans_rollback();
			echo json_encode(array (
					'response_type' => 'false',
					'response_data' => 'DB 등록에 실패하였습니다.'
			));
			return;
		}
		
		// isf 연동
		$isf_response = $this->isf->media('PUT', $param_array['media_id']);
		if ($isf_response !== TRUE) {
			$this->media_model->trans_rollback();
			$this->ajax_json_response(false, 'ISF 매체 수정에 실패하였습니다.'.$isf_response['err_msg']);
		}
		
		// DB 트랜잭션 종료
		$this->media_model->trans_complete();
		
		echo json_encode(array (
				'response_type' => 'success',
				'response_data' => '/media/media/detail?type=detail&media_id='.$param_array['media_id']
		));
	}
	
	function history_get()
	{
		$vars = array();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		$querystring['media_id'] = $media_id = $this->get('media_id');
		
		$params = array (
				'media_id' => $media_id,
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		
		$vars['list'] = $this->media_model->select_media_history_list($params);
		$vars['total_rows'] = $this->media_model->count_media_history_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/media/media/history';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $querystring;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		
		$this->yield = false;
		$this->load->view('media/media_history_popup', $vars);
	}
	
	private function  _make_history_data($param_array, $before, $after, $gb)
	{
		if($param_array != null)
		{
			$data = array(
						'media_id'		 	=> $param_array['media_id'],
						'account_sq'	 	=> $this->session->userdata('ACCOUNT_SQ'),
						'history_gb' 	 	=> $gb,
						'modify_before'		=> $before,
						'modify_after'		=> $after,
						'history_comment'	=> ""
				);
		}
		return $data;
	}
	
	
	private function  _make_query_data($param_array)
	{
		if($param_array != null)
		{
			$media_vo = new Media_vo();
			$media_vo->set_media_nm($param_array['media_nm']);
			$media_vo->set_os_cd($param_array['flatform_cd']);
			$media_vo->set_media_status_cd($param_array['media_status_cd']);
			$media_vo->set_media_category_cd($param_array['category_cd']);
			$media_vo->set_media_group_ids(isset($param_array['media_group_ids'])?$param_array['media_group_ids']:"");
			$media_vo->set_create_account_sq($this->session->userdata('ACCOUNT_SQ'));
			$media_vo->set_update_account_sq($this->session->userdata('ACCOUNT_SQ'));
			$media_vo->set_media_desc(isset($param_array['media_desc'])?$param_array['media_desc'] : "");
		}
		
		return $media_vo;
	}
	
	
	private function _push_linkage($form_array)
	{
		$url = $this->config->item('push_planet_url') .'/push/application';
		$auth = 'Authorization: PP_DASHBOARD ' .base64_encode($this->config->item('push_planet_id').':'.$this->config->item('push_planet_pwd'));
			
		$headers = array(
				'Content-Type: application/json', $auth
		);
		
		$query = array('name' => $form_array->get_media_nm() , 'description' => $form_array->get_media_desc() );
		$json_query = json_encode($query);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$json_query);
		$ch_result = curl_exec($ch);
		$info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ch_result_error = curl_errno($ch);
		$chleaderrmsg = curl_error($ch);
		curl_close($ch);
		
		if($info != 200)
		{
			$this->response(array('response_type' => 'fail', 'response_data' => 'pp연동에 실패했습니다. '));
		}
		else
		{
			return json_decode($ch_result, true);
		}
	}
}

/* End of file media.php */
/* Location: ./application/admin/controllers/media/media.php */