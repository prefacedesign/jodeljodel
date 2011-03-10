<?php

Configure::write('Dashboard.itemSettings',array(
		'default' => array(
			'actions' => array('publish_draft','delete','edit', 'create'),
			'edit_version' => 'backstage'
		),
		'corktile' => array(
			'actions' => array('edit'),
			'edit_version' => 'corktile'
		)
	)
);