<?php

Configure::write('Dashboard.item_settings',array(
		'default' => array(
			'actions' => array('publish_draft','delete','edit'),
			'edit_version' => 'backstage'
		),
		'corktile' => array(
			'actions' => array('edit'),
			'edit_version' => 'corktile'
		)
	)
);