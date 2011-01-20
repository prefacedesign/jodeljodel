<?php
$this->Html->script('prototype', array('inline' => false));

$html->scriptBlock("
	var theExpandedRow = false;

	function dashExpandRow(row_number)
	{
		$$('tr.row_' + (0 + row_number))[0].addClassName('expanded');
		$$('tr.row_' + (1 + row_number))[0].addClassName('expanded');
		$$('tr.row_' + (2 + row_number))[0].addClassName('expanded');
		theExpandedRow = row_number;
	}
	
	function dashContractRow(row_number)
	{
		$$('tr.row_' + (0 + row_number))[0].removeClassName('expanded');
		$$('tr.row_' + (1 + row_number))[0].removeClassName('expanded');
		$$('tr.row_' + (2 + row_number))[0].removeClassName('expanded');
		theExpandedRow = false;
	}
	
	function dashToggleExpandableRow(row_number)
	{
		if (theExpandedRow === row_number)
		{
			dashContractRow(theExpandedRow);
			return;
		}
		
		if (theExpandedRow !== false)
		{
			dashContractRow(theExpandedRow);
		}
		
		dashExpandRow(row_number);
	}
	
", array('inline' => false));

echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
	echo $this->Bl->h1Dry(__('Backstage index page: Page title - Dashboard', true));
	
	echo $this->Bl->sdiv(array('class' => 'pagination'));
		echo $this->Paginator->first('<<');
		if ($this->Paginator->hasPrev())
			echo $this->Paginator->prev('<');	
		echo $this->Paginator->numbers(array('modulus' => 9, 'separator' => ''));
		if ($this->Paginator->hasPrev())
			echo $this->Paginator->prev('>');
		echo $this->Paginator->last('>>');
	echo $this->Bl->ediv();

	echo $this->Bl->ssmartTable(array('class' => 'dashboard'), array(
		'automaticColumnNumberHeaderClasses' => true, 
		'automaticRowNumberClasses' => true, 
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
			__('Dashboard - dashboard header: Type',true), 
			$this->Paginator->sort(__('Dashboard - dashboard header: Status',true),'status'), 
			$this->Paginator->sort(__('Dashboard - dashboard header: Name',true),'name'),
			__('Dashboard - dashboard header: Extra info',true),
			$this->Paginator->sort(__('Dashboard - dashboard header: Created',true),'created'),
			$this->Paginator->sort(__('Dashboard - dashboard header: Modified',true),'modified'),
			__('Dashboard - dashboard header: Translations',true),
		));
		foreach ($this->data as $k => $item)
		{
			$row_number = $k*3 + 2;
		
			$arrow = $this->Bl->sdiv(array('class' => 'arrow'))
					 . $this->Bl->anchor(array(), array('url' => ''), ' ')
					 . $this->Bl->ediv();
			
		
			echo $this->Bl->smartTableRowDry(array(
				__('Dashboard types: ' . $item['DashDashboardItem']['type'], true), 
				__('Dashboard status: ' . $item['DashDashboardItem']['status'], true),
				$item['DashDashboardItem']['name'],
				$item['DashDashboardItem']['info'],
				$item['DashDashboardItem']['created'],
				$item['DashDashboardItem']['modified'],
				array(array(), array('escape' => false), $arrow . $item['DashDashboardItem']['idiom'])
			));
	
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('colspan' => 3),' '), 
				array(array('id' => 'item_info_$k'),array('colspan' => 4, 'rowspan' => 2), 'Descricao: Desmond has a barrow in the marketplace / Molly is the singer in a band / Desmond say to Molly, girl I like you face /And Molly says this as she takes him by the hand / Obladi, oblada, / Life goes on, bra / La la how the life goes on / Obladi, oblada / Life goes on, bra / La la how the life goes on')
			));
			echo $html->scriptBlock("
				$$('tr.row_". $row_number . " .arrow a')[0].observe('click', function (ev) { ev.stop(); dashToggleExpandableRow(" . $row_number . ");});
			", array('inline' => true));
			
			$links = $this->Bl->divDry(
					   $this->Bl->anchor(array('class' => 'link_button'), array('url' => ''), __('Dashboard: Delete content', true))
					 . $this->Bl->anchor(array('class' => 'link_button'), array('url' => ''), __('Dashboard: Hide from public', true))
			//		 . $this->Bl->anchor(array('class' => 'link_button'), array('url' => ''), __('Dashboard: See on the page', true))
					 . $this->Bl->anchor(array('class' => 'link_button'), array('url' => ''), __('Dashboard: Edit', true))
			);
			
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('escape' => false, 'colspan' => 3),$links)
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