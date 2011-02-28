<?php
class JourJournal extends PaperAppModel {
	var $name = 'JourJournal';
	var $displayField = 'short_name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/*
	function __construct()
	{
		parent::__construct();
		
		$this->validate = array(
			'surname' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('AuthAuthor validation: surname.', true),
				)
			),
			'name' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('AuthAuthor validation: name.', true),
				)
			),
			'reference_name' => array
			(
				'required' => array(
					'rule' => 'notEmpty',
					'allowEmpty' => false,
					'required' => true,
					'message' => __('AuthAuthor validation: reference_name.', true),
				)
			)
		);
	}
	*/

	var $hasMany = array(
		'PapPaper' => array(
			'className' => 'Paper.PapPaper',
			'foreignKey' => 'jour_journal_id',
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

}
?>