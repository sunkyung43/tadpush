<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends MY_Model
{
	/**
	 * @var CI_Loader
	 */
	// 	private $load;

	function __construct()
	{
		parent::__construct();
	}

	// 로그인 확인
	function select_login($user_id='', $user_password='')
	{
		$params = array('user_id' => $user_id, 'user_password' => $user_password);
		return $this->fpbatis->doSelectOne('main.selectLogin', $params);
	}

	// 메인으로 이동했을 경우 메인 URL을 취득
	function select_main_url($role_sq)
	{
		return $this->fpbatis->doSelectOne('main.selectMainUrl', $role_sq);
	}

	function update_last_access_dt($account_sq, $last_access_dt)
	{
		$params = array('account_sq' => $account_sq, 'last_access_dt' => $last_access_dt);
 		return $this->fpbatis->doUpdate('main.updateLastAccessDt', $params);
	}
	
	function select_menu($account_sq, $menu_depth)
	{
		$params = array('account_sq' => $account_sq, 'menu_depth' => $menu_depth);
		return $this->fpbatis->doSelectList('main.selectMenu', $params);
	}
}

/* End of file main_model.php */
/* Location: ./application/admin/models/login/main_model.php */