<?php
/**
 * Coffee Framework
 *
 * PHP Version 5.3
 *
 * LICENSE
 *
 * 본 프로그램은 New BSD License 를 기본으로 하고 있지만 약간 다른 제약조건을 가지고 있습니다. 
 * 함께 제공된 license file 인  doc/LICENSE 를 꼭 확인하시길 바랍니다.
 *
 * This Source is subject to the New BSD License with SOME CONSTRAINT that is boudled
 * with this package in the file doc/LICENSE 
 *
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: JSON.php 19 2012-06-17 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\reader;

use	CF\config\Reader,
	CF\config\json\JSON as Decoder,
	CF\config\json\Constants;


/**
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class JSON implements Reader
{
// {{{ properties 
	/** @var array */
	private $data;
// }}}


// {{{ construct (string input [, integer option])
	/**
	 * JSON Decoding
	 *
	 * @param	string input 		Path of json file or string containing json
	 * @param	integer $option
	 * @return	void
	 */
	public function __construct ($input, $option = 0) 
	{
		$opt = $this->detected($option);

		if($opt) {
			if($opt === true)
				$this->data = json_decode($input, true, 1024);
			else 
				$this->data = json_decode($input, true, 1024, $opt);

			if($this->data) return;
		}

		$this->data = Decoder::decode($input, $option);
	}
// }}}


// {{{ array getData (void) 
	/**
	 * @return array
	 */
	public function getData ()
	{
		return $this->data;
	}
// }}}


// {{{ private boolean|integer detected (integer option) 
	/**
	 * @param	integer option
	 * @return	boolean|integer
	 */
	private function detected ($option)
	{
		if(!function_exists('json_decode'))
			return false;

		if(!$option) return true;

		if(defined('JSON_BIGINT_AS_STRING')
			&& ($option & Constants::BIGINT_AS_STRING))
			return JSON_BIGINT_AS_STRING;

		return false;
	}
// }}}

}

// vim600: ts=4 sw=4 fdm=marker
?>
