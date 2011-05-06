<?php
class JodelHelper extends AppHelper
{
	protected $View;
	
/**
 * To be called as insertModule('New.AgeAgency', array('start_page', 'mini')) as alias
 * of $View->element('age_agency', array('plugin' => 'new', 'type' => array('start_page', 'mini')))
 * 
 * @access public
 * @return string The element requested
 */
	public function insertModule($name, $type, $data = array())
	{
		$View =& $this->_getView();
		
		list($plugin_name, $model_class_name) = pluginSplit($name);
		$plugin = Inflector::underscore($plugin_name);
		
		$vars = compact('plugin', 'type');
		if ($data !== false)
			$vars['data'] = $data;
		return $View->element(Inflector::underscore($model_class_name), $vars);
	}
	
/**
 * Gets and caches an View object reference
 *
 * @access protected
 * @return object The View object reference
 */
	protected function _getView()
	{
		if (!$this->View)
			return $this->View = &ClassRegistry::getObject('view');
		
		return $this->View;
	}

}