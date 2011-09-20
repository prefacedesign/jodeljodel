<?php
/**
 * Component for burocrata plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.components
 */
 
App::import('Lib', 'JjUtils.SecureParams');


/**
 * BuroBurocrata.
 *
 * Some handy procedures to deal with burocrata POSTs.
 * This class is used on BuroBurocrataController and on 
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.components
 */
class BuroBurocrataComponent extends Object
{

/**
 * If is set $controller->data['_b'], its data is passed to $controller->buroData
 * If was POSTed a `baseID`, it repasses for the view.
 * And, finally, if is set a `layout_scheme`, it loads the Typographer helpers
 * 
 * @access public
 */
	public function startup(&$controller)
	{
		if(isset($controller->data['_b']))
		{
			$controller->buroData = $controller->data['_b'];
			unset($controller->data['_b']);
		}
		
		if(isset($controller->buroData['type']))
			$controller->set('type', $controller->buroData['type']);
		
		if(isset($controller->buroData['baseID']))
			$controller->set('baseID', $controller->buroData['baseID']);
		
		if(isset($controller->buroData['layout_scheme']))
		{
			$controller->helpers = am($controller->helpers,
				array(
					'Typographer.TypeDecorator' => array(
						'name' => 'decorator',
						'compact' => false,
						'receive_tools' => true
					),
					'Typographer.*TypeStyleFactory' => array(
						'name' => 'styleFactory', 
						'receive_automatic_classes' => true, 
						'receive_tools' => true,
						'generate_automatic_classes' => false
					),
					'Typographer.*TypeBricklayer' => array(
						'name' => 'Bl',
						'receive_tools' => true,
					),
					'Burocrata.*BuroBurocrata' => array(
						'name' => 'Buro'
					)
				)
			);
			$controller->layout_scheme = $controller->buroData['layout_scheme'];
			unset($controller->buroData['layout_scheme']);
		}
	}

/**
 * beforeRender callback
 * 
 * @access public
 */
	public function beforeRender(&$controller)
	{
		if($controller->layout_scheme)
			$controller->TypeLayoutSchemePicker->pick($controller->layout_scheme);
	}

/**
 * Loads the model especified in controller POSTed data.
 *
 * @access public
 * @param mixed $var An variable to be filled with Model Object
 * @return mixed true when single model found and instance created, error message returned if model not found.
 */
	public function loadPostedModel(&$controller, &$var)
	{
		$debug = Configure::read()>0;
		$error = false;
		
		if(!isset($controller->buroData['request']))
			$error = $debug?'BuroBurocrataController::_load - Request security field not defined':true;

		if($error === false)
		{
			// The counter-part of this code is in BuroBurocrataHelper::_security method
			@list($secure, $model_plugin, $model_alias) = SecureParams::unpack($controller->buroData['request']);
			
			$hash = substr(Security::hash($controller->here), -5);
			if($secure != $hash)
				$error = $debug?'BuroBurocrataController::_load - POST Destination check failed.':true;
		}

		if($error === false)
		{
			$model_class_name = $model_alias;
			if(!empty($model_plugin))
				$model_class_name = $model_plugin . '.' . $model_class_name;
			
			if(!$controller->loadModel($model_class_name))
				$error = $debug?'BuroBurocrataController::_load - Couldn\'t load model.':true;
		}
		
		if($error === false)
		{
			$controller->model_name = $model_alias;
			$controller->model_plugin = $model_plugin;
			
			$controller->set('model_name', $controller->model_name);
			$controller->set('model_plugin', $controller->model_plugin);
			$controller->set('model_class_name', $model_class_name);
			$controller->set('fullModelName', $model_class_name);
			
			$var = $controller->{$model_alias};
		}
		
		return $error;
	}

/**
 * Used to find data on database using burocratas conventions
 * based on passed id.
 * 
 * @access protected
 * @param object $controller The controller 
 * @param mixed $id If empty will be used $controller->buroData['id']
 * @return array An array with two index: `data` and `error`
 */
	public function getViewData(&$controller, $id = null)
	{
		$error = false;
		$data = array();
		$Model = null;
		
		if (empty($id) && !empty($controller->buroData['id']))
			$id = $controller->buroData['id'];
		
		if(($error = $this->loadPostedModel($controller, $Model)) === false && !empty($id))
		{
			if (method_exists($Model, 'findBurocrata'))
				$data = $Model->findBurocrata($id);
			else
				$data = $Model->find('first', array(
					'recursive' => -1,
					'conditions' => array(
						$Model->alias.'.'.$Model->primaryKey => $id
					)
				));
		}
		return compact('error', 'data');
	}

/**
 * Searches specific saves methods related to the type on $Model object
 * If it doesnt find any specific method, it returns the save method
 * 
 * 
 * @access public
 * @param object $controller The controller 
 * @param object $Model The model where this method will search
 * @access public
 */
	public function getSaveMethod(&$controller, &$Model)
	{
		$type = array();
		if (isset($controller->buroData['type']))
			$type = explode('|', $controller->buroData['type']);
		
		// Find what kind of buro/form we are dealing
		while (isset($array[0]) && in_array($type[0], array('buro', 'form')))
			array_shift($type);
		
		$methodName = '';
		foreach($type as $k => $subType)
		{
			$methodName = 'saveBurocrata';
			for ($i = count($type) - 1; $i >= $k; $i--)
				$methodName .= Inflector::camelize($type[$i]);
			debug($methodName);
			if (method_exists($Model, $methodName))
				return $methodName;
		}
		
		$methodName = 'saveBurocrata';
		if (method_exists($Model, $methodName))
			return $methodName;
		
		return 'save';
	}
}