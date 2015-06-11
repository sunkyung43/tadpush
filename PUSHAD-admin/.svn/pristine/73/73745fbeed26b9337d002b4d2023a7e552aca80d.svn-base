<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ParamStatistics extends MY_Controller
{
	/**
	 * @var ParamStatistics_model
	 */
	public $paramstatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/paramstatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();

		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') :  date("Y-m")."-01";
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : date("Y-m-d");
		
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$vars['list'] = $this->paramstatistics_model->select_statistics_list($params);
		$vars['total_rows'] = $this->paramstatistics_model->count_statistics_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/statistics/paramStatistics';
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
		
		$vars['excel_url'] = '/statistics/paramStatistics/excel?' . $_SERVER['QUERY_STRING'];		
		$this->yield = true;
		$this->load->view('statistics/param/param_param_view', $vars);
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
	
		$list = $this->paramstatistics_model->select_statistics_list($params);
		$column_list = array (
				'일자' => 'division_dt',
				'모수' => 'param_cnt',
				'증감' => 'variation_cnt'
		);
	
		$this->excel->export_excel('param_statistics_list.xls', 'param_statistics', $column_list, $list);
	}

}


/* End of file osstatistics.php */
/* Location: ./application/admin/controllers/statistics/osstatistics.php */