<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PushAgreement extends MY_Controller {
	/**
	 *
	 * @var Push_agreement_model
	 */
	public $push_agreement_model;

	function __construct() {
		parent::__construct();
		
		$this->load->model('/system/push_agreement_model');
	}

	function index_get()
	{
		$total_list = array();
		$total_list = array_merge($total_list, $this->push_agreement_model->select_param_list());
		$total_list = array_merge($total_list, $this->push_agreement_model->select_idle_list());
		$total_list = array_merge($total_list, $this->push_agreement_model->select_cancel_list());

		$vars = array();
		$vars['total_param_count'] = 0;
		$vars['total_idle_count'] = 0;
		$vars['total_cancel_count'] = 0;
		$cnt_array = array('param_cnt' => 0, 'idle_cnt' => 0, 'cancel_cnt' => 0);
		$vars['list'] = array('SKT' => $cnt_array, 'KT' => $cnt_array, 'LGU+' => $cnt_array, 'ETC' => $cnt_array);
		foreach($total_list as $row) {
			if(isset($row['param_cnt'])) {
				$vars['total_param_count'] += $row['param_cnt'];
				$vars['list'][$row['carrier_nm']]['param_cnt'] = $row['param_cnt'];
			} else if(isset($row['idle_cnt'])) {
				$vars['total_idle_count'] += $row['idle_cnt'];
				$vars['list'][$row['carrier_nm']]['idle_cnt'] = $row['idle_cnt'];
			} else if(isset($row['cancel_cnt'])) {
				$vars['total_cancel_count'] += $row['cancel_cnt'];
				$vars['list'][$row['carrier_nm']]['cancel_cnt'] = $row['cancel_cnt'];
			}
		}		
	
		$this->yield = true;
		$this->load->view('/system/pushAgreement/push_agreement_list_view', $vars);
	}

}

/* End of file pushAgreement.php */
/* Location: ./application/admin/controllers/system/pushAgreement.php */