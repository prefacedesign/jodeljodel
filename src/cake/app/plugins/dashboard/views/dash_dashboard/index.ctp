<?php
	echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->h1Dry(__('Backstage index page: Page title - Dashboard', true));
	
		echo $this->Bl->ssmartTable(array('class' => 'dashboard'), array(
			'automaticColumnNumberHeaderClasses' => true, 
			'rows' => array(
				'every1of3' => array('class' => 'main_info'), 
				'every2of3' => array('class' => 'extra_info'),
				'every3of3' => array('class' => 'actions')
			),
			'columns' => array(
				1 => array('class' => 'first_col'),
				7 => array('class' => 'last_col')
			)
		));
			echo $this->Bl->smartTableHeaderDry(array(
				__('Dashboard - dashboard header: Type'      	,true), 
				__('Dashboard - dashboard header: Status'    	,true), 
				__('Dashboard - dashboard header: Name'      	,true),
				__('Dashboard - dashboard header: Extra info'	,true),
				__('Dashboard - dashboard header: Created'	 	,true),
				__('Dashboard - dashboard header: Modified'	    ,true),
				__('Dashboard - dashboard header: Translations' ,true),
			));
			foreach ($this->data as $k => $item)
			{ 
				echo $this->Bl->smartTableRowDry(array(
					__('Dashboard types: ' . $item['DashDashboardItem']['type'], true), 
					__('Dashboard status: ' . $item['DashDashboardItem']['status'], true),
					$item['DashDashboardItem']['name'],
					$item['DashDashboardItem']['info'],
					$item['DashDashboardItem']['created'],
					$item['DashDashboardItem']['modified'],
					$item['DashDashboardItem']['idiom']
				));
		
				echo $this->Bl->smartTableRowDry(array(
					array(array(),array('colspan' => 3),' '), 
					array(array('id' => 'item_info_$k'),array('colspan' => 4, 'rowspan' => 2), 'Descricao: Desmond has a barrow in the marketplace / Molly is the singer in a band / Desmond say to Molly, girl I like you face /And Molly says this as she takes him by the hand / Obladi, oblada, / Life goes on, bra / La la how the life goes on / Obladi, oblada / Life goes on, bra / La la how the life goes on')
				));
				echo $this->Bl->smartTableRowDry(array(
					array(array(),array('colspan' => 3),'Some links')
				));
			}
		echo $this->Bl->esmartTable();
	echo $this->Bl->ebox();

/*
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
	
*/

?>