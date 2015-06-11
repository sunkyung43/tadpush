<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CarrierStatistics extends MY_Controller
{
	/**
	 * @var CarrierStatistics_model
	 */
	public $carrierstatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/carrierstatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();

		$vars['start_dt'] = $query['start_dt'] = $this->get('start_dt');
		$vars['end_dt'] = $query['end_dt'] = $this->get('end_dt');
		
		$query['skt_value'] = $this->lang->line('device_carrier_skt');
		$query['kt_value'] = $this->lang->line('device_carrier_kt');
		$query['lgu_value'] = $this->lang->line('device_carrier_lgu');
		
		$vars['list'] = $this->carrierstatistics_model->select_list($query);
		
		if($vars['list'] != null){
			foreach ($vars['list'] as $row){
				$chart_data['chart_Requeat'][] = array('name' => $row->get_carrier_nm(), 'data' => $row->get_request_cnt());
				$chart_data['chart_success'][] = array('name' => $row->get_carrier_nm(), 'data' => $row->get_success_cnt());
				$chart_data['chart_str'][] = array('name' => $row->get_carrier_nm(), 'data' => $row->get_success_rate());
				$chart_data['chart_click'][] = array('name' => $row->get_carrier_nm(), 'data' => $row->get_click_cnt());
				$chart_data['chart_ctr'][] = array('name' => $row->get_carrier_nm(), 'data' => $row->get_click_rate());
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
		$this->yield_js = '/web/js/common/highcharts.js';
		$this->load->view('statistics/carrier/carrier_carrier_view', $vars);
	}
	
	function excel_get()
	{
		$vars = array();
		$query['start_dt'] = $this->get('start_dt');
		$query['end_dt'] = $this->get('end_dt');
		
		$query['skt_value'] = $this->lang->line('device_carrier_skt');
		$query['kt_value'] = $this->lang->line('device_carrier_kt');
		$query['lgu_value'] = $this->lang->line('device_carrier_lgu');
		
		$excel_data = $this->carrierstatistics_model->select_list($query);	    
		
		
		$column_list = array (
				'구분' => 'carrier_nm',
				'시도건수' => 'request_cnt',
				'성공건수' => 'success_cnt',
				'성공률' => 'success_rate',
				'클릭수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
		
		$this->load->library('excel');
		$this->excel->export_excel('carrier_statistics_list.xls', 'carrier_statistics_list', $column_list, $excel_data);
	}
	
}

/* End of file carrierstatistics.php */
/* Location: ./application/admin/controllers/statistics/carrierstatistics.php */