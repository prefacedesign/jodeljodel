<?php

Configure::write('Dashboard.itemSettings',array(
		'default' => array(
			'actions' => array('publish_draft','delete','edit', 'create'),
			'edit_version' => 'backstage'
		),
		'corktile' => array(
			'actions' => array('edit'),
			'edit_version' => 'corktile'
		),
	)
);

Configure::write('Dashboard.limitSize', 20);
Configure::write('Dashboard.statusOptions', array('published', 'draft'));