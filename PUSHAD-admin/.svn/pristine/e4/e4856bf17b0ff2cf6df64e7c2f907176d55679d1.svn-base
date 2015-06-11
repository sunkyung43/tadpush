<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller
{
	/**
	 * @var Test_model
	 */
	public $test_model;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('test/test_model');
		
	}

	function advertBookingDateEdit_get()
	{
		$data = array();

		$data['campaign_nm'] = $this->get('campaign_nm');
		$data['campaign_sq'] = $this->get('campaign_sq');
		$data['ad_nm'] = $this->get('ad_nm');
		$data['ad_sq'] = $this->get('ad_sq');

		$start_dt = $this->get('start_dt');
		log_message('info', "start_dt=$start_dt");
		$temp = explode(' ', $start_dt);
		list($year, $month, $day) = explode("-", $temp[0]) ;
		list($hour, $minute, $second) = explode(":", $temp[1]) ;

		$data['start_dt'] = $start_dt;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['day'] = $day;
		$data['hour'] = $hour;
		$data['minute'] = $minute;

		$this->yield = true;
		$this->load->view('/test/advertBookingDateEdit_view', $data);
	}

	function advertBookingDateEdit_post()
	{
		$post_data = $this->input->post();

		// 유효성 검사
		$this->form_validation->set_rules('campaign_sq', 'campaign_sq', 'required');
		$this->form_validation->set_rules('ad_sq', 'ad_sq', 'required');

		$this->form_validation->set_rules('year', '년', 'required|max_length[4]|numeric');
		$this->form_validation->set_rules('month', '월', 'required|max_length[2]|numeric');
		$this->form_validation->set_rules('day', '일', 'required|max_length[2]|numeric');
		$this->form_validation->set_rules('hour', '시', 'required|max_length[2]|numeric');
		$this->form_validation->set_rules('minute', '분', 'required|max_length[2]|numeric');

		if ($this->form_validation->run() == FALSE)
		{
			$response_data = '';
			$response_data = $this->lang->line('form_validation_error') ."\n";
			$response_data .= $this->form_validation->error_string('[', ']');
			echo json_encode(array('response_type' => 'fail', 'response_data' => $response_data));
			return;
		}

		if($post_data['month'] < 1 || $post_data['month'] > 12 || $post_data['day'] < 1 || $post_data['day'] > 31 || $post_data['hour'] < 0 || $post_data['hour'] > 23 || $post_data['minute'] < 0 || $post_data['minute'] > 59)
		{
			echo json_encode(array('response_type' => 'fail', 'response_data' => '발송시간 형식이 맞지 않습니다.'));
			return;
		}

		$start_dt = sprintf('%04d-%02d-%02d %02d:%02d:00', $post_data['year'], $post_data['month'], $post_data['day'], $post_data['hour'], $post_data['minute']);

		// 광고 시간 업데이트
		$this->test_model->update_advert_start_dt($post_data['ad_sq'], $start_dt);
		
		// 광고 히스토리 등록
		$history_array = array ();
		$history_array['campaign_sq'] = $post_data['campaign_sq'];
		$history_array['ad_sq'] = $post_data['ad_sq'];
		$history_array['account_sq'] = $this->session->userdata('ACCOUNT_SQ');
		$history_array['history_gb'] = '발송일';
		$history_array['modify_before'] = $post_data['start_dt'];
		$history_array['modify_after'] = $start_dt;
		$this->test_model->insert_campaign_history($history_array);

		// 캠페인 수정 (시작, 종료, 발송)
		$this->test_model->update_campaign_summary($post_data['campaign_sq']);
		
		$this->response(array('response_type' => 'success', 'response_data' => '/campaign/campaign/detail?campaign_sq=' .$post_data['campaign_sq']));
	}


	function mdnDecrypt_get()
	{
		$str = $this->get('str');
// 		$str = 'VtQexxbXbkXpuCCJoxDoZg==';
		$result = des_decrypt($str);
		echo $str .' / ' .$result;
	}
	
	function mdnEncrypt_get()
	{
		$str = $this->get('str');
// 		$str = '+821063178591';
		$result = des_encrypt($str);
		echo $str .' / ' .$result;
	}
	
	function hashEncrypt_get() {
		$str = $this->get('str');
		$result = hash("sha256", $str);
		echo $str .' / ' .$result;
	}
	
	function skpEncrypt_get()
	{
		$str = $this->get('str');
		$result = skp_encrypt($str);
		echo $str .' / ' .$result;
	}

	function skpDecrypt_get()
	{
		$str = $this->get('str');
		$result = skp_decrypt($str);
		echo $str .' / ' .$result;
	}

	function phpinfo_get()
	{
		echo phpinfo();
	}

}

/* End of file test.php */
/* Location: ./application/admin/controllers/test/test.php */
