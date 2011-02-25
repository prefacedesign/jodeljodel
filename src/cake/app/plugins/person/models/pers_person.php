<?php
class PersPerson extends PersonAppModel {
	var $name = 'PersPerson';
	var $validate = array();
	
	function __construct()
	{
		parent::__construct();
		
		$this->validate = array(
			'lattes_link' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: lattes_link.', true),
				)
			),
			'research_fields' => array
			(
				'required' => array(
					'rule' => array('maxLength', 300),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: research_fields.', true),
				)
			),
			'profile' => array
			(
				'required' => array(
					'rule' => array('between', 100, 600),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: profile.', true),
				)
			),
			'cooperation_with_dinafon' => array
			(
				'required' => array(
					'rule' => array('between', 100, 400),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: cooperation_with_dinafon.', true),
				)
			),
			'position' => array
			(
				'required' => array(
					'rule' => array('maxLength', 150),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PersPerson validation: position.', true),
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
	var $hasOne = array('PersPersonTranslation');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'AuthAuthor' => array(
			'className' => 'Author.AuthAuthor',
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
		$data = $this->saveAll(array($this->alias => array('publishing_status' => 'draft'), 'AuthAuthor' => array('name' => '')), array('validate' => false));
		$data = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id), 'contain' => array('AuthAuthor')));
		
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
		//debug($data);
		//debug($this->saveAll($data));
		//die;
		
		//debug($data);
		//debug($this->saveAll($data, array('validate' => 'only')));
		//die;
		
		if ($this->saveAll($data, array('validate' => 'first')))
			return true;
		else
		{
			//debug($this->validationErrors);
			//die;
			return false;
		}
		
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