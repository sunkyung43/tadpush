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
 * @version    $Id: YAML.php 2 2012-04-29 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\reader;

use CF\config\Reader,
	CF\config\yaml\Spyc;


/**
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2009 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class YAML implements Reader
{
// {{{ properties 
	/** @var array */
	private $data;
// }}}


// {{{ construct (string input)
	/**
	 * @param	string input Path of YAML file or string containing YAML
	 * @return	void
	 */
	public function __construct ($input) 
	{
		$this->data = Spyc::YAMLLoad($input);
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

}

// vim600: ts=4 sw=4 fdm=marker
?>
