<?php
/**
 * Methods for displaying presentation data in JSON for passing data via JS.
 *
 * PHP versions 4 and 5
 *
 * @copyright 
 * @link      
 * @package   
 * @subpackage
 * @since     
 * @license   
 */
 
 
/**
 * Methods for displaying presentation data in JSON for passing data via JS.
 */
class JsonView extends View
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
		header('Content-type: application/json');
		
		$loaded;
		if(!isset($this->Js))
			$this->_loadHelpers($loaded, array('Js'));
		$this->Js = $loaded['Js'];
		
		if(isset($this->viewVars['jsonVars'])) {
			return $this->Js->object($this->viewVars['jsonVars']);
		} else {
			if($this->layout == null)
				$layout = 'ajax';
			return parent::render($action, $layout, $file);
		}
	}
}