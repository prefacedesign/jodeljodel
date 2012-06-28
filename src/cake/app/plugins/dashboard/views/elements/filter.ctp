<?php

	$paginator->options(
		array(
			'update'=>'dashboard_table', 
			'url'=>array('controller'=>'dash_dashboard', 'action'=>'index'), 
			'before' => "$('dashboard_table').setLoading();",
			'complete' => "$('dashboard_table').unsetLoading();"
		)
	); 
	
	echo $this->Bl->sdiv(array('class' => 'pagination'));
		echo $this->Paginator->first('<<');
		if ($this->Paginator->hasPrev())
			echo $this->Paginator->prev('<');	
		echo $this->Paginator->numbers(array('modulus' => 9, 'separator' => ''));
		if ($this->Paginator->hasNext())
			echo $this->Paginator->next('>');
		echo $this->Paginator->last('>>');
	echo $this->Bl->ediv();
	
	$languages = Configure::read('Tradutore.languages');
	if (count($languages) > 1)
		$totalCols = 7;
	else
		$totalCols = 6;
		
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
			$totalCols => array('class' => 'last_col')
		)
	));
		
		$smartTableColumns = array();
		$smartTableColumns[] = $this->Paginator->sort(__d('dashboard','Dashboard header: Type',true),'type');
		$smartTableColumns[] = $this->Paginator->sort(__d('dashboard','Dashboard header: Status',true),'status');
		$smartTableColumns[] = $this->Paginator->sort(__d('dashboard','Dashboard header: Name',true),'name');
		$smartTableColumns[] = __d('dashboard','Dashboard header: Extra info',true);
		$smartTableColumns[] = $this->Paginator->sort(__d('dashboard','Dashboard header: Created',true),'created');
		$smartTableColumns[] = $this->Paginator->sort(__d('dashboard','Dashboard header: Modified',true),'modified');
		if (count($languages) > 1)
			$smartTableColumns[] = __d('dashboard', 'Dashboard - dashboard header: Translations',true);
		
		echo $this->Bl->smartTableHeaderDry($smartTableColumns);
		
		
		foreach ($this->data as $k => $item)
		{
			$row_number = $k*3 + 2;
			
			if (isset($itemSettings[$item['DashDashboardItem']['type']]))
				$curSettings = $itemSettings[$item['DashDashboardItem']['type']];
			else
				$curSettings = $itemSettings['default'];
		
			$arrow = $this->Bl->sdiv(array('class' => 'arrow'))
					 . $this->Bl->anchor(array(), array('url' => array('action' => 'index')), ' ')
					 . $this->Bl->ediv();
					 
			$languageStr = '';
			
			if (is_array($item['DashDashboardItem']['idiom']))
			{
				foreach ($item['DashDashboardItem']['idiom'] as $lang => $status)
				{
					$l = 'Dashboard language abrev.: '. $lang;
					if ($curSettings['edit_version'] == 'corktile')
					{
						$languageStr .= $this->Bl->anchor(
							array(), 
							array('url' => array('language' => $lang, 'plugin' => 'corktile', 'controller' => 'cork_corktiles', 'action' => 'edit', $item['DashDashboardItem']['dashable_id'])),
							$this->Bl->span(array('class' => $status), array(), __d('dashboard',$l, true))
						) 
						. ' &nbsp;';
					}
					else
					{
						$languageStr .= $this->Bl->anchor(
							array(), 
							array('url' => array('language' => $lang, 'plugin' => 'backstage', 'controller' => 'back_contents', 'action' => 'edit', $item['DashDashboardItem']['type'], $item['DashDashboardItem']['dashable_id'])),
							$this->Bl->span(array('class' => $status), array(), __d('dashboard',$l, true))
						) 
						. ' &nbsp;';
					}
					
				}
			}

			$type = 'Dashboard types: ' . $item['DashDashboardItem']['type'];
			$status = 'Dashboard status: ' . $item['DashDashboardItem']['status'];
			
			$curModule = Configure::read('jj.modules.'.$item['DashDashboardItem']['type']);
			
			$can_see = true;
			if (isset($curModule['permissions']) && isset($curModule['permissions']['view']))
			{
				if (!$this->JjAuth->can($curModule['permissions']['view']))
					$can_see = false;
			}
			
			if ($can_see)
			{
				$smartTableRow = array();
				$smartTableRow[] = __d('dashboard', $type, true);
				$smartTableRow[] = __d('dashboard', $status, true);
				$smartTableRow[] = $item['DashDashboardItem']['name'];
				$smartTableRow[] = $item['DashDashboardItem']['info'];
				$smartTableRow[] = strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['created']));
				if (count($languages) > 1)
				{
					$smartTableRow[] = strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['modified']));
					$smartTableRow[] = array(array(), array('escape' => false), $arrow . ' ' . $languageStr);
				}
				else
					$smartTableRow[] = $arrow . strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['modified']));
				
				
				echo $this->Bl->smartTableRow(array('id' => 'row_'.$row_number), array(), $smartTableRow);
		
				//@todo Substitute this with an AJAX call.
				echo $this->Bl->smartTableRowDry(array(
					array(array(),array('colspan' => 3),' '), 
					array(array('id' => "item_info_$k"),array('colspan' => 4, 'rowspan' => 2), '')
				));
				
				// Does this entry has publishing and drafting capabilities?
				if (in_array('publish_draft', $curSettings['actions']))
				{
					$can_publish = true;
					if (isset($curModule['permissions']) && isset($curModule['permissions']['edit_publishing_status']))
					{
						if (!$this->JjAuth->can($curModule['permissions']['edit_publishing_status']))
							$can_publish = false;
					}
					if ($can_publish)
					{
						$onclick = "";
						$class = 'link_button';
					}
					else
					{
						$onclick = "return false;";
						$class = 'link_button disabled';
					}
					$draftLink = $ajax->link(__d('dashboard','Hide from public', true), 			
						array(
							'plugin' => 'backstage',
							'controller' => 'back_contents',
							'action' => 'set_publishing_status',
							$item['DashDashboardItem']['type'],
							$item['DashDashboardItem']['dashable_id'], 'draft'
						), array(
							'complete' => "if(request.responseJSON.success) {showPopup('draft_alert_ok');} else {showPopup('draft_alert_failure');}",
							'class' => $class,
							'onclick' => $onclick
						)
					);
				
					$publishLink = $ajax->link(__d('dashboard','Publish to the great public', true),
						array(
							'plugin' => 'backstage', 
							'controller' => 'back_contents',
							'action' => 'set_publishing_status',
							$item['DashDashboardItem']['type'],
							$item['DashDashboardItem']['dashable_id'],'published'
						), array(
							'complete' => "if(request.responseJSON.success) {showPopup('publish_alert_ok');} else {showPopup('publish_alert_failure');}",
							'class' => $class,
							'onclick' => $onclick
						)
					);
				}
				
				$links = $this->Bl->sdiv();
				
				if (in_array('delete', $curSettings['actions']))
				{
					$can_delete = true;
					if (isset($curModule['permissions']) && isset($curModule['permissions']['delete']))
					{
						if (!$this->JjAuth->can($curModule['permissions']['delete']))
							$can_delete = false;
					}
					if ($can_delete)
					{
						$delete_url = $this->Html->url(array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'delete_item', $item['DashDashboardItem']['id'], $item['DashDashboardItem']['type']));
						$onclick = "deleteID = '". $delete_url . "'; showPopup('delete_alert_confirmation'); event.returnValue = false; return false;";
						$class = 'link_button';
					}
					else
					{
						$onclick = "return false";
						$class = 'link_button disabled';
					}					
					
					$links .= $this->Bl->anchor(
						array(
							'class' => $class,
							'onclick' => $onclick,
						), 
						array('url' => ''),
						__d('dashboard','Delete content', true)
					);
				}
				
				if (in_array('publish_draft', $curSettings['actions']))
				{
					$links .= $item['DashDashboardItem']['status'] == 'published' ? $draftLink : $publishLink;
				}
				
				// Default view action
				if (in_array('see_on_page', $curSettings['actions']))
				{
					$standardUrl = $this->Bl->moduleViewURL($item['DashDashboardItem']['type'],$item['DashDashboardItem']['dashable_id']);
					
					if ($curSettings['edit_version'] != 'corktile' && is_array($standardUrl))
					{
						$links .= $this->Bl->anchor(
							array('class' => 'link_button'),
							array('url' => $standardUrl), 
							__d('dashboard', 'Dashboard: See on the page', true)
						);
					}
				}
				
				if (in_array('edit', $curSettings['actions']))
				{
					$can_edit = true;
					if (isset($curModule['permissions']) && isset($curModule['permissions']['edit_draft']) && isset($curModule['permissions']['edit_published']))
					{
						if ($item['DashDashboardItem']['status'] == 'published')
						{
							if (!$this->JjAuth->can($curModule['permissions']['edit_published']))
								$can_edit = false;
						}
						else
						{
							if (!$this->JjAuth->can($curModule['permissions']['edit_draft']))
								$can_edit = false;
						}
					}
					if ($can_edit)
					{
						$onclick = "";
						$class = 'link_button';
					}
					else
					{
						$onclick = "return false;";
						$class = 'link_button disabled';
					}
					if ($curSettings['edit_version'] == 'backstage')
					{
						$links .= $this->Bl->anchor(
							array('class' => $class, 'onclick' => $onclick), 
							array('url' => array(
								'plugin' => 'backstage',
								'controller' => 'back_contents',
								'action' => 'edit',
								$item['DashDashboardItem']['type'],
								$item['DashDashboardItem']['dashable_id']
							)),
							__d('dashboard','Dashboard: Edit', true)
						);
					}
					elseif ($curSettings['edit_version'] == 'corktile')
					{
						$links .= $this->Bl->anchor(
							array('class' => $class, 'onclick' => $onclick), 
							array('url' => 
								array(
									'plugin' => 'corktile',
									'controller' => 'cork_corktiles',
									'action' => 'edit',
									$item['DashDashboardItem']['dashable_id']
								)
							), 
							__d('dashboard','Dashboard: Edit', true)
						);
					}
				}
				
				$links .= $this->Bl->ediv();
				
				echo $this->Bl->smartTableRowDry(array(
					array(array(),array('escape' => false, 'colspan' => 3),$links)
				));
				
				echo $this->Html->scriptBlock("new TableRow('row_$row_number');");
			}
		}
		
	echo $this->Bl->esmartTable();

?>
