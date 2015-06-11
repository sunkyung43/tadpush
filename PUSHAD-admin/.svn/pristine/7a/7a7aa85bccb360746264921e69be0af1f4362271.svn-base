<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HumanStatistics extends MY_Controller
{
	/**
	 * @var HumanStatistics_model
	 */
	public $humanstatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/humanstatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$search_type = $this->lang->line('gender_ent');
		
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'search_type' => $search_type
		);
		
		$vars['list'] = $this->humanstatistics_model->select_gender_list($params);
		$vars['chart_data'] = $this->_make_chart_data($vars['list']);;
		
		$vars['excel_url'] = '/statistics/humanStatistics/gender_excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = array('/web/js/common/highcharts.js', '/web/js/statistics/human.js');
		$this->load->view('statistics/human/human_gender_view', $vars);
	}
	
	function gender_excel_get()
	{
		$this->load->library('excel');
		
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$search_type = $this->lang->line('gender_ent');
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'search_type' => $search_type
		);
		
		$list = $this->humanstatistics_model->select_gender_list($params);
		$column_list = array (
				'구분' => 'division_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
		
		$this->excel->export_excel('gender_statistics_list.xls', 'gender_statistics', $column_list, $list);
	}
	
	function age_get()
	{
		$vars = array();
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$querystring['search_type'] = $search_type = $this->lang->line('age_ent');
		$querystring['search_value'] = $search_value = $this->get('search_value') ?  $this->get('search_value') : '';
		
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'search_type' => $search_type,
				'search_value' => $search_value
		);
		
		$vars['list'] = $this->humanstatistics_model->select_age_list($params);
		$vars['chart_data'] = $this->_make_chart_data($vars['list']);
		
		$search_value_list = array (
				'M' => '남자',
				'F' => '여자'
		);
		$vars['search_value_selectbox'] = $this->ui_component->create_selectbox('search_value', $search_value_list, $search_value, '전체');
		
		$search_type_list = array (
				'PSGENDER' => '성별',
				'AGE' => '나이'
		);
		$vars['search_type_selectbox'] = $this->ui_component->create_selectbox('search_type', $search_type_list, $search_type);
		
		
		$vars['excel_url'] = '/statistics/humanStatistics/age_excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = array('/web/js/common/highcharts.js', '/web/js/statistics/human.js');
		$this->load->view('statistics/human/human_age_view', $vars);
	}
	function age_excel_get()
	{
		$this->load->library('excel');
	
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$search_type = $this->lang->line('age_ent');
		$search_value = $this->get('search_value') ?  $this->get('search_value') : '';
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'search_type' => $search_type,
				'search_value' => $search_value
		);
	
		$list = $this->humanstatistics_model->select_age_list($params);
		$column_list = array (
				'구분' => 'division_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
	
		$this->excel->export_excel('age_statistics_list.xls', 'age_statistics', $column_list, $list);
	}
	
	function _make_chart_data($data_list)
	{
		if($data_list != null){
			foreach ($data_list as $row){
				$chart_data['chart_Requeat'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_request_cnt());
				$chart_data['chart_success'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_success_cnt());
				$chart_data['chart_str'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_success_rate());
				$chart_data['chart_click'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_click_cnt());
				$chart_data['chart_ctr'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_click_rate());
			}
		
			$return_data['request_chart'] = json_encode($chart_data['chart_Requeat'],JSON_NUMERIC_CHECK);
			$return_data['success_chart'] = json_encode($chart_data['chart_success'],JSON_NUMERIC_CHECK);
			$return_data['str_chart'] = json_encode($chart_data['chart_str'],JSON_NUMERIC_CHECK);
			$return_data['click_chart'] = json_encode($chart_data['chart_click'],JSON_NUMERIC_CHECK);
			$return_data['ctr_chart'] = json_encode($chart_data['chart_ctr'],JSON_NUMERIC_CHECK);
		
			unset($chart_data, $row);
		}
		else
		{
			$return_data['request_chart'] = "";
			$return_data['success_chart'] = "";
			$return_data['str_chart'] = "";
			$return_data['click_chart'] = "";
			$return_data['ctr_chart'] = "";
		}
		return $return_data;
	}
}


/* End of file carrierstatistics.php */
/* Location: ./application/admin/controllers/statistics/carrierstatistics.php */