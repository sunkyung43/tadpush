<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log
{

	function __construct()
	{
		parent::__construct();

		$this->_levels	= array('ERROR' => '1',  'INFO' => '2', 'DEBUG' => '3', 'ALL' => '4');
	}

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$msg = $this->get_msg($msg);

		$level = strtoupper($level);

		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
		{
			return FALSE;
		}

		$filepath = $this->_log_path.'/poc_'.date('Ymd').'.log';
		$message  = '';

		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";

		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}

	function get_msg($msg_array)
	{
		if(!is_array($msg_array))
		{
			return $msg_array;
		}

		$result = '';
		foreach($msg_array as $key => $value)
		{
			if(is_array($value))
			{
				$result .= '[' .$this->get_msg($value) .']';
			}
			else
			{
				$result .= $key .'=' .$value;
			}
			$result .= ',';
		}
		
		return $result;
	}
}

/* End of file MY_Log.php */
/* Location: ./application/admin/libraries/MY_Log.php */