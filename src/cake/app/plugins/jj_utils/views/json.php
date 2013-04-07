<?php

/**
 *
 * Methods for displaying presentation data in JSON for passing data via JS.
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

App::import('View', 'Typographer.Type');

/**
 * Methods for displaying presentation data in JSON for passing data via JS.
 */
class JsonView extends TypeView
{
	
/**
 * Overloads the default render action
 *
 * @param string $action Name of action to render for
 * @param string $layout Layout to use
 * @param string $file Custom filename for view
 * @return string Rendered Element
 * @access public
 */
	function render($action = null, $layout = null, $file = null)
	{
		if(Configure::read() > 1)
			Configure::write('debug', 1);
		header('Content-Type: application/json; charset=UTF-8');

		if (isset($this->viewVars['jsonVars']))
		{
			return json_encode($this->viewVars['jsonVars']);
		}
		else
		{
			if (empty($layout))
				$layout = 'ajax';

			$out = parent::render($action, $layout, $file);

			if (isset($this->BuroOfficeBoy))
			{
				$extraCaptions = $this->BuroOfficeBoy->getAllCaptions();
				if (!empty($extraCaptions))
				{
					$json = json_decode($out, true);
					if (is_array($json))
						$json['extraCaptions'] = $extraCaptions;
					$out = json_encode($json);
				}
			}

			return $out;
		}
	}
}
