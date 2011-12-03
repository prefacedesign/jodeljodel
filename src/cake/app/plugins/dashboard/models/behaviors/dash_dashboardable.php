<?php
	
/**
 * DashDashboardBehavior
 *
 * @Developer Preface
 *
 * A dashboard is a table with some info about not necessaryly 
 * related data. It is useful to visualize, edit and remove existing
 * data of dashboardable models. 
 * 
 * What it does:
 * 
 * afterSave: It inserts/updates  a summarized version of an item into a dash_dashboard_items table
 * afterDelete: it deletes the dashboardItem related to the item from the dashboard_items table
 *
 * Hot to make it work:
 * 
 * The database must have a table named dash_dashboard_items, containing
 * the fields
 *		a) 'dashable_id' => The ID of the item in the original model
 * 		b) 'dashable_model' => the name of the original model
 * 		c) 'type'=> the type of this item (it can be any string)
 * 		e) 'status' => the status of this item
 * 		f) 	'created' => moment this item was created
 * 		g) 'modified' => moment this item was modified
 * 		h) 	'name' => some name (title, headline, person name...)
 *		i) 	'info' => some aditional info this item might have
 * 		j) 	'idiom' =>  'the idiom of this registry 

 * The model acting as this behavior must implement the following functions:
 * 1) getDashboardInfo($id):  it must return an array with the indexes defined in the dash_dashboard_items table
 * (this is the summary of one registry). This function is used to insert or update a registry into the dashboard_items table
 *  
 */
class DashDashboardableBehavior extends ModelBehavior
{		
/**
 * Callback method that creates one DashDashboard entry for every attached Model item.
 * 
 * @access public
 * @return void
 */
	function afterSave(&$Model, $created)
	{
		if($Model->Behaviors->attached('TempTemp'))
		{
			$tempField = $Model->Behaviors->TempTemp->__settings[$Model->alias]['field'];
			if ($Model->data[$Model->alias][$tempField] != 0)
				return;
		}
		
		$this->updateItem($Model, $Model->id);
	}

/**
 * Callback method used to remove the Dashboard item from table
 * 
 * @access public
 * @param Model $Model
 * @return void 
 */
	function afterDelete(&$Model)
	{
		$this->getDashboard()->removeDashItem($Model->alias.'@'.$Model->id);
	}
	
/**
 * Method used to synch every DashDashboard entries 
 * 
 * @access public
 * @param Model $Model
 * @param boolean $force_update If true, will update all dashboard entries, else, will update only those witch modified field differ
 * @return void
 */
	function synchronizeWithDashboard(&$Model, $force_update = false)
	{
		$DashDashboard =& $this->getDashboard();
		$dbo = $DashDashboard->getDatasource();
		$dbo->begin($Model);
		
		// Remove childless entries
		$DashDashboard->bindModel(array('belongsTo' => array(
			$Model->alias => array(
				'className' => $Model->name,
				'foreignKey' => 'dashable_id',
			)
		)));
		$childless = $DashDashboard->find('all', array(
			'contain' => array($Model->alias),
			'conditions' => array(
				'DashDashboardItem.dashable_model' => $Model->alias,
				$Model->alias . '.' . $Model->primaryKey => null
			)
		));
		$DashDashboard->deleteAll(
			array('DashDashboardItem.id' => Set::extract('/DashDashboardItem/id', $childless))
		);

		$to_update = array();
		
		// Select out-dated entries
		if ($force_update)
		{
			$outdated = $DashDashboard->find('all', array(
				'conditions' => array('DashDashboardItem.dashable_model' => $Model->alias)
			));
		}
		else
		{
			$DashDashboard->bindModel(array('belongsTo' => array(
				$Model->alias => array(
					'className' => $Model->name,
					'foreignKey' => 'dashable_id',
				)
			)));
			
			// Here was needed to create an kludge for translatable models that holds modified date on translate model.
			$modifiedModel = $Model->alias;
			if ($Model->Behaviors->attached('TradTradutore'))
			{
				$translatable = $Model->Behaviors->TradTradutore->__settings[$Model->alias]['translatableFields']['translatable'];
				if (in_array("{$Model->alias}.modified", $translatable))
				{
					$className = $Model->Behaviors->TradTradutore->settings[$Model->alias]['className'];
					$foreignKey = $Model->Behaviors->TradTradutore->settings[$Model->alias]['foreignKey'];
					$DashDashboard->bindModel(array('belongsTo' => array(
						$className => array(
							'foreignKey' => false,
							'conditions' => array(
								"$className.language" => Configure::read('Tradutore.mainLanguage'),
								"DashDashboardItem.dashable_id = $className.$foreignKey"
							)
						)
					)));
					$modifiedModel = $className;
				}
			}
			
			$outdated = $DashDashboard->find('all', array(
				'language' => Configure::read('Tradutore.mainLanguage'),
				'conditions' => array(
					'DashDashboardItem.dashable_model' => $Model->alias,
					"DashDashboardItem.modified <> $modifiedModel.modified"
				)
			));
		}
		if (!empty($outdated))
			$to_update = Set::extract('/DashDashboardItem/dashable_id', $outdated);
		
		
		// And last but not least, items without dashboard entries
		$Model->bindModel(array('hasOne' => array(
			'DashDashboardItem' => array(
				'className' => 'Dashboard.DashDashboardItem',
				'foreignKey' => 'dashable_id',
				'conditions' => array('DashDashboardItem.dashable_model' => $Model->alias)
			)
		)));
		$doesnt_have = $Model->find('all', array(
			'contain' => array('DashDashboardItem'),
			'conditions' => array('DashDashboardItem.id' => null)
		));
		$to_update += Set::extract("/{$Model->alias}/{$Model->primaryKey}", $doesnt_have);

		$to_update = array_unique($to_update);
		foreach ($to_update as $id)
			$this->updateItem($Model, $id);

		$dbo->commit($Model);
		
		return compact('childless', 'outdated', 'doesnt_have');
	}

/**
 * Method used to update one specific dashboard item.
 * 
 * @access protected
 * @return void
 */
	protected function updateItem(&$Model, $item_id)
	{
		//gets the summarized description of this registry
		$dashInfo['DashDashboardItem'] = $Model->getDashboardInfo($item_id);
		
		//creates an ID for the dashboard that is the concatenation of Model and Id inside model
		$dashInfo['DashDashboardItem']['id'] = $Model->alias.'@'.$item_id;
		
		//saves the summary into the dashboard
		if (!isset($dashInfo['DashDashboardItem']['modified']))
			debug('asdasdasdasd');
		$this->getDashboard()->saveDashItem($dashInfo);
	}

/**
 * This method creates an instance of DashDashboard model and caches it with an static var.
 * 
 * @access protected
 * @return Model The object of DashDashboard model
 */
	protected function getDashboard()
	{
		static $DashDashboard = false;
		if ($DashDashboard === false)
			$DashDashboard =& ClassRegistry::init(array('class' => 'Dashboard.DashDashboardItem'));
		return $DashDashboard;
	}
}

