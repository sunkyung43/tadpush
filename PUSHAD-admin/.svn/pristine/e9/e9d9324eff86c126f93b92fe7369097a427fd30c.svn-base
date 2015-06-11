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
 * @package    CF_config_json
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: JSON.php 2 2012-04-29 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\json;

use CF\config\Config,
	CF\Exception,
	CF\exception\RuntimeException;


/**
 * JSON Encoder / Decoder
 * Encoder is Based Zend_Json_Encoder
 *
 * @category   CF
 * @package    CF_config_json
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class JSON
{

// {{{ properties 
	/** @var integer */
	private $option;

	/** @var string */
	private $indent;

	/** @var integer */
	private $_indent = 0;

	/** @var boolean */
	private $_not_unicode = false;
// }}}


// {{{ private constructor (integer option, string indent) 
	/**
	 * @param	integer option
	 * @param	string	indent
	 * @return	void
	 */
	private function __construct ($option, $indent)
	{
		$this->option = (int)$option;
		$this->indent = $indent;
	}
// }}}


// {{{ string static public encode (mixed value [, integer option [, string indent]) 
	/**
	 * JSON Encoding
	 *
	 * @param	mixed	value
	 * @param	integer	option
	 * @param	string	indent
	 * @return	string
	 */
	static public function encode($value, $option = 0, $indent = "\t")
	{
		$encoder = new self($option, $indent);
		if($value instanceof Config)
			$value = $value->toArray();

		return $encoder->encodeValue($value);
	}
// }}}

// {{{ array static public decode (string value [, integer option]) 
	/**
	 * JSON Decoding
	 *
	 * @param	string input	json data
	 * @param	integer option
	 * @return	array
	 * @throws	CF\exception\RuntimeException
	 */
	static public function decode($input, $option = 0)
	{
		if(!$input || !is_string($input)) return null;

		if(file_exists($input))
			$input = file_get_contents($input);

		try {
			$parser = new Parser(
							new Scanner($input),
							$option
						);

			$parser->parse();
		} catch (RuntimeException $je) {
			throw new RuntimeException('JSON data Parse Error'."\n".$je->getMessage());
		} catch (Exception $e) {
			throw new RuntimeException($e->getMessage());
		}

		return $parser->retvalue;
	}
// }}}


// {{{ private methods for encoding - based Zend_Json_Encoder 
	// {{{ string encodeValue (mixed value) 
	/**
	 * Encoding
	 *
	 * @param	mixed value
	 * @return	string
	 */
	private function encodeValue($value)
	{
		if($value instanceof ConstantsJS)
			return $this->encodeDatum($value->value, $value->__js__);
		elseif(is_array($value))
			return $this->encodeArray($value);

		return $this->encodeDatum($value, false);
	}
	// }}}
	// {{{ string encodeArray (array array) 
	/**
	 * JSON encode an array value
	 *
	 * @param	array array
	 * @return	string
	 */
	private function encodeArray(array $array)
	{
		$indentFlag = $this->option & Constants::PRETTY_PRINT;
		$arr = array();
		if(!empty($array) && (array_keys($array) !== range(0, count($array) - 1))) {
			$result = '{'.($indentFlag ? "\n" : '');

			$this->_indent++;
			$indentString = str_repeat($this->indent, $this->_indent);
			foreach($array as $key => $value) {
				$key = (string)$key;
				$arr[] = ($indentFlag ? $indentString : '')
							.$this->encodeString($key).':'
							.($indentFlag ? ' ' : '')
							.$this->encodeValue($value);
			}
			$result .= implode(','.($indentFlag ? "\n" : ''), $arr);

			$this->_indent--;
			$indentString = str_repeat($this->indent, $this->_indent);
			$result .= ($indentFlag ? "\n".$indentString : '').'}';
		}
		else {
			$result = '['.($indentFlag ? "\n" : '');

			$this->_indent++;
			$indentString = str_repeat($this->indent, $this->_indent);
			$length = count($array);
			for($i = 0; $i < $length; $i++)
				$arr[] = ($indentFlag ? $indentString : '')
							.$this->encodeValue($array[$i]);

			$result .= implode(','.($indentFlag ? "\n" : ''), $arr);

			$this->_indent--;
			$indentString = str_repeat($this->indent, $this->_indent);
			$result .= ($indentFlag ? "\n".$indentString : '').']';
		}

		return $result;
	}
	// }}}
	// {{{ string encodeDatum (mixed value [, boolean js]) 
	/**
	 * JSON encode a data
	 *
	 * @param	mixed value
	 * @param	boolean js javascript expression
	 * @return	string
	 */
	private function encodeDatum($value, $js = false)
	{
		$result = 'null';

		if(is_int($value) || is_float($value)) {
			$result = (string)$value;
			$result = str_replace(",", ".", $result);
		}
		elseif(is_numeric($value)
				&& Constants::NUMERIC_CHECK & $this->option) {
			if(intval($value) != floatval($value))
				$result = floatval($value);
			else $result = intval($value);
		}
		elseif(is_string($value))
			$result = $this->encodeString($value, $js);
		elseif(is_bool($value))
			$result = $value ? 'true' : 'false';

		return $result;
	}
	// }}}
	// {{{ string encodeString (string value [, boolean js]) 
	/**
	 * JSON encode a string
	 *
	 * @param	string value
	 * @param	boolean js javascript expression
	 * @return	string
	 */
	private function encodeString($value, $js = false)
	{
		$search  = array('\\', "\n", "\t", "\r", "\b", "\f",
						'/', '"', '<', '>', '&', "'");
		$replace = array('\\\\', '\\n', '\\t', '\\r', '\\b', '\\f',
						$this->option & Constants::UNESCAPED_SLASHES
							? '/' : '\\/',
						$this->option & Constants::HEX_QUOT
							? '\u0022' : '\"',
						$this->option & Constants::HEX_TAG
							? '\u003C' : '<',
						$this->option & Constants::HEX_TAG
							? '\u003E' : '>',
						$this->option & Constants::HEX_AMP
							? '\u0026' : '&',
						$this->option & Constants::HEX_APOS
							? '\u0027' : "'"
					);

		$value  = str_replace($search, $replace, $value);

		$value = str_replace(array(chr(0x08), chr(0x0C)), array('\b', '\f'), $value);
		$value = $this->encodeUnicodeString($value);

		if($js === true || $this->_not_unicode === true) return $value;

		return '"'.$value.'"';
	}
	// }}}
	// {{{ string encodeUnicodeString (string value) 
	/**
	 * JSON encode to unicode string
	 *
	 * @param  string value
	 * @return string
	 */
    private function encodeUnicodeString($value)
    {
		$this->_not_unicode = false;

		$strlen_var = strlen($value);
		$ascii = "";

		for($i = 0; $i < $strlen_var; $i++) {
			$ord_var_c = ord($value[$i]);

			switch (true) {
				case (($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
					$ascii .= $value[$i];
					break;
				case (($ord_var_c & 0xE0) == 0xC0):
					if(!isset($value[$i + 1])) {
						$this->_not_unicode = true;
						return 'null';
					}

					$char = pack('C*', $ord_var_c, ord($value[$i + 1]));
					$i += 1;
					if($this->option & Constants::UNESCAPED_UNICODE) {
						$ascii .= $char;
						break;
					}
					$utf16 = $this->utf8_to_utf16($char);
					$ascii .= sprintf('\u%04s', bin2hex($utf16));
					break;
				case (($ord_var_c & 0xF0) == 0xE0):
					if(!isset($value[$i + 1]) || !isset($value[$i + 2])) {
						$this->_not_unicode = true;
						return 'null';
					}

					$char = pack('C*', $ord_var_c, ord($value[$i + 1]), ord($value[$i + 2]));
					$i += 2;
					if($this->option & Constants::UNESCAPED_UNICODE) {
						$ascii .= $char;
						break;
					}
					$utf16 = $this->utf8_to_utf16($char);
					$ascii .= sprintf('\u%04s', bin2hex($utf16));
					break;
				case (($ord_var_c & 0xF8) == 0xF0):
					if(!isset($value[$i + 1]) || !isset($value[$i + 2]) || !isset($value[$i + 3])) {
						$this->_not_unicode = true;
						return 'null';
					}

					$char = pack('C*', $ord_var_c, ord($value[$i + 1]),
									ord($value[$i + 2]), ord($value[$i + 3]));
					$i += 3;
					if($this->option & Constants::UNESCAPED_UNICODE) {
						$ascii .= $char;
						break;
					}
					$utf16 = $this->utf8_to_utf16($char);
					$ascii .= sprintf('\u%04s', bin2hex($utf16));
					break;
				case (($ord_var_c & 0xFC) == 0xF8):
					if(!isset($value[$i + 1]) || !isset($value[$i + 2]) || !isset($value[$i + 3]) || !isset($value[$i + 4])) {
						$this->_not_unicode = true;
						return 'null';
					}

					$char = pack('C*', $ord_var_c, ord($value[$i + 1]),
									ord($value[$i + 2]), ord($value[$i + 3]),
									ord($value[$i + 4]));
					$i += 4;
					if($this->option & Constants::UNESCAPED_UNICODE) {
						$ascii .= $char;
						break;
					}
					$utf16 = $this->utf8_to_utf16($char);
					$ascii .= sprintf('\u%04s', bin2hex($utf16));
					break;
				case (($ord_var_c & 0xFE) == 0xFC):
					if(!isset($value[$i + 1]) || !isset($value[$i + 2]) || !isset($value[$i + 3]) || !isset($value[$i + 4]) || !isset($value[$i + 5])) {
						$this->_not_unicode = true;
						return 'null';
					}

					$char = pack('C*', $ord_var_c, ord($value[$i + 1]),
								ord($value[$i + 2]), ord($value[$i + 3]),
								ord($value[$i + 4]), ord($value[$i + 5]));
					$i += 5;
					if($this->option & Constants::UNESCAPED_UNICODE) {
						$ascii .= $char;
						break;
					}
					$utf16 = $this->utf8_to_utf16($char);
					$ascii .= sprintf('\u%04s', bin2hex($utf16));
					break;
			}
		}

		return $ascii;
	}
	// }}}
	// {{{ string utf8_to_utf16 (string utf8) 
	/**
	 * Convert utf8 to utf16
	 *
	 * @param	string utf8
	 * @return	string
	 */
	private function utf8_to_utf16($utf8)
    {
		switch(strlen($utf8)) {
			case 1: return $utf8;
			case 2:
				return chr(0x07 & (ord($utf8{0}) >> 2)).chr((0xC0 & (ord($utf8{0}) << 6)) | (0x3F & ord($utf8{1})));
			case 3:
				return chr((0xF0 & (ord($utf8{0}) << 4)) | (0x0F & (ord($utf8{1}) >> 2))).chr((0xC0 & (ord($utf8{1}) << 6)) | (0x7F & ord($utf8{2})));
		}

		return '';
	}
	// }}}
// }}}

}
// vim: ts=4 sw=4 fdm=marker
?>
