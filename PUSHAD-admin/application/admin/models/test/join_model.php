<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Join_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function select_id($user_id)
	{
		$this->db->select("PAU.ACCOUNT_SQ, PAU.ROLE_SQ, PAU.USER_NM, PAU.COMPANY_NM, PAU.TEAM_NM, PAU.DUTY_NM, PAU.MOBILE_NO, PAU.EMAIL", FALSE);
		$this->db->from("TAD3.POC_ACCOUNT PA");
		$this->db->join("TAD3.POC_ADMIN_USER PAU", 'PA.ACCOUNT_SQ = PAU.ACCOUNT_SQ');
		$this->db->where("PA.USER_ID =", $user_id);

		$q = $this->db->get();
		return $q->result_array();
	}
	
	function insert_account($data_array)
	{
		foreach($data_array as $key => $val)
		{
			if($key == 'CREATE_DT' || $key == 'UPDATE_DT')
			{
				$this->db->set($key, $val, FALSE);
			}
			else
			{
				$this->db->set($key, $val);
			}
	
		}
	
		$this->db->insert("TAD3.POC_ACCOUNT");
	
		return $this->db->insert_id();
	}
	
	function insert_admin_user($data_array)
	{
		foreach($data_array as $key => $val)
		{
			if($key == 'CREATE_DT' || $key == 'UPDATE_DT')
			{
				$this->db->set($key, $val, FALSE);
			}
			else
			{
				$this->db->set($key, $val);
			}
	
		}
	
		$this->db->insert("TAD3.POC_ADMIN_USER");
	
		return $this->db->insert_id();
	}
}

/* End of file join_model.php */
/* Location: ./application/admin/models/test/join_model.php */