<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model
{

/**
 * validCpfCnpj()
 *
 * Função de validação que verifica o número de CPF ou de CNPJ, usando o digito verificador
 *
 * @access	public
 * @param	array $data
 * @param	string $accepts Could be cpf, cnpj, both
 * @return	boolean
 */
	function validCpfCnpj($data = array(), $accepts = 'both')
	{
		foreach($data as $key => $doc)
		{
			$doc = preg_replace('/[^0-9]/', '', $doc);
			$numberOfChars = strlen($doc);
			
			// Check if is an CNPJ and it is not allowed and vice-versa
			$is_cnpj = $numberOfChars == 14;
			$is_cpf = $numberOfChars == 11;
			if (($accepts == 'cpf' && !$is_cpf) || ($accepts == 'cnpj' && !$is_cnpj))
				return false;
			
			$dig_verf = substr($doc, 0, -2);
			
			// Check is it is 111.111.111-11 CPF or CNPJ type
			if (count(array_unique(str_split(substr($doc, 0, -2)))) == 1)
				return false;
			
			// Creates the checksum
			for($j=1; $j <= 2; $j++)
			{
				$k = 2;
				$soma = 0;
				for($i=strlen($dig_verf)-1; $i >= 0; $i--)
				{
					$soma += ((int)$dig_verf[$i])*$k;
					$k++;
					if($k > 9 && $is_cnpj) $k = 2;
				}
				$digito = 11 - $soma%11;
				if($digito >= 10) $digito = 0;
				$dig_verf .= $digito;
			}
			
			return $dig_verf == $doc;
		}
		return false;
	}

/**
 * Validation for "confirm" inputs
 * 
 * @access public
 * @return boolean 
 */
	function identicalFieldValues($field = array(), $compare_field = null) 
	{
		foreach ($field as $key => $value)
		{
			if($value !== $this->data[$this->alias][$compare_field])
				return FALSE;
			else
				continue;
		}
		return true;
	}
/**
 * Compares the date with $comparisonDate and checks if is valid using the $comparisonType
 * 
 * @access public
 * @param array $field Array of data, passed automagically
 * @param string Either 'after' or 'before'
 * @param string The date witch the passed data will be compared
 * @return boolean If the date is valid (after or before $comparisonDate)
 */
	function validWhen($field = array(), $comparisonType, $comparisonDate)
	{
		if (is_string($comparisonDate))
			$comparisonDate = strtotime($comparisonDate);
		
		if (empty($comparisonDate) && $comparisonDate !== 0)
		{
			trigger_error('AppModel::validWhen() - Validation failed because `'.$comparisonDate.'` could not be undestood.');
			return false;
		}
		
		if (!in_array($comparisonType, array('after', 'before')))
		{
			trigger_error('AppModel::validWhen() - Validation failed because `'.$comparisonType.'` is not a valid comparision type (availables: `after` and  `before`).');
			return false;
		}
		
		foreach ($field as $key => $date)
		{
			if (is_string($date) && strpos($date, '/'))
				$date = $this->convertDateBRSQL($date, 'sql');
			if (is_string($date))
				$date = strtotime($date);
			if ($date === false)
				return false;
			
			switch ($comparisonType)
			{
				case 'after': 
					if ($comparisonDate > $date)
						return false;
				break;
				
				case 'before':
					if ($comparisonDate < $date)
						return false;
				break;
			}
		}
		return true;
	}

/**
 * Checks if an date is local holliday or weekend (in dd/mm/yyyy format)
 * 
 * @access public
 * @return boolean 
 */
	function hollidayDate($field = array())
	{
		App::import('Lib', 'JjUtils.Hollidays');
		
		foreach ($field as $key => $date)
		{
			if (is_string($date) && strpos($date, '/'))
				$date = $this->convertDateBRSQL($date, 'sql');

			if (is_string($date))
				$date = strtotime($date);
			
			if ($date === false)
				return false;
			
			if (date('N', $date) > 5 || Hollidays::isHollidayDate($date, 'brazil'))
				return false;
		}
		
		return true;
	}

/**
 * This method tries to covert an date in the brazilian format (dd/mm/YYYY) to SQL (YYYY-mm-dd) format
 * 
 * @access protected
 * @param string $date The date to be converted
 * @param string $to Direction of convertion ('sql', 'br')
 * @return string|false String when successfully converted, false, otherwise
 */
	protected function convertDateBRSQL($date, $to)
	{
		switch ($to)
		{
			case 'sql':
				$pieces = explode('/', $date);
				if (count($pieces) == 3)
					return $pieces[2] . '-' . $pieces[1] . '-' . $pieces[0];
				elseif(count(explode('-', $date)) == 3)
					return $date;
			break;
		
			case 'br':
				$pieces = explode('-', $date);
				if (count($pieces) == 3)
					return $pieces[0] . '/' . $pieces[1] . '/' . $pieces[2];
			break;
			
			default:
				trigger_error('AppModel::convertDateBRSQL() - `' . $to . '` convertion not known.');
		}
		return false;
	}
}
