<?php

App::import('Core', array('Security', 'Configure'));

/**
 * In which cases the packed parameters will be encrypted
 *
 * - `never` - Never encrypts the packed params
 * - `always` - Always encrypts the packed params
 * - `method` - Let the $secure param on the method decide
 */
Configure::write('Security.secureParams', 'always');

/**
 * SecureParams class
 *
 * JjUtil SecureParams
 *
 * @package jj_utils
 * @subpackage jj_utils.libs
 */
class SecureParams {


/**
 * Length of checksum
 * 
 * @access public
 * @var integer
 */
	public static $checksum_strength = 5;


/**
 * One char, used to separate the data strings
 * 
 * @access public
 * @var string
 */
	public static $separator = ',';


/**
 * Cipher a string using a random seed and transforms it to base64 format
 * 
 * @access public
 * @param string $param The string to be encrypted
 * @return string The Base64 string encoded
 */
	static function secure($param)
	{
		$params = (string) $params;
		$seed = sprintf('%02d', mb_strlen($param));
		return str_replace(array('=','/', '+'),array('','*', '-'),base64_encode(Security::cipher($param, $seed) . $seed));
	}


/**
 * Unciphes a string created by the secure method
 * 
 * @access public
 * @param string $param The string to be decrypted
 * @return string The original string
 */
	static public function unsecure($param)
	{
		$param = base64_decode(str_replace(array('*', '-'), array('/', '+'),$param));
		return Security::cipher(substr($param, 0, -2), substr($param, -2));
	}


/**
 * Creates a package containig the passed params with a checksum
 * 
 * @access public
 * @param array $params The content strings
 * @param boolean $secure If true, will pass every parameter through self::secure method
 * @return string The packed params ended with a checksum
 */
	static public function pack($params, $secure = false)
	{
		switch (Configure::read('Security.secureParams'))
		{
			case 'always': $secure = true; break;
			case 'never': $secure = false; break;
			case 'method':
			default: break;
		}
		
		if ($secure)
			$params = array_map(array('SecureParams', 'secure'), $params);
		
		$glued_params = ($secure ? '1' : '0') . implode(self::$separator, $params);
		$checksum = self::_checksum($glued_params);
		
		return $glued_params . self::$separator . $checksum . self::$separator;
	}


/**
 * Unpack the package created by self::pack() method
 * 
 * @access public
 * @param string $string The content string
 * @return string|boolean The unpacked params or false, if the params doesnt check
 */
	static public function unpack($params)
	{
		$pieces = false;
		if (self::check($params))
			list($pieces, $separator, $checksum) = self::_unpack($params);
		
		if (!empty($pieces))
		{
			$secure = (boolean) $pieces[0][0];
			$pieces[0] = substr($pieces[0],1);
			if ($secure)
				$pieces = array_map(array('SecureParams', 'unsecure'), $pieces);
		}
		
		return $pieces;
	}


/**
 * Checks if the packed params are consistent
 * 
 * @access public
 * @param string $string The content string
 * @return boolean 
 */
	static public function check($params)
	{
		list($separator, $pieces, $checksum) = self::_unpack($params);
		return Configure::read() != 0 || $checksum == self::_checksum(implode($separator, $pieces));
	}


/**
 * Creates a checksum string
 * 
 * @access protected
 * @param string $string The content string
 * @return string The checksum used to verify the content
 */
	static protected function _checksum($string)
	{
		return substr(Security::hash($string), -self::$checksum_strength);
	}


/**
 * Extract the pieces of the packed data, the used separator and
 * the checksum from the packed string
 * 
 * @access protected
 * @param string $string The content string
 * @return string The checksum used to verify the content
 */
	static protected function _unpack($params)
	{	
		$separator = substr($params,-1);
		$pieces = explode($separator, $params);
		
		array_pop($pieces);
		$checksum = array_pop($pieces);
		
		return array($pieces, $separator, $checksum);
	}
}