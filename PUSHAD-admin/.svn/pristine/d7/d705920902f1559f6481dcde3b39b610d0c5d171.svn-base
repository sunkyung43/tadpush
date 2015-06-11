<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PeriodStatistics extends MY_Controller
{
	/**
	 * @var PeriodStatistics_model
	 */
	public $periodstatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/periodstatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();
		$vars['list'] = $this->periodstatistics_model->select_year_list();
		$vars['chart_data'] = $this->_chart_data_maker($vars['list']);
		
		$this->yield = true;
		$this->yield_js = array('/web/js/statistics/period_chart.js', '/web/js/common/highcharts.js');
		$this->load->view('statistics/period/period_year_view', $vars);
	}
	function month_get()
	{
		$vars = array();
		$start_dt = $this->get('start_dt') ? $this->get('start_dt') : date('Y-m-d', mktime(0,0,0,1,1,date('Y')));
		$end_dt = $this->get('end_dt') ?  $this->get('end_dt') : date('Y-m-t', mktime(0,0,0,12,1,date('Y')));
		
		list($s_year, $s_month) = explode("-", $start_dt);
		$vars['start_dt'] = date('Y-m-d', mktime(0,0,0,$s_month,1,$s_year));
		list($e_year, $e_month) = explode("-", $end_dt);
		$vars['end_dt'] = date('Y-m-t', mktime(0,0,0,$e_month,1,$e_year));
		
		$query_string['start_dt'] = substr($vars['start_dt'],0,7);
		$query_string['end_dt'] = substr($vars['end_dt'],0,7);
		$query_string['search_type'] = 'month';
		
		$vars['list'] = $this->periodstatistics_model->select_detail_list($query_string);
		
		$vars['chart_data'] = $this->_chart_data_maker($vars['list']);
		
		$this->yield = true;
		$this->yield_js = array('/web/js/statistics/period_chart.js', '/web/js/common/highcharts.js');
		$this->load->view('statistics/period/period_month_view', $vars);
	}
	function day_get()
	{
		$vars = array();
		if($this->get('start_dt') != null && $this->get('end_dt') == null)
		{
			list($year, $month) = explode(".",  $this->get('start_dt')) ;
			$vars['start_dt'] = $query_string['start_dt'] = date('Y-m-d', mktime(0,0,0,$month,1,$year));
			$vars['end_dt'] = $query_string['end_dt'] = date('Y-m-t', mktime(0,0,0,$month,1,$year));
		}
		else
		{
			$vars['start_dt'] = $query_string['start_dt'] = $this->get('start_dt')? $this->get('start_dt') : date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y')));
			$vars['end_dt'] = $query_string['end_dt'] = $this->get('end_dt')? $this->get('end_dt') : date('Y-m-t', mktime(0,0,0,date('m'),1,date('Y')));
		}
		
		$vars['search_type'] = $query_string['search_type'] = 'day';

		$vars['list'] = $this->periodstatistics_model->select_detail_list($query_string);
	
		$vars['chart_data'] = $this->_chart_data_maker($vars['list']);
		
		$this->yield = true;
		$this->yield_js = array('/web/js/statistics/period_chart.js', '/web/js/common/highcharts.js');
		$this->load->view('statistics/period/period_day_view', $vars);
	}
	
	function _chart_data_maker($list_data)
	{
		if(!empty($list_data)){
			krsort($list_data);
			foreach ($list_data as $row)
			{
				if(strlen($row->get_division_dt()) > 7)
				{
					$data['division_dt'][] = substr($row->get_division_dt(), 8);
				}else
				{
					$data['division_dt'][] = $row->get_division_dt();
				}
				$data['request_cnt'][] = $row->get_request_cnt();
				$data['success_cnt'][] = $row->get_success_cnt();
				$data['success_rate'][] = $row->get_success_rate();
				$data['click_cnt'][] = $row->get_click_cnt();
				$data['click_rate'][] = $row->get_click_rate();
			}
			
			$chart_data['division_dt'] = json_encode($data['division_dt']);
			$chart_data['request_cnt'] = json_encode($data['request_cnt'],JSON_NUMERIC_CHECK);
			$chart_data['success_cnt'] = json_encode($data['success_cnt'],JSON_NUMERIC_CHECK);
			$chart_data['success_rate'] = json_encode($data['success_rate'],JSON_NUMERIC_CHECK);
			$chart_data['click_cnt'] = json_encode($data['click_cnt'],JSON_NUMERIC_CHECK);
			$chart_data['click_rate'] = json_encode($data['click_rate'],JSON_NUMERIC_CHECK);
			unset($data);
		}else{
			$chart_data['division_dt'] = "";
			$chart_data['request_cnt'] = "";
			$chart_data['success_cnt'] = "";
			$chart_data['success_rate'] = "";
			$chart_data['click_cnt'] = "";
			$chart_data['click_rate'] = "";
		}
		return $chart_data;
	}
	
	function excel_get()
	{
		$query_string['start_dt'] = $this->get('start_dt');
		$query_string['end_dt'] = $this->get('end_dt');
		$query_string['search_type'] = $this->get('search_type');
		
		if($query_string['search_type'] == 'year')
		{
			$excel_data = $this->periodstatistics_model->select_year_list();
		}
		else 
		{
			if($query_string['search_type'] == 'month')
			{
				$query_string['start_dt'] = substr($query_string['start_dt'],0,7);
				$query_string['end_dt'] = substr($query_string['end_dt'],0,7);
			}
			$excel_data = $this->periodstatistics_model->select_detail_list($query_string);
		} 
	    $column_list = array(
	    		'구분' => 'division_dt',
	    		'시도건수' => 'request_cnt',
	    		'성공건수' => 'success_cnt',
	    		'성공률' => 'success_rate',
	    		'클릭수' => 'click_cnt',
	    		'CTR' => 'click_rate');

	    $this->load->library('excel');
	    $this->excel->export_excel('period_'.$query_string['search_type'].'_statistics_list.xls', 'period'.$query_string['search_type'].'_statistics_list', $column_list, $excel_data);	    
	}
	
	private function _export_statistics_excel($file_name, $sheet_nm, $title, $column_list, $data_list)
	{
		$this->load->library('excel');
		$excel_sheet_nm = '통계 리스트';
		$excel_data = array();
		$excel_data['excel_file_nm']	= $file_name;  // 파일명
		$excel_data['excel_sheet_nm']   = $sheet_nm;  // 시트명
		$excel_data['excel_key']        = $column_list;       // 배열의 키구분
		$excel_data['excel_title']      = $title;     // 제일 상단에 출력된 타이틀명
		$excel_data['excel_list']       = $data_list;    // 출력되야할 엑셀 리스트
		$this->excel->exportToExcel($excel_data);
	}
	
	
}
/* End of file statistics.php */
/* Location: ./application/admin/controllers/statistics/statistics.php */