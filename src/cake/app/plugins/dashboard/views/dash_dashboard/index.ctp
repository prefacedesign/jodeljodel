<?php
$this->Html->script('prototype', array('inline' => false));
$this->Html->script('/dashboard/js/burocrata.js', array('inline' => false));

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
	echo $this->Bl->h1Dry(__d('dashboard','Page title - Dashboard', true));
	
	echo $this->Bl->sboxContainer(array('class' => 'dash_toolbox'),array('size' => array('M' => 12, 'g' => -1)));
	
		echo $this->Bl->sdiv(array('class' => array('dash_additem')));
			echo $this->Bl->sdiv(array('class' => 'dash_itemlist'));
				echo $this->Bl->h3Dry(__d('dashboard','Add new content:', true));
				$linkList = array();
				
				foreach(Configure::read('jj.modules') as $moduleName => $module)
				{
					if (isset($module['plugged']))
					{
						$curSettings = isset($itemSettings[$moduleName]) ? $itemSettings[$moduleName] : $itemSettings['default'];
					
						if (in_array('dashboard', $module['plugged']) && in_array('create', $curSettings['actions']))
						{
							$url = array(
								'language' => $mainLanguage,
								'plugin' => 'backstage','controller' => 'back_contents',
								'action' => 'edit', $moduleName
							);
							$linkList[] = $this->Bl->anchor(array(), compact('url'), __($module['humanName'], true));
						}
					}
				}
				echo $this->Text->toList($linkList, ' '.__d('dashboard','or', true).' ');
				echo $this->Bl->anchor(array('id' => 'close_dash_additem'),array(), __d('dashboard','Close item list',true));
			echo $this->Bl->ediv();
		echo $this->Bl->ediv();
		
		echo $this->Bl->sdiv(array('class' => array('dash_link_to_additem','expanded')));
			echo $this->Bl->anchor(array('id' => 'open_dash_additem'),array(),__d('dashboard','Open item list',true));
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
		
		
		
		
		
		echo $bl->floatBreak();
		
	echo $this->Bl->eboxContainer();
	
	echo $this->Bl->sboxContainer(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->sdiv(array('class' => array('dash_filter')));
			echo $this->Bl->sdiv(array('id' => 'dash_filter_list'));
				echo $this->Bl->sdiv(array('class' => 'filters'));
					echo $this->Bl->h4Dry(__d('dashboard','Type', true));
					$linkFilters = array();
					
					$modulesCount = 0;
					foreach(Configure::read('jj.modules') as $moduleName => $module)
					{
						if (isset($module['plugged']) || $moduleName == 'corktile') 
						{
							$curSettings = isset($itemSettings[$moduleName]) ? $itemSettings[$moduleName] : $itemSettings['default'];
							if ((in_array('dashboard', $module['plugged']) && in_array('create', $curSettings['actions'])) || $moduleName == 'corktile')
								$modulesCount++;

						}
					}
					foreach(Configure::read('jj.modules') as $moduleName => $module)
					{
						if (isset($module['plugged']) || $moduleName == 'corktile')
						{
							$curSettings = isset($itemSettings[$moduleName]) ? $itemSettings[$moduleName] : $itemSettings['default'];
							if ((in_array('dashboard', $module['plugged']) && in_array('create', $curSettings['actions'])) || $moduleName == 'corktile')
							{
								$class = '';
								if ($filter == $moduleName)
									$class = 'selected';
								$filterLink = $ajax->link(__($module['humanName'], true), 			
									array(
										'plugin' => 'dashboard',
										'controller' => 'dash_dashboard',
										'action' => 'filter',
										$moduleName
									), 
									array(
										'before' => "$('dashboard_table').setLoading();",
										'complete' => "
											$('dashboard_table').unsetLoading();
											for (var i = 1; i <= ". ($modulesCount * 2) ."; i++) {
												$('dash_filter_list').down('.filters', 0).down(i).removeClassName('selected');
												i++;
											}
											$('filter_all').removeClassName('selected');
											$('filter_".$moduleName."').addClassName('selected');
										",
										'id' => 'filter_'.$moduleName,
										'class' => $class,
										'update' => 'dashboard_table'
									)
								);
								$linkFilters[] = $filterLink;
							}

						}
					}
					$class = '';
					if ($filter == 'all')
						$class = 'selected';
					$filterLink = $ajax->link(__d('dashboard','Show All', true), 			
						array(
							'plugin' => 'dashboard',
							'controller' => 'dash_dashboard',
							'action' => 'filter',
							'all'
						), 
						array(
							'before' => "$('dashboard_table').setLoading();",
							'complete' => "
								$('dashboard_table').unsetLoading();
								for (var i = 1; i < ". ($modulesCount*2) ."; i++) {
									$('dash_filter_list').down('.filters', 0).down(i).removeClassName('selected');
									i++;
								}
								$('filter_all').addClassName('selected');
							",
							'id' => 'filter_all',
							'class' => $class,
							'update' => 'dashboard_table'
						)
					);
					$linkFilters[] = $filterLink;
					echo $this->Text->toList($linkFilters, ' ', ' ');
				echo $this->Bl->ediv();
				
				echo $this->Bl->sdiv(array('class' => 'filters'));
					echo $this->Bl->h4Dry(__d('dashboard','Status', true));
					$linkFilters = array();
					$modulesCount = 0;
					foreach($statusOptions as $module)
						$modulesCount++;
					foreach($statusOptions as $module)
					{

						$class = '';
						if ($filter_status == $module)
							$class = 'selected';
						$filterLink = $ajax->link(__d('dashboard', 'Dashboard status: ' . $module, true), 			
							array(
								'plugin' => 'dashboard',
								'controller' => 'dash_dashboard',
								'action' => 'filter_published_draft',
								$module
							), 
							array(
								'before' => "$('dashboard_table').setLoading();",
								'complete' => "
									$('dashboard_table').unsetLoading();
									for (var i = 1; i < ". ($modulesCount*2) ."; i++) {
										$('dash_filter_list').down('.filters', 1).down(i).removeClassName('selected');
										i++;
									}
									$('filter_published_draft_all').removeClassName('selected');
									$('filter_published_draft_".$module."').addClassName('selected');
								",
								'id' => 'filter_published_draft_'.$module,
								'class' => $class,
								'update' => 'dashboard_table'
							)
						);
						$linkFilters[] = $filterLink;
					}
					$class = '';
					if ($filter_status == 'all')
						$class = 'selected';
					$filterLink = $ajax->link(__d('dashboard','Show All', true), 			
						array(
							'plugin' => 'dashboard',
							'controller' => 'dash_dashboard',
							'action' => 'filter_published_draft',
							'all'
						), 
						array(
							'before' => "$('dashboard_table').setLoading();",
							'complete' => "
								$('dashboard_table').unsetLoading();
								for (var i = 1; i < ". ($modulesCount*2) ."; i++) {
									$('dash_filter_list').down('.filters', 1).down(i).removeClassName('selected');
									i++;
								}
								$('filter_published_draft_all').addClassName('selected');
							",
							'id' => 'filter_published_draft_all',
							'class' => $class,
							'update' => 'dashboard_table'
						)
					);
					$linkFilters[] = $filterLink;
					echo $this->Text->toList($linkFilters, ' ', ' ');
				echo $this->Bl->ediv();
				echo $this->Bl->floatbreak();
			echo $this->Bl->ediv();
		echo $this->Bl->ediv();
		
	echo $this->Bl->eboxContainer();
	
	// The popups called after success or failure of "Mark as draft" or "Publish"
	echo $this->Popup->popup('draft_alert_ok', array(
				'type' => 'notice',
				'title' => __d('dashboard','Notice of marking as draft success - TITLE',true),
				'content' => __d('dashboard','Notice of marking as draft success - TEXT',true),
				'actions' => array('ok' => 'OK'),
				'callback' => "if (action == 'ok') window.location.reload();"
			));
			
	echo $this->Popup->popup('draft_alert_failure', array(
				'type' => 'error',
				'title' => __d('dashboard','Notice of marking as draft failure - TITLE',true),
				'content' => __d('dashboard','Notice of marking as draft failure - TEXT',true),
				'actions' => array('ok' => 'OK')
			));
			
	echo $this->Popup->popup('publish_alert_ok', array(
				'type' => 'notice',
				'title' => __d('dashboard','Notice of publishing success - TITLE',true),
				'content' => __d('dashboard','Notice of publishing success - TEXT',true),
				'actions' => array('ok' => 'OK'),
				'callback' => "if (action == 'ok') window.location.reload();"
			));
			
	echo $this->Popup->popup('publish_alert_failure', array(
				'type' => 'error',
				'title' => __d('dashboard','Notice of publishing failure - TITLE',true),
				'content' => __d('dashboard','Notice of publishing failure - TEXT',true),
				'actions' => array('ok' => 'OK')
			));
			
	echo $this->Popup->popup('delete_alert_ok', array(
				'type' => 'notice',
				'title' => __d('dashboard','Notice of delete success - TITLE',true),
				'content' => __d('dashboard','Notice of delete success - TEXT',true),
				'actions' => array('ok' => 'OK'),
				'callback' => "if (action == 'ok') window.location.reload();"
			));
			
	echo $this->Popup->popup('delete_alert_failure', array(
				'type' => 'error',
				'title' => __d('dashboard','Notice of delete failure - TITLE',true),
				'content' => __d('dashboard','Notice of delete failure - TEXT',true),
				'actions' => array('ok' => 'OK')
			));
	
	
	echo $ajax->div('dashboard_table');
		echo $this->element('filter');
	echo $ajax->divEnd('dashboard_table');
echo $this->Bl->ebox();

?>