<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OsStatistics extends MY_Controller
{
	/**
	 * @var OsStatistics_model
	 */
	public $osstatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/osstatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$querystring['os_cd'] = $end_dt = $this->get('os_cd') ?  $this->get('os_cd') : $this->lang->line('os_android');
		
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'os_cd' => $querystring['os_cd']
		);
		
		$vars['list'] = $this->osstatistics_model->select_statistics_list($params);
		
		$vars['excel_url'] = '/statistics/osStatistics/excel?' . $_SERVER['QUERY_STRING'];

		// 검색조건 selectbox
		$os_type_list = array (
				$this->lang->line('os_android') => 'Android',
				$this->lang->line('os_ios') => 'iOS' 
		);
		$vars['os_type_selectbox'] = $this->ui_component->create_selectbox('os_cd', $os_type_list, $querystring['os_cd'], '');

		if($vars['list'] != null){
			foreach ($vars['list'] as $row){
				$chart_data['chart_Requeat'][] = array('name' => $row->get_os_ver_nm(), 'data' => $row->get_request_cnt());
				$chart_data['chart_success'][] = array('name' => $row->get_os_ver_nm(), 'data' => $row->get_success_cnt());
				$chart_data['chart_str'][] = array('name' => $row->get_os_ver_nm(), 'data' => $row->get_success_rate());
				$chart_data['chart_click'][] = array('name' => $row->get_os_ver_nm(), 'data' => $row->get_click_cnt());
				$chart_data['chart_ctr'][] = array('name' => $row->get_os_ver_nm(), 'data' => $row->get_click_rate());
			}
		
			$vars['request_chart'] = json_encode($chart_data['chart_Requeat'],JSON_NUMERIC_CHECK);
			$vars['success_chart'] = json_encode($chart_data['chart_success'],JSON_NUMERIC_CHECK);
			$vars['str_chart'] = json_encode($chart_data['chart_str'],JSON_NUMERIC_CHECK);
			$vars['click_chart'] = json_encode($chart_data['chart_click'],JSON_NUMERIC_CHECK);
			$vars['ctr_chart'] = json_encode($chart_data['chart_ctr'],JSON_NUMERIC_CHECK);
		
			unset($chart_data, $row);
		}
		else
		{
			$vars['request_chart'] = "";
			$vars['success_chart'] = "";
			$vars['str_chart'] = "";
			$vars['click_chart'] = "";
			$vars['ctr_chart'] = "";
		}
		
		
		$this->yield = true;
		$this->yield_js = array('', '/web/js/common/highcharts.js');
		$this->load->view('statistics/os/os_os_view', $vars);
	}
	
	function excel_get()
	{
		$this->load->library('excel');
		
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt
		);
		
		$list = $this->osstatistics_model->select_statistics_list($params);
		$column_list = array (
				'버전' => 'os_ver_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
		
		$this->excel->export_excel('os_statistics_list.xls', 'os_statistics', $column_list, $list);
	}
}


/* End of file osstatistics.php */
/* Location: ./application/admin/controllers/statistics/osstatistics.php */