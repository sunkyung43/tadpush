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
 * @version    $Id: Parser.y 3 2012-06-15 ccooffeee Exp $
 */

/** @namespace */
namespace CF\config\json;

use	CF\config\json\exception\SyntaxErrorException,
	CF\exception\OverflowException;


/**
 * This class is JSON parser
 *
 * LALR shift/reduce conflicts and how they are resolved:
 * Parser statistics: 27 terminals, 15 nonterminals, 43 rules
 *                    54 states, 0 parser table entries, 0 conflicts
 *
 * @category   CF
 * @package    CF_config_json
 * @author     그네 Jung Sik, Park <ccooffeee@hotmail.com>
 * @copyright  Copyright (c) 2012 Jung Sik, Park <ccooffeee@hotmail.com>
 * @license    doc/LICENSE    Based New BSD License
 */
class Parser
{
	const T_LBRACE                         =  1;
	const T_RBRACE                         =  2;
	const T_COMMA                          =  3;
	const T_COLON                          =  4;
	const T_LBRACKET                       =  5;
	const T_RBRACKET                       =  6;
	const T_TRUE                           =  7;
	const T_FALSE                          =  8;
	const T_NULL                           =  9;
	const T_MINUS                          = 10;
	const T_DNUMBER                        = 11;
	const T_NUMBER                         = 12;
	const T_ENUMBER                        = 13;
	const T_QUOTE                          = 14;
	const T_UNICODE                        = 15;
	const T_DATUM                          = 16;
	const T_BSLASH                         = 17;
	const T_BS                             = 18;
	const T_SL                             = 19;
	const T_BK                             = 20;
	const T_BF                             = 21;
	const T_BN                             = 22;
	const T_BR                             = 23;
	const T_BT                             = 24;
	const T_SI                             = 25;
	const T_DB                             = 26;
	const YY_NO_ACTION = 99;
	const YY_ACCEPT_ACTION = 98;
	const YY_ERROR_ACTION = 97;
	const YY_SZ_ACTTAB = 109;
	const YYNOCODE = 43;
	const YYSTACKDEPTH = 100;
	const YYNSTATE = 54;
	const YYNRULE = 43;
	const YYERRORSYMBOL = 27;
	const YYERRSYMDT = 'yy0';
	const YYFALLBACK = 0;

	static public $yy_action = array(
		    4,    7,   38,    5,    1,   29,   49,   48,   44,    8,
		   47,   53,   27,    9,    4,    3,   13,   46,    1,   14,
		   49,   48,   44,    8,   47,   53,   27,    9,   18,    8,
		   47,   53,   27,   49,   48,   44,    8,   47,   53,   27,
		    9,   21,   22,   31,   28,   30,   23,   24,   25,   26,
		   49,   48,   44,    8,   47,   53,   27,    9,   50,   51,
		   43,   87,   87,   10,   20,   52,   32,   98,   45,   39,
		   40,   41,   50,   51,   43,   87,   52,   32,   42,   52,
		   32,   12,   11,   17,   87,   87,   52,   32,   35,   34,
		   33,   87,   12,   87,   37,   52,   32,   52,   32,   87,
		   87,   19,   16,   15,    6,    2,   87,   87,   36,
	);
	static public $yy_lookahead = array(
		    1,   39,    2,    3,    5,    6,    7,    8,    9,   10,
		   11,   12,   13,   14,    1,    4,   40,   37,    5,   41,
		    7,    8,    9,   10,   11,   12,   13,   14,    2,   10,
		   11,   12,   13,    7,    8,    9,   10,   11,   12,   13,
		   14,   18,   19,   20,   21,   22,   23,   24,   25,   26,
		    7,    8,    9,   10,   11,   12,   13,   14,   30,   31,
		   32,   42,   42,   35,   36,   37,   38,   28,   29,   30,
		   31,   32,   30,   31,   32,   42,   37,   38,   36,   37,
		   38,   32,   33,   34,   42,   42,   37,   38,   30,   31,
		   32,   42,   32,   42,   34,   37,   38,   37,   38,   42,
		   42,   14,   15,   16,   17,    3,   42,   42,    6,
	);
	const YY_SHIFT_USE_DFLT = -2;
	const YY_SHIFT_MAX = 12;
	static public $yy_shift_ofst = array(
		   13,   -1,   13,   13,   26,   43,   23,   87,   19,   -2,
		  102,    0,   11,
	);
	const YY_REDUCE_USE_DFLT = -39;
	const YY_REDUCE_MAX = 9;
	static public $yy_reduce_ofst = array(
		   39,   28,   42,   58,   49,   60,  -22,  -24,  -20,  -38,
	);
	static public $yyExpectedTokens = array(
			array(1, 5, 7, 8, 9, 10, 11, 12, 13, 14, ),
			array(1, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ),
			array(1, 5, 7, 8, 9, 10, 11, 12, 13, 14, ),
			array(1, 5, 7, 8, 9, 10, 11, 12, 13, 14, ),
			array(2, 7, 8, 9, 10, 11, 12, 13, 14, ),
			array(7, 8, 9, 10, 11, 12, 13, 14, ),
			array(18, 19, 20, 21, 22, 23, 24, 25, 26, ),
			array(14, 15, 16, 17, ),
			array(10, 11, 12, 13, ),
			array(),
			array(3, 6, ),
			array(2, 3, ),
			array(4, ),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
			array(),
	);
	static public $yy_default = array(
		   55,   97,   97,   97,   97,   97,   97,   97,   97,   83,
		   97,   97,   97,   86,   87,   85,   84,   61,   60,   82,
		   68,   88,   89,   93,   94,   95,   96,   81,   91,   67,
		   92,   90,   77,   63,   64,   65,   66,   62,   59,   56,
		   57,   58,   69,   70,   76,   54,   78,   79,   75,   74,
		   71,   72,   73,   80,
	);

	static public $yyFallback = array(
		);


	public $successful = true;
	public $retvalue = 0;
	private $internalError = false;
	private $lex;

	private $option;


	public function __construct(Scanner $lex, $option = 0) {
		$this->lex = $lex;
		$this->option = $option;
	}

	public function parse() {
		while($this->lex->yylex())
			$this->doParse($this->lex->token, $this->lex->value);

		$this->doParse(0, 0);
	}


	private function unicodeDecode($chrs)
	{
		$utf16 = chr(hexdec(substr($chrs, 2, 2)))
						.chr(hexdec(substr($chrs, 4, 2)));
		return $this->utf16_to_utf8($utf16);
	}

	private function utf16_to_utf8($utf16)
	{
		$bytes = (ord($utf16{0}) << 8) | ord($utf16{1});

		switch(true) {
			case ((0x7F & $bytes) == $bytes):
				return chr(0x7F & $bytes);
			case (0x07FF & $bytes) == $bytes:
				return chr(0xC0 | (($bytes >> 6) & 0x1F))
						.chr(0x80 | ($bytes & 0x3F));
			case (0xFFFF & $bytes) == $bytes:
				return chr(0xE0 | (($bytes >> 12) & 0x0F))
						.chr(0x80 | (($bytes >> 6) & 0x3F))
						.chr(0x80 | ($bytes & 0x3F));
		}
		return '';
	}

	static public function Trace($TraceFILE, $zTracePrompt) {
		if(!$TraceFILE) $zTracePrompt = 0;
		elseif(!$zTracePrompt) $TraceFILE = 0;

		self::$yyTraceFILE = $TraceFILE;
		self::$yyTracePrompt = $zTracePrompt;
	}

	static public function PrintTrace() {
		self::$yyTraceFILE = fopen('php://output', 'w');
		self::$yyTracePrompt = '<br>';
	}

	public function setPrompt($prompt) {
		self::$yyTracePrompt = $prompt;
	}


	public $yyTokenName = array( 
	'$',           	'LBRACE',      	'RBRACE',      	'COMMA',       
	'COLON',       	'LBRACKET',    	'RBRACKET',    	'TRUE',        
	'FALSE',       	'NULL',        	'MINUS',       	'DNUMBER',     
	'NUMBER',      	'ENUMBER',     	'QUOTE',       	'UNICODE',     
	'DATUM',       	'BSLASH',      	'BS',          	'SL',          
	'BK',          	'BF',          	'BN',          	'BR',          
	'BT',          	'SI',          	'DB',          	'error',       
	'input',       	'json',        	'array',       	'object',      
	'datum',       	'object_element_list',	'object_element',	'array_element_list',
	'array_element',	'number',      	'quote_string',	'quote',       
	'backslash',   	'escape',      
		);

	static public $yyRuleName = array(
		'input ::= json',
		'json ::=',
		'json ::= array',
		'json ::= object',
		'json ::= datum',
		'object ::= LBRACE object_element_list RBRACE',
		'object ::= LBRACE RBRACE',
		'object_element_list ::= object_element',
		'object_element_list ::= object_element_list COMMA object_element',
		'object_element ::= datum COLON datum',
		'object_element ::= datum COLON object',
		'object_element ::= datum COLON array',
		'array ::= LBRACKET array_element_list RBRACKET',
		'array ::= LBRACKET RBRACKET',
		'array_element_list ::= array_element',
		'array_element_list ::= array_element_list COMMA array_element',
		'array_element ::= datum',
		'array_element ::= array',
		'array_element ::= object',
		'datum ::= number',
		'datum ::= TRUE',
		'datum ::= FALSE',
		'datum ::= NULL',
		'datum ::= quote_string',
		'number ::= MINUS number',
		'number ::= DNUMBER',
		'number ::= NUMBER',
		'number ::= ENUMBER',
		'quote_string ::= QUOTE quote QUOTE',
		'quote ::=',
		'quote ::= quote UNICODE',
		'quote ::= quote DATUM',
		'quote ::= quote backslash',
		'backslash ::= BSLASH escape',
		'escape ::= BS',
		'escape ::= SL',
		'escape ::= BK',
		'escape ::= BF',
		'escape ::= BN',
		'escape ::= BR',
		'escape ::= BT',
		'escape ::= SI',
		'escape ::= DB',
		);


	static public $yyTraceFILE;
	static public $yyTracePrompt;
	public $yyidx;
	public $yyerrcnt;
	public $yystack = array();

	private function tokenName($tokenType) {
		if($tokenType === 0)
			return 'End of Input';
		if($tokenType > 0 && $tokenType < count($this->yyTokenName))
			return $this->yyTokenName[$tokenType];

		return "Unknown";
	}

	static private function yy_destructor($yymajor, $yypminor) {
		switch($yymajor) {
			default: break;
		}
	}

	private function yy_pop_parser_stack() {
		if(!count($this->yystack)) return;

		$yytos = array_pop($this->yystack);
		if(self::$yyTraceFILE && $this->yyidx >= 0)
			fwrite(self::$yyTraceFILE,
					self::$yyTracePrompt.'Popping '.$this->yyTokenName[$yytos->major]."\n");
		$yymajor = $yytos->major;
		self::yy_destructor($yymajor, $yytos->minor);
		$this->yyidx--;
		return $yymajor;
	}

	public function __destruct() {
		while($this->yystack !== Array())
			$this->yy_pop_parser_stack();

		if(is_resource(self::$yyTraceFILE))
			fclose(self::$yyTraceFILE);
	}

	public function yy_get_expected_tokens($token) {
		$state = $this->yystack[$this->yyidx]->stateno;
		$expected = self::$yyExpectedTokens[$state];
		if(in_array($token, self::$yyExpectedTokens[$state], true))
			return $expected;

		$stack = $this->yystack;
		$yyidx = $this->yyidx;
		do {
			$yyact = $this->yy_find_shift_action($token);
			if($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
				$done = 0;
				do {
					if($done++ == 100) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						return array_unique($expected);
					}
					$yyruleno = $yyact - self::YYNSTATE;
					$this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
					$nextstate = $this->yy_find_reduce_action(
						$this->yystack[$this->yyidx]->stateno,
						self::$yyRuleInfo[$yyruleno]['lhs']);
					if(isset(self::$yyExpectedTokens[$nextstate])) {
						$expected = array_merge($expected, self::$yyExpectedTokens[$nextstate]);
						if(in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
							$this->yyidx = $yyidx;
							$this->yystack = $stack;
							return array_unique($expected);
						}
					}
					if($nextstate < self::YYNSTATE) {
						$this->yyidx++;
						$x = new Parser_yyStackEntry;
						$x->stateno = $nextstate;
						$x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
						$this->yystack[$this->yyidx] = $x;
						continue 2;
					}
					elseif($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						return array_unique($expected);
					}
					elseif($nextstate === self::YY_NO_ACTION) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						return $expected;
					}
					else $yyact = $nextstate;
				} while(true);
			}
			break;
		} while(true);
		$this->yyidx = $yyidx;
		$this->yystack = $stack;
 		return array_unique($expected);
	}

	private function yy_is_expected_token($token) {
		if($token === 0) return true;

		$state = $this->yystack[$this->yyidx]->stateno;
		if(in_array($token, self::$yyExpectedTokens[$state], true))
			return true;

		$stack = $this->yystack;
		$yyidx = $this->yyidx;
		do {
			$yyact = $this->yy_find_shift_action($token);
			if($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
				$done = 0;
				do {
					if($done++ == 100) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						return true;
					}
					$yyruleno = $yyact - self::YYNSTATE;
					$this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
					$nextstate = $this->yy_find_reduce_action(
						$this->yystack[$this->yyidx]->stateno,
						self::$yyRuleInfo[$yyruleno]['lhs']);
					if(isset(self::$yyExpectedTokens[$nextstate]) && in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						return true;
					}
					if($nextstate < self::YYNSTATE) {
						$this->yyidx++;
						$x = new Parser_yyStackEntry;
						$x->stateno = $nextstate;
						$x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
						$this->yystack[$this->yyidx] = $x;
						continue 2;
					}
					elseif($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						if(!$token) return true;

						return false;
					}
					elseif($nextstate === self::YY_NO_ACTION) {
						$this->yyidx = $yyidx;
						$this->yystack = $stack;
						return true;
					}
					else $yyact = $nextstate;
				} while(true);
			}
			break;
		} while(true);
		$this->yyidx = $yyidx;
		$this->yystack = $stack;
		return true;
	}

	private function yy_find_shift_action($iLookAhead) {
		$stateno = $this->yystack[$this->yyidx]->stateno;
     
		if(!isset(self::$yy_shift_ofst[$stateno]))
			return self::$yy_default[$stateno];

		$i = self::$yy_shift_ofst[$stateno];
		if($i === self::YY_SHIFT_USE_DFLT)
			return self::$yy_default[$stateno];

		if($iLookAhead == self::YYNOCODE)
			return self::YY_NO_ACTION;

		$i += $iLookAhead;
		if($i < 0 || $i >= self::YY_SZ_ACTTAB
				|| self::$yy_lookahead[$i] != $iLookAhead) {
			if(count(self::$yyFallback)
					&& $iLookAhead < count(self::$yyFallback)
					&& ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
				if(self::$yyTraceFILE) {
					fwrite(self::$yyTraceFILE, self::$yyTracePrompt."FALLBACK "
						.$this->yyTokenName[$iLookAhead]." => "
						.$this->yyTokenName[$iFallback]."\n");
				}
				return $this->yy_find_shift_action($iFallback);
			}
			return self::$yy_default[$stateno];
		}
		return self::$yy_action[$i];
	}

	private function yy_find_reduce_action($stateno, $iLookAhead) {
		if(!isset(self::$yy_reduce_ofst[$stateno]))
			return self::$yy_default[$stateno];

		$i = self::$yy_reduce_ofst[$stateno];
		if($i == self::YY_REDUCE_USE_DFLT)
			return self::$yy_default[$stateno];

		if($iLookAhead == self::YYNOCODE)
			return self::YY_NO_ACTION;

		$i += $iLookAhead;
		if($i < 0 || $i >= self::YY_SZ_ACTTAB ||
				self::$yy_lookahead[$i] != $iLookAhead)
			return self::$yy_default[$stateno];

		return self::$yy_action[$i];
	}

	private function yy_shift($yyNewState, $yyMajor, $yypMinor) {
		$this->yyidx++;
		if($this->yyidx >= self::YYSTACKDEPTH) {
			$this->yyidx--;
			if(self::$yyTraceFILE)
				fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);

			while($this->yyidx >= 0)
				$this->yy_pop_parser_stack();

			$this->internalError = true;
			throw new OverflowException("#Error: Stack overflow in configfile parser");
			return;
		}
		$yytos = new Parser_yyStackEntry;
		$yytos->stateno = $yyNewState;
		$yytos->major = $yyMajor;
		$yytos->minor = $yypMinor;
		array_push($this->yystack, $yytos);
		if(self::$yyTraceFILE && $this->yyidx > 0) {
			fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt, $yyNewState);
			fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
			for($i = 1; $i <= $this->yyidx; $i++)
				fprintf(self::$yyTraceFILE, " %s", $this->yyTokenName[$this->yystack[$i]->major]);

			fwrite(self::$yyTraceFILE,"\n");
		}
	}

	static public $yyRuleInfo = array(
		array( 'lhs' => 28, 'rhs' => 1 ),
		array( 'lhs' => 29, 'rhs' => 0 ),
		array( 'lhs' => 29, 'rhs' => 1 ),
		array( 'lhs' => 29, 'rhs' => 1 ),
		array( 'lhs' => 29, 'rhs' => 1 ),
		array( 'lhs' => 31, 'rhs' => 3 ),
		array( 'lhs' => 31, 'rhs' => 2 ),
		array( 'lhs' => 33, 'rhs' => 1 ),
		array( 'lhs' => 33, 'rhs' => 3 ),
		array( 'lhs' => 34, 'rhs' => 3 ),
		array( 'lhs' => 34, 'rhs' => 3 ),
		array( 'lhs' => 34, 'rhs' => 3 ),
		array( 'lhs' => 30, 'rhs' => 3 ),
		array( 'lhs' => 30, 'rhs' => 2 ),
		array( 'lhs' => 35, 'rhs' => 1 ),
		array( 'lhs' => 35, 'rhs' => 3 ),
		array( 'lhs' => 36, 'rhs' => 1 ),
		array( 'lhs' => 36, 'rhs' => 1 ),
		array( 'lhs' => 36, 'rhs' => 1 ),
		array( 'lhs' => 32, 'rhs' => 1 ),
		array( 'lhs' => 32, 'rhs' => 1 ),
		array( 'lhs' => 32, 'rhs' => 1 ),
		array( 'lhs' => 32, 'rhs' => 1 ),
		array( 'lhs' => 32, 'rhs' => 1 ),
		array( 'lhs' => 37, 'rhs' => 2 ),
		array( 'lhs' => 37, 'rhs' => 1 ),
		array( 'lhs' => 37, 'rhs' => 1 ),
		array( 'lhs' => 37, 'rhs' => 1 ),
		array( 'lhs' => 38, 'rhs' => 3 ),
		array( 'lhs' => 39, 'rhs' => 0 ),
		array( 'lhs' => 39, 'rhs' => 2 ),
		array( 'lhs' => 39, 'rhs' => 2 ),
		array( 'lhs' => 39, 'rhs' => 2 ),
		array( 'lhs' => 40, 'rhs' => 2 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		array( 'lhs' => 41, 'rhs' => 1 ),
		);

	static public $yyReduceMap = array(
		0 => 0,
		2 => 0,
		3 => 0,
		16 => 0,
		17 => 0,
		18 => 0,
		19 => 0,
		23 => 0,
		33 => 0,
		1 => 1,
		6 => 1,
		13 => 1,
		4 => 4,
		5 => 5,
		12 => 5,
		28 => 5,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 9,
		11 => 9,
		14 => 14,
		15 => 15,
		20 => 20,
		21 => 21,
		22 => 22,
		24 => 24,
		25 => 25,
		27 => 25,
		26 => 26,
		29 => 29,
		30 => 30,
		31 => 31,
		32 => 31,
		34 => 34,
		35 => 35,
		36 => 36,
		37 => 37,
		38 => 38,
		39 => 39,
		40 => 40,
		41 => 41,
		42 => 42,
		);

	private function yy_r0() {
		$this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
	}

	private function yy_r1() {
		$this->_retvalue = array();
	}

	private function yy_r4() {
		$this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);
	}

	private function yy_r5() {
		$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;
	}

	private function yy_r7() {
		$this->_retvalue = array();
		$this->_retvalue[$this->yystack[$this->yyidx + 0]->minor[0]] = $this->yystack[$this->yyidx + 0]->minor[1];
	}

	private function yy_r8() {
		$this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;
		$this->_retvalue[$this->yystack[$this->yyidx + 0]->minor[0]] = $this->yystack[$this->yyidx + 0]->minor[1];
	}

	private function yy_r9() {
		$this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);
	}

	private function yy_r14() {
		$this->_retvalue = array();
		$this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;
	}

	private function yy_r15() {
		$this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;
		$this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;
	}

	private function yy_r20() {
		$this->_retvalue = true;
	}

	private function yy_r21() {
		$this->_retvalue = false;
	}

	private function yy_r22() {
		$this->_retvalue = null;
	}

	private function yy_r24() {
		$this->_retvalue = -$this->yystack[$this->yyidx + 0]->minor;
	}

	private function yy_r25() {
		$this->_retvalue = floatval($this->yystack[$this->yyidx + 0]->minor);
	}

	private function yy_r26() {
		if(intval($this->yystack[$this->yyidx + 0]->minor) !== floatval($this->yystack[$this->yyidx + 0]->minor)) {
			if($this->option & Constants::BIGINT_AS_STRING)
				$this->_retvalue = (string)$this->yystack[$this->yyidx + 0]->minor;
			else $this->_retvalue = floatval($this->yystack[$this->yyidx + 0]->minor);
		}
		else $this->_retvalue = intval($this->yystack[$this->yyidx + 0]->minor);
	}

	private function yy_r29() {
		$this->_retvalue = '';
	}

	private function yy_r30() {
		$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->unicodeDecode($this->yystack[$this->yyidx + 0]->minor);
	}

	private function yy_r31() {
		$this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;
	}

	private function yy_r34() {
		$this->_retvalue = "\\";
	}

	private function yy_r35() {
		$this->_retvalue = '/';
	}

	private function yy_r36() {
		$this->_retvalue = "\b";
	}

	private function yy_r37() {
		$this->_retvalue = "\f";
	}

	private function yy_r38() {
		$this->_retvalue = "\n";
	}

	private function yy_r39() {
		$this->_retvalue = "\r";
	}

	private function yy_r40() {
		$this->_retvalue = "\t";
	}

	private function yy_r41() {
		$this->_retvalue = "'";
	}

	private function yy_r42() {
		$this->_retvalue = '"';
	}

	private $_retvalue;

	private function yy_reduce($yyruleno) {
		$yymsp = $this->yystack[$this->yyidx];
		if(self::$yyTraceFILE && $yyruleno >= 0 
				&& $yyruleno < count(self::$yyRuleName)) {
			fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
					self::$yyTracePrompt,
					$yyruleno,
					self::$yyRuleName[$yyruleno]);
		}

		$this->_retvalue = $yy_lefthand_side = null;
		if(array_key_exists($yyruleno, self::$yyReduceMap)) {
			$this->_retvalue = null;
			if(!method_exists($this, 'yy_r' . self::$yyReduceMap[$yyruleno]))
				throw new SyntaxErrorException ('#Error: Syntex Error - Unexpected syntax (Not found rule');

			$this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
			$yy_lefthand_side = $this->_retvalue;
		}
		$yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
		$yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
		$this->yyidx -= $yysize;
		for($i = $yysize; $i; $i--)
			array_pop($this->yystack);

		$yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
		if($yyact < self::YYNSTATE) {
			if(!self::$yyTraceFILE && $yysize) {
				$this->yyidx++;
				$x = new Parser_yyStackEntry;
				$x->stateno = $yyact;
				$x->major = $yygoto;
				$x->minor = $yy_lefthand_side;
				$this->yystack[$this->yyidx] = $x;
			}
			else $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
		}
		elseif($yyact == self::YYNSTATE + self::YYNRULE + 1)
			$this->yy_accept();
	}

	private function yy_parse_failed() {
		if(self::$yyTraceFILE)
			fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);

		while ($this->yyidx >= 0)
			$this->yy_pop_parser_stack();
	}

	private function yy_syntax_error($yymajor, $TOKEN) {

		$this->internalError = true;
		$this->yymajor = $yymajor;
		if($TOKEN === 0)
			throw new SyntaxErrorException ('#Error: line '.$this->lex->line.': Syntax Error - unexpected any json data');

		throw new SyntaxErrorException ('#Error: line '.$this->lex->line.': Syntax Error at or near from \''.$TOKEN."'\n");
	}

	private function yy_accept() {
		if(self::$yyTraceFILE)
			fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);

		while ($this->yyidx >= 0)
			$stack = $this->yy_pop_parser_stack();

		$this->successful = !$this->internalError;
		$this->internalError = false;
		$this->retvalue = $this->_retvalue;
	}

	public function doParse($yymajor, $yytokenvalue) {
		$yyerrorhit = 0;
        
		if($this->yyidx === null || $this->yyidx < 0) {
			$this->yyidx = 0;
			$this->yyerrcnt = -1;
			$x = new Parser_yyStackEntry;
			$x->stateno = 0;
			$x->major = 0;
			$this->yystack = array();
			array_push($this->yystack, $x);
		}
		$yyendofinput = ($yymajor==0);
        
		if(self::$yyTraceFILE) {
			fprintf(self::$yyTraceFILE, "%sInput \033[0;36m%s\033[0m - #line: %s - \033[1;35m%s\033[0m %s\n",
					self::$yyTracePrompt, $this->yyTokenName[$yymajor],
					$this->lex->line, $yytokenvalue, bin2hex($yytokenvalue));
		}
        
		do {
			$yyact = $this->yy_find_shift_action($yymajor);
			if($yymajor < self::YYERRORSYMBOL
					&& !$this->yy_is_expected_token($yymajor)) {
				$yyact = self::YY_ERROR_ACTION;
			}
			if($yyact < self::YYNSTATE) {
				$this->yy_shift($yyact, $yymajor, $yytokenvalue);
				$this->yyerrcnt--;
				if($yyendofinput && $this->yyidx >= 0)
					$yymajor = 0;
				else $yymajor = self::YYNOCODE;
			}
			elseif($yyact < self::YYNSTATE + self::YYNRULE)
				$this->yy_reduce($yyact - self::YYNSTATE);
			elseif($yyact == self::YY_ERROR_ACTION) {
				if(self::$yyTraceFILE) {
					fprintf(self::$yyTraceFILE, "%sSyntax Error!\n",
							self::$yyTracePrompt);
				}
				if(self::YYERRORSYMBOL) {
					if($this->yyerrcnt < 0)
						$this->yy_syntax_error($yymajor, $yytokenvalue);

					$yymx = $this->yystack[$this->yyidx]->major;
					if($yymx == self::YYERRORSYMBOL || $yyerrorhit){
						if(self::$yyTraceFILE) {
							fprintf(self::$yyTraceFILE, "%sDiscard input token %s\n",
									self::$yyTracePrompt, $this->yyTokenName[$yymajor]);
						}
						$this->yy_destructor($yymajor, $yytokenvalue);
						$yymajor = self::YYNOCODE;
					}
					else {
						while($this->yyidx >= 0
								&& $yymx != self::YYERRORSYMBOL
								&& ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE) {
							$this->yy_pop_parser_stack();
						}
						if($this->yyidx < 0 || $yymajor==0) {
							$this->yy_destructor($yymajor, $yytokenvalue);
							$this->yy_parse_failed();
							$yymajor = self::YYNOCODE;
						}
						elseif($yymx != self::YYERRORSYMBOL) {
							$u2 = 0;
							$this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
						}
					}
					$this->yyerrcnt = 3;
					$yyerrorhit = 1;
				}
				else {
					if($this->yyerrcnt <= 0)
						$this->yy_syntax_error($yymajor, $yytokenvalue);

					$this->yyerrcnt = 3;
					$this->yy_destructor($yymajor, $yytokenvalue);
					if($yyendofinput)
						$this->yy_parse_failed();

					$yymajor = self::YYNOCODE;
				}
			}
			else {
				$this->yy_accept();
				$yymajor = self::YYNOCODE;
			}            
		} while($yymajor != self::YYNOCODE && $this->yyidx >= 0);
	}
}

class Parser_yyStackEntry
{
	public $stateno;
	public $major;
	public $minor;
}
// vim: ts=4 sw=4
?>
