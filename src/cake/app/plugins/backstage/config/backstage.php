<?php
Configure::write('Backstage.itemSettings',array(
		'module_name' => array(
			'actions' => array('publish_draft','delete','edit', 'create', 'see_on_page'),
			'limitSize' => 20,
			'statusOptions' => array('published', 'draft'),
			'columns' => array(
				'title' => array('label' => __d('backstage', 'ModuleName header: title', true), 'field' => 'title', 'size' => '2'),
				'abstract' => array('label' => __d('backstage', 'ModuleName header: abstract', true), 'field' => 'abstract', 'size' => '3'),
				'status' => array('label' => __d('backstage', 'ModuleName header: publishing_status', true), 'field' => 'publishing_status', 'size' => '2'),
				'created' => array('label' => __d('backstage', 'ModuleName header: created', true), 'field' => 'created', 'size' => '2'),
				'modified' => array('label' => __d('backstage', 'ModuleName header: modified', true), 'field' => 'modified', 'size' => '2'),
			),
			'customRow' => false,
			'customHeader' => true,
			'customSearch' => true,
			'paramsFoward' => array(0 => 'some_field_to_filter'),
			'contain' => array('ModelModel'),
		),
	)
);