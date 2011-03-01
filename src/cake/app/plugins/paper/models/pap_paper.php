<?php
class PapPaper extends PaperAppModel {
	var $name = 'PapPaper';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $validate = array();
	
	
	function __construct()
	{
		parent::__construct();
		
		$this->validate = array(
			'auth_author_id' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PapPaper validation: auth_author_id.', true),
				)
			),
			'jour_journal_id' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PapPaper validation: jour_journal_id.', true),
				)
			),
			'complete_reference' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PapPaper validation: complete_reference required.', true),
				)
			),
			'title' => array
			(
				'required' => array(
					'rule' => array('between', 50, 350),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PapPaper validation: title required, between 50 350.', true),
				)
			),
			'abstract' => array
			(
				'required' => array(
					'rule' => array('between', 100, 6000),
					'allowEmpty' => false,
					'required' => true,
					'message' => __('PapPaper validation: abstract required, between 100 6000.', true),
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
	
	var $belongsTo = array(
		'JourJournal' => array(
			'className' => 'Paper.JourJournal',
			'foreignKey' => 'jour_journal_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasOne = array(
		'PapPaperTranslation' => array(
			'className' => 'Paper.PapPaperTranslation',
			'foreignKey' => 'pap_paper_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	var $hasAndBelongsToMany = array(
		'AuthAuthor' => array(
			'className' => 'Author.AuthAuthor',
			'joinTable' => 'auth_authors_pap_papers',
			'foreignKey' => 'pap_paper_id',
			'associationForeignKey' => 'auth_author_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	
	
	/* Creates a blank row in the table. It is part of the backstage contract.
	*
	*/
	function createEmpty()
	{
		//@todo Maybe the status behavior should place these defaults?
		//Or should it be a global default?
		$data = $this->saveAll(array($this->alias => array('publishing_status' => 'draft')), array('validate' => false));
		$data = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id), 'contain' => array('JourJournal', 'AuthAuthor')));

		return $data;
	}
	
	/* Find suited for the burocrata form. Part of the Burocrata/Backstage contract.
	 *
	 */
	
	function findBurocrata($id)
	{
		$data = $this->find('first', 
			array(
				'emptyTranslation' => true, 
				'conditions' => array($this->alias.'.id' => $id), 
				'contain' => array('JourJournal', 'AuthAuthor', 'TagsTag')
			)
		);
		$data['PapPaper']['languages'] = $this->getLanguages($id);
		//debug($data);
		
		if (isset($data['PapPaper']['TagsTag']) && !empty($data['PapPaper']['TagsTag'])) 
		{	                
			foreach($data['PapPaper']['TagsTag'] as $tag) 
				$tags[] = $tag['name'];
			$data['Tag']['tags'] = implode(', ',$tags);
		}
		
		return $data;
	}
	
	
	function saveBurocrata($data)
	{		
		if ($this->saveAll($data))
		{
			// hard coded to save Tags related with Translation
			$saved_data = $this->PapPaperTranslation->find('first', array('conditions' => array('pap_paper_id' => $this->id, 'language' => TradTradutoreBehavior::$currentLanguage)));
			$id = $saved_data['PapPaperTranslation']['id'];
			
			if ($data['Tag']['tags']) {
				$tags = explode(',',$data['Tag']['tags']);
				foreach($tags as $_tag) {
					$_name = trim($_tag);
					$_keyName = mb_strtolower(trim($_tag));
					if ($_tag) {
						// check if the tag exists
						//$this->Tag->recursive = -1;
						$tag = $this->PapPaperTranslation->TagsTag->findByKeyname($_keyName);
						if (!$tag) {
							// create new tag
							$this->PapPaperTranslation->TagsTag->create();
							$tag = $this->PapPaperTranslation->TagsTag->save(array('identifier' => 'dinafon', 'name'=>$_name, 'keyname'=>$_keyName));
							$tag['TagsTag']['id'] = $this->PapPaperTranslation->TagsTag->id;
							if (!$tag) {
								$this->Session->setFlash(__(sprintf('The Tag %s could not be saved.',$_tag), true));
							}
						}
						if ($tag) {
							// use current tag
							//debug($tag);
							$new_data['TagsTag']['TagsTag'][$tag['TagsTag']['id']] = $tag['TagsTag']['id'];
						}
					}
				}
			}
			$new_data['PapPaperTranslation']['id'] = $id;
			//debug($new_data);
			$this->PapPaperTranslation->save($new_data);
			//die;
			return true;
			
		}
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
			), 
			'contain' => array('JourJournal', 'AuthAuthor')
		));
		if ($data == null)
			return null;
		
		$dashdata = array(
			'dashable_id' => $data['PapPaper']['id'],
			'dashable_model' => $this->name,
			'type' => 'paper',
			'status' => $data['PapPaper']['publishing_status'],
			'created' => $data['PapPaper']['created'],
			'modified' => $data['PapPaper']['modified'], 
			'name' => $data['PapPaper']['title'],
			'info' => 'Abstract: ' . substr($data['PapPaper']['abstract'], 0, 30) . '...',
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