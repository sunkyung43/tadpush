<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PcpMediaReport extends MY_Controller
{
	/**
	 * @var PcpMediaReport_model
	 */
	public $PcpMediaReport_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/report/pcpMediaReport_model');
		
		$this->load_vo('report/report_vo');
	}

	function index_get()
	{
		$vars = array();
		
		$cur_page			= $this->get('cur_page') ? $this->get('cur_page') : 1;
		$per_page			= $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page');
		$num_links 			= $this->config->item('list_num_links'); // 페이지 수

		$type = $this->get('type') ? $this->get('type') : '';
		
		$vars = $querystring = $this->_get_list_request_data();

		$vars['status_type_selectbox'] = $this->get_status_type_selectbox($querystring['status_type'], '전체');
		$vars['platform_selectbox'] = $this->get_platform_selectbox($querystring['platform_type'], '전체');
		$vars['search_type_selectbox'] = $this->get_search_type_selectbox($querystring['search_type'], '전체');

		// 카테고리													
		$category_array = $this->common_model->select_code_list($this->lang->line('media_category_ent'));
		$vars['category_selectbox'] = $this->ui_component->create_selectbox('category_cd', $category_array, $querystring['category_cd'], '전체', '');
		
		// 미디어
		$media_array = $this->pcpMediaReport_model->get_media_name_list();
		$vars['media_name_selectbox'] = $this->ui_component->create_selectbox('media_nm', $media_array, $querystring['media_nm'], '선택', FALSE);
		
		$params = array('searchStartDate' => $querystring['searchStartDate'],
						'searchEndDate' => $querystring['searchEndDate'],
						'search_type' => $querystring['search_type'],
						'search_value' => $querystring['search_value'],
						'status_type' => $querystring['status_type'],
						'category_cd' => $querystring['category_cd'],
						'platform_type' => $querystring['platform_type']);
		
		list($vars['total_rows'], $vars['list']) = $this->pcpMediaReport_model->select_mediaReport_list($params, $cur_page, $per_page);
		
		$config['base_url'] = '/report/pcpMediaReport';
		$config['total_rows'] 				= $vars['total_rows'];
		$config['cur_page']					= $cur_page;
		$config['per_page']					= $per_page;
		$config['num_links']				= $num_links;
		
		$this->paging->init($config);
		
		$vars['paging'] 					= $this->paging->create_page();
		$vars['paging_volume'] 				= $this->paging->create_page_volume($per_page);
		
		if($type == 'popup'){
			$this->layout = 'popup';
		} 
		$this->yield = true;
		$this->yield_js = array('/web/js/report/mediaReport_list.js');
		$this->load->view('report/media/mediaReport_list_view', $vars);
	}

	function list_excel_get() {
		$querystring = $this->_get_list_request_data();
	
		$params = array (
				'searchStartDate' => $querystring['searchStartDate'],
				'searchEndDate' => $querystring['searchEndDate'],
				'search_type' => $querystring['search_type'],
				'search_value' => $querystring['search_value'],
				'status_type' => $querystring['status_type'],
				'category_cd' => $querystring['category_cd'],
				'platform_type' => $querystring['platform_type']
		);
	
		list($total_rows, $excel_data) = $this->pcpMediaReport_model->select_mediaReport_list($params);
	
		$column_list = array (
				'No' => 'row_num',
				'등록일' => 'create_dt',
				'미디어 명' => 'media_nm',
				'APP ID' => 'media_key',
				'플랫폼' => 'media_os_nm',
				'카테고리' => 'media_category_nm',
				'상태' => 'media_status_nm',
				'시도' => 'request_cnt',
				'성공' => 'success_cnt',
				'성공률' => 'success_per',
				'Click' => 'tot_click',
				'CTR' => 'ctr_cnt'
		);
	
		$this->load->library('excel');
		$this->excel->export_excel('mediaReport_list.xls', 'list', $column_list, $excel_data);
	}
		
	function detail_get()
	{
		$media_id = $this->get('media_id') ? $this->get('media_id') : '';
		$report_type = $this->get('report_type') ? $this->get('report_type') : 'campaign';
		$type = $this->get('type') ? $this->get('type') : '';
		
		$cur_page			= $this->get('cur_page') ? $this->get('cur_page') : 1;
		$per_page			= $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page');
		$num_links 			= $this->config->item('list_num_links'); // 페이지 수
		
		if($media_id == '')
		{
			redirect('/report/pcpMediaReport');
			return;
		}
		
		$vars = $querystring = $this->_get_list_request_data();
		
		$params = array('searchStartDate' => $querystring['searchStartDate'],
						'searchEndDate' => $querystring['searchEndDate'],
						'media_id' => $media_id,
						'report_type' => $report_type);
		
		$vars['report_type_selectbox'] = $this->get_report_type_selectbox($report_type);
		
		$vars['media_vo'] = $this->pcpMediaReport_model->select_media_detail($params);
		
		$vars['total'] = $this->pcpMediaReport_model->select_total_campaign($params);
		
		list($vars['total_rows'], $vars['campaign_vo']) = $this->pcpMediaReport_model->select_campaign_list($params, $cur_page, $per_page);
		
		if($vars['campaign_vo'] != null){
			
			foreach ($vars['campaign_vo'] as $row)
			{
				$chart_data['division_dt'][] = $row->get_division_dt();
				$chart_data['ad_nm'][] = $row->get_ad_nm();
				$chart_data['campaign_nm'][] = $row->get_campaign_nm();
				$chart_data['request_cnt'][] = $row->get_request_cnt();
				$chart_data['success_cnt'][] = $row->get_success_cnt();
				$chart_data['success_per'][] = $row->get_success_per();
				$chart_data['tot_click'][] = $row->get_tot_click();
				$chart_data['ctr_cnt'][] = $row->get_ctr_cnt();
			}
			
			$vars['division_dt'] 	= json_encode($chart_data['division_dt'],JSON_NUMERIC_CHECK);
			$vars['ad_nm']			= json_encode($chart_data['ad_nm'],JSON_NUMERIC_CHECK);
			$vars['campaign_nm'] 	= json_encode($chart_data['campaign_nm'],JSON_NUMERIC_CHECK);
			$vars['request_cnt'] 	= json_encode($chart_data['request_cnt'],JSON_NUMERIC_CHECK);
			$vars['success_cnt'] 	= json_encode($chart_data['success_cnt'],JSON_NUMERIC_CHECK);
			$vars['success_per'] 	= json_encode($chart_data['success_per'],JSON_NUMERIC_CHECK);
			$vars['tot_click'] 		= json_encode($chart_data['tot_click'],JSON_NUMERIC_CHECK);
			$vars['ctr_cnt'] 		= json_encode($chart_data['ctr_cnt'],JSON_NUMERIC_CHECK);
			$vars['report_type'] 	= $report_type;
	
			unset($chart_data);
		
		}else{
			$vars['division_dt'] = "";
			$vars['ad_nm'] = "";
			$vars['campaign_nm'] = "";
			$vars['request_cnt'] = "";
			$vars['success_cnt'] = "";
			$vars['success_per'] = "";
			$vars['tot_click'] = "";
			$vars['ctr_cnt'] = "";
			$vars['report_type'] = $report_type;
		}
		
		$config['total_rows'] 				= $vars['total_rows'];
		$config['cur_page']					= $cur_page;
		$config['per_page']					= $per_page;
		$config['num_links']				= $num_links;
		
		$this->paging->init($config);
		
		$vars['paging'] 					= $this->paging->create_page();
		
		$this->yield = true;
		
		if($type == 'popup'){
			$this->layout = 'popup';
		} 
		$this->yield_js = array('/web/js/report/mediaReport_detail.js', '/web/js/common/highcharts.js');
		$this->load->view('report/media/mediaReport_detail_view', $vars);
	}

	function detail_excel_get() {
		
		$media_id = $this->get('media_id') ? $this->get('media_id') : '';
		$report_type = $this->get('report_type') ? $this->get('report_type') : 'campaign';
	
		$querystring = $this->_get_list_request_data();
	
		$params = array (
					'searchStartDate' => $querystring['searchStartDate'],
					'searchEndDate' => $querystring['searchEndDate'],
					'media_id' => $media_id,
					'report_type' => $report_type
		);
	
		list($total_rows, $excel_data) = $this->pcpMediaReport_model->select_campaign_list($params);
	
		if($report_type == 'campaign') {
			$column_list = array (
					'캠페인' => 'campaign_nm',
					'광고' => 'ad_nm',
					'시도 건수' => 'request_cnt',
					'성공 건수' => 'success_cnt',
					'성공률' => 'success_per',
					'클릭수' => 'tot_click',
					'CTR' => 'ctr_cnt'
			);
		} else if($report_type == 'month' || $report_type == 'daily') {
			if ($report_type == 'month') {
				$report_value = '월';
			} else if ($report_type == 'daily') {
				$report_value = '일';
			}
	
			$column_list = array (
					$report_value => 'division_dt',
					'시도 건수' => 'request_cnt',
					'성공 건수' => 'success_cnt',
					'성공률' => 'success_per',
					'클릭수' => 'tot_click',
					'CTR' => 'ctr_cnt',
			);
		}
		$this->load->library('excel');
		$this->excel->export_excel('mediaReport_detail.xls', 'list', $column_list, $excel_data);
	}
		
	function get_status_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array(
				$this->lang->line('media_status_cd_enable') => $this->pcpMediaReport_model->get_status_name($this->lang->line('media_status_cd_enable')),
				$this->lang->line('media_status_cd_disable') => $this->pcpMediaReport_model->get_status_name($this->lang->line('media_status_cd_disable')));
		return $this->ui_component->create_selectbox('status_type', $option_array, $selected_value, $default_value);
	}
	
	function get_platform_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array(
				$this->lang->line('os_android') => 'Android',
				$this->lang->line('os_ios') => 'iOS' );
		return $this->ui_component->create_selectbox('platform_type', $option_array, $selected_value, $default_value);
	}
	
	function get_search_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array('media_nm' => '미디어 명', 'app_id' => 'APP ID');
		return $this->ui_component->create_selectbox('search_type', $option_array, $selected_value, $default_value);
	}
	
	function get_report_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array('campaign' => '캠페인 리포트', 'month' => '월별 리포트', 'daily' => '일별 리포트');
		return $this->ui_component->create_selectbox('report_type', $option_array, $selected_value, $default_value);
	}
	
	private function _get_list_request_data()
	{
		$querystring = array();
	
		$querystring['searchStartDate'] 	= $this->get('searchStartDate') ? $this->get('searchStartDate') : '';
		$querystring['searchEndDate'] 	= $this->get('searchEndDate') ? $this->get('searchEndDate') : '';
		$querystring['search_type']	 		= $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value']	 	= $this->get('searchValue') ? $this->get('searchValue') : '';
		$querystring['status_type'] 		= $this->get('status_type') ? $this->get('status_type') : '';
		$querystring['platform_type'] 		= $this->get('platform_type') ? $this->get('platform_type') : '';
		$querystring['category_cd'] 		= $this->get('category_cd') ? $this->get('category_cd') : '';
		$querystring['media_nm']			= $this->get('media_nm') ? $this->get('media_nm') : '';
		
		return $querystring;
	}
	
}


/* End of file pcpMediaReport.php */
/* Location: ./application/admin/controllers/report/pcpMediaReport.php */
