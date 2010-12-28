<?php

	echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->h1Dry(__('Backstage index page: Page title - Dashboard', true));
	
		echo $this->Bl->ssmartTable(array('class' => 'dashboard'), array(
			'automaticColumnNumberHeaderClasses' => true, 
			'rows' => array(
				'every1of3' => array('class' => 'main_info'), 
				'every2of3' => array('class' => 'extra_info'),
				'every3of3' => array('class' => 'actions')
			)
		));		
			echo $this->Bl->smartTableHeaderDry(array('Tipo', 'Status', 'Nome', 'Informação extra', 'Criado', 'Editado', 'Línguas'));
			echo $this->Bl->smartTableRowDry(array('Evento', 'Publicado','São Paulo School on Advanced Studies on Speech Dynamics', 'Quando: 3 a 7 de outubro de 2010', 'Ontem', 'Hoje', 'PT JP'));
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('colspan' => 3),' '), 
				array(array(),array('colspan' => 4, 'rowspan' => 2),'Descricao: Desmond has a barrow in the marketplace / Molly is the singer in a band / Desmond say to Molly, girl I like you face /And Molly says this as she takes him by the hand / Obladi, oblada, / Life goes on, bra / La la how the life goes on / Obladi, oblada / Life goes on, bra / La la how the life goes on')
			));
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('colspan' => 3),'Some links')
			));
			
			echo $this->Bl->smartTableRowDry(array('Evento', 'Publicado','São Paulo School on Advanced Studies on Speech Dynamics', 'Quando: 3 a 7 de outubro de 2010', 'Ontem', 'Hoje', 'PT JP'));
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('colspan' => 3),' '),
				array(array(),array('colspan' => 4, 'rowspan' => 2),'Descricao: Desmond has a barrow in the marketplace / Molly is the singer in a band / Desmond say to Molly, girl I like you face /And Molly says this as she takes him by the hand / Obladi, oblada, / Life goes on, bra / La la how the life goes on / Obladi, oblada / Life goes on, bra / La la how the life goes on')
			));
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('colspan' => 3),'Some links')
			)); 
			
			
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