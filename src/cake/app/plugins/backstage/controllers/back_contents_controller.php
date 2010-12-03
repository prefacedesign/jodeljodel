<?php
class BackContentsController extends BackstageAppController
{
    var $name = 'BackContents';
    var $uses = array();

    function edit($contentPlugin, $modelName, $id = null)
    {
        $fullModelName = Inflector::camelize($contentPlugin) . '.' . Inflector::camelize($modelName);
        $Model =& ClassRegistry::init($fullModelName);
        
        if (is_null($id))
        {
            if (method_exists($Model, 'createEmpty'))
                $this->data = $Model->createEmpty();
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
        $this->set('modelName', $modelName);
        $this->set('fullModelName', $fullModelName);
    }
}

?>