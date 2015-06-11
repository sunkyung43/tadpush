<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RegionStatistics extends MY_Controller
{
	/**
	 * @var RegionStatistics_model
	 */
	public $regionstatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/regionstatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$vars = $querystring;
		
		$sido_data = $this->regionstatistics_model->select_exist_sido_list(array('except_cd' => '##'));
		$sido_list = array ();
		foreach ( $sido_data as $row ) {
			$sido_list[$row['sido_cd']] = $row['sido_nm'];
		}
		$vars['sido_list_selectbox'] = $this->ui_component->create_selectbox('sido_cd', $sido_list, '', '전체', '', 'class=mg_r10');
		
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt
		);
		
		$vars['list'] = $this->regionstatistics_model->select_sido_list($params);
		if($vars['list'] != null){
			foreach ($vars['list'] as $row){
				$chart_data['chart_Requeat'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_request_cnt());
				$chart_data['chart_success'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_success_cnt());
				$chart_data['chart_str'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_success_rate());
				$chart_data['chart_click'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_click_cnt());
				$chart_data['chart_ctr'][] = array('name' => $row->get_division_nm(), 'data' => $row->get_click_rate());
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
		
		$vars['excel_url'] = '/statistics/regionStatistics/sido_excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = array('/web/js/common/highcharts.js');
		$this->load->view('statistics/region/region_city_view', $vars);
	}
	function sido_excel_get()
	{
		$this->load->library('excel');
		
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$sido_cd = $this->get('sido_cd') ?  $this->get('sido_cd') : '';
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'sido_cd' => $sido_cd
		);
		
		$list = $this->regionstatistics_model->select_sido_list($params);
		$column_list = array (
				'구분' => 'division_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
		
		$this->excel->export_excel('sido_statistics_list.xls', 'sido_statistics', $column_list, $list);
	}
	function district_get()
	{
		$vars = array();
	
		$cur_page = $this->get ( 'cur_page' ) ? $this->get ( 'cur_page' ) : 1; // 현재 페이지
		$num_links = $this->config->item ( 'list_num_links' ); // 페이지 수
		$per_page = $this->get ( 'per_page' ) ? $this->get ( 'per_page' ) : 15; // 페이지당 출력 게시글수
		
		$vars['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$vars['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$vars['sido_cd'] = $sido_cd =  $this->get('sido_cd') ?  $this->get('sido_cd') : '';
		$vars['sigugun_cd'] = $sigugun_cd =  $this->get('sigugun_cd') ?  $this->get('sigugun_cd') : '';
		
		$params = array (
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page,
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'sido_cd' => $sido_cd,
				'sigugun_cd' => $sigugun_cd
		);
		
		$sido_data = $this->regionstatistics_model->select_exist_sido_list(array('except_cd' => '##'));
		$sido_list = array ();
		foreach ( $sido_data as $row ) {
			$sido_list[$row['sido_cd']] = $row['sido_nm'];
		}
		$vars['sido_list_selectbox'] = $this->ui_component->create_selectbox('sido_cd', $sido_list, $sido_cd, '', 'this.form.submit();');
		
		$sigugun_data = $this->regionstatistics_model->select_exist_sigugun_list(array('sido_cd' => $sido_cd));
		$sigugun_list = array ();
		foreach ( $sigugun_data as $row ) {
			$sigugun_list[$row['sigugun_cd']] = $row['sigugun_nm'];
		}
		$vars['sigugun_list_selectbox'] = $this->ui_component->create_selectbox('sigugun_cd', $sigugun_list, $sigugun_cd, '전체', '');
		
		$vars['list'] = $this->regionstatistics_model->select_sigugun_list($params);
		$vars['total_rows'] = $this->regionstatistics_model->count_sigugun_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/statistics/regionStatistics/district';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $params;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		$vars ['paging_volume'] = $this->paging->create_page_volume ( $per_page, array (15,30,50,100));
	
		$vars['excel_url'] = '/statistics/regionStatistics/district_excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = array('/web/js/statistics/device.js', '/web/js/jquery/jquery.tablesorter.min.js');
		$this->load->view('statistics/region/region_district_view', $vars);
	}
	
	function district_excel_get()
	{
		$this->load->library('excel');
		
		/* $cur_page = $this->get ( 'cur_page' ) ? $this->get ( 'cur_page' ) : 1; // 현재 페이지
		$num_links = $this->config->item ( 'list_num_links' ); // 페이지 수
		$per_page = $this->get ( 'per_page' ) ? $this->get ( 'per_page' ) : 15; // 페이지당 출력 게시글수 */
		
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$sido_cd =  $this->get('sido_cd') ?  $this->get('sido_cd') : '';
		$sigugun_cd =  $this->get('sigugun_cd') ?  $this->get('sigugun_cd') : '';
		
		$params = array (
				/* 'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page, */
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'sido_cd' => $sido_cd,
				'sigugun_cd' => $sigugun_cd
		);
	
		$list = $this->regionstatistics_model->select_sigugun_list($params);
		$column_list = array (
				'구분' => 'division_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
	
		$this->excel->export_excel('sigungu_statistics_list.xls', 'sigungu_statistics', $column_list, $list);
	}

}


/* End of file regionStatistics.php */
/* Location: ./application/admin/controllers/statistics/regionStatistics.php */