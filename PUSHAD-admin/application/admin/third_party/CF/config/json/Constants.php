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
 * @version    $Id: Constants.php 19 2012-06-17 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\json;


/**
 * @category   CF
 * @package    CF_config_json
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class Constants
{
	/** for decode */
	const BIGINT_AS_STRING	= 0x01;

	/** for encode */
	const UNESCAPED_UNICODE = 0x01;
	const HEX_QUOT			= 0x02;
	const HEX_TAG			= 0x04;
	const HEX_AMP			= 0x08;
	const HEX_APOS			= 0x10;
	const NUMERIC_CHECK		= 0x20;
	const UNESCAPED_SLASHES = 0x40;
	const PRETTY_PRINT		= 0x80;
}

// vim600: ts=4 sw=4 fdm=marker
?>
