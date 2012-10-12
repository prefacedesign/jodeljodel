<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

class BigBadGuy
{
	
/**
 * Check if a user has the power
 * 
 * @access public
 */
	public static function can($needle, $haystack)
	{
		if (empty($needle))
		{
			trigger_error('BigBadGuy::can() - Testing for empty permissions: it doesnt make sense.');
			// Returning true for backwards compatibility
			return true;
		}

		if (!is_array($needle))
		{
			$needle = array($needle);
		}

		$checks = array();
		foreach ($needle as $index => $permission)
		{
			if (is_array($permission))
			{
				if ($index != 'OR')
				{
					trigger_error('You can pass an array, but the index must be OR, to pass or conditions');
					$checks[] = false;
					break;
				}
				
				$checks[] = count(array_intersect($permission, array_keys($haystack))) > 0;
			}
			elseif (is_string($permission))
			{
				$checks[] = isset($haystack[$permission]);
			}
		}
		
		return array_search(false, $checks) === false;
	}
}

