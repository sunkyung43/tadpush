<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediaStatistics extends MY_Controller
{
	/**
	 * @var MediaStatistics_model
	 */
	public $mediastatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/mediastatistics_model');
		$this->load_vo('statistics/statistics_vo');
	}

	function index_get()
	{
		$vars = array();
		
		$vars['start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$vars['end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		
		$query = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'media_category_ent' => $this->lang->line('media_category_ent')
		);
		
		$vars['list'] = $this->mediastatistics_model->select_category_list($query);
	 	$total = new Statistics_vo();
		
		if($vars['list'] != null){
			foreach ($vars['list'] as $row){
				$chart_data['chart_Requeat'][] = array('name' => $row->get_media_category_nm(), 'data' => $row->get_request_cnt());
				$chart_data['chart_success'][] = array('name' => $row->get_media_category_nm(), 'data' => $row->get_success_cnt());
				$chart_data['chart_str'][] = array('name' => $row->get_media_category_nm(), 'data' => $row->get_success_rate());
				$chart_data['chart_click'][] = array('name' => $row->get_media_category_nm(), 'data' => $row->get_click_cnt());
				$chart_data['chart_ctr'][] = array('name' => $row->get_media_category_nm(), 'data' => $row->get_click_rate());
				
				$total-> set_request_cnt($total->get_request_cnt() + $row->get_request_cnt());
				$total-> set_success_cnt($total->get_success_cnt() + $row->get_success_cnt());
				$total-> set_success_rate($total->get_success_rate() + $row->get_success_rate());
				$total-> set_click_cnt($total->get_click_cnt() + $row->get_click_cnt());
				$total-> set_click_rate($total->get_click_rate() + $row->get_click_rate());
			}
				
			$vars['request_chart'] = json_encode($chart_data['chart_Requeat'],JSON_NUMERIC_CHECK);
			$vars['success_chart'] = json_encode($chart_data['chart_success'],JSON_NUMERIC_CHECK);
			$vars['str_chart'] = json_encode($chart_data['chart_str'],JSON_NUMERIC_CHECK);
			$vars['click_chart'] = json_encode($chart_data['chart_click'],JSON_NUMERIC_CHECK);
			$vars['ctr_chart'] = json_encode($chart_data['chart_ctr'],JSON_NUMERIC_CHECK);

			unset($chart_data, $row);
			
			$vars['total'] = $total;			
		}
		else
		{
			$vars['request_chart'] = "";
			$vars['success_chart'] = "";
			$vars['str_chart'] = "";
			$vars['click_chart'] = "";
			$vars['ctr_chart'] = "";
			
			$vars['total'] = '';
		}
		
		$vars['excel_url'] = '/statistics/mediaStatistics/excel?search_start_dt=.';
		
		$this->yield = true;
		$this->yield_js = '/web/js/common/highcharts.js';
		$this->load->view('statistics/media/media_category_view', $vars);
	}
	
	function excel_get()
	{
		$this->load->library('excel');
		
		$querystring['search_start_dt'] = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] =  $this->get('search_end_dt') ? $this->get('search_end_dt') : '';
		
		
		// 리스트 조회
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'media_category_ent' => $this->lang->line('media_category_ent')
		);
		
		$list = $this->mediastatistics_model->select_category_list($params);
		$total = new Statistics_vo();
		if($list != null){
			foreach ($list as $row){
				$total-> set_request_cnt($total->get_request_cnt() + $row->get_request_cnt());
				$total-> set_success_cnt($total->get_success_cnt() + $row->get_success_cnt());
				$total-> set_success_rate($total->get_success_rate() + $row->get_success_rate());
				$total-> set_click_cnt($total->get_click_cnt() + $row->get_click_cnt());
				$total-> set_click_rate($total->get_click_rate() + $row->get_click_rate());
			}
		}
		else
		{
			$total-> set_request_cnt('0');
			$total-> set_request_cnt('0');
			$total-> set_success_cnt('0');
			$total-> set_success_rate('0');
			$total-> set_click_cnt('0');
			$total-> set_click_rate('0');
		}
		
		$total->set_media_category_nm('전체');
		array_unshift($list, $total);
		$column_list = array (
				'카테고리' => 'media_category_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'click 수' => 'click_cnt',
				'CTR' => 'click_rate',
		);
		
		$this->excel->export_excel('category_statistics_list.xls', 'category_statistics', $column_list, $list);
	}
	
	
	function media_get()
	{
		$vars = array();
		
		$cur_page = $this->get ( 'cur_page' ) ? $this->get ( 'cur_page' ) : 1; // 현재 페이지
		$num_links = $this->config->item ( 'list_num_links' ); // 페이지 수
		$per_page = $this->get ( 'per_page' ) ? $this->get ( 'per_page' ) : 15; // 페이지당 출력 게시글수
		
		
		
		$vars['start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$vars['end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$vars['media_category_cd'] = $media_category_cd =  $this->get('media_category_cd') ?  $this->get('media_category_cd') : '';
	
		$params = array (
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page,
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'media_category_cd' => $media_category_cd
		);
		
		$vars['list'] = $this->mediastatistics_model->select_media_list($params);
		$vars['total_rows'] = $this->mediastatistics_model->count_media_list($params);
		
		// 페이징 처리
		$config['base_url'] = '/system/target/mediaGroup';
		$config['total_rows'] = $vars['total_rows'];
		$config['cur_page'] = $cur_page;
		$config['per_page'] = $per_page;
		$config['num_links'] = $num_links;
		$config['querystring_list'] = $params;
		
		$this->paging->init($config);
		$vars['paging'] = $this->paging->create_page();
		$vars ['paging_volume'] = $this->paging->create_page_volume ( $per_page, array (15,30,50,100));
		
		
		$this->yield = true;
		$this->yield_js = array('/web/js/statistics/media_media.js', '/web/js/jquery/jquery.tablesorter.min.js');
		$this->load->view('statistics/media/media_media_view', $vars);
	}
	
	function media_excel_get()
	{
		$this->load->library('excel');
		
		/* $cur_page = $this->get ( 'cur_page' ) ? $this->get ( 'cur_page' ) : 1; // 현재 페이지
		$num_links = $this->config->item ( 'list_num_links' ); // 페이지 수
		$per_page = $this->get ( 'per_page' ) ? $this->get ( 'per_page' ) : 15; // 페이지당 출력 게시글수 */
		
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$media_category_cd =  $this->get('media_category_cd') ?  $this->get('media_category_cd') : '';
		
		$params = array (
				/* 'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page, */
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'media_category_cd' => $media_category_cd
		);
		
		$list = $this->mediastatistics_model->select_media_list($params);
	
		$column_list = array (
				'미디어 명' => 'media_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'click 수' => 'click_cnt',
				'CTR' => 'click_rate',
		);
	
		$this->excel->export_excel('media_statistics_list.xls', 'media_statistics', $column_list, $list);
	}
}


/* End of file mediaStatistics.php */
/* Location: ./application/admin/controllers/statistics/mediaStatistics.php */