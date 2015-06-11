<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Yield {
	/**
	 *
	 * @var CI_URI
	 */
	private $uri;

	function pre_system_init() {
		ini_set('mysql.connect_timeout', 1);
	}

	function doYield() {
		global $OUT;
		
		$CI = & get_instance();
		$output = $CI->output->get_output();
		
		$CI->yield = isset($CI->yield) ? $CI->yield : false; // false로 할 경우에는 기본 레이아웃을 호출하지 않음.
		$CI->layout = isset($CI->layout) ? $CI->layout : 'default';
		
		// url의 debug옵션이 Y일경우 디버깅 프로파일러를 출력.
		if ($CI->input->get('debug') == 'Y') {
			$CI->output->enable_profiler(true);
		}
		
		if ($CI->yield === false) {
			$OUT->_display($output);
			return;
		}
		
		if ($CI->layout == 'default') {
			$CI->logged_in = $CI->session->userdata('LOGGED_IN');
			$CI->session_account_sq = $CI->session->userdata('ACCOUNT_SQ');
			$CI->session_user_nm = $CI->session->userdata('USER_NM');
			$CI->session_role_nm = $CI->session->userdata('ROLE_NM');
			$CI->session_user_id = $CI->session->userdata('USER_ID');
			$CI->last_access_dt = $CI->session->userdata('LAST_ACCESS_DT');
			$CI->menu = $this->_get_menu();
			$CI->top_menu_list = $CI->menu['TOP_MENU_LIST'];
			$CI->depth2_menu_list = $CI->menu['DEPTH2_MENU_LIST'];
			$CI->depth3_menu_list = isset($CI->menu['DEPTH3_MENU_LIST']) ? $CI->menu['DEPTH3_MENU_LIST'] : array ();
			
			if (!isset($CI->logged_in) or $CI->logged_in !== TRUE) {
				redirect('/');
				// $output = '<meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
				// $output .= '페이지 권한이 없습니다...';
				// $OUT->_display($output);
				return;
			}
			
			$CI->top_menu_sq = 0;
			$CI->depth2_menu_sq = 0;
			$CI->depth3_menu_sq = 0;
			
			$segments = $CI->uri->segment_array();
			$segment_count = count($segments);
			for($i = $segment_count; $i > 0; $i--) {
				$url = '';
				for($segment_index = 1; $segment_index <= $i; $segment_index++) {
					$url .= '/' . $CI->uri->segment($segment_index);
				}
				
				foreach ( $CI->depth2_menu_list as $depth1_menu_sq => $menuArray ) {
					foreach ( $menuArray as $depth2_menu_sq => $menu ) {
						if (isset($CI->depth3_menu_list[$depth2_menu_sq])) {
							foreach ( $CI->depth3_menu_list[$depth2_menu_sq] as $depth3_menu_sq => $depth3_menu ) {
								$MENU_URL = $depth3_menu['MENU_URL'];
								if (substr($MENU_URL, 0, 1) !== '/') {
									$MENU_URL = '/' . $depth3_menu['MENU_URL'];
								}
								
								if ($MENU_URL == $url) {
									$CI->top_menu_sq = $menu['MENU_PARENT_SQ'];
									$CI->depth2_menu_sq = $menu['MENU_SQ'];
									$CI->depth3_menu_sq = $depth3_menu['MENU_SQ'];
									break 4;
								}
							}
						}
						$MENU_URL = $menu['MENU_URL'];
						if (substr($MENU_URL, 0, 1) !== '/') {
							$MENU_URL = '/' . $menu['MENU_URL'];
						}
						
						if ($MENU_URL == $url) {
							$CI->top_menu_sq = $menu['MENU_PARENT_SQ'];
							$CI->depth2_menu_sq = $menu['MENU_SQ'];
							$CI->depth3_menu_sq = 0;
							break 3;
						}
					}
				}
			}
		}
		
		$requested = APPPATH . 'views/layouts/' . $CI->layout . EXT;
		$layout = $CI->load->file($requested, true);
		$output = str_replace('{yield}', $output, $layout);
		
		if (isset($CI->yield_js)) {
			$js_html = '';
			if (is_array($CI->yield_js)) {
				foreach ( $CI->yield_js as $path ) {
					
					$js_html .= sprintf('<script type="text/javascript" src="%s"></script>', $path);
					$js_html .= "\n";
				}
			} else {
				$js_html .= sprintf('<script type="text/javascript" src="%s"></script>', $CI->yield_js);
				$js_html .= "\n";
			}
			
			$output = str_replace('{yield javascript}', $js_html, $output);
		} else {
			$output = str_replace('{yield javascript}', '', $output);
		}
		
		if (isset($CI->yield_popup)) {
			$popup_html = '';
			if (is_array($CI->yield_popup)) {
				foreach ( $CI->yield_popup as $popup_id => $popup_contents ) {
					$popup_html .= sprintf('<div id="%s" class="popupWindow">%s</div>', $popup_id, $popup_contents);
					$popup_html .= "\n";
				}
			} else {
				$popup_html .= sprintf('<div id="%s" class="popupWindow"></div>', $CI->yield_popup);
				$popup_html .= "\n";
			}
			$output = str_replace('{yield popup}', $popup_html, $output);
		} else {
			$output = str_replace('{yield popup}', '', $output);
		}
		
		if (preg_match_all('/{yield[\s]*([^}]*)}/', $layout, $matches) && array_key_exists(1, $matches)) {
			foreach ( $matches[1] as $k => $v ) {
				if (!empty($v)) {
					$requested = APPPATH . 'views/layouts/' . $CI->layout . '/' . $v . EXT;
					// if(file_exists(FCPATH.$requested))
					if (file_exists($requested)) {
						$yield = $CI->load->file($requested, true);
						$output = str_replace(sprintf('{yield %s}', $v), $yield, $output);
					}
				}
			}
		}
		
		$OUT->_display($output);
	}

	private function _get_menu() {
		$CI = & get_instance();
		
		$CI->load->model('login/main_model');
		
		$menu = array ();
		
		$temp = $CI->main_model->select_menu($CI->session->userdata('ACCOUNT_SQ'), 1);
		$top_menu_list = array ();
		foreach ( $temp as $row ) {
			$top_menu_list[$row['MENU_SQ']] = $row;
		}
		$menu['TOP_MENU_LIST'] = $top_menu_list;
		
		$temp = $CI->main_model->select_menu($CI->session->userdata('ACCOUNT_SQ'), 2);
		$depth2_menu_list = array ();
		foreach ( $temp as $row ) {
			$depth2_menu_list[$row['MENU_PARENT_SQ']][$row['MENU_SQ']] = $row;
		}
		$menu['DEPTH2_MENU_LIST'] = $depth2_menu_list;
		
		$temp = $CI->main_model->select_menu($CI->session->userdata('ACCOUNT_SQ'), 3);
		$depth3_menu_list = array ();
		foreach($temp as $row)
		{
		$depth3_menu_list[$row['MENU_PARENT_SQ']][$row['MENU_SQ']] = $row;
		}
		$menu['DEPTH3_MENU_LIST'] = $depth3_menu_list;
		
		return $menu;
	}

}

	/* End of file yield.php */
	/* Location: ./application/admin/hooks/yield.php */
