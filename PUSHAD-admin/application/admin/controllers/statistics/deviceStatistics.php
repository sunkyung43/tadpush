<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DeviceStatistics extends MY_Controller
{
	/**
	 * @var DeviceStatistics_model
	 */
	public $devicestatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/devicestatistics_model');
		$this->load_vo('statistics/statistics_vo');

	}

	function index_get()
	{
		$vars = array();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$vars['list'] = $this->devicestatistics_model->select_statistics_list($params);
		$vars['total_rows'] = $this->devicestatistics_model->count_statistics_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/statistics/mediaStatistics';
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
		
		$vars['excel_url'] = '/statistics/deviceStatistics/excel?' . $_SERVER['QUERY_STRING'];
		$this->yield = true;
		$this->yield_js = array('/web/js/statistics/device.js', '/web/js/jquery/jquery.tablesorter.min.js');
		$this->load->view('statistics/device/device_device_view', $vars);
	}
	
	function excel_get()
	{
		$this->load->library('excel');
		
		/* $cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수 */
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt']
				/* ,'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page */
		);
		
		$list = $this->devicestatistics_model->select_statistics_list($params);
		$column_list = array (
				'구분' => 'vendor',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
		
		$this->excel->export_excel('device_statistics_list.xls', 'device_statistics', $column_list, $list);
	}
}


/* End of file deviceStatistics.php */
/* Location: ./application/admin/controllers/statistics/deviceStatistics.php */