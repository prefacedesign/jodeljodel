<?php
class PersPerson extends PersonAppModel {
	var $name = 'PersPerson';
	var $validate = array();
	
	function __construct()
	{
		parent::__construct();
		/*
		$this->validate = array(
			'surname' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: surname.', true),
					'on' => 'update'
				)
			),
			'name' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: name.', true),
					'on' => 'update'
				)
			)
		);
		*/
	}
	
	var $actsAs = array(
		'Cascata.AguaCascata', 
		'Tradutore.TradTradutore', 
		'Containable', 
		'Dashboard.DashDashboardable', 
		'Status.Status' => array('publishing_status')
	);
	var $hasOne = array('PersPersonTranslation');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'AuthAuthor' => array(
			'className' => 'AuthAuthor',
			'foreignKey' => 'auth_author_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
		
		/* Creates a blank row in the table. It is part of the backstage contract.
         *
		 */
        function createEmpty()
        {
			//@todo Maybe the status behavior should place these defaults?
			//Or should it be a global default?
			//$dataAuthor = $this->save(array());
			//debug(array($this->alias => array('publishing_status' => 'draft'), 'AuthAuthor' => array()));
			$data = $this->saveAll(array($this->alias => array('publishing_status' => 'draft'), 'AuthAuthor' => array('name' => '')));
			$data = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id), 'contain' => array('AuthAuthor')));
            //$data[$this->alias]['id'] = $this->id;
            debug($data);
			//die;
			
            return $data;
        }
        
		/* Find suited for the burocrata form. Part of the Burocrata/Backstage contract.
         *
		 */
		
        function findBurocrata($id)
        {
            $data = $this->find('first', array('emptyTranslation' => true, 'conditions' => array($this->alias.'.id' => $id), 'contain' => array('AuthAuthor')));
			$data['PersPerson']['languages'] = $this->getLanguages($id);
			return $data;
        }
		
		
		function saveBurocrata($data)
        {
			if ($this->saveAll($data) !== false)
				return true;
			else
				return false;
			//debug($this->findById($this->id));
            //debug($data);
			//die;
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
				'contain' => array('AuthAuthor')
			));
			if ($data == null)
				return null;
			
			$dashdata = array(
				'dashable_id' => $data['PersPerson']['id'],
				'dashable_model' => $this->name,
				'type' => 'person',
				'status' => $data['PersPerson']['publishing_status'],
				'created' => $data['PersPerson']['created'],
				'modified' => $data['PersPerson']['modified'], 
				'name' => $data['AuthAuthor']['name'] . ' ' . $data['AuthAuthor']['surname'],
				'info' => 'Profile: ' . substr($data['PersPerson']['profile'], 0, 30) . '...',
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