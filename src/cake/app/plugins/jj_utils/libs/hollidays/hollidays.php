<?php

/**
 * 
 * 
 */
class Hollidays
{
/**
 * method description
 * 
 * @access public
 * @return array The list of timestamps for holliday dates for this year
 */
	public static function hollidayDates($locale, $year =  null)
	{
		if (is_string($locale))
			$locale = array($locale);
		
		if (!is_array($locale))
		{
			trigger_error('Hollidays::hollidayDates() - First parameter must be a array or a string');
			return array();
		}
		
		if (empty($year))
			$year = date('Y');
		
		$dates = array();
		$method = '';
		foreach ($locale as $value)
		{
			$method .= '_' . $value;
			if (method_exists('Hollidays', $method))
				$dates += self::$method($year);
		}
		return $dates;
	}

/**
 * method description
 * 
 * @access public
 * @param int $date In unix timestamp format
 * @param array $locale The array of localization, like array('brazil', 'sao paulo', 'campinas')
 * @return boolean True if given date is holliday, false otherwise
 */
	public static function isHollidayDate($date, $locale)
	{
		return in_array($date, self::hollidayDates($locale, date('Y', $date)));
	}
	
/**
 * Creates an list of brazilian holliday dates
 * 
 * @access protected
 * @param int $year
 * @return array List of brazilian holliday dates
 */
	protected function _brazil($year)
	{
		$easter = easter_date($year);

		return array(
			// National Hollidays
			mktime(0, 0, 0, 1,   1, $year), // Confraternização Universal - Lei nº 662, de 06/04/49
			mktime(0, 0, 0, 4,  21, $year), // Tiradentes - Lei nº 662, de 06/04/49
			mktime(0, 0, 0, 5,   1, $year), // Dia do Trabalhador - Lei nº 662, de 06/04/49
			mktime(0, 0, 0, 9,   7, $year), // Dia da Independência - Lei nº 662, de 06/04/49
			mktime(0, 0, 0, 10, 12, $year), // N. S. Aparecida - Lei nº 6802, de 30/06/80
			mktime(0, 0, 0, 11,  2, $year), // Todos os santos - Lei nº 662, de 06/04/49
			mktime(0, 0, 0, 11, 15, $year), // Proclamação da republica - Lei nº 662, de 06/04/49
			mktime(0, 0, 0, 12, 25, $year), // Natal - Lei nº 662, de 06/04/49

			// These days have a date depending on easter
			strtotime('-48 days', $easter),	 // 2ºferia Carnaval
			strtotime('-47 days', $easter),	 // 3ºferia Carnaval
			strtotime('-2 days', $easter),	 // 6ºfeira Santa
			$easter,						 // Pascoa
			strtotime('60 days', $easter),	 // Corpus Cirist
		);
	}
}
