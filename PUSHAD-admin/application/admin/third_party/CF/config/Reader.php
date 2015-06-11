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
 * @version    $Id: Reader.php 1 2012-04-26 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config;


/**
 * @category   CF
 * @package    CF_config
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011 - 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
interface Reader
{
	/**
	 * @return array
	 */
	public function getData ();
}

// vim600: ts=4 sw=4 fdm=marker
?>
