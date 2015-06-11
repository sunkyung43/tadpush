<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PushHistory extends MY_Controller {
	/**
	 *
	 * @var Push_history_model
	 */
	public $push_history_model;

	function __construct() {
		parent::__construct();
		
		$this->load->model('/system/push_history_model');
		
		$this->load_vo('system/push_history_vo');
	}

	function index_get() {
		$querystring['mdn'] = $this->get('mdn') ? $this->get('mdn') : '';
		
		$vars = $querystring;
		
		if ($querystring['mdn'] != '') {
			$cur_page = $this->get('cur_page') ? $this->get('cur_page') : 1; // 현재 페이지
			$num_links = $this->config->item('list_num_links'); // 페이지 수
			$per_page = $this->get('per_page') ? $this->get('per_page') : $this->config->item('list_per_page'); // 페이지당 출력 게시글수
			
			$params = array (
					'mdn' => des_encrypt($querystring['mdn']),
					'cur_page' => ($cur_page - 1) * $per_page,
					'per_page' => $per_page 
			);
			
			$vars['list'] = $this->push_history_model->select_push_history_list($params);
			$vars['total_rows'] = $this->push_history_model->count_push_history_list($params);
			
			$this->push_history_model->generate_row_num($vars['list'], $vars['total_rows'], $cur_page, $per_page);
			
			foreach($vars['list'] as $push_history_vo) {
				$push_history_vo->set_mdn(des_decrypt($push_history_vo->get_mdn()));
			}
			
			// 페이징 처리
			$config['base_url'] = '/system/pushHistory';
			$config['total_rows'] = $vars['total_rows'];
			$config['cur_page'] = $cur_page;
			$config['per_page'] = $per_page;
			$config['num_links'] = $num_links;
			$config['querystring_list'] = $querystring;
			
			$this->paging->init($config);
			$vars['paging'] = $this->paging->create_page();
			
			$vars['excel_url'] = '/system/pushHistory/excel?' . $_SERVER['QUERY_STRING'];
		}
		
		$this->yield = true;
		$this->yield_js = '/web/js/system/pushHistory/push_history_list.js';
		$this->load->view('/system/pushHistory/push_history_list_view', $vars);
	}

	function excel_get() {
		$this->load->library('excel');
		
		$mdn = $this->get('mdn') ? $this->get('mdn') : '';
		
		// 리스트 조회
		$params = array (
				'mdn' => des_encrypt($mdn) 
		);
		
		$list = $this->push_history_model->select_push_history_list($params);
		$total_rows = $this->push_history_model->count_push_history_list($params);
		
		$this->push_history_model->generate_row_num($list, $total_rows);
		
		foreach($list as $push_history_vo) {
			$push_history_vo->set_mdn(des_decrypt($push_history_vo->get_mdn()));
		}
		
		$column_list = array (
				'No' => 'row_num',
				'MDN' => 'mdn',
				'Device ID' => 'device_id',
				'발송일/시간' => 'start_dt',
				'캠페인 명' => 'campaign_nm',
				'AD 명' => 'ad_nm',
				'App 명' => 'media_nm',
				'상태' => 'success_yn'
		);
		
		$this->excel->export_excel('push_history_list.xls', 'push_hitory', $column_list, $list);
	}

}

/* End of file pushHistory.php */
/* Location: ./application/admin/controllers/system/pushHistory.php */