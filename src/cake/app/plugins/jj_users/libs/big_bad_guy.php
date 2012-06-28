<?php
class BigBadGuy
{
	
/**
 * Check if a user has the power
 * 
 * @access public
 */
	public function can($needle, $haystack)
	{
		$error = false;
		
		if (!is_array($needle))
		{
			$needle = array($needle);
		}
		foreach($needle as $index => $permission)
		{
			if (is_array($permission))
			{
				if ($index != 'OR')
				{
					$this->jodelError('You can pass an array, but the index must be OR, to pass or conditions');
				}
				else
				{
					$error = true;
					foreach($permission as $ors)
					{
						if (isset($haystack[$ors]))
						{
							$error = false;
						}
					}
				}
			}
			else
			{
				if (!isset($haystack[$permission]))
				{
					$error = true;
				}
			}
		}
		
		return !$error;
	}
}

