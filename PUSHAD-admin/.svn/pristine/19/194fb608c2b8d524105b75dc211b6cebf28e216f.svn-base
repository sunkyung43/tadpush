<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'vo/common/base_vo.php';

class Report_vo extends Base_vo
{
	private $campaign_sq;
	private $campaign_nm;
	private $adv_company_sq;
	private $adv_account_sq;
	private $start_dt;
	private $end_dt;
	private $tot_budget_amt;
	private $tot_push_booking_cnt;
	private $tot_receive_cnt;	
	private $adv_company_nm;
	private $adv_brand_nm;
	
	//광고
	private $ad_sq;
	private $ad_nm;
	private $success_cnt;
	private $receive_cnt;
	private $request_cnt;
	private $tot_click;
	private $success_per;
	private $ctr_cnt;
	private $division_dt;
	private $ad_type_nm;
	private $ad_status_cd;
	
	//미디어
	private $media_id;
	private $media_nm;
	private $media_status_nm;
	private $media_category_nm;
	private $media_os_nm;
	private $media_key;
	private $create_dt;
	
	//합계
	private $tot_request_cnt;
	private $tot_success_cnt;
	
	//타겟팅
	private $target_nm;
	private $target;
	
	function __construct()
	{
		
	}
	
	function get_row_num()
	{
		return $this->row_num;
	}
	
	function set_row_num($row_num)
	{
		$this->row_num = $row_num;
	}
	
	public function get_campaign_sq()
	{
		return $this->campaign_sq;
	}
	
	public function set_campaign_sq($campaign_sq)
	{
		$this->campaign_sq = $campaign_sq;
	}

	public function get_campaign_nm()
	{
	    return $this->campaign_nm;
	}

	public function set_campaign_nm($campaign_nm)
	{
	    $this->campaign_nm = $campaign_nm;
	}

	public function get_adv_company_sq()
	{
	    return $this->adv_company_sq;
	}

	public function set_adv_company_sq($adv_company_sq)
	{
	    $this->adv_company_sq = $adv_company_sq;
	}

	public function get_adv_account_sq()
	{
	    return $this->adv_account_sq;
	}

	public function set_adv_account_sq($adv_account_sq)
	{
	    $this->adv_account_sq = $adv_account_sq;
	}

	public function get_start_dt()
	{
	    return $this->start_dt;
	}

	public function set_start_dt($start_dt)
	{
	    $this->start_dt = $start_dt;
	}

	public function get_end_dt()
	{
	    return $this->end_dt;
	}

	public function set_end_dt($end_dt)
	{
	    $this->end_dt = $end_dt;
	}

	public function get_tot_budget_amt()
	{
	    return $this->tot_budget_amt;
	}

	public function set_tot_budget_amt($tot_budget_amt)
	{
	    $this->tot_budget_amt = $tot_budget_amt;
	}

	public function get_tot_push_booking_cnt()
	{
	    return $this->tot_push_booking_cnt;
	}

	public function set_tot_push_booking_cnt($tot_push_booking_cnt)
	{
	    $this->tot_push_booking_cnt = $tot_push_booking_cnt;
	}

	public function get_bizrep_company_sq()
	{
	    return $this->bizrep_company_sq;
	}

	public function set_bizrep_company_sq($bizrep_company_sq)
	{
	    $this->bizrep_company_sq = $bizrep_company_sq;
	}

	public function get_rep_company_sq()
	{
	    return $this->rep_company_sq;
	}

	public function set_rep_company_sq($rep_company_sq)
	{
	    $this->rep_company_sq = $rep_company_sq;
	}

	public function get_agency_company_sq()
	{
	    return $this->agency_company_sq;
	}

	public function set_agency_company_sq($agency_company_sq)
	{
	    $this->agency_company_sq = $agency_company_sq;
	}
	
	public function get_tot_receive_cnt()
	{
		return $this->tot_receive_cnt;
	}
	
	public function set_tot_receive_cnt($tot_receive_cnt)
	{
		$this->tot_receive_cnt = $tot_receive_cnt;
	}
	
	public function get_adv_company_nm() {
		return $this->adv_company_nm;
	}
	
	public function set_adv_company_nm($adv_company_nm) {
		$this->adv_company_nm = $adv_company_nm;
	}
	
	public function get_adv_brand_nm() {
		return $this->adv_brand_nm;
	}
	
	public function set_adv_brand_nm($adv_brand_nm) {
		$this->adv_brand_nm = $adv_brand_nm;
	}
	
	//광고
	public function get_ad_sq()
	{
		return $this->ad_sq;
	}
	
	public function set_ad_sq($ad_sq)
	{
		$this->ad_sq = $ad_sq;
	}
	
	public function get_ad_nm()
	{
		return $this->ad_nm;
	}
	
	public function set_ad_nm($ad_nm)
	{
		$this->ad_nm = $ad_nm;
	}
	
	public function get_success_cnt()
	{
		return $this->success_cnt;
	}
	
	public function set_success_cnt($success_cnt)
	{
		$this->success_cnt = $success_cnt;
	}
	
	public function get_request_cnt()
	{
		return $this->request_cnt;
	}
	
	public function set_receive_cnt($receive_cnt)
	{
		$this->receive_cnt = $receive_cnt;
	}
	
	public function get_receive_cnt()
	{
		return $this->receive_cnt;
	}
	
	public function set_request_cnt($request_cnt)
	{
		$this->request_cnt = $request_cnt;
	}
	
	public function get_tot_click()
	{
		return $this->tot_click;
	}
	
	public function set_tot_click($tot_click)
	{
		$this->tot_click = $tot_click;
	}
	
	public function get_success_per()
	{
		return $this->success_per;
	}
	
	public function set_success_per($success_per)
	{
		$this->success_per = $success_per;
	}
	
	public function get_ctr_cnt()
	{
		return $this->ctr_cnt;
	}
	
	public function set_ctr_cnt($ctr_cnt)
	{
		$this->ctr_cnt = $ctr_cnt;
	}
	
	public function get_division_dt()
	{
		return $this->division_dt;
	}
	
	public function set_division_dt($division_dt)
	{
		$this->division_dt = $division_dt;
	}
	
	public function get_ad_type_nm()
	{
		return $this->ad_type_nm;
	}
	
	public function set_ad_type_nm($ad_type_nm)
	{
		$this->ad_type_nm = $ad_type_nm;
	}
	
	public function get_ad_status_cd()
	{
		return $this->ad_status_cd;
	}
	
	public function set_ad_status_cd($ad_status_cd)
	{
		$this->ad_status_cd = $ad_status_cd;
	}
	
	//미디어
	public function get_media_id()
	{
		return $this->media_id;
	}
	
	public function set_media_id($media_id)
	{
		$this->media_id = $media_id;
	}
	
	public function get_media_nm()
	{
		return $this->media_nm;
	}
	
	public function set_media_nm($media_nm)
	{
		$this->media_nm = $media_nm;
	}
	
	public function get_media_status_nm()
	{
		return $this->media_status_nm;
	}
	
	public function set_media_status_nm($media_status_nm)
	{
		$this->media_status_nm = $media_status_nm;
	}
	
	public function get_media_category_nm()
	{
		return $this->media_category_nm;
	}
	
	public function set_media_category_nm($media_category_nm)
	{
		$this->media_category_nm = $media_category_nm;
	}
	
	public function get_create_dt()
	{
		return $this->create_dt;
	}
	
	public function set_create_dt($create_dt)
	{
		$this->create_dt = $create_dt;
	}
	
	public function get_media_os_nm()
	{
		return $this->media_os_nm;
	}
	
	public function set_media_os_nm($media_os_nm)
	{
		$this->media_os_nm = $media_os_nm;
	}
	
	public function get_media_key()
	{
		return $this->media_key;
	}
	
	public function set_media_key($media_key)
	{
		$this->media_key = $media_key;
	}
	
	//합계
	public function get_tot_request_cnt()
	{
		return $this->tot_request_cnt;
	}
	
	public function set_tot_request_cnt($tot_request_cnt)
	{
		$this->tot_request_cnt = $tot_request_cnt;
	}
	
	public function get_tot_success_cnt()
	{
		return $this->tot_success_cnt;
	}
	
	public function set_tot_success_cnt($tot_success_cnt)
	{
		$this->tot_success_cnt = $tot_success_cnt;
	}
	
	public function get_target_nm()
	{
		return $this->target_nm;
	}
	
	public function set_target_nm($target_nm)
	{
		$this->target_nm = $target_nm;
	}
	
	public function get_target()
	{
		return $this->target;
	}
	
	public function set_target($target)
	{
		$this->target = $target;
	}
}

/* End of file report_vo.php */
/* Location: ./application/admin/vo/report/report_vo.php */