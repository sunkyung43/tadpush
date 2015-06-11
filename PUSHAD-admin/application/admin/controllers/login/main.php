<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends My_Controller
{
	/**
	 * @var Main_model
	 */
	public $main_model;

	var $session_userdata = array();

	function __construct()
	{
		parent::__construct();

		$this->session_userdata = array('ACCOUNT_SQ' => '', 'USER_ID' => '', 'USER_NM' => '', 'ROLE_SQ' => '', 'ROLE_NM' => '', 'ALLOW_ACCOUNT_SQ' => '', 'ALLOW_IP_SMS' => '', 'ALLOW_IP_FLAG' => false, 'LOGGED_IN' => false, 'LAST_ACCESS_DT' => '');

		$this->load->model('login/main_model');
	}

	// 로그인 뷰페이지
	function index_get()
	{
		// 로그인 상태일 경우 이전 페이지 혹은 메인 메뉴 페이지로 이동.
		$logged_in = $this->session->userdata('LOGGED_IN');
		if ($logged_in)
		{
			$main_url	= $this->main_model->select_main_url($this->session->userdata('ROLE_SQ'));
			if ($main_url == '')		// referrer가 없고, main_url 설정이 없을 경우 강제 로그아웃 처리.
			{
				$this->session->unset_userdata($this->session_userdata);	// 세션 제거
			}
			else
			{
				redirect($main_url);
				exit;
			}
		}

		$this->yield = false;
		$this->load->view('login/main_view');
	}

	// 로그인 시 jCryption을 이용한 공개키 응답
	function login_get()
	{
		session_start();
		require_once(APPPATH ."helpers/jCryption-1.0.1.php");
		$keyLength = 256;
		$jCryption = new jCryption();
		if(isset($_GET["generateKeypair"])) {
			$keys = $jCryption->generateKeypair($keyLength);
			$_SESSION["e"] = array("int" => $keys["e"], "hex" => $jCryption->dec2string($keys["e"],16));
			$_SESSION["d"] = array("int" => $keys["d"], "hex" => $jCryption->dec2string($keys["d"],16));
			$_SESSION["n"] = array("int" => $keys["n"], "hex" => $jCryption->dec2string($keys["n"],16));

			echo '{"e":"'.$_SESSION["e"]["hex"].'","n":"'.$_SESSION["n"]["hex"].'","maxdigits":"'.intval($keyLength*2/16+3).'"}';
			return;
		}
	}

	// 로그인 요청
	function login_post()
	{
		session_start();
		require_once(APPPATH ."helpers/jCryption-1.0.1.php");
		$keyLength = 256;
		$jCryption = new jCryption();
		$var = $jCryption->decrypt($_POST['jCryption'], $_SESSION["d"]["int"], $_SESSION["n"]["int"]);
		unset($_SESSION["e"]);
		unset($_SESSION["d"]);
		unset($_SESSION["n"]);
		parse_str($var,$result);

		$this->yield		= false;
		$response_type		= 'fail';
		$response_data		= '';
		$user_id			= isset($result['user_id']) ? $result['user_id'] : '';
		$user_password			= isset($result['user_pw']) ? $result['user_pw'] : '';

		if(null == ($login_data = $this->main_model->select_login($user_id, hash("sha256", $user_password))))
		{
			echo json_encode(array('response_type' => 'fail', 'response_data' => ''));
			return;
		}
			
		if('' == ($main_url = $this->main_model->select_main_url($login_data['ROLE_SQ'])))
		{
			echo json_encode(array('response_type' => 'fail', 'response_data' => ''));
			return;
		}

		$last_access_dt = date('Y-m-d H:i:s');
		// 			$this->main_model->update_last_access_dt($login_data['ACCOUNT_SQ'], $last_access_dt);

		$this->tad3_session_data		= array(
				'ACCOUNT_SQ'	=> $login_data['ACCOUNT_SQ'],
				'USER_ID'		=> $login_data['USER_ID'],
				'USER_NM'		=> $login_data['USER_NM'],
				'ROLE_SQ'		=> $login_data['ROLE_SQ'],
				'ROLE_NM'		=> $login_data['ROLE_NM'],
				'LAST_ACCESS_DT' => $last_access_dt,
				'LOGGED_IN'		=> true
		);
			
		$this->session->unset_userdata($this->session_userdata);					// 세션 제거
		$this->session->set_userdata($this->tad3_session_data);	// 세션 저장
		echo json_encode(array('response_type' => 'success', 'response_data' => $main_url));
	}

	// 로그아웃
	function logout_post()
	{
		$this->yield		= false;
		$this->session->unset_userdata($this->session_userdata);					// 세션 제거
		$this->session->sess_destroy();		// 세션 제거 Destroying a Session

		echo json_encode(array('response_type' => 'success', 'response_data' => ''));
	}

	private function _validate($user_id, $user_password)
	{
		return $user_id != '' && $user_password != '';
	}

}

/* End of file main.php */
/* Location: ./application/admin/controllers/login/main.php */