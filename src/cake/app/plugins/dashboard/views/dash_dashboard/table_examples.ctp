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


	echo $this->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->h1Dry(__('Backstage index page: Page title - Dashboard', true));
	
	
	/*echo $this->Bl->expandableMenu(array(),
		array(
			'title' => __('Backstage index page: Add item',true)),
			'linkList' => array()
		;
	
	//@todo Create substitute to the default Cake paginator helper. Including perhaps more sofisticated output.
	
	echo $this->Paginator->first('<<');
	echo $this->Paginator->prev('<');
	echo $this->Paginator->numbers();
	echo $this->Paginator->next('>');
	echo $this->Paginator->last('>>');
	
	echo $this->Bl->hr(); */
	
	// Exemplos de table
	
	/*echo $this->Bl->ssmartTable(array(),
		array(
			'columns' => array(
				'odd' => array('class' => 'odd'),
				'even' => array('class' => 'even'),
				1 => array(array('class' => 'first_column'), array('escape' => false)),
				3 => ,
				'every2of3' => ''
			),
			'rows' => array(
				'header' =>
				2 => array('class' => 'second_row'),
				'odd' => 
				'even' =>
				'footer' =>
			),
			'every_cell' => array(
				array('class' => 'a_cell')
			),
			'automatic_row_number_classes' => true,
			'automatic_row_number_options' => true
		)
	); */
	
	//echo $this->Bl->ssmartTable(array(), array('columns' => array('odd' => array(array('class' => 'even'),array()))));
	echo $this->Bl->ssmartTable(array(), array('rows' => array('even' => array('class' => 'eveline'), 3 => array('class' => 'third'), 'every1of3' => array('class' => 'excentrico')),
					'columns' => array('odd' => array('class' => 'col_odd'))));
	
		echo $this->Bl->smartTableRow(array(), array('header' => true), array('eu', 'voce', 'jorge', 'ricardo', 'regina'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', 'jorge', 'ricardo', 'tatiana'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', 'jorge', 'ricardo', 'tatiana'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', array(array('class' => 'jorge'), array('header' => true), 'jorge'), 'ricardo', 'tatiana'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', array(array(),array('rowspan' => 3),'jorge'), 'ricardo', 'tatiana','vicente'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', 'jorge', 'ricardo'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', 'jorge', 'ricardo'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', 'jorge', 'ricardo', 'tatiana'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', 'voce', 'jorge', 'ricardo', 'tatiana'));
		echo $this->Bl->smartTableRow(array(), array(), array('eu', array(array(),array('colspan' => 3),'jorge'), 'tatiana'));
		
	echo $this->Bl->esmartTable();
		
	echo $this->ebox();
	
	/*	echo $this->Bl->smartTableHeader(array(
			'Loucas',
			array(array(),array(),'Liceu'),
			'Limeu', 
			array(array('class' => 'classe'),array('escape' => false), 'content') 
		));
		
		echo $this->Bl->smartTableRow(array('coluna 1', array(array(), array('colspan' => 3), 'celula col 2'));
		
		echo $this->Bl->smartTableRows(array(
			array('ou','e','então','senão'),
			array('ou','e','então','senão')
		));
		
	*/		

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