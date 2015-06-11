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
 * @version    $Id: YAML.php 7 2012-05-18 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\writer;

use CF\config\Writer,
	CF\config\Config,
	CF\config\yaml\Spyc,
	CF\exception\RuntimeException;


/**
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class YAML implements Writer
{

// {{{ properties 
	/** @var string */
	private $result;
// }}}


// {{{ construct (null|string filename, CF\config\Config config) 
	/**
	 * @param	null|string			filename
	 * @param	CF\config\Config	config
	 * @return	void
	 * @throws	CF\exception\RuntimeException
	 */
	public function __construct ($filename, Config $config) 
	{
		$data = $config->toArray();

		$yaml = Spyc::YAMLDump($data);

		if($filename === null) {
			$this->result = $yaml;
			return;
		}

		$result = @file_put_contents($filename, $yaml);

		if($result === false)
			throw new RuntimeException("Cant write file '$filename'");
	}

// }}}


// {{{ __toString
	/**
	 * __toString magic method
	 *
	 * @return string
	 */
	public function __toString () {
		return (string) $this->result;
	}
// }}}

}

// vim600: ts=4 sw=4 fdm=marker
?>
