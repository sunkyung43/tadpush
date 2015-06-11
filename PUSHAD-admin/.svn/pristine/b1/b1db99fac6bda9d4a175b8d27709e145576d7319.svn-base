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
 * @copyright  Copyright (c) 2011 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: JSON.php 19 2012-06-17 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\writer;

use	CF\config\Writer,
	CF\config\Config,
	CF\config\json\JSON as Encoder,
	CF\config\json\Constants,
	CF\exception\RuntimeException;


/**
 * Yaml writer
 *
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class JSON implements Writer
{

// {{{ properties 
	/** @var string */
	private $result;
// }}}


// {{{ construct (null|string filename, CF\config\Config config [, array option]) 
	/**
	 * following option structure
	 *
	 * <code>
	 * array(
	 *	'option' => INTEGER, // \CF\config\json\Constants::xxx with bitwise OR
	 *	'indent' => STRING	 // indent string. default: \t
	 * );
	 * </code>
	 *
	 * @param	string|null			filename
	 * @param	CF\config\Config	config
	 * @param	array				option
	 * @return	void
	 * @throws	CF\exception\RuntimeException
	 */
	public function __construct ($filename, Config $config, $option = array()) 
	{
		if(!is_array($option)) $option = array();

		if(!isset($option['option']) || !is_int($option['option']))
			$option['option'] = 0;
		if(!isset($option['indent']))
			$option['indent'] = null;

		$data = $config->toArray();

		if($option['indent'] === null)
			$json = Encoder::encode($data, $option['option']);
		else $json = Encoder::encode($data, $option['option'], $option['indent']);


		if($filename === null) {
			$this->result = $json;
			return;
		}

		$result = @file_put_contents($filename, $json);

		if($result === false)
			throw new RuntimeException("Cant write file '$filename'");
	}
// }}}


// {{{ __toString
	/**
	 * @return string
	 */
	public function __toString() {
		return (string) $this->result;
	}
// }}}

}

// vim600: ts=4 sw=4 fdm=marker
?>
