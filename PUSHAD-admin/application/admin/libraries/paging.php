<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paging
{
	var $base_url		= '';	// 기본 URL

	var $total_rows		= 0;	// 총 게시글 수
	var $per_page		= 10;	// 노출되는 게시글 수
	var $num_links 		= 10;	// 페이지 수
	var $cur_page 		= 1;	// 현재 페이지

	var $search_type	= '';
	var $search_keyword = '';
	var $select_search = '';
	var $start_dt ='';
	var $end_dt ='';
	var $querystring_list	= array();

	var $first_page		= '<img src="/web/images/button/paging01.gif" alt="처음" />';
	var $previous_page	= '<img src="/web/images/button/paging02.gif" alt="이전" />';
	var $next_page		= '<img src="/web/images/button/paging03.gif" alt="다음" />';
	var $last_page		= '<img src="/web/images/button/paging04.gif" alt="맨끝" />';

	var $call_javascript_function = '';

	function __construct($conf = array())
	{
		if (count($conf) > 0)
		{
			$this->init($conf);
		}
	}

	function init($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}


	/*
		<div class="pagingList">
	<a href="#"><img src="../images/button/paging01.gif" alt="처음" /></a>
	<a href="#"><img src="../images/button/paging02.gif" alt="이전" /></a>
	<span class="now"><a href="">1</a></span>
	<span><a href="">2</a></span>
	<span><a href="">3</a></span>
	<a href="#"><img src="../images/button/paging03.gif" alt="다음" /></a>
	<a href="#"><img src="../images/button/paging04.gif" alt="맨끝" /></a>
	</div>
	*/
	public function create_page()
	{
		$return_url		= '<div class="pagingList">';
		$cur_page	= ceil($this->cur_page / $this->num_links);
		$total_rows 	= ceil($this->total_rows / $this->per_page);
		$total_page		= ceil($total_rows / $this->num_links);

		$base_url		= rtrim($this->base_url, '/');

		$querystring = '&per_page='.$this->per_page;

		if ($this->search_type != '')
		{
			$querystring .= '&search_type='.urlencode($this->search_type);
		}
		if ($this->search_keyword != '')
		{
			$querystring .= '&searchValue='.urlencode($this->search_keyword);
		}
		if ($this->select_search != '')
		{
			$querystring .= '&selectSearch='.urlencode($this->select_search);
		}

		if ($this->start_dt != '')
		{
			$querystring .= '&searchStartDate='.urlencode($this->start_dt);
		}
		if ($this->end_dt != '')
		{
			$querystring .= '&searchEndDate='.urlencode($this->end_dt);
		}

		if (count($this->querystring_list) > 0)
		{
			foreach ($this->querystring_list as $key => $val)
			{
				if($val != '')
				{
					$querystring .= '&' .$key .'=' .urlencode($val);
				}
			}
		}

		// 처음페이지로 이동.
		if ($this->cur_page == 1)
		{
			$return_url .= $this->first_page;
		}
		else
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<a href="%s?cur_page=%s%s" class="prev">%s</a>', $base_url, 1, $querystring, $this->first_page);
			}
			else
			{
				$return_url .= sprintf('<a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a>', $this->call_javascript_function, $base_url, 1, $querystring, $this->first_page);
			}
		}
		// 이전페이지로 이동.
		if($cur_page > 1)
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<a href="%s?cur_page=%s%s" class="prev">%s</a>', $base_url, (($cur_page-2) * $this->num_links + 1), $querystring, $this->previous_page);
			}
			else
			{
				$return_url .= sprintf('<a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a>', $this->call_javascript_function, $base_url, (($cur_page-2) * $this->num_links + 1), $querystring, $this->previous_page);
			}
		}
		else
		{
			$return_url .= $this->previous_page;
		}

		// 게시글이 없을 경우.
		if ($total_rows == 0) $return_url .= sprintf(' <span class="now">1</span> ');

		$page = ($cur_page - 1) * $this->num_links + 1;
		while ($page <= $total_rows && $page <= ($cur_page * $this->num_links))
		{
			if ($page == $this->cur_page)
			{
				$return_url .= sprintf(' <span class="now">%s</span> ', $page);
			}
			else
			{
				if($this->call_javascript_function == '')
				{
					$return_url .= sprintf(' <span><a href="%s?cur_page=%s%s">%s</a></span> ', $base_url, $page, $querystring, $page);
				}
				else
				{
					$return_url .= sprintf(' <span><a href="javascript:%s(\'%s?cur_page=%s%s\')">%s</a></span> ', $this->call_javascript_function, $base_url, $page, $querystring, $page);
				}
			}
			$page++;
		}

		// 다음페이지로 이동.
		if($cur_page < $total_page)
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<span><a href="%s?cur_page=%s%s" class="prev">%s</a></span>', $base_url, (($cur_page)*$this->num_links + 1), $querystring, $this->next_page);
			}
			else
			{
				$return_url .= sprintf('<span><a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a></span>', $this->call_javascript_function, $base_url, (($cur_page)*$this->num_links + 1), $querystring, $this->next_page);
			}
		}
		else
		{
			$return_url .= $this->next_page;
		}
		// 마지막페이지로 이동.
		if ($this->cur_page >= $total_rows)
		{
			$return_url .= $this->last_page;
		}
		else
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<span><a href="%s?cur_page=%s%s" class="prev">%s</a></span>', $base_url, $total_rows, $querystring, $this->last_page);
			}
			else
			{
				$return_url .= sprintf('<span><a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a></span>', $this->call_javascript_function, $base_url, $total_rows, $querystring, $this->last_page);
			}
		}

		$return_url .= '</div>';
		return $return_url;
	}

	// device 기종 관리 pageing
	public function create_device_page()
	{
		$return_url		= '<div class="pagingList">';
		$cur_page	= ceil($this->cur_page / $this->num_links);
		$total_rows 	= ceil($this->total_rows / $this->per_page);
		$total_page		= ceil($total_rows / $this->num_links);

		$base_url		= rtrim($this->base_url, '/');

		$querystring = '&per_page='.$this->per_page;

		if ($this->search_type != '')
		{
			$querystring .= '&search_type='.$this->search_type;
		}
		if ($this->search_keyword != '')
		{
			$querystring .= '&searchValue='.$this->search_keyword;
		}
		if ($this->select_search != '')
		{
			$querystring .= '&selectSearch='.$this->select_search;
		}
		if ($this->start_dt != '')
		{
			$querystring .= '&searchStartDate='.$this->start_dt;
		}
		if ($this->end_dt != '')
		{
			$querystring .= '&searchEndDate='.$this->end_dt;
		}

		if (count($this->querystring_list) > 0)
		{
			foreach ($this->querystring_list as $key => $val)
			{
				if($val != '')
				{
					$querystring .= '&' .$key .'=' .urlencode($val);
				}
			}
		}

		// 처음페이지로 이동.
		if ($this->cur_page == 1)
		{
			$return_url .= $this->first_page;
		}
		else
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<a href="%s?cur_page=%s%s" class="prev">%s</a>', $base_url, 1, $querystring, $this->first_page);
			}
			else
			{
				$return_url .= sprintf('<a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a>', $this->call_javascript_function, $base_url, 1, $querystring, $this->first_page);
			}
		}
		// 이전페이지로 이동.
		if($cur_page > 1)
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<a href="%s?cur_page=%s%s" class="prev">%s</a>', $base_url, (($cur_page-2) * $this->num_links + 1), $querystring, $this->previous_page);
			}
			else
			{
				$return_url .= sprintf('<a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a>', $this->call_javascript_function, $base_url, (($cur_page-2) * $this->num_links + 1), $querystring, $this->previous_page);
			}
		}
		else
		{
			$return_url .= $this->previous_page;
		}

		// 게시글이 없을 경우.
		if ($total_rows == 0) $return_url .= sprintf(' <span class="now">1</span> ');

		$page = ($cur_page - 1) * $this->num_links + 1;
		while ($page <= $total_rows && $page <= ($cur_page * $this->num_links))
		{
			if ($page == $this->cur_page)
			{
				$return_url .= sprintf(' <span class="now">%s</span> ', $page);
			}
			else
			{
				if($this->call_javascript_function == '')
				{
					$return_url .= sprintf(' <span><a href="%s?cur_page=%s%s">%s</a></span> ', $base_url, $page, $querystring, $page);
				}
				else
				{
					$return_url .= sprintf(' <span><a href="javascript:%s(\'%s?cur_page=%s%s\')">%s</a></span> ', $this->call_javascript_function, $base_url, $page, $querystring, $page);
				}
			}
			$page++;
		}

		// 다음페이지로 이동.
		if($cur_page < $total_page)
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<span><a href="%s?cur_page=%s%s" class="prev">%s</a></span>', $base_url, (($cur_page)*$this->num_links + 1), $querystring, $this->next_page);
			}
			else
			{
				$return_url .= sprintf('<span><a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a></span>', $this->call_javascript_function, $base_url, (($cur_page)*$this->num_links + 1), $querystring, $this->next_page);
			}
		}
		else
		{
			$return_url .= $this->next_page;
		}
		// 마지막페이지로 이동.
		if ($this->cur_page >= $total_rows)
		{
			$return_url .= $this->last_page;
		}
		else
		{
			if($this->call_javascript_function == '')
			{
				$return_url .= sprintf('<span><a href="%s?cur_page=%s%s" class="prev">%s</a></span>', $base_url, $total_rows, $querystring, $this->last_page);
			}
			else
			{
				$return_url .= sprintf('<span><a href="javascript:%s(\'%s?cur_page=%s%s\')" class="prev">%s</a></span>', $this->call_javascript_function, $base_url, $total_rows, $querystring, $this->last_page);
			}
		}

		$return_url .= '</div>';
		return $return_url;
	}

	/*
	 <div class="n_class">
	<select>
	<option>15개씩보기</option>
	<option>30개씩보기</option>
	<option>50개씩보기</option>
	</select>
	</div>
	*/
	public function create_popup_page()
	{
		$return_url		= '<div class="pagingList">';
		$cur_page	= ceil($this->cur_page / $this->num_links);
		$total_rows 	= ceil($this->total_rows / $this->per_page);
		$total_page		= ceil($total_rows / $this->num_links);

		$base_url		= rtrim($this->base_url, '/');

		$querystring = '&per_page='.$this->per_page;

		if ($this->search_type != '')
		{
			$querystring .= '&search_type='.$this->search_type;
		}
		if ($this->search_keyword != '')
		{
			$querystring .= '&searchValue='.$this->search_keyword;
		}

		if ($this->start_dt != '')
		{
			$querystring .= '&searchStartDate='.$this->start_dt;
		}
		if ($this->end_dt != '')
		{
			$querystring .= '&searchEndDate='.$this->end_dt;
		}

		if (count($this->querystring_list) > 0)
		{
			foreach ($this->querystring_list as $key => $val)
			{
				if($val != '')
				{
					$querystring .= '&' .$key .'=' .urlencode($val);
				}
			}
		}

		// 처음페이지로 이동.
		if ($this->cur_page == 1)
		{
			$return_url .= $this->first_page;
		}
		else
		{
			$return_url .= sprintf('<a href="%s?cur_page=%s%s" class="prev">%s</a>', $base_url, 1, $querystring, $this->first_page);
		}
		// 이전페이지로 이동.
		if($cur_page > 1)
		{
			$return_url .= sprintf('<a href="%s?cur_page=%s%s" class="prev">%s</a>', $base_url, (($cur_page-2) * $this->num_links + 1), $querystring, $this->previous_page);
		}
		else
		{
			$return_url .= $this->previous_page;
		}

		// 게시글이 없을 경우.
		if ($total_rows == 0) $return_url .= sprintf(' <span class="now">1</span> ');

		$page = ($cur_page - 1) * $this->num_links + 1;
		while ($page <= $total_rows && $page <= ($cur_page * $this->num_links))
		{
			if ($page == $this->cur_page)
			{
				$return_url .= sprintf(' <span class="now">%s</span> ', $page);
			}
			else
			{
				$return_url .= sprintf(' <span><a href="%s?cur_page=%s%s">%s</a></span> ', $base_url, $page, $querystring, $page);
			}
			$page++;
		}

		// 다음페이지로 이동.
		if($cur_page < $total_page)
		{
			$return_url .= sprintf('<span><a href="%s?cur_page=%s%s" class="prev">%s</a></span>', $base_url, (($cur_page)*$this->num_links + 1), $querystring, $this->next_page);
		}
		else
		{
			$return_url .= $this->next_page;
		}
		// 마지막페이지로 이동.
		if ($this->cur_page >= $total_rows)
		{
			$return_url .= $this->last_page;
		}
		else
		{
			$return_url .= sprintf('<span><a href="%s?cur_page=%s%s" class="prev">%s</a></span>', $base_url, $total_rows, $querystring, $this->last_page);
		}

		$return_url .= '</div>';
		return $return_url;
	}

	public function create_page_volume($per_page=15, $per_page_array=array(15, 30, 50, 100))
	{
		$return_text	= '<div class="n_class"><select id="per_page" name="per_page" onchange="this.form.submit();">';
		foreach ($per_page_array as $value)
		{
			$selected = $value == $per_page ? 'selected' : '';
			$return_text .= sprintf('<option value="%s" %s>%s개씩보기</option>', $value, $selected, $value);
		}
		$return_text .= '</select></div>';
		return $return_text;
	}
}

/* End of file paging.php */
/* Location: ./application/admin/libraries/paging.php */
