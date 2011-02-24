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
	
	echo $this->Bl->sboxContainer(array('class' => 'dash_toolbox'),array('size' => array('M' => 12, 'g' => -1)));
				
		echo $this->Bl->sdiv(array('class' => array('dash_additem')));
			echo $this->Bl->sdiv(array('class' => 'dash_itemlist'));
				echo $this->Bl->h3Dry(__('Dashboard: Add new content:', true));
				$linklist = array();
				
				foreach($jjModules as $k => $module)
				{
					if (isset($module['plugged']))
					{
						if (in_array('dashboard', $module['plugged']))
						{
							$linkList[] = $this->Bl->anchor(array(), array('url' => array(
										'plugin' => 'backstage',
										'controller' => 'back_contents',
										'action' => 'edit',
										$module['plugin'],
										Inflector::underscore($module['model'])
									)
								),
								__($module['humanName'],true)
							);
						}
					}
				}
				echo $this->Text->toList($linkList, ' '.__('or', true).' ');
				echo $this->Bl->anchor(array('id' => 'close_dash_additem'),array(), __('Dashboard: Close item list',true));
			echo $this->Bl->ediv();
		echo $this->Bl->ediv();
		
		echo $this->Bl->sdiv(array('class' => array('dash_link_to_additem','expanded')));
			echo $this->Bl->anchor(array('id' => 'open_dash_additem'),array(),__('Dashboard: Open item list',true));
		echo $this->Bl->ediv();
		echo $html->scriptBlock("
				$('open_dash_additem').observe('click', function (ev) { ev.stop(); dashOpenAdditem();});
				$('close_dash_additem').observe('click', function (ev) { ev.stop(); dashCloseAdditem();});
			", array('inline' => true));
		echo $html->scriptBlock("
				function dashCloseAdditem()
				{
					$$('.dash_link_to_additem')[0].addClassName('expanded');
					$$('.dash_additem')[0].removeClassName('expanded');
				}
				
				function dashOpenAdditem()
				{
					$$('.dash_link_to_additem')[0].removeClassName('expanded');
					$$('.dash_additem')[0].addClassName('expanded');
				}", 
			array('inline' => false)
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
		
	echo $this->Bl->eboxContainer();
	
	// The popups called after success or failure of "Mark as draft" or "Publish"
	echo $this->Popup->popup('draft_alert_ok', array(
				'type' => 'notice',
				'title' => __('Dashboard: Notice of marking as draft success - TITLE',true),
				'content' => __('Dashboard: Notice of marking as draft success - TEXT',true),
				'actions' => array('ok' => 'OK'),
				'callback' => "if (action == 'ok') window.location.reload();"
			));
			
	echo $this->Popup->popup('draft_alert_failure', array(
				'type' => 'error',
				'title' => __('Dashboard: Notice of marking as draft failure - TITLE',true),
				'content' => __('Dashboard: Notice of marking as draft failure - TEXT',true),
				'actions' => array('ok' => 'OK')
			));
			
	echo $this->Popup->popup('publish_alert_ok', array(
				'type' => 'notice',
				'title' => __('Dashboard: Notice of publishing success - TITLE',true),
				'content' => __('Dashboard: Notice of publishing success - TEXT',true),
				'actions' => array('ok' => 'OK'),
				'callback' => "if (action == 'ok') window.location.reload();"
			));
			
	echo $this->Popup->popup('publish_alert_failure', array(
				'type' => 'error',
				'title' => __('Dashboard: Notice of publishing failure - TITLE',true),
				'content' => __('Dashboard: Notice of publishing failure - TEXT',true),
				'actions' => array('ok' => 'OK')
			));
			
	echo $this->Popup->popup('delete_alert_ok', array(
				'type' => 'notice',
				'title' => __('Dashboard: Notice of delete success - TITLE',true),
				'content' => __('Dashboard: Notice of delete success - TEXT',true),
				'actions' => array('ok' => 'OK'),
				'callback' => "if (action == 'ok') window.location.reload();"
			));
			
	echo $this->Popup->popup('delete_alert_failure', array(
				'type' => 'error',
				'title' => __('Dashboard: Notice of delete failure - TITLE',true),
				'content' => __('Dashboard: Notice of delete failure - TEXT',true),
				'actions' => array('ok' => 'OK')
			));
	
	
	
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
					$languageStr .= __('Dashboard language abrev.: ', true). $lang;
			}
			
			echo $this->Bl->smartTableRowDry(array(
				__('Dashboard types: ' . $item['DashDashboardItem']['type'], true), 
				__('Dashboard status: ' . $item['DashDashboardItem']['status'], true),
				$item['DashDashboardItem']['name'],
				$item['DashDashboardItem']['info'],
				strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['created'])),
				strftime("%d/%m/%y", strtotime($item['DashDashboardItem']['modified'])),
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
				$draftLink = $ajax->link(__('Dashboard: Hide from public', true), 			
					array(
						'plugin' => 'backstage',
						'controller' => 'back_contents',
						'action' => 'set_publishing_status', 
						$jjModules[$item['DashDashboardItem']['type']]['plugin'],
						Inflector::underscore($jjModules[$item['DashDashboardItem']['type']]['model']),
						$item['DashDashboardItem']['dashable_id'], 'draft'
					), array(
						'complete' => "if(request.responseJSON.success) {showPopup('draft_alert_ok');} else {showPopup('draft_alert_failure');}",
						'class' => 'link_button'
					)
				);
			
				$publishLink = $ajax->link(__('Dashboard: Publish to the great public', true),
					array(
						'plugin' => 'backstage', 
						'controller' => 'back_contents',
						'action' => 'set_publishing_status',
						$jjModules[$item['DashDashboardItem']['type']]['plugin'],
						Inflector::underscore($jjModules[$item['DashDashboardItem']['type']]['model']),
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
				$links .= $ajax->link(__('Dashboard: Delete content', true),
						array(
							'plugin' => 'dashboard',
							'controller' => 'dash_dashboard',
							'action' => 'delete_item',
							$item['DashDashboardItem']['id']
						), array(
							'complete' => "if(request.responseJSON.success) {showPopup('delete_alert_ok');} else {showPopup('delete_alert_failure');}",
							'class' => 'link_button'
						)
				);
			}
			
			if (in_array('publish_draft', $curSettings['actions']))
			{
				 $links .= $item['DashDashboardItem']['status'] == 'published' ? $draftLink : $publishLink;
			}
			
			if (in_array('see_on_page', $curSettings['actions']))
			{
				//$this->Bl->anchor(array('class' => 'link_button'), array('url' => ''), __('Dashboard: See on the page', true))
			}
			
			if (in_array('edit', $curSettings['actions']))
			{
				 if ($curSettings['edit_version'] == 'backstage')
				 {
					 $links .= $this->Bl->anchor(array('class' => 'link_button'), array('url' => array(
									'plugin' => 'backstage',
									'controller' => 'back_contents',
									'action' => 'edit',
									$jjModules[$item['DashDashboardItem']['type']]['plugin'],
									Inflector::underscore($jjModules[$item['DashDashboardItem']['type']]['model']),
									$item['DashDashboardItem']['dashable_id']
							 )
						 ), __('Dashboard: Edit', true)
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
						 ), __('Dashboard: Edit', true)
					 );
				}
			}
				 
			$links .= $this->Bl->ediv();
			
			echo $this->Bl->smartTableRowDry(array(
				array(array(),array('escape' => false, 'colspan' => 3),$links)
			));
		}
	echo $this->Bl->esmartTable();
echo $this->Bl->ebox();

?>