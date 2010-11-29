<?php

	foreach ($items as $item)
	{ 
		//echo $item['DashboardItem']['dashable_model'];
		echo $item['DashDashboardItem']['type'];
		echo '<br>';
		echo $item['DashDashboardItem']['status'];
		echo '<br>';
		echo $item['DashDashboardItem']['name'];
		echo '<br>';
		//echo $item['DashboardItem']['info'];
		echo $item['DashDashboardItem']['idiom'];
		echo '<br>';
		echo $item['DashDashboardItem']['created'];
		echo '<br>';
		echo $item['DashDashboardItem']['modified'];		
		echo '<br>';
		
		echo $html->link('Delete', array('plugin'=>'dashboard', 'controller'=>'DashDashboard', 'action'=>'removeDashboardItem', $item['DashDashboardItem']['id']));
		
		echo '<br>';
		echo '<br>';
	}

?>