<?php
class PrefModule extends ModuleAppModel {
	var $name = 'PrefModule';
	var $validate = array();
	
	function __construct()
	{
		parent::__construct();
		/* Validation has to come here I don't know why! */
		$this->validate = array(
		);
	}
	
	var $actsAs = array(
		'Cascata.AguaCascata',  
			//Cascata needs to be added if you wan't do deal with translations
			//it must be the first behavior attached.
		'Tradutore.TradTradutore', 
			//If you want translations you must add TradTradutore behavior, it must
		'Containable', 
			//TradTradutore behavior needs Containable and has to be after TradTradutore
		'Dashboard.DashDashboardable', 
			//If you want to it to appear in the dashboard, you must add this behavior 
		'Status.Status' => array('publishing_status')
			//If you want to be able to publish and draft it, you must set Status with
			//publishing_status
	);
	
	//If you used Tradutore, you must have a hasOne relationship with 
	var $hasOne = array('PrefModuleTranslation');
		
	/* Creates a blank row in the table. It is part of the backstage contract.
	 *
	 */
	function createEmpty()
	{
		//You must save here what is considered an empty entrie, what it is
		//depends on the model structure.
		
		// SAVING CODE
		
		//The saved data must be returned
		return $data;
	}
	
	/* Find suited for the burocrata form. Part of the Burocrata/Backstage contract.
	 *
	 */
	
	function findBurocrata($id)
	{
		//If you use TradTradutore you must set the contain field, and emptyTranslation to true -- for it to retrieve data
		//even if there isn't a translation.
		$data = $this->find('first', array('emptyTranslation' => true, 'conditions' => array($this->alias.'.id' => $id), 'contain' => array());
		//To the backstage it's important to send the list of languages for wich there are versions
		$data['PersPerson']['languages'] = $this->getLanguages($id);
		return $data;
	}
	
	
	/* Used by the Burocrata forms, to automatically treat form submission.
	 */
	function saveBurocrata($data)
	{
		// return true or false if you suceeded saving the data.
	}
	
	/** The data that must be saved into the dashboard. Part of the Dashboard contract.
	 *
	 */
	
	function getDashboardInfo($id)
	{
		$mainLanguage = Configure::read('Tradutore.mainLanguage');
		$data = $this->find('first', array(
			'language' => $mainLanguage, 
			'conditions' => array(
				$this->alias.'.id' => $id
			), 
			'contain' => array()
		));
		if ($data == null)
			return null;
		
		$dashdata = array(
			'dashable_id' => ,
			'dashable_model' => $this->name,
			'type' => 
			'status' => 
			'created' => 
			'modified' => 
			'name' => 
			'info' => 
			'idiom' => $this->getLanguages($id)
		);
		
		return $dashdata;
	}
	
	/** When data is deleted from the Dashboard. Part of the Dashboard contract.
	 *  @todo Maybe we should study how to do it from Backstage contract.
	 */
	
	function dashDelete($id)
	{
		return $this->delete($id);
	}
}
?>