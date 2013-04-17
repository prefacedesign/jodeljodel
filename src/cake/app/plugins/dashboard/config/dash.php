<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


$config['Dashboard.itemSettings'] = array(
		'default' => array(
			'actions' => array('publish_draft','delete','edit', 'create', 'see_on_page'),
			'edit_version' => 'backstage'
		),
		'corktile' => array(
			'actions' => array('edit'),
			'edit_version' => 'corktile'
		),
	);

$config['Dashboard.limitSize'] = 20;
$config['Dashboard.statusOptions'] = array('published', 'draft');

// You can configure additional components to build the conditions for the dashboard.
// This component should receive the conditions array and then return the conditions 
// treated through a standard function: getDashboardFilterConditionsByPermission ($conditions)
// This feature should be used for more advanced settings in permissions scheme
// when there are permissions based on dynamic content, for example.

$config['Dashboard.additionalFilteringConditions'] = array('Dashboard.DashboardFiltering');
