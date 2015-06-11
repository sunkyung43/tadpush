<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompanyStatistics extends MY_Controller
{
	/**
	 * @var CompanyStatistics_model
	 */
	public $companystatistics_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/statistics/companystatistics_model');
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
		$querystring['company_sq'] = $company_sq = $this->get('company_sq') ?  $this->get('company_sq') : '';
		
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'company_sq' => $company_sq,
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$vars['list'] = $this->companystatistics_model->select_company_list($params);
		$vars['total_rows'] = $this->companystatistics_model->count_select_company_list($params);
		$exist_company_list = $this->companystatistics_model->select_exist_company_list();
		$company_list = array();
		foreach ($exist_company_list as $row)
		{
			$company_list[$row['adv_company_sq']] = $row['company_nm'];
		}
		$vars['exist_company_list_selectbox'] = $this->ui_component->create_selectbox('company_sq', $company_list, $querystring['company_sq'], '전체');
		
		// 페이징 처리
		$config['base_url'] = '/statistics/companyStatistics';
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
		
		$vars['excel_url'] = '/statistics/companyStatistics/excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = '/web/js/statistics/company.js';
		$this->load->view('statistics/company/company_company_view', $vars);
	}
	
	function excel_get()
	{
		$this->load->library('excel');
	
	 	$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$company_sq = $this->get('company_sq') ?  $this->get('company_sq') : '';
	
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'company_sq' => $company_sq
		);
	
		$list = $this->companystatistics_model->select_company_list($params);
		$column_list = array (
				'광고주' => 'company_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
	
		$this->excel->export_excel('company_statistics_list.xls', 'company_statistics', $column_list, $list);
	}
	
	function brand_get()
	{
		$vars = array();
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$querystring['adv_company_sq'] = $adv_company_sq = $this->get('adv_company_sq') ?  $this->get('adv_company_sq') : '';
		$querystring['adv_account_sq'] = $adv_account_sq = $this->get('adv_account_sq') ?  $this->get('adv_account_sq') : '';
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'adv_company_sq' => $adv_company_sq,
				'adv_account_sq' => $adv_account_sq,
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$vars['list'] = $this->companystatistics_model->select_brand_list($params);
		$vars['total_rows'] = $this->companystatistics_model->count_select_brand_list($params);
		$exist_company_list = $this->companystatistics_model->select_exist_company_list();
		$company_list = array();
		foreach ($exist_company_list as $row)
		{
			$company_list[$row['adv_company_sq']] = $row['company_nm'];
		}
		$vars['exist_company_list_selectbox'] = $this->ui_component->create_selectbox('adv_company_sq', $company_list, $querystring['adv_company_sq'],'', 'selectbox_change();');
		
		$exist_brand_list = $this->companystatistics_model->select_exist_Brand_list(array('adv_company_sq' => $adv_company_sq));
		$brand_list = array();
		foreach ($exist_brand_list as $row)
		{
			$brand_list[$row['adv_account_sq']] = $row['adv_brand_nm'];
		}
		$vars['exist_brand_list_selectbox'] = $this->ui_component->create_selectbox('adv_account_sq', $brand_list, $querystring['adv_account_sq'],'전체');
		
		// 페이징 처리
		$config['base_url'] = '/statistics/companyStatistics/brand';
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
		
		$vars['excel_url'] = '/statistics/companyStatistics/brand_excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = array('/web/js/jquery/jquery.tablesorter.min.js', '/web/js/statistics/company.js');
		$this->load->view('statistics/company/company_brand_view', $vars);
	}
	
	function brand_excel_get()
	{
		$this->load->library('excel');
	
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$adv_company_sq = $this->get('adv_company_sq') ?  $this->get('adv_company_sq') : '';
		$adv_account_sq = $this->get('adv_account_sq') ?  $this->get('adv_account_sq') : '';
	
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'adv_company_sq' => $adv_company_sq,
				'adv_account_sq' => $adv_account_sq
		);
	
		$list = $this->companystatistics_model->select_brand_list($params);
		$column_list = array (
				'브랜드' => 'adv_brand_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
	
		$this->excel->export_excel('brand_statistics_list.xls', 'brand_statistics', $column_list, $list);
	}
	
	
	function media_get()
	{
		$vars = array();
		
		$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
		$num_links = $this->config->item('list_num_links'); // 페이지 수
		$per_page = $this->get('per_page') ? $this->get('per_page') : 15; // 페이지당 출력 게시글수
		
		$querystring['search_start_dt'] = $start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$querystring['search_end_dt'] = $end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$querystring['adv_company_sq'] = $adv_company_sq = $this->get('adv_company_sq') ?  $this->get('adv_company_sq') : '';
		$querystring['adv_account_sq'] = $adv_account_sq = $this->get('adv_account_sq') ?  $this->get('adv_account_sq') : '';
		$vars = $querystring;
		
		$params = array (
				'search_start_dt' => $querystring['search_start_dt'],
				'search_end_dt' => $querystring['search_end_dt'],
				'adv_company_sq' => $adv_company_sq,
				'adv_account_sq' => $adv_account_sq,
				'cur_page' => ($cur_page - 1) * $per_page,
				'per_page' => $per_page
		);
		
		$vars['list'] = $this->companystatistics_model->select_media_list($params);
		$vars['total_rows'] = $this->companystatistics_model->count_select_media_list($params);
		$exist_company_list = $this->companystatistics_model->select_exist_company_list();
		$company_list = array();
		foreach ($exist_company_list as $row)
		{
			$company_list[$row['adv_company_sq']] = $row['company_nm'];
		}
		$vars['exist_company_list_selectbox'] = $this->ui_component->create_selectbox('adv_company_sq', $company_list, $querystring['adv_company_sq'],'', 'selectbox_change();');
		
		$exist_brand_list = $this->companystatistics_model->select_exist_Brand_list(array('adv_company_sq' => $adv_company_sq));
		$brand_list = array();
		foreach ($exist_brand_list as $row)
		{
			$brand_list[$row['adv_account_sq']] = $row['adv_brand_nm'];
		}
		$vars['exist_brand_list_selectbox'] = $this->ui_component->create_selectbox('adv_account_sq', $brand_list, $querystring['adv_account_sq'],'전체');
		
		// 페이징 처리
		$config['base_url'] = '/statistics/companyStatistics/media';
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
		
		$vars['excel_url'] = '/statistics/companyStatistics/media_excel?' . $_SERVER['QUERY_STRING'];
		
		$this->yield = true;
		$this->yield_js = array('/web/js/jquery/jquery.tablesorter.min.js', '/web/js/statistics/company.js');
		$this->load->view('statistics/company/company_media_view', $vars);
	}
	
	function media_excel_get()
	{
		$this->load->library('excel');
	
		$start_dt = $this->get('search_start_dt') ? $this->get('search_start_dt') : '';
		$end_dt = $this->get('search_end_dt') ?  $this->get('search_end_dt') : '';
		$adv_company_sq = $this->get('adv_company_sq') ?  $this->get('adv_company_sq') : '';
		$adv_account_sq = $this->get('adv_account_sq') ?  $this->get('adv_account_sq') : '';
	
		// 리스트 조회
		$params = array (
				'search_start_dt' => $start_dt,
				'search_end_dt' => $end_dt,
				'adv_company_sq' => $adv_company_sq,
				'adv_account_sq' => $adv_account_sq
		);
	
		$list = $this->companystatistics_model->select_media_list($params);
		$column_list = array (
				'미디어' => 'media_nm',
				'시도 건수' => 'request_cnt',
				'성공 건수' => 'success_cnt',
				'성공율' => 'success_rate',
				'Click 수' => 'click_cnt',
				'CTR' => 'click_rate'
		);
	
		$this->excel->export_excel('media_statistics_list.xls', 'media_statistics', $column_list, $list);
	}
}
/* End of file companystatistics.php */
/* Location: ./application/admin/controllers/statistics/companystatistics.php */