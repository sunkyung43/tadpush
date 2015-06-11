<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
require_once (APPPATH . 'third_party/CF/loader/Autoloader.php');

class Json {
	/**
	 *
	 * @var MY_Controller
	 */
	public $CI;
	
	function __construct() {
		$this->CI = &get_instance();
		
		new CF\loader\Autoloader();
	}

	function json_encode($value) {
		return CF\config\json\JSON::encode($value, CF\config\json\Constants::HEX_AMP | CF\config\json\Constants::UNESCAPED_UNICODE | CF\config\json\Constants::UNESCAPED_SLASHES, 0);
	}

	function json_decode($value) {
		return CF\config\json\JSON::decode($value);
	}
}