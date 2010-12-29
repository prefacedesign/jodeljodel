<?php

App::import('Core','ModelBehavior');
App::import('Behavior','Status.Status');


class BackContentsController extends BackstageAppController
{
    var $name = 'BackContents';
    var $uses = array();
	
	function beforeFilter()
	{
		StatusBehavior::setGlobalActiveStatuses(array('publishing_status' => array('active' => array('published','draft'), 'overwrite' => false)));
	
		parent::beforeFilter();
	}
	
	/** Action to edit/create a model row. Model must have implemented
	 *  createEmpty (to create a new empty row) and. findBurocrata (to retrieve
	 *  the data needed for the form). The plugin must have
	 *  the element model_name with 'type' => array('burocrata','form').
	 *
	 *  @access	public
	 *  @param	string 	$contentPlugin	The plugin name in underscore format.
	 *	@param	string 	$modelName	The model name to be edited, in underscore format.
	 *	@param	mixed	$id	The id of the row to be edited. If "null" it means that a new will be created.
     */
	
    function edit($contentPlugin, $modelName, $id = null)
    {
        $fullModelName = Inflector::camelize($contentPlugin) . '.' . Inflector::camelize($modelName);
        $Model =& ClassRegistry::init($fullModelName);
        
        if (is_null($id))
        {
            if (method_exists($Model, 'createEmpty'))
			{
                $this->data = $Model->createEmpty();
				$this->redirect('edit/'. $contentPlugin .'/'. $modelName .'/'. $Model->id);
			}
            else
                $this->data = null;
        }
        else
        {
            if (!method_exists($Model, 'findBurocrata'))
                $this->data = $Model->findById($id);
            else
                $this->data = $Model->findBurocrata($id);
        }
        
        $this->set('contentPlugin', $contentPlugin);
        $this->set('modelName', Inflector::camelize($modelName));
        $this->set('fullModelName', $fullModelName);
    }
	
	/** To change the publishing status of a content. This action returns
	 *  a JSON, with {"sucess":true} if the status change has success.
	 *
	 *	@access public
	 *  @param	string 	$contentPlugin	The plugin name in underscore format.
	 *	@param	string 	$modelName	The model name to be edited, in underscore format.
     */
	
	function set_publishing_status($contentPlugin, $modelName, $id, $status)
	{
		$this->view = 'Burocrata.Json';
	
		$fullModelName = Inflector::camelize($contentPlugin) . '.' . Inflector::camelize($modelName);
		$Model =& ClassRegistry::init($fullModelName);
		
		if ($Model->setStatus($id, array('publishing_status' => $status)))
			$this->set('jsonVars', array('success' => true));
		else
			$this->set('jsonVars', array('success' => false));
	}
}

?>