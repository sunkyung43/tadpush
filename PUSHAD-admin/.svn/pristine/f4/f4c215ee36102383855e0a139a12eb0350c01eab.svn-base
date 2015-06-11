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
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: INI.php 2 2012-04-26 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\reader;

use CF\config\Reader,
	CF\exception\RuntimeException;


/**
 * INI loader
 *
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class INI implements Reader 
{
// {{{ properties 
	/** @var array */
	private $data = array();
// }}}


// {{{ construct (string input) 
	/**
	 * @param  string input		ini file or ini string
	 * @return void
	 */
	public function __construct ($input)
	{
		if(empty($input)) return; 

		if(file_exists($input))
			$ini = parse_ini_file($input, true);
		else $ini = $this->_parse_ini_string($input);


		$data = array();
		foreach($ini as $key => $val) {
			$key = trim($key);

			if(is_array($val))
				$data[$key] = $this->parseSection($val);
			else $data = array_merge_recursive($data, $this->parseKey($key, $val));
		}

		$this->data = $data;
    }

// }}}


// {{{ array getData (void) 
	/**
	 *
	 * @return array
	 */
	public function getData ()
	{
		return $this->data;
	}
// }}}


// {{{ private methods 
	// {{{ array parseSection (array section) 
	/**
	 * Secton parse
	 *
	 * @param	array section
	 * @return	array
	 */
	private function parseSection (array $section)
	{
		$data = array();

		foreach($section as $key => $value) 
			$data = $this->parseKey($key, $value, $data);

		return $data;
    }

	// }}}
	// {{{ array parseKey (string key, mixed value [, array data]) 

	/**
	 * Key parse
	 * Self recursive calling
	 *
	 * @param	string	key
	 * @param	mixed	value
	 * @param	array	data
	 * @return	array
	 * @throws	CF\exception\RuntimeException
	 */
	protected function parseKey ($key, $value, array $data = array())
	{
		if(strpos($key, '.') !== false) {
			$part = explode('.', $key, 2);

			if(!strlen($part[0]) || !strlen($part[1]))
				throw new RuntimeException("Invalid key '$key'");


			if(!isset($data[$part[0]])) 
				$data[$part[0]] = array();
			elseif(!is_array($data[$part[0]]))
				throw new RuntimeException("Key '".$part[0]."' already exists");

			$data[$part[0]] = $this->parseKey($part[1], $value, $data[$part[0]]);
		}
		else $data[$key] = $value;

		return $data;
	}

	// }}}
	// {{{ array _parse_ini_string (string input) 
	/**
	 * @param	string input
	 * @return	array
	 */
	private function _parse_ini_string ($input)
	{
		if(function_exists('parse_ini_string'))
			return parse_ini_string($input, true);

		$lines = explode("\n", $input);
		$array = array();
		$inSect = false;
		foreach($lines as $line){
			$line = trim($line);

			// comment
			if(!$line || preg_match('/^[#;]/', $line))
				continue;

			// section
			if(preg_match('/^\[(.*)\]/', $line, $match)) {
				$inSect = $this->_stripQuote($match[1]);
				continue;
			}

			if(preg_match('/^(?!;)(?P<key>[\w+\.\-]+?)\s*=\s*(?P<value>.+?)\s*$/', $line, $match)) {
				$key = $this->_stripQuote($match['key']);
				$value = $this->_stripQuote($match['value']);

				if($inSect) $return[$inSect][$key] = $value;
				else $return[$key] = $value;
			}
		}
		return $return;
	}
	// }}}
	// {{{ string _stripQuote (string string) 

	/**
	 * @param	string string
	 * @return	string
	 */
	private function _stripQuote ($string)
	{
		if(preg_match("/^\".*\"$/", $string)
			|| preg_match("/^'.*'$/", $string)) 
		$string = mb_substr($string, 1, mb_strlen($string) - 2);

		return trim($string);
	}
	// }}}
// }}}

}

// vim600: ts=4 sw=4 fdm=marker
?>
