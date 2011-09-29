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
 * @param string $moduleName Module name, configured on bootstrap.php
 * @param mixed $id The id of the row to be edited. If "null" it means that a new will be created.
 */
    function edit($moduleName = false, $id = null)
    {
		if (empty($moduleName) || !($config = Configure::read('jj.modules.'.$moduleName)))
			$this->cakeError('error404');
		
		list($contentPlugin, $modelName) = pluginSplit($config['model']);
		
        $fullModelName = $config['model'];
        $Model =& ClassRegistry::init($fullModelName);
        
        if (is_null($id))
        {
            if (method_exists($Model, 'createEmpty'))
			{
                if ($Model->createEmpty())
					$this->redirect(array($moduleName, $Model->id));
				elseif (Configure::read())
					trigger_error('Could not create an empty record.') and die;
			}
			else
			{
				trigger_error('Method '.$modelName.'::createEmpty() on '.$contentPlugin.' not found!') and die;
			}
        }
        else
        {
            if (method_exists($Model, 'findBurocrata'))
                $this->data = $Model->findBurocrata($id);
            else
                $this->data = $Model->findById($id);
        }
        
		$this->set(compact('contentPlugin', 'modelName', 'fullModelName', 'moduleName'));
    }
	
/** 
 * To change the publishing status of a content. This action returns
 * a JSON, with {"sucess":true} if the status change has success.
 *
 * @access public
 * @param string $moduleName Module name, configured on bootstrap.php
 * @param string $id The id of the row to set a new status to.
 * @param string $status The status that can be either 'draft' or 'published'.
 */
	function set_publishing_status($moduleName = false, $id = false, $status = false)
	{
		if (empty($moduleName) || empty($id) || empty($status))
			$this->cakeError('error404');
		
		if (!($config = Configure::read('jj.modules.'.$moduleName)))
			$this->cakeError('error404');
		
		list($contentPlugin, $modelName) = pluginSplit($config['model']);
		
		$fullModelName = $config['model'];
		$Model =& ClassRegistry::init($fullModelName);
		
		if ($Model->setStatus($id, array('publishing_status' => $status)))
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
		
		$this->view = 'JjUtils.Json';
	}
}