<?php
class EveEvent extends EventAppModel {
	var $name = 'EveEvent';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $validate = array();
		
	
	function __construct()
	{
		parent::__construct();
		
		$this->validate = array(
			'name' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('EveEvent validation: name.', true),
				)
			),
			'abstract' => array
			(
				'required' => array(
					'rule' => array('between', 50, 255),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('EveEvent validation: abstract required, between 50 255.', true),
				)
			),
		);
		
	}
	
	
	var $actsAs = array(
		'Cascata.AguaCascata', 
		'Tradutore.TradTradutore', 
		'Containable', 
		'Dashboard.DashDashboardable', 
		'Status.Status' => array('publishing_status')
	);
	
	var $hasOne = array('EveEventTranslation' => array('className' => 'Event.EveEventTranslation'));

	
	
	/* Creates a blank row in the table. It is part of the backstage contract.
	 *
	 */
	function createEmpty()
	{
		//@todo Maybe the status behavior should place these defaults?
		//Or should it be a global default?
		$data = $this->saveAll(array($this->alias => array('publishing_status' => 'draft')), array('validate' => false));
		$data = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id)));
		
		return $data;
	}
	
	/* Find suited for the burocrata form. Part of the Burocrata/Backstage contract.
	 *
	 */
	
	function findBurocrata($id)
	{
		$data = $this->find('first', array('emptyTranslation' => true, 'conditions' => array($this->alias.'.id' => $id)));
		$data['EveEvent']['languages'] = $this->getLanguages($id);
		return $data;
	}
	
	
	function saveBurocrata($data)
	{
		if ($this->saveAll($data, array('validate' => 'first')))
			return true;
		else
		{
			return false;
		}
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
			)
		));
		if ($data == null)
			return null;
		
		$dashdata = array(
			'dashable_id' => $data['EveEvent']['id'],
			'dashable_model' => $this->name,
			'type' => 'event',
			'status' => $data['EveEvent']['publishing_status'],
			'created' => $data['EveEvent']['created'],
			'modified' => $data['EveEvent']['modified'], 
			'name' => $data['EveEvent']['name'],
			'info' => 'Abstract: ' . substr($data['EveEvent']['abstract'], 0, 30) . '...',
			'idiom' => $this->getLanguages($id)
		);
		
		return $dashdata;
	}
	
	/** When data is deleted from the Dashboard. Part of the Dashboard contract.
	 *  @todo Maybe we should study how to do it from Backstage contract.
	 *
	 */
	
	function dashDelete($id)
	{
		return $this->delete($id);
	}
}
?>