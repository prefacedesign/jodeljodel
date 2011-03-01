<?php
class AuthAuthor extends AuthorAppModel {
	var $name = 'AuthAuthor';
	var $displayField = 'reference_name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
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
	
	
	var $hasMany = array(
		'NewsNews' => array(
			'className' => 'New.NewsNews',
			'foreignKey' => 'auth_author_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PersPerson' => array(
			'className' => 'Person.PersPerson',
			'foreignKey' => 'auth_author_id',
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
		'PapPaper' => array(
			'className' => 'Paper.PapPaper',
			'joinTable' => 'auth_authors_pap_papers',
			'foreignKey' => 'auth_author_id',
			'associationForeignKey' => 'pap_paper_id',
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
	

}
?>