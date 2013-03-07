<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
			'additionalFilteringConditions' => array('Dashboard.DashboardFiltering'), // see plugins/dashboard/config/dash.php to more details
		),
		'user_users' => array(
			'actions' => array('delete','edit', 'create'),
			'limitSize' => 100,
			'statusOptions' => array('published', 'draft'),
			'columns' => array(
				'name' => array('label' => __d('backstage', 'UserUser header: name', true), 'field' => 'name', 'size' => '2'),
				'profiles' => array('label' => __d('backstage', 'UserUser header: profiles', true), 'size' => '4'),
				'actions' => array('label' => __d('backstage', 'UserUser header: actions', true), 'size' => '3'),
			),
			'customRow' => true,
			'customSearch' => true,
			'contain' => array('UserProfile'),
		),
		'user_profiles' => array(
			'actions' => array('delete','edit', 'create'),
			'limitSize' => 100,
			'statusOptions' => array('published', 'draft'),
			'columns' => array(
				'name' => array('label' => __d('backstage', 'UserProfile header: name', true), 'field' => 'name', 'size' => '2'),
				'profiles' => array('label' => __d('backstage', 'UserProfile header: permissions', true), 'size' => '4'),
				'actions' => array('label' => __d('backstage', 'UserProfile header: actions', true), 'size' => '3'),
			),
			'customRow' => true,
			'customSearch' => true,
			'contain' => array('UserPermission', 'UserUser'),
		),
		'user_permissions' => array(
			'actions' => array('delete','edit', 'create'),
			'limitSize' => 100,
			'statusOptions' => array('published', 'draft'),
			'columns' => array(
				'name' => array('label' => __d('backstage', 'UserPermission header: name', true), 'field' => 'name', 'size' => '3'),
				'description' => array('label' => __d('backstage', 'UserPermission header: description', true), 'field' => 'name', 'size' => '6'),
				'actions' => array('label' => __d('backstage', 'UserPermission header: actions', true), 'size' => '3'),
			),
			'customRow' => true,
			'customSearch' => true,
		),
	)
);
