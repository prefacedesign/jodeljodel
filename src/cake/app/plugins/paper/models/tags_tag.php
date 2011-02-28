<?php
class TagsTag extends PaperAppModel {
	var $name = 'TagsTag';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'PapPaperTranslation' => array(
			'className' => 'PapPaperTranslation',
			'joinTable' => 'pap_paper_translations_tags_tags',
			'foreignKey' => 'tags_tag_id',
			'associationForeignKey' => 'pap_paper_translation_id',
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