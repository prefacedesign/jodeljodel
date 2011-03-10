<?php

class AddAliasToAclBehavior extends ModelBehavior 
{
	var $_defaults = array(
		'type' => 'requester',
		'field' => 'alias'
	);

	/**
	 * Setup
	 *
	 * One must specify if it is a 'requester' or 'controlled' and
	 * what field is used for alias.
	 *
	 * @param object AppModel
	 * @param array $config Sample config is array('type' => 'requester', 'field' => array('alias')) - this is the default;
	 */

	public function setup(&$model, $config = array()) 
	{
		$settings = array_merge($this->_defaults, $config);
		$this->settings[$model->alias] = $settings;
	}
	
	/**
	 * Transfers the alias in the Acl Node.
	 *
	 * @param object AppModel
	 * @param array $config Sample config is array('type' => 'requester', 'field' => array('alias')) - this is the default;
	 */
	 
	function afterSave(&$model, $created)
	{
		if (isset($model->data[$model->alias][$this->settings[$model->alias]['field']]))
		{
			$node = $model->node(array($model->alias => array('id' => $model->id)));
			
			if ($this->settings[$model->alias]['type'] == 'requester')
				$aclModel = ClassRegistry::init('Aro');
			else
				$aclModel = ClassRegistry::init('Aco');

			$data = array($aclModel->alias => array(
					'id' => $node[0]['Aro']['id'],
					'alias' => $model->data[$model->alias][$this->settings[$model->alias]['field']]
				)
			);
			
			$aclModel->create();
			$aclModel->save($data);
		}
	}
}