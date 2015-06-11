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
 * @version    $Id: XML.php 2 2012-04-28 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\reader;

use XMLReader,
	CF\config\Reader;


/**
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class XML implements Reader
{
// {{{ properties 
	/** @var array */
	private $data = array();

	/** @var XMLReader */
	private $reader;
// }}}


// {{{ construct (string input)
	/**
	 * @param  string input	xml file or xml string
	 * @return void
	 */
	public function __construct ($input)
	{
		if(empty($input)) return;

		$this->reader = new XMLReader;
		if(file_exists($input))
			$this->reader->open($input, null, LIBXML_XINCLUDE);
		else $this->reader->xml($input, null, LIBXML_XINCLUDE);

		$this->data = $this->parseElement();
	}
// }}}


// {{{ array getData (void) 

	/**
	 * Returns all data
	 *
	 * @return array
	 */
	public function getData ()
	{
		return $this->data;
	}

// }}}


// {{{ private methods
	// {{{ array parseElement (void) 
	/**
	 * @return	array|string
	 */
	private function parseElement ()
	{
		$data = array();
		$text = '';
		while($this->reader->read()) {
			switch($this->reader->nodeType) {
				case XMLReader::ELEMENT:
					if($this->reader->depth === 0)
						return $this->parseElement();

					$name = $this->reader->name;
					$attrs = $this->getAttributes();

					if($this->reader->isEmptyElement)
						$child = array();
					else $child = $this->parseElement();

					if($attrs) {
						if(!is_array($child))
							$child = array('@value@' => $child);

						$child['@attribute@'] = $attrs;
					}

					if(isset($data[$name])) {
						if(!is_array($data[$name]) || !$data[$name])
							$data[$name] = array($data[$name]);

						if(!isset($data[$name][0])) {
							$tmp = $data[$name];
							$data[$name] = array();
							array_push($data[$name], $tmp);
						}
						array_push($data[$name], $child);
					}
					else $data[$name] = $child;

					break;
				case XMLReader::END_ELEMENT:
					return $data ?: $text;
				case XMLReader::TEXT:
				case XMLReader::CDATA:
				case XMLReader::WHITESPACE:
				case XMLReader::SIGNIFICANT_WHITESPACE:
					$text .= $this->reader->value;
					break;
			}
		}

		return $data ?: $text;
	}
	// }}}
	// {{{ array getAttributes (void) 
	/**
	 * Get all attribute current node
	 *
	 * @return	array
	 */
	private function getAttributes ()
	{
		$attrs = array();

		if($this->reader->hasAttributes) {
			while($this->reader->moveToNextAttribute())
				$attrs[$this->reader->localName] = $this->reader->value;

			$this->reader->moveToElement();
		}

		return $attrs;
	}
	// }}}
// }}}

}

// vim600: ts=4 sw=4 fdm=marker
?>
