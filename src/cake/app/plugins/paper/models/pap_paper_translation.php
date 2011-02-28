<?php
class PapPaperTranslation extends PaperAppModel {
	var $name = 'PapPaperTranslation';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'PapPaper' => array(
			'className' => 'Paper.PapPaper',
			'foreignKey' => 'pap_paper_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $hasAndBelongsToMany = array(
		'TagsTag' => array(
			'className' => 'Paper.TagsTag',
			'joinTable' => 'pap_paper_translations_tags_tags',
			'foreignKey' => 'pap_paper_translation_id',
			'associationForeignKey' => 'tags_tag_id',
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