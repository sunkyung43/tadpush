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
 * This Source is subject o the New BSD License with SOME CONSTRAINT that is boudled
 * with this package in the file doc/LICENSE 
 *
 * @category   CF
 * @package    CF_config_json
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011-2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 * @version    $Id: Scanner.l 2 2012-04-29 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\json;

use CF\config\json\exception\SyntaxErrorException as Exception;


/**
 * JSON lexer
 *
 * @category   CF
 * @package    CF_config_json
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2011-2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class Scanner
{
	public $data;
	public $counter;
	public $token;
	public $value;
	public $node;
	public $line;


	public function __construct($data) {
		$this->data = $data;
		$this->counter = 0;
		$this->line = 1;
	}



	private $_yy_state = 1;
	private $_yy_stack = array();

	public function yylex() {
		return $this->{'yylex' . $this->_yy_state}();
	}

	private function yypushstate($state) {
		array_push($this->_yy_stack, $this->_yy_state);
		$this->_yy_state = $state;
	}

	private function yypopstate() {
		$this->_yy_state = array_pop($this->_yy_stack);
	}

	private function yybegin($state) {
		$this->_yy_state = $state;
	}

	private function _yylex(array $tokenMap, $yy_global_pattern, $stateName, $stateNumber) {
		do {
			if(preg_match($yy_global_pattern, $this->data, $yymatches, null, $this->counter)) {
				$yysubmatches = $yymatches;
				$yymatches = array_filter($yymatches, 'strlen');
				if(!count($yymatches))
					throw new Exception('Error: lexing failed because a rule matched an empty string. Input "' . substr($this->data, $this->counter, 5).'... state '.$stateName);

				next($yymatches);
				$this->token = key($yymatches);
				if(isset($tokenMap[$this->token]) && $tokenMap[$this->token])
					$yysubmatches = array_slice($yysubmatches, $this->token + 1, $tokenMap[$this->token]);
				else $yysubmatches = array();

				$this->value = current($yymatches);
				if(!method_exists($this, 'yy_r'.$stateNumber.'_' . $this->token))
					throw new Exception('Syntax Error: Unexpected syntax (Not found rule)');

				$r = $this->{'yy_r'.$stateNumber.'_' . $this->token}($yysubmatches);
				if($r === null) {
					$this->counter += strlen($this->value);
					$this->line += substr_count($this->value, "\n");
					return true;
				}
				elseif($r === true) return $this->yylex();
				elseif($r === false) {
					$this->counter += strlen($this->value);
					$this->line += substr_count($this->value, "\n");
					if($this->counter >= strlen($this->data))
						return false;
					continue;
				}
				elseif($r === 'loop') return true;
			}
			else 
				throw new Exception('Unexpected input at line ' .$this->line.': '. $this->data[$this->counter]);
			break;
		} while(true);
	}



	private function yylex1() {
		$tokenMap = array (
					  1 => 0,
					  2 => 0,
					  3 => 0,
					  4 => 0,
					  5 => 0,
					  6 => 0,
					  7 => 0,
					  8 => 0,
					  9 => 0,
					  10 => 0,
					  11 => 1,
					  13 => 0,
					  14 => 0,
					  15 => 0,
					  16 => 1,
					  18 => 0,
					);
		if($this->counter >= strlen($this->data))
			return false;

		$yy_global_pattern = "/\G(\\{)|\G(\\})|\G(\\[)|\G(\\])|\G(,)|\G(:)|\G(\")|\G(-)|\G(\\d+)|\G(\\d+\\.\\d+)|\G((\\d+|\\d+\\.\\d+)[eE][+-]?\\d+)|\G(true)|\G(false)|\G(null)|\G(([\t\b\f\n\r ])+)|\G([\s\S]+)/S";

		return $this->_yylex($tokenMap, $yy_global_pattern, 'INITIAL', 1);
	}


	const INITIAL = 1;
	private function yy_r1_1($yy_subpatterns) {
		$this->token = Parser::T_LBRACE;
	}
	private function yy_r1_2($yy_subpatterns) {
		$this->token = Parser::T_RBRACE;
	}
	private function yy_r1_3($yy_subpatterns) {
		$this->token = Parser::T_LBRACKET;
	}
	private function yy_r1_4($yy_subpatterns) {
		$this->token = Parser::T_RBRACKET;
	}
	private function yy_r1_5($yy_subpatterns) {
		$this->token = Parser::T_COMMA;
	}
	private function yy_r1_6($yy_subpatterns) {
		$this->token = Parser::T_COLON;
	}
	private function yy_r1_7($yy_subpatterns) {
		$this->token = Parser::T_QUOTE;
		$this->yypushstate(self::QUOTE);
	}
	private function yy_r1_8($yy_subpatterns) {
		$this->token = Parser::T_MINUS;
	}
	private function yy_r1_9($yy_subpatterns) {
		$this->token = Parser::T_NUMBER;
	}
	private function yy_r1_10($yy_subpatterns) {
		$this->token = Parser::T_DNUMBER;
	}
	private function yy_r1_11($yy_subpatterns) {
		$this->token = Parser::T_ENUMBER;
	}
	private function yy_r1_13($yy_subpatterns) {
		$this->token = Parser::T_TRUE;
	}
	private function yy_r1_14($yy_subpatterns) {
		$this->token = Parser::T_FALSE;
	}
	private function yy_r1_15($yy_subpatterns) {
		$this->token = Parser::T_NULL;
	}
	private function yy_r1_16($yy_subpatterns) {
		return false;
	}
	private function yy_r1_18($yy_subpatterns) {
		return false;
	}



	private function yylex2() {
		$tokenMap = array (
					  1 => 0,
					  2 => 0,
					  3 => 0,
					  4 => 0,
					);
		if($this->counter >= strlen($this->data))
			return false;

		$yy_global_pattern = "/\G(\\\\u[0-9a-fA-F]{4})|\G(\\\\)|\G(\")|\G([^\"\\\\]+)/S";

		return $this->_yylex($tokenMap, $yy_global_pattern, 'QUOTE', 2);
	}


	const QUOTE = 2;
	private function yy_r2_1($yy_subpatterns) {
		$this->token = Parser::T_UNICODE;
	}
	private function yy_r2_2($yy_subpatterns) {
		$this->token = Parser::T_BSLASH;
		$this->yybegin(self::BACKSLASH);
	}
	private function yy_r2_3($yy_subpatterns) {
		$this->token = Parser::T_QUOTE;
		$this->yypopstate();
	}
	private function yy_r2_4($yy_subpatterns) {
		$this->token = Parser::T_DATUM;
	}



	private function yylex3() {
		$tokenMap = array (
					  1 => 0,
					  2 => 0,
					  3 => 0,
					  4 => 0,
					  5 => 0,
					  6 => 0,
					  7 => 0,
					  8 => 0,
					  9 => 0,
					);
		if($this->counter >= strlen($this->data))
			return false;

		$yy_global_pattern = "/\G(\\\\)|\G(\/)|\G(b)|\G(f)|\G(n)|\G(r)|\G(t)|\G(')|\G(\")/S";

		return $this->_yylex($tokenMap, $yy_global_pattern, 'BACKSLASH', 3);
	}


	const BACKSLASH = 3;
	private function yy_r3_1($yy_subpatterns) {
		$this->token = Parser::T_BS;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_2($yy_subpatterns) {
		$this->token = Parser::T_SL;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_3($yy_subpatterns) {
		$this->token = Parser::T_BK;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_4($yy_subpatterns) {
		$this->token = Parser::T_BF;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_5($yy_subpatterns) {
		$this->token = Parser::T_BN;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_6($yy_subpatterns) {
		$this->token = Parser::T_BR;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_7($yy_subpatterns) {
		$this->token = Parser::T_BT;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_8($yy_subpatterns) {
		$this->token = Parser::T_SI;
		$this->yybegin(self::QUOTE);
	}
	private function yy_r3_9($yy_subpatterns) {
		$this->token = Parser::T_DB;
		$this->yybegin(self::QUOTE);
	}

}
// vim: ts=4 sw=4
?>
