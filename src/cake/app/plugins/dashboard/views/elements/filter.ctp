<?php

	$paginator->options(
		array(
			'update'=>'dashboard_table', 
			'url'=>array('controller'=>'DashDashboard', 'action'=>'index'), 
			'before' => "$('dashboard_table').setLoading();",
			'complete' => "$('dashboard_table').unsetLoading();"
		)
	); 
	
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
			$this->Paginator->sort(__d('dashboard','Dashboard header: Type',true),'type'), 
			$this->Paginator->sort(__d('dashboard','Dashboard header: Status',true),'status'), 
			$this->Paginator->sort(__d('dashboard','Dashboard header: Name',true),'name'),
			__d('dashboard','Dashboard header: Extra info',true),
			$this->Paginator->sort(__d('dashboard','Dashboard header: Created',true),'created'),
			$this->Paginator->sort(__d('dashboard','Dashboard header: Modified',true),'modified'),
			__('Dashboard - dashboard header: Translations',true),
		));
		
		
		foreach ($this->data as $k => $item)
		{
			$row_number = $k*3 + 2;
			
			if (isset($itemSettings[$item['DashDashboardItem']['type']]))
				$curSettings = $itemSettings[$item['DashDashboardItem']['type']];
			else
				$curSettings = $itemSettings['default'];
		
			$arrow = $this->Bl->sdiv(array('class' => 'arrow'))
					 . $this->Bl->anchor(array(), array('url' => ''), ' ')
					 . $this->Bl->ediv();
					 
			$languageStr = '';
			
			if (is_array($item['DashDashboardItem']['idiom']))
			{
				foreach ($item['DashDashboardItem']['idiom'] as $lang)
				{
					$lang = 'Dashboard language abrev.: '. $lang;
					$languageStr .= __d('dashboard',$lang, true) . ' ';
				}
			}
			
			$type = 'Dashboard types: ' . $item['DashDashboardItem']['type'];
			$status = 'Dashboard status: ' . $item['DashDashboardItem']['status'];
			echo $this->Bl->smartTableRowDry(array(
				__d('dashboard', $type, true), 
				__d('dashboard', $status, true),
				$item['DashDashboardItem']['name'],
				$item['DashDashboardItem']['info'],
				strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['created'])),
				$arrow . strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['modified'])),
				array(array(), array('escape' => false), $arrow . $languageStr)
			));
	
			//@todo Substitute this with an AJAX call.
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('colspan' => 3),' '), 
				array(array('id' => 'item_info_$k'),array('colspan' => 4, 'rowspan' => 2), '')
			));
			
			
			echo $html->scriptBlock("
				$$('tr.row_". $row_number . " .arrow a')[0].observe('click', function (ev) { ev.stop(); dashToggleExpandableRow(" . $row_number . ");});
			", array('inline' => true));
			
			//Does this entry has publishing and drafting capabilities?
			if (in_array('publish_draft',$curSettings['actions']))
			{
				$draftLink = $ajax->link(__d('dashboard','Hide from public', true), 			
					array(
						'plugin' => 'backstage',
						'controller' => 'back_contents',
						'action' => 'set_publishing_status',
						$item['DashDashboardItem']['type'],
						$item['DashDashboardItem']['dashable_id'], 'draft'
					), array(
						'complete' => "if(request.responseJSON.success) {showPopup('draft_alert_ok');} else {showPopup('draft_alert_failure');}",
						'class' => 'link_button'
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
						'class' => 'link_button'
					)
				);
			}
			
			$links = $this->Bl->sdiv();
			
			if (in_array('delete', $curSettings['actions']))
			{
				$links .= $ajax->link(__d('dashboard','Delete content', true),
						array(
							'plugin' => 'dashboard',
							'controller' => 'dash_dashboard',
							'action' => 'delete_item',
							$item['DashDashboardItem']['id']
						), array(
							'complete' => "if(request.responseJSON.success) {showPopup('delete_alert_ok');} else {showPopup('delete_alert_failure');}",
							'class' => 'link_button'
						),
						__d('dashboard','Are you sure that desires delete this item?', true)
				);
			}
			
			if (in_array('publish_draft', $curSettings['actions']))
			{
				 $links .= $item['DashDashboardItem']['status'] == 'published' ? $draftLink : $publishLink;
			}
			
			$modules = Configure::read('jj.modules');
			$standardUrl = array(
				'controller' => (!empty($modules[$item['DashDashboardItem']['type']]['prefix']) ? $modules[$item['DashDashboardItem']['type']]['prefix'] . '_' : '') . Inflector::pluralize($modules[$item['DashDashboardItem']['type']]['plugin']),
				'action' => 'view'
			);
			
			if (isset($modules[$item['DashDashboardItem']['type']]['viewUrl']))
				$standardUrl = am($standardUrl, $modules[$item['DashDashboardItem']['type']]['viewUrl']);
			
			
			if (in_array('see_on_page', $curSettings['actions']))
			{
				if ($curSettings['edit_version'] != 'corktile')
				{
					$links .= $this->Bl->anchor(array('class' => 'link_button'), array('url' => array(
							'plugin' => $modules[$item['DashDashboardItem']['type']]['plugin'],
							'controller' => $standardUrl['controller'],
							'action' => $standardUrl['action'], $item['DashDashboardItem']['dashable_id']
						)), 
						__('Dashboard: See on the page', true)
					);
				}
			}
			
			if (in_array('edit', $curSettings['actions']))
			{
				 if ($curSettings['edit_version'] == 'backstage')
				 {
					 $links .= $this->Bl->anchor(array('class' => 'link_button'), array('url' => array(
									'plugin' => 'backstage',
									'controller' => 'back_contents',
									'action' => 'edit',
									$item['DashDashboardItem']['type'],
									$item['DashDashboardItem']['dashable_id']
							 )
						 ), __d('dashboard','Dashboard: Edit', true)
					 );
				 }
				 elseif ($curSettings['edit_version'] == 'corktile')
				 {
					 $links .= $this->Bl->anchor(array('class' => 'link_button'), array('url' => array(
									'plugin' => 'corktile',
									'controller' => 'cork_corktiles',
									'action' => 'edit',
									$item['DashDashboardItem']['dashable_id']
							 )
						 ), __d('dashboard','Dashboard: Edit', true)
					 );
				}
			}
				 
			$links .= $this->Bl->ediv();
			
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('escape' => false, 'colspan' => 3),$links)
			));
		}
		
	echo $this->Bl->esmartTable();


?>