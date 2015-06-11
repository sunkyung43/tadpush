<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Creative_vo {
	private $creative_sq;
	private $ticket_text;
	private $large_icon_image;
	private $content_title;
	private $content_text;
	private $sub_text;
	private $landing_type_cd;
	private $landing_type_url;
	private $and_run_url;
	private $tst_dl_url;
	private $mar_dl_url;
	private $alt_url;
	private $banner_image;
	private $summary_text;
	private $action1_landing_type_cd;
	private $action1_text;
	private $action1_landing_type_url;
	private $action1_and_run_url;
	private $action1_tst_dl_url;
	private $action1_mar_dl_url;
	private $action1_alt_url;
	private $action2_landing_type_cd;
	private $action2_text;
	private $action2_landing_type_url;
	private $action2_and_run_url;
	private $action2_tst_dl_url;
	private $action2_mar_dl_url;
	private $action2_alt_url;
	private $action3_landing_type_cd;
	private $action3_text;
	private $action3_landing_type_url;
	private $action3_and_run_url;
	private $action3_tst_dl_url;
	private $action3_mar_dl_url;
	private $action3_alt_url;
	private $inbox_text_line_1;
	private $inbox_text_line_2;
	private $inbox_text_line_3;
	private $inbox_text_line_4;
	private $inbox_text_line_5;
	private $inbox_text_line_6;
	private $inbox_text_line_7;
	private $popup_title;
	private $popup_content_text;
	private $landing_button_title;
	private $popup_image;

	function __construct() {
	}

	public function equals($vo) {
		$class = new ReflectionClass('Creative_vo');
		$methods = $class->getMethods();
		foreach ( $methods as $method_info ) {
			$method = $method_info->name;
			$index = strpos($method, '_');
			if ($index > 0 && strcmp('get', substr($method, 0, $index)) == 0) {
				if ($method == 'get_creative_sq') {
					continue;
				}
				if ($this->$method() != $vo->$method()) {
					return false;
				}
			}
		}
		return true;
	}

	public function get_creative_sq() {
		return $this->creative_sq;
	}

	public function set_creative_sq($creative_sq) {
		$this->creative_sq = $creative_sq;
	}

	public function get_ticket_text() {
		return $this->ticket_text;
	}

	public function set_ticket_text($ticket_text) {
		$this->ticket_text = $ticket_text;
	}

	public function get_large_icon_image() {
		return $this->large_icon_image;
	}

	public function set_large_icon_image($large_icon_image) {
		$this->large_icon_image = $large_icon_image;
	}

	public function get_content_title() {
		return $this->content_title;
	}

	public function set_content_title($content_title) {
		$this->content_title = $content_title;
	}

	public function get_content_text() {
		return $this->content_text;
	}

	public function set_content_text($content_text) {
		$this->content_text = $content_text;
	}

	public function get_sub_text() {
		return $this->sub_text;
	}

	public function set_sub_text($sub_text) {
		$this->sub_text = $sub_text;
	}

	public function get_landing_type_cd() {
		return $this->landing_type_cd;
	}

	public function set_landing_type_cd($landing_type_cd) {
		$this->landing_type_cd = $landing_type_cd;
	}

	public function get_landing_type_url() {
		return $this->landing_type_url;
	}

	public function set_landing_type_url($landing_type_url) {
		$this->landing_type_url = $landing_type_url;
	}

	public function get_and_run_url() {
		return $this->and_run_url;
	}

	public function set_and_run_url($and_run_url) {
		$this->and_run_url = $and_run_url;
	}

	public function get_tst_dl_url() {
		return $this->tst_dl_url;
	}

	public function set_tst_dl_url($tst_dl_url) {
		$this->tst_dl_url = $tst_dl_url;
	}

	public function get_mar_dl_url() {
		return $this->mar_dl_url;
	}

	public function set_mar_dl_url($mar_dl_url) {
		$this->mar_dl_url = $mar_dl_url;
	}

	public function get_alt_url() {
		return $this->alt_url;
	}

	public function set_alt_url($alt_url) {
		$this->alt_url = $alt_url;
	}

	public function get_banner_image() {
		return $this->banner_image;
	}

	public function set_banner_image($banner_image) {
		$this->banner_image = $banner_image;
	}

	public function get_summary_text() {
		return $this->summary_text;
	}

	public function set_summary_text($summary_text) {
		$this->summary_text = $summary_text;
	}

	public function get_action1_landing_type_cd() {
		return $this->action1_landing_type_cd;
	}

	public function set_action1_landing_type_cd($action1_landing_type_cd) {
		$this->action1_landing_type_cd = $action1_landing_type_cd;
	}

	public function get_action1_text() {
		return $this->action1_text;
	}

	public function set_action1_text($action1_text) {
		$this->action1_text = $action1_text;
	}

	public function get_action1_landing_type_url() {
		return $this->action1_landing_type_url;
	}

	public function set_action1_landing_type_url($action1_landing_type_url) {
		$this->action1_landing_type_url = $action1_landing_type_url;
	}

	public function get_action1_and_run_url() {
		return $this->action1_and_run_url;
	}

	public function set_action1_and_run_url($action1_and_run_url) {
		$this->action1_and_run_url = $action1_and_run_url;
	}

	public function get_action1_tst_dl_url() {
		return $this->action1_tst_dl_url;
	}

	public function set_action1_tst_dl_url($action1_tst_dl_url) {
		$this->action1_tst_dl_url = $action1_tst_dl_url;
	}

	public function get_action1_mar_dl_url() {
		return $this->action1_mar_dl_url;
	}

	public function set_action1_mar_dl_url($action1_mar_dl_url) {
		$this->action1_mar_dl_url = $action1_mar_dl_url;
	}

	public function get_action1_alt_url() {
		return $this->action1_alt_url;
	}

	public function set_action1_alt_url($action1_alt_url) {
		$this->action1_alt_url = $action1_alt_url;
	}

	public function get_action2_landing_type_cd() {
		return $this->action2_landing_type_cd;
	}

	public function set_action2_landing_type_cd($action2_landing_type_cd) {
		$this->action2_landing_type_cd = $action2_landing_type_cd;
	}

	public function get_action2_text() {
		return $this->action2_text;
	}

	public function set_action2_text($action2_text) {
		$this->action2_text = $action2_text;
	}

	public function get_action2_landing_type_url() {
		return $this->action2_landing_type_url;
	}

	public function set_action2_landing_type_url($action2_landing_type_url) {
		$this->action2_landing_type_url = $action2_landing_type_url;
	}

	public function get_action2_and_run_url() {
		return $this->action2_and_run_url;
	}

	public function set_action2_and_run_url($action2_and_run_url) {
		$this->action2_and_run_url = $action2_and_run_url;
	}

	public function get_action2_tst_dl_url() {
		return $this->action2_tst_dl_url;
	}

	public function set_action2_tst_dl_url($action2_tst_dl_url) {
		$this->action2_tst_dl_url = $action2_tst_dl_url;
	}

	public function get_action2_mar_dl_url() {
		return $this->action2_mar_dl_url;
	}

	public function set_action2_mar_dl_url($action2_mar_dl_url) {
		$this->action2_mar_dl_url = $action2_mar_dl_url;
	}

	public function get_action2_alt_url() {
		return $this->action2_alt_url;
	}

	public function set_action2_alt_url($action2_alt_url) {
		$this->action2_alt_url = $action2_alt_url;
	}

	public function get_action3_landing_type_cd() {
		return $this->action3_landing_type_cd;
	}

	public function set_action3_landing_type_cd($action3_landing_type_cd) {
		$this->action3_landing_type_cd = $action3_landing_type_cd;
	}

	public function get_action3_text() {
		return $this->action3_text;
	}

	public function set_action3_text($action3_text) {
		$this->action3_text = $action3_text;
	}

	public function get_action3_landing_type_url() {
		return $this->action3_landing_type_url;
	}

	public function set_action3_landing_type_url($action3_landing_type_url) {
		$this->action3_landing_type_url = $action3_landing_type_url;
	}

	public function get_action3_and_run_url() {
		return $this->action3_and_run_url;
	}

	public function set_action3_and_run_url($action3_and_run_url) {
		$this->action3_and_run_url = $action3_and_run_url;
	}

	public function get_action3_tst_dl_url() {
		return $this->action3_tst_dl_url;
	}

	public function set_action3_tst_dl_url($action3_tst_dl_url) {
		$this->action3_tst_dl_url = $action3_tst_dl_url;
	}

	public function get_action3_mar_dl_url() {
		return $this->action3_mar_dl_url;
	}

	public function set_action3_mar_dl_url($action3_mar_dl_url) {
		$this->action3_mar_dl_url = $action3_mar_dl_url;
	}

	public function get_action3_alt_url() {
		return $this->action3_alt_url;
	}

	public function set_action3_alt_url($action3_alt_url) {
		$this->action3_alt_url = $action3_alt_url;
	}

	public function get_inbox_text_line_1() {
		return $this->inbox_text_line_1;
	}

	public function set_inbox_text_line_1($inbox_text_line_1) {
		$this->inbox_text_line_1 = $inbox_text_line_1;
	}

	public function get_inbox_text_line_2() {
		return $this->inbox_text_line_2;
	}

	public function set_inbox_text_line_2($inbox_text_line_2) {
		$this->inbox_text_line_2 = $inbox_text_line_2;
	}

	public function get_inbox_text_line_3() {
		return $this->inbox_text_line_3;
	}

	public function set_inbox_text_line_3($inbox_text_line_3) {
		$this->inbox_text_line_3 = $inbox_text_line_3;
	}

	public function get_inbox_text_line_4() {
		return $this->inbox_text_line_4;
	}

	public function set_inbox_text_line_4($inbox_text_line_4) {
		$this->inbox_text_line_4 = $inbox_text_line_4;
	}

	public function get_inbox_text_line_5() {
		return $this->inbox_text_line_5;
	}

	public function set_inbox_text_line_5($inbox_text_line_5) {
		$this->inbox_text_line_5 = $inbox_text_line_5;
	}

	public function get_inbox_text_line_6() {
		return $this->inbox_text_line_6;
	}

	public function set_inbox_text_line_6($inbox_text_line_6) {
		$this->inbox_text_line_6 = $inbox_text_line_6;
	}

	public function get_inbox_text_line_7() {
		return $this->inbox_text_line_7;
	}

	public function set_inbox_text_line_7($inbox_text_line_7) {
		$this->inbox_text_line_7 = $inbox_text_line_7;
	}

	public function get_popup_title() {
		return $this->popup_title;
	}

	public function set_popup_title($popup_title) {
		$this->popup_title = $popup_title;
	}

	public function get_popup_content_text() {
		return $this->popup_content_text;
	}

	public function set_popup_content_text($popup_content_text) {
		$this->popup_content_text = $popup_content_text;
	}

	public function get_landing_button_title() {
		return $this->landing_button_title;
	}

	public function set_landing_button_title($landing_button_title) {
		$this->landing_button_title = $landing_button_title;
	}

	public function get_popup_image() {
		return $this->popup_image;
	}

	public function set_popup_image($popup_image) {
		$this->popup_image = $popup_image;
	}

}

/* End of file advert_vo.php */
/* Location: ./application/admin/vo/campaign/advert_vo.php */