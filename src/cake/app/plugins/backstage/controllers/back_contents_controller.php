<?php
/**
 * SOME FILE INFORMATIONS
 * 
 * @package
 * @subpackage
 */
 
App::import('Core','ModelBehavior');
App::import('Behavior','Status.Status');

/**
 * SOME CLASS INFORMATIONS
 * 
 * @package
 * @subpackage
 */
class BackContentsController extends BackstageAppController
{
/**
 * Name for this controller
 * 
 * @access public
 * @var string
 */
    var $name = 'BackContents';

/**
 * List of Models to load on construct. Defaults to none.
 * 
 * @access public
 * @var array
 */
    var $uses = array();
	
/** 
 * Action to edit/create a model row. Model must have implemented
 * createEmpty (to create a new empty row) and. findBurocrata (to retrieve
 * the data needed for the form). The plugin must have
 * the element model_name with 'type' => array('burocrata','form').
 *
 * @access public
 * @param string $contentPlugin The plugin name in underscore format.
 * @param string $modelName The model name to be edited, in underscore format.
 * @param mixed $id The id of the row to be edited. If "null" it means that a new will be created.
 */
    function edit($contentPlugin = false, $modelName = false, $id = null)
    {
		if (empty($contentPlugin) || empty($modelName))
			$this->cakeError('error404');
		
        $fullModelName = Inflector::camelize($contentPlugin) . '.' . Inflector::camelize($modelName);
        $Model =& ClassRegistry::init($fullModelName);
        
        if (is_null($id))
        {
            if (method_exists($Model, 'createEmpty'))
			{
                if ($Model->createEmpty())
					$this->redirect(array($contentPlugin, $modelName, $Model->id));
				elseif (Configure::read())
					die ('Could not create an empty record.');
			}
			$this->redirect(array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'));
        }
        else
        {
            if (method_exists($Model, 'findBurocrata'))
                $this->data = $Model->findBurocrata($id);
            else
                $this->data = $Model->findById($id);
        }
        
        $this->set('contentPlugin', $contentPlugin);
        $this->set('modelName', Inflector::camelize($modelName));
        $this->set('fullModelName', $fullModelName);
    }
	
/** 
 * To change the publishing status of a content. This action returns
 * a JSON, with {"sucess":true} if the status change has success.
 *
 * @access public
 * @param string $contentPlugin The plugin name in underscore format.
 * @param string $modelName The model name to be edited, in underscore format.
 */
	function set_publishing_status($contentPlugin, $modelName, $id, $status)
	{
		$this->view = 'JjUtils.Json';
	
		$fullModelName = Inflector::camelize($contentPlugin) . '.' . Inflector::camelize($modelName);
		$Model =& ClassRegistry::init($fullModelName);
		
		if ($Model->setStatus($id, array('publishing_status' => $status)))
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
	}
}