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
		extract($this->settings[$model->alias], EXTR_PREFIX_ALL|EXTR_REFS, 'set_');
		
		if (isset($model->data[$model->alias][$set_field]))
		{
			$node = $model->node(array($model->alias => array('id' => $model->id)));
			
			if ($set_type == 'requester')
				$aclModel = ClassRegistry::init('Aro');
			else
				$aclModel = ClassRegistry::init('Aco');

			$data = array($aclModel->alias => array(
					'id' => $node[0]['Aro']['id'],
					'alias' => $model->data[$model->alias][$set_field]
				)
			);
			if ($created)
				$aclModel->create();
			$aclModel->save($data);
		}
	}
}
