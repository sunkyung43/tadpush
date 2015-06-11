<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends MY_Model
{
	var $account_sq	= '';
	function __construct()
	{
		parent::__construct();
	}
    
	// 상단 메뉴 리스트
    function get_top_menu_list($account_sq)
	{
		$data = array();
        $this->db->select('M.MENU_SQ, M.MENU_NM, M.MENU_URL');
        $this->db->from("$this->tad3_database.POC_MENU M");
        $this->db->join("$this->tad3_database.POC_AUTH A", 'A.MENU_SQ = M.MENU_SQ');
        $this->db->join("$this->tad3_database.POC_ADMIN_USER U", 'U.ROLE_SQ = A.ROLE_SQ');
		$this->db->where('U.ACCOUNT_SQ', $account_sq);
		$this->db->where('(A.MENU_READ_FL = 1 or A.MENU_WRITE_FL = 1)');
        $this->db->where('M.MENU_DEPTH', 1);

        $this->db->order_by('M.MENU_ORDER');
        $q = $this->db->get();
		
		//echo $this->db->last_query();
		if ($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[$row->MENU_SQ] = $row;
            }
        }
		
		return $data;
    }
    
	// 2뎁스 메뉴 리스트
    function get_sub_menu_list($account_sq, $menu_depth = 2)
    {
		$data = array();
        $this->db->select('M.MENU_SQ, M.MENU_NM, M.MENU_URL, M.MENU_PARENT_SQ');
        $this->db->from("$this->tad3_database.POC_MENU M");
        $this->db->join("$this->tad3_database.POC_AUTH A", 'A.MENU_SQ = M.MENU_SQ');
        $this->db->join("$this->tad3_database.POC_ADMIN_USER U", 'U.ROLE_SQ = A.ROLE_SQ');
		$this->db->where('(A.MENU_READ_FL = 1 or A.MENU_WRITE_FL = 1)');
		$this->db->where('U.ACCOUNT_SQ', $account_sq);
        $this->db->where('M.MENU_DEPTH = ', $menu_depth);
        $this->db->order_by('M.MENU_DEPTH, M.MENU_PARENT_SQ, M.MENU_ORDER');
        $q = $this->db->get();
		
		if ($q->num_rows() > 0)
        {
            foreach($q->result() as $row)
            {
                $data[$row->MENU_PARENT_SQ][$row->MENU_SQ] = $row;
            }
        }
		
		return $data;
    }
}

/* End of file menu_model.php */
/* Location: ./application/admin/models/menu_model.php */