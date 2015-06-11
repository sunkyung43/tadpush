<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PcpCampaignReport extends MY_Controller
{
	/**
	 * @var PcpCampaignReport_model
	 */
	public $PcpCampaignReport_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/report/pcpCampaignReport_model');
		$this->load_vo('report/report_vo');
		$this->load->library('excel');
	}

	function index_get()
	{
		$vars = array();
		
		$cur_page	= $this->get('cur_page') ? $this->get('cur_page') : 1;
		$per_page	= $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page');
		$num_links = $this->config->item('list_num_links'); // 페이지 수 
		
		$vars = $querystring = $this->_get_list_request_data();
		
		$search_type = $querystring['search_type'] ? $querystring['search_type'] : '';
		$status_type = $querystring['status_type'] ? $querystring['status_type'] : '';
		
		$vars['search_type_selectbox'] = $this->get_search_type_selectbox($search_type, '전체');
		$vars['status_type_selectbox'] = $this->get_status_type_selectbox($status_type, '전체');
		
		$params = array('searchStartDate' => $querystring['searchStartDate'],
						'searchEndDate' => $querystring['searchEndDate'],
						'search_type' => $querystring['search_type'],
						'search_value' => $querystring['search_value'],
						'status_type' => $querystring['status_type']);
		
		list($vars['total_rows'], $vars['list']) = $this->pcpCampaignReport_model->select_campaignReport_list($params, $cur_page, $per_page);

		$config['base_url'] = '/report/pcpCampaignReport';
		$config['total_rows'] 				= $vars['total_rows'];
		$config['cur_page']					= $cur_page;
		$config['per_page']					= $per_page;
		$config['num_links']				= $num_links;
		$config['querystring_list']			= $querystring;
		
		$this->paging->init($config);
		
		$vars['paging'] 					= $this->paging->create_page();
		$vars['paging_volume'] 				= $this->paging->create_page_volume($per_page);
		
		$this->yield = true;
		$this->yield_js = array('/web/js/report/campaignReport_list.js');
		$this->load->view('report/campaign/campaignReport_list_view', $vars);

	}
	
	function list_excel_get()
	{
		$vars = $querystring = $this->_get_list_request_data();
		
		$params = array('searchStartDate' => $querystring['searchStartDate'],
						'searchEndDate' => $querystring['searchEndDate'],
						'search_type' => $querystring['search_type'],
						'search_value' => $querystring['search_value'],
						'status_type' => $querystring['status_type']);
		
		list($vars['total_rows'], $excel_data) = $this->pcpCampaignReport_model->select_campaignReport_list($params);
	
		$column_list = array (
				'No' => 'row_num',
				'캠페인 명' => 'campaign_nm',
				'광고주' => 'adv_company_nm',
				'브랜드' => 'adv_brand_nm',
				'시작일' => 'start_dt',
				'종료일' => 'end_dt',
				'목표건수' => 'tot_push_booking_cnt',
				'발송건수' => 'tot_request_cnt'
		);
		
		$this->excel->export_excel('campaign_list.xls', 'campaign', $column_list, $excel_data);
	}
	
	function detail_get()
	{
		$campaign_sq = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
		$type = $this->get('type') ? $this->get('type') : '';
		$report = $this->get('report') ? $this->get('report') : '';
		
		if($campaign_sq == '')
		{
			redirect('/report/pcpCampaignReport');
			return;
		}
		
		$vars = $querystring = $this->_get_list_request_data();
		
		$vars['report_type_selectbox'] = $this->get_report_type_selectbox($querystring['report_type']);
		$vars['ad_report_type_selectbox'] = $this->get_ad_report_type_selectbox($querystring['ad_report_type']);
		
		$ad_report_type = $querystring['ad_report_type'] ? $querystring['ad_report_type'] : 'media';
		
		if($this->input->get('searchStartDate') != null && $this->input->get('searchEndDate') == null)
		{
			if($report == 'daily'){
				list($year, $month) = explode(".",  $this->input->get('searchStartDate'));
				$querystring['searchStartDate'] = $query_string['searchStartDate'] = date('Y-m-d', mktime(0,0,0,$month,1,$year));
				$querystring['searchEndDate'] = $query_string['searchEndDate'] = date('Y-m-t', mktime(0,0,0,$month,1,$year));
				$vars['searchStartDate'] = $querystring['searchStartDate'];
				$vars['searchEndDate'] = $querystring['searchEndDate'];
			}else{
				$querystring['searchStartDate'] 	= $this->input->get('searchStartDate') ? $this->input->get('searchStartDate') : '';
				$querystring['searchEndDate'] 		= $this->input->get('searchEndDate') ? $this->input->get('searchEndDate') : '';
			}
		}else{
			if($report == 'daily'){
				list($year, $month) = explode(".",  $this->input->get('searchStartDate'));
				$querystring['searchStartDate'] = $query_string['searchStartDate'] = date('Y-m-d', mktime(0,0,0,$month,1,$year));
				$querystring['searchEndDate'] = $query_string['searchEndDate'] = date('Y-m-t', mktime(0,0,0,$month,1,$year));
				$vars['searchStartDate'] = $querystring['searchStartDate'];
				$vars['searchEndDate'] = $querystring['searchEndDate'];
			}else{
				$querystring['searchStartDate'] 	= $this->input->get('searchStartDate') ? $this->input->get('searchStartDate') : '';
				$querystring['searchEndDate'] 		= $this->input->get('searchEndDate') ? $this->input->get('searchEndDate') : '';
			}
		}
		
		$skt_values = $this->_generate_where_in_values(explode(',', $this->lang->line('device_carrier_skt')));
		$kt_values = $this->_generate_where_in_values(explode(',', $this->lang->line('device_carrier_kt')));
		$lgu_values = $this->_generate_where_in_values(explode(',', $this->lang->line('device_carrier_lgu')));
		
		$params = array('searchStartDate' => $querystring['searchStartDate'],
						'searchEndDate' => $querystring['searchEndDate'],
						'search_type' => $querystring['search_type'],
						'search_value' => $querystring['search_value'],
						'status_type' => $querystring['status_type'],
						'report_type' => $querystring['report_type'],
						'ad_name' => $querystring['ad_name'],
						'ad_sq' => $querystring['ad_sq'],
						'campaign_sq' => $campaign_sq,
						'skt_values' => $skt_values,
						'kt_values' => $kt_values,
						'lgu_values' => $lgu_values);
		
		$ad_name_array = $this->pcpCampaignReport_model->select_ad_name_list($campaign_sq, TRUE);
		$vars['ad_name_selectbox'] = $this->ui_component->create_selectbox('ad_sq', $ad_name_array, $querystring['ad_sq'], '전체', 'javascript:changeReportType(this.value);');

		//캠페인 정보
		$vars['campaign_vo'] = $this->pcpCampaignReport_model->select_campaign_detail($params);
		
		//isf 정보
		$vars['isf'] = $this->pcpCampaignReport_model->select_isf_list($params);
		
		//target 정보
		$vars['target'] = $this->pcpCampaignReport_model->select_target_list($params);
		
		if($querystring['ad_sq'] != '' && $ad_report_type == 'media'){
			$vars['total'] = $this->pcpCampaignReport_model->select_tot_media($querystring['searchStartDate'], $querystring['searchEndDate'], $querystring['ad_sq'], $ad_report_type, $campaign_sq);
			//미디어 정보
			$vars['media_vo'] = $this->pcpCampaignReport_model->select_media_detail($params);
			$vars['list'] = $vars['media_vo'];
		}else{
			if($querystring['report_type'] == 'media'){
				$vars['total'] = $this->pcpCampaignReport_model->select_tot_media($querystring['searchStartDate'], $querystring['searchEndDate'], $querystring['ad_sq'], $ad_report_type, $campaign_sq);
				$vars['media_vo'] = $this->pcpCampaignReport_model->select_media_detail($params);
				$vars['list'] = $vars['media_vo'];
			}else{
				$vars['total'] = $this->pcpCampaignReport_model->select_tot_ad($querystring['searchStartDate'], $querystring['searchEndDate'], $querystring['ad_sq'], $ad_report_type, $campaign_sq);
				//광고 정보
				$vars['ad_vo'] = $this->pcpCampaignReport_model->select_ad_detail($params);
				$vars['list'] = $vars['ad_vo'];
			}
		}
		
		if($vars['list'] != null){
			foreach ($vars['list'] as $row)
			{
				$chart_data['division_dt'][] = $row->get_division_dt();
				$chart_data['ad_nm'][] = $row->get_ad_nm();
				$chart_data['media_nm'][] = $row->get_media_nm();
				$chart_data['request_cnt'][] = $row->get_request_cnt();
				$chart_data['receive_cnt'][] = $row->get_receive_cnt();
				$chart_data['success_cnt'][] = $row->get_success_cnt();
				$chart_data['success_per'][] = $row->get_success_per();
				$chart_data['tot_click'][] = $row->get_tot_click();
				$chart_data['ctr_cnt'][] = $row->get_ctr_cnt();
			}
			
			$vars['division_dt'] 	= json_encode($chart_data['division_dt']);
			$vars['ad_nm']			= json_encode($chart_data['ad_nm'],JSON_NUMERIC_CHECK);
			$vars['media_nm'] 		= json_encode($chart_data['media_nm'],JSON_NUMERIC_CHECK);
			$vars['request_cnt'] 	= json_encode($chart_data['request_cnt'],JSON_NUMERIC_CHECK);
			$vars['receive_cnt'] 	= json_encode($chart_data['receive_cnt'],JSON_NUMERIC_CHECK);
			$vars['success_cnt'] 	= json_encode($chart_data['success_cnt'],JSON_NUMERIC_CHECK);
			$vars['success_per'] 	= json_encode($chart_data['success_per'],JSON_NUMERIC_CHECK);
			$vars['tot_click'] 		= json_encode($chart_data['tot_click'],JSON_NUMERIC_CHECK);
			$vars['ctr_cnt'] 		= json_encode($chart_data['ctr_cnt'],JSON_NUMERIC_CHECK);
			$vars['report_type'] 	= $querystring['report_type'];
			$vars['ad_report_type'] = $ad_report_type;
			$vars['ad_name'] 		= $querystring['ad_name'];
			$vars['type'] 			= $type;
			$vars['ad_sq'] 		= $querystring['ad_sq'];
			
			unset($chart_data);
		}else{
			$vars['division_dt'] 	= '';
			$vars['ad_nm']			= '';
			$vars['media_nm'] 		= '';
			$vars['request_cnt'] 	= '';
			$vars['receive_cnt'] 	= '';
			$vars['success_cnt'] 	= '';
			$vars['success_per'] 	= '';
			$vars['tot_click'] 		= '';
			$vars['ctr_cnt'] 		= '';
			$vars['report_type'] 	= $querystring['report_type'];
			$vars['ad_report_type'] = $ad_report_type;
			$vars['ad_name'] 		= $querystring['ad_name'];
			$vars['type'] 			= $type;
			$vars['ad_sq'] 			=  $querystring['ad_sq'];;
		}
		
		$config['querystring_list']= $querystring;
		
		if($type == 'popup'){
			$this->layout = 'popup';
		}
		$vars['excel_url'] = '/report/pcpCampaignReport/detail_excel?' . $_SERVER['QUERY_STRING'];
		$this->yield = true;
		$this->yield_js = array('/web/js/report/campaignReport_detail.js', '/web/js/common/highcharts.js');
		$this->load->view('report/campaign/campaignReport_detail_view', $vars);
	
	}
	
	function detail_excel_get()
	{
		$campaign_sq = $this->get('campaign_sq') ? $this->get('campaign_sq') : '';
		$report = $this->get('report') ? $this->get('report') : '';
		
		$vars = $querystring = $this->_get_list_request_data();
		
		if($this->input->get('searchStartDate') != null && $this->input->get('searchEndDate') == null)
		{
			if($report == 'daily'){
				list($year, $month) = explode(".",  $this->input->get('searchStartDate'));
				$querystring['searchStartDate'] = $query_string['searchStartDate'] = date('Y-m-d', mktime(0,0,0,$month,1,$year));
				$querystring['searchEndDate'] = $query_string['searchEndDate'] = date('Y-m-t', mktime(0,0,0,$month,1,$year));
				$vars['searchStartDate'] = $querystring['searchStartDate'];
				$vars['searchEndDate'] = $querystring['searchEndDate'];
			}else{
				$querystring['searchStartDate'] 	= $this->input->get('searchStartDate') ? $this->input->get('searchStartDate') : '';
				$querystring['searchEndDate'] 		= $this->input->get('searchEndDate') ? $this->input->get('searchEndDate') : '';
			}
		}else{
			if($report == 'daily'){
				list($year, $month) = explode(".",  $this->input->get('searchStartDate'));
				$querystring['searchStartDate'] = $query_string['searchStartDate'] = date('Y-m-d', mktime(0,0,0,$month,1,$year));
				$querystring['searchEndDate'] = $query_string['searchEndDate'] = date('Y-m-t', mktime(0,0,0,$month,1,$year));
				$vars['searchStartDate'] = $querystring['searchStartDate'];
				$vars['searchEndDate'] = $querystring['searchEndDate'];
			}else{
				$querystring['searchStartDate'] 	= $this->input->get('searchStartDate') ? $this->input->get('searchStartDate') : '';
				$querystring['searchEndDate'] 		= $this->input->get('searchEndDate') ? $this->input->get('searchEndDate') : '';
			}
		}
		
		$ad_report_type = $querystring['ad_report_type'] ? $querystring['ad_report_type'] : 'media';
		
		$skt_values = $this->_generate_where_in_values(explode(',', $this->lang->line('device_carrier_skt')));
		$kt_values = $this->_generate_where_in_values(explode(',', $this->lang->line('device_carrier_kt')));
		$lgu_values = $this->_generate_where_in_values(explode(',', $this->lang->line('device_carrier_lgu')));
		
		$params = array('searchStartDate' => $querystring['searchStartDate'],
						'searchEndDate' => $querystring['searchEndDate'],
						'search_type' => $querystring['search_type'],
						'search_value' => $querystring['search_value'],
						'status_type' => $querystring['status_type'],
						'report_type' => $querystring['report_type'],
						'ad_report_type' => $querystring['ad_report_type'],
						'ad_name' => $querystring['ad_name'],
						'ad_sq' => $querystring['ad_sq'],
						'campaign_sq' => $campaign_sq,
						'skt_values' => $skt_values,
						'kt_values' => $kt_values,
						'lgu_values' => $lgu_values);
		
		if($querystring['ad_sq'] == ''){
			if($querystring['report_type'] == 'summery'){
				$excel_data = $this->pcpCampaignReport_model->select_ad_detail($params);
					
				$column_list = array (
						'광고 명' => 'ad_nm',
						'발송 일시' => 'division_dt',
						'시도건수' => 'request_cnt',
						'성공건수' => 'success_cnt',
						'성공률' => 'success_per',
						'클릭수' => 'tot_click',
						'CTR' => 'ctr_cnt'
				);
			}elseif($querystring['report_type'] == 'media'){
				$excel_data = $this->pcpCampaignReport_model->select_media_detail($params);
					
				$column_list = array (
						'미디어 명' => 'media_nm',
						'시도건수' => 'request_cnt',
						'성공건수' => 'success_cnt',
						'성공률' => 'success_per',
						'클릭수' => 'tot_click',
						'CTR' => 'ctr_cnt'
				);
			}elseif($querystring['report_type'] == 'month' || $querystring['report_type'] == 'daily'){
				$excel_data = $this->pcpCampaignReport_model->select_ad_detail($params);
					
				if($querystring['report_type'] == 'month'){
					$report_value = '월';
				}else{
					$report_value = '일';
				}
					
				$column_list = array (
						$report_value => 'division_dt',
						'시도건수' => 'request_cnt',
						'성공건수' => 'success_cnt',
						'성공률' => 'success_per',
						'클릭수' => 'tot_click',
						'CTR' => 'ctr_cnt'
				);
			}
		}else{
			if($querystring['ad_report_type'] == 'media'){
				$excel_data = $this->pcpCampaignReport_model->select_media_detail($params);
					
				$column_list = array (
						'미디어 명' => 'media_nm',
						'시도건수' => 'request_cnt',
						'성공건수' => 'success_cnt',
						'성공률' => 'success_per',
						'클릭수' => 'tot_click',
						'CTR' => 'ctr_cnt'
				);
			}elseif($querystring['ad_report_type'] == 'target' || $querystring['ad_report_type'] == 'isf'){
				if($ad_report_type == 'target'){
						
					//target 정보
					$excel_data = $this->pcpCampaignReport_model->select_target_list($params);
				
					$report_value = '기본 타게팅';
				}else{
					//isf 정보
					$excel_data = $this->pcpCampaignReport_model->select_isf_list($params);
				
					$report_value = 'ISF 타게팅';
				}
					
				$column_list = array (
						$report_value => 'target_nm',
						'시도건수' => 'request_cnt',
						'성공건수' => 'success_cnt',
						'성공률' => 'success_per',
						'클릭수' => 'tot_click',
						'CTR' => 'ctr_cnt'
				);
				$this->excel->export_target_report_excel('campaign_target.xls', 'campaign', $column_list, $excel_data);
			}
		}
		$this->excel->export_excel('campaign_detail.xls', 'campaign', $column_list, $excel_data);
	}
	
	function get_search_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array('campaign_nm' => '캠페인 명', 'adv_company_nm' => '광고주', 'adv_brand_nm' => '브랜드');
		return $this->ui_component->create_selectbox('search_type', $option_array, $selected_value, $default_value);
	}
	
	function get_status_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array(
				$this->lang->line('ad_status_test') => $this->pcpCampaignReport_model->get_status_name($this->lang->line('ad_status_test')),
				$this->lang->line('ad_status_stand') => $this->pcpCampaignReport_model->get_status_name($this->lang->line('ad_status_stand')),
				$this->lang->line('ad_status_com') => $this->pcpCampaignReport_model->get_status_name($this->lang->line('ad_status_com')));
		return $this->ui_component->create_selectbox('status_type', $option_array, $selected_value, $default_value);
	}
	
	function get_report_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array('summery' => '요약 리포트', 'media' => '미디어 리포트', 'month' => '월별 리포트', 'daily' => '일별 리포트');
		return $this->ui_component->create_selectbox('report_type', $option_array, $selected_value, $default_value);
	}
	
	function get_ad_report_type_selectbox($selected_value = '', $default_value = '')
	{
		$option_array = array('media' => '요약 리포트', 'target' => '기본 타게팅 리포트', 'isf' => 'ISF 타게팅 리포트');
		return $this->ui_component->create_selectbox('ad_report_type', $option_array, $selected_value, $default_value);
	}
	
	private function _generate_where_in_values($array)
	{
		$result = '';
		foreach($array as $value)
		{
			if($result != '')
			{
				$result .= ',';
			}
			$result .= "'" .$value ."'";
		}
		return $result;
	}
	
	private function _get_list_request_data()
	{
		$querystring = array();
	
		$querystring['searchStartDate'] 	= $this->get('searchStartDate') ? $this->get('searchStartDate') : '';
		$querystring['searchEndDate'] 		= $this->get('searchEndDate') ? $this->get('searchEndDate') : '';
		$querystring['search_type']	 		= $this->get('search_type') ? $this->get('search_type') : '';
		$querystring['search_value']	 	= $this->get('searchValue') ? $this->get('searchValue') : '';
		$querystring['status_type'] 		= $this->get('status_type') ? $this->get('status_type') : '';
		$querystring['report_type'] 		= $this->get('report_type') ? $this->get('report_type') : '';
		$querystring['ad_report_type']		= $this->get('ad_report_type') ? $this->get('ad_report_type') : '';
		$querystring['ad_name'] 			= $this->get('ad_name') ? $this->get('ad_name') : '';
		$querystring['ad_sq'] 				= $this->get('ad_sq') ? $this->get('ad_sq') : '';
		
		return $querystring;
	}
}


/* End of file campaignReport.php */
/* Location: ./application/admin/controllers/report/campaignReport.php */
