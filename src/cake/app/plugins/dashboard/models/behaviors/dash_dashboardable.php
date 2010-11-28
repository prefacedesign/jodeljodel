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
	
		function afterSave(&$Model, $created)
		{
			$dashInfo = $Model->getDashboardInfo($Model->id);	//gets the summarized description of this registry
			$dashInfo['id'] = $Model->alias.'@'.$Model->id;;			//creates an ID for the dashboard that is the concatenation of Model and Id inside model
			
			$dashboard = ClassRegistry::init(array('class' => 'Dashboard.DashDashboardItem'));		//creates a refference to the dashboard model
			$dashboard->saveDashItem($dashInfo);		//saves the summary int the dashboard
		}
		
		function afterDelete(&$Model)
		{
			$dashId = $Model->alias.'@'.$Model->id;		//recovers the ID for the dashboard that is the concatenation of Model and Id inside model
			$dashboard = ClassRegistry::init(array('class' => 'Dashboard.DashDashboardItem'));		//creates a refference to the dashboard model
			$dashboard->removeDashItem($dashId);	//removes the item from the dashboard
		}
		
		function synchronizeWithDashboard(&$Model)
		{
			$Model->saveAll($Model->find('all')); //saves all the registries (so they are inserted or updated in the dashboards since aftersave is called)
		}
	}

?>