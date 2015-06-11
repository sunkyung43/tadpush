<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Join extends MY_Controller
{
	/**
	 * @var Join_model
	 */
	public $join_model;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('/test/join_model');
		
		$account_sq = $this->session->userdata('ACCOUNT_SQ');
		if ($account_sq != 5000) {
			echo "access denied";
			exit();
		}
	}

	function index_get()
	{
		$this->yield = true;
		$this->load->view('/test/join_view');
	}

	function index_post()
	{
		$this->form_validation->set_rules('ACCOUNT_GB', 'ACCOUNT_GB', 'required');
		$this->form_validation->set_rules('ACCOUNT_STATUS_CD', 'ACCOUNT_STATUS_CD', 'required');
		$this->form_validation->set_rules('USER_ID', 'USER_ID', 'required');
		$this->form_validation->set_rules('USER_PASSWD', 'USER_PASSWD', 'required');
		$this->form_validation->set_rules('ROLE_SQ', 'ROLE_SQ', 'required');
		$this->form_validation->set_rules('USER_STATUS_CD', 'USER_STATUS_CD', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->response(array('response_type' => 'fail', 'response_data' => $this->lang->line('form_validation_error')));
			return;
		}
		
		$form_array = $this->input->post();
	
		
		$form_array['CREATE_DT'] = 'now()';
		$form_array['UPDATE_DT'] = 'now()';
		$form_array['CREATE_ACCOUNT_SQ'] = 4000;
		$form_array['UPDATE_ACCOUNT_SQ'] = 4000;
	
		$list = $this->join_model->select_id($form_array['USER_ID']);
		if(count($list) > 0) {
			$this->response(array('response_type' => 'fail', 'response_data' => $form_array['USER_ID'] .'계정이 존재합니다.'));
			return;
		}
	
		// DB 트랜잭션 시작
		$this->join_model->db->trans_begin();
	
		$account_data['ACCOUNT_GB'] = $form_array['ACCOUNT_GB'];
		$account_data['ACCOUNT_STATUS_CD'] = $form_array['ACCOUNT_STATUS_CD'];
		$account_data['USER_ID'] = $form_array['USER_ID'];
		$account_data['USER_PASSWD'] = hash("sha256", $form_array['USER_PASSWD']);
		$account_data['CREATE_DT'] = 'now()';
		$account_data['UPDATE_DT'] = 'now()';
		$account_data['CREATE_ACCOUNT_SQ'] = 4000;
		$account_data['UPDATE_ACCOUNT_SQ'] = 4000;
		
		$admin_user_data['ACCOUNT_SQ'] = $this->join_model->insert_account($account_data);

		$admin_user_data['ROLE_SQ'] = $form_array['ROLE_SQ'];
		$admin_user_data['USER_STATUS_CD'] = $form_array['USER_STATUS_CD'];

		$admin_user_data['USER_NM'] = $form_array['USER_NM'];
		$admin_user_data['COMPANY_NM'] = $form_array['COMPANY_NM'];
		$admin_user_data['TEAM_NM'] = $form_array['TEAM_NM'];
		$admin_user_data['DUTY_NM'] = $form_array['DUTY_NM'];
		$admin_user_data['MOBILE_NO'] = $form_array['MOBILE_NO'];
		$admin_user_data['EMAIL'] = $form_array['EMAIL'];
		
		$admin_user_data['CREATE_DT'] = 'now()';
		$admin_user_data['UPDATE_DT'] = 'now()';
		$admin_user_data['CREATE_ACCOUNT_SQ'] = 4000;
		$admin_user_data['UPDATE_ACCOUNT_SQ'] = 4000;
		
		$this->join_model->insert_admin_user($admin_user_data);
	
		// DB 트랜잭션 종료
		if ($this->join_model->db->trans_status() === FALSE)
		{
			$this->join_model->db->trans_rollback();
			$this->response(array('response_type' => 'false', 'response_data' => 'DB 등록에 실패하였습니다..'));
			return;
		}
		else
		{
			$this->join_model->db->trans_commit();
		}
		$this->response(array('response_type' => 'success', 'response_data' => '등록완료'));
	}
	
	function idcheck_get()
	{
		$user_id = $this->get('USER_ID') ? $this->get('USER_ID') : ''; // 검색어
		if($user_id == '')
		{
			echo 'user_id is empty';
			return;
		}
		$list = $this->join_model->select_id($user_id);
		if(count($list) <= 0) {
			echo json_encode(array('response_type' => 'success', 'response_data' => $user_id .'계정은 사용가능합니다.'));
		} else {
			echo json_encode(array('response_type' => 'fail', 'response_data' => $user_id .'계정이 존재합니다.'));
		}
	}
	
}

/* End of file campaign.php */
/* Location: ./application/admin/controllers/caplaign/campaign.php */
