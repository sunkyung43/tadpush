<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('des_encrypt'))
{
	function des_encrypt($text)
	{
		$block_size = mcrypt_get_block_size('tripledes', 'ecb');
		return base64_encode(mcrypt_encrypt('tripledes', 'nasanghy', _pkcs5_pad($text, $block_size), 'ecb'));
	}
}

if (!function_exists('des_decrypt'))
{
	function des_decrypt($enc_text)
	{
		return _pkcs5_unpad(mcrypt_decrypt('tripledes', 'nasanghy', base64_decode($enc_text), 'ecb'));
	}
}

if (!function_exists('_pkcs5_pad'))
{
	function _pkcs5_pad($text, $blocksize)
	{
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}
}

if (!function_exists('_pkcs5_unpad'))
{
	function _pkcs5_unpad($text)
	{
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)) return false;
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
		return substr($text, 0, -1 * $pad);
	}
}

if (!function_exists('skp_encrypt'))
{
	function skp_encrypt($str)
	{
		$CI = &get_instance();
		if(!$CI->config->item('use_crypto_library')) {
			return $str;
		}

		$domain_check	= strpos($_SERVER['HTTP_HOST'], 'test');
		if ($domain_check !== false)
		{
			$ch = curl_init();
			$url = 'http://admin.adotsolution.com/welcome/skp_encode';
			$post_fields	= 'text='.$str;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			$result = curl_exec($ch);
			curl_close($ch);
				
			return $result;
		}

		if(ini_get('enable_dl') && !extension_loaded('c_crypto'))
		{
			try {
				dl('c_crypto.' . PHP_SHLIB_SUFFIX);
			} catch(Exception $e) {
			}
		}
		if (!extension_loaded('c_crypto'))
		{
			return 'load fail : ' .$str;
		}
		$keyfile_path 	= '/app/docroot/apache/pushad/application/admin/config/encrypt.key';
		$passwd 		= "742d61642e61642e70617373776f7264";	// "t-ad.ad.password" 문자열의 hexa 코드

		$values = c_getValues($keyfile_path, $passwd);
		$deriveKey = $values["key"];
		$iv = $values["iv"];

		return c_hex_encode(c_aes128_encrypt($str, $deriveKey, $iv));
	}
}

if (!function_exists('skp_decrypt'))
{
	function skp_decrypt($hexa)
	{
		$CI = &get_instance();
		if(!$CI->config->item('use_crypto_library')) {
			return $hexa;
		}

		$domain_check	= strpos($_SERVER['HTTP_HOST'], 'test');
		if ($domain_check !== false)
		{
			$ch = curl_init();
			$url = 'http://admin.adotsolution.com/welcome/skp_decode';
			$post_fields	= 'text='.$hexa;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			$result = curl_exec($ch);
			curl_close($ch);
				
			return $result;
		}

		if(ini_get('enable_dl') && !extension_loaded('c_crypto'))
		{
			try {
				dl('c_crypto.' . PHP_SHLIB_SUFFIX);
			} catch(Exception $e) {
			}
		}
		if (!extension_loaded('c_crypto'))
		{
			return $hexa;
		}
		$keyfile_path 	= '/app/docroot/apache/pushad/application/admin/config/encrypt.key';
		$passwd 		= "742d61642e61642e70617373776f7264";	// "t-ad.ad.password" 문자열의 hexa 코드

		$values = c_getValues($keyfile_path, $passwd);
		$deriveKey = $values["key"];
		$iv = $values["iv"];

		return c_aes128_decrypt(c_hex_decode($hexa), $deriveKey, $iv);
	}
}
