<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

$this->Html->script('prototype', array('inline' => false));
$this->Html->script('/dashboard/js/core.js', array('inline' => false));
$this->Html->script('/dashboard/js/dashboard.js', array('inline' => false));

$this->BuroOfficeBoy->addHtmlEmbScript("
	new Dashboard();
	new ItemList('dash_additem', 'dash_link_to_additem');
");

echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
	echo $this->Bl->h1Dry(__d('dashboard','Page title - Dashboard', true));
	
	echo $this->Bl->sboxContainer(array('class' => 'dash_toolbox'),array('size' => array('M' => 12, 'g' => -1)));
		
		echo $this->Bl->sdiv(array('id' => 'dash_additem'));
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
							$class = '';
							$onclick = '';
							if (isset($module['permissions']) && isset($module['permissions']['create']))
							{
								if (!$this->JjAuth->can($module['permissions']['create']))
								{
									$onclick = "return false;";
									$class = 'disabled';
								}
							}
							$url = array(
								'language' => $mainLanguage,
								'plugin' => 'backstage','controller' => 'back_contents',
								'action' => 'edit', $moduleName
							);
							$linkList[] = $this->Bl->anchor(array('class' => $class, 'onclick' => $onclick), compact('url'), __($module['humanName'], true));
						}
					}
				}
				echo $this->Text->toList($linkList, ' '.__d('dashboard','or', true).' ');
			echo $this->Bl->ediv();
			
			echo $this->Bl->sspan();
				echo $this->Bl->anchor(array(), array('url' => ''), __d('dashboard','Close item list',true));
			echo $this->Bl->espan();
			
			echo $this->Bl->floatBreak();
		echo $this->Bl->ediv();
		
		echo $this->Bl->sdiv(array('id' => 'dash_link_to_additem', 'class' => 'expanded'));
			echo $this->Bl->anchor(array(), array('url' => ''), __d('dashboard','Open item list',true));
		echo $this->Bl->ediv();
		
		echo $bl->floatBreak();
		
	echo $this->Bl->eboxContainer();
	
	echo $this->Bl->sboxContainer(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->sdiv(array('class' => array('dash_filter')));
			echo $this->Bl->sdiv(array('id' => 'dash_filter_list'));
				echo $this->Bl->sdiv(array('class' => 'filters'));
				
					// SEARCH INPUT		
					$this->BuroOfficeBoy->addHtmlEmbScript("new SearchInput('dash_search');");
					
					echo $this->Bl->h4Dry(__d('dashboard','Text', true));
					
					echo $this->Bl->sdiv(array('class' => array('dash_search')));
						echo $form->input('dash_search', array('value' => $searchQuery, 'label' => __d('dashboard','or search for a content previously inserted',true)));
						echo $ajax->observeField('dash_search', 
							array(
								'url' => array('action' => 'search'),
								'frequency' => 2.5,
								'loading' => "$('dashboard_table').setLoading(); ",
								'complete' => "$('dashboard_table').unsetLoading();",
								'update' => 'dashboard_table'
							) 
						); 
					echo $this->Bl->ediv();
					echo $bl->floatBreak();
				echo $this->Bl->ediv();
				
				
				echo $this->Bl->sdiv(array('class' => 'filters'));
					echo $this->Bl->h4Dry(__d('dashboard','Status', true));
					$linkFilters = array();
					$modulesCount = count($statusOptions);
					foreach($statusOptions as $module)
					{							
						$filterLink = $ajax->link(__d('dashboard', 'Dashboard status: ' . $module, true), 			
							array(
								'plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'filter_published_draft', $module
							), 
							array(
								'before' => "$('dashboard_table').setLoading();",
								'complete' => "$('dashboard_table').unsetLoading();",
								'id' => 'filter_published_draft_'.$module,
								'update' => 'dashboard_table'
							)
						);
						$linkFilters[] = $filterLink;
						
						$selected = $filter_status == $module ? 'true' : 'false';
						$this->BuroOfficeBoy->addHtmlEmbScript("new FilterLink('filter_published_draft_$module', $selected, 'filter_published_draft_all');");
					}
					
					$filterLink = $ajax->link(__d('dashboard','Show All', true), 			
						array(
							'plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'filter_published_draft', 'all'
						), 
						array(
							'before' => "$('dashboard_table').setLoading();",
							'complete' => "$('dashboard_table').unsetLoading();",
							'id' => 'filter_published_draft_all',
							'update' => 'dashboard_table'
						)
					);
					$linkFilters[] = $filterLink;

					$selected = $filter_status == 'all' || empty($filter_status) ? 'true' : 'false';
					$this->BuroOfficeBoy->addHtmlEmbScript("new FilterLink('filter_published_draft_all', $selected);");
					echo $this->Text->toList($linkFilters, ' ', ' ');
				echo $this->Bl->ediv();
				echo $bl->floatBreak();



				echo $this->Bl->sdiv(array('class' => 'filters'));
					
					$linkFilters = array();
					foreach(Configure::read('jj.modules') as $moduleName => $module)
					{
						if (isset($module['plugged']) || $moduleName == 'corktile')
						{
							$curSettings = isset($itemSettings[$moduleName]) ? $itemSettings[$moduleName] : $itemSettings['default'];
							if ((in_array('dashboard', $module['plugged']) && in_array('create', $curSettings['actions'])) || $moduleName == 'corktile')
							{
								$can_view = true;
								if (isset($module['permissions']) && isset($module['permissions']['view']))
								{
									if (!$this->JjAuth->can($module['permissions']['view']))
										$can_view = false;
								}
								if ($can_view)
								{
									$url = array('plugin' => 'dashboard','controller' => 'dash_dashboard','action' => 'filter', $moduleName);
									$filterLink = $ajax->link(
										$module['humanName'],
										array('plugin' => 'dashboard','controller' => 'dash_dashboard','action' => 'filter', $moduleName),
										array(
											'before' => "$('dashboard_table').setLoading();",
											'complete' => "$('dashboard_table').unsetLoading();",
											'id' => 'filter_'.$moduleName,
											'update' => 'dashboard_table',
										)
									);
									$selected = $filter == $moduleName ? 'true' : 'false';
									$this->BuroOfficeBoy->addHtmlEmbScript("new FilterLink('filter_$moduleName', $selected, 'filter_all');");
								}
								else
								{
									$filterLink = $ajax->link(
										$module['humanName'],
										array(),
										array(
											'class'	=> 'disabled',
											'onclick' => "return false;",
											'id' => 'filter_'.$moduleName,
											'update' => 'dashboard_table',
										)
									);
								}
								$linkFilters[] = $filterLink;
							}

						}
					}
					$filterLink = $ajax->link(__d('dashboard','Show All', true), 			
						array(
							'plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'filter', 'all'
						), 
						array(
							'before' => "$('dashboard_table').setLoading();",
							'complete' => "$('dashboard_table').unsetLoading();",
							'id' => 'filter_all',
							'update' => 'dashboard_table'
						)
					);
					$linkFilters[] = $filterLink;
					
					$selected = $filter == 'all' || empty($filter) ? 'true' : 'false';
					$this->BuroOfficeBoy->addHtmlEmbScript("new FilterLink('filter_all', $selected);");
					
					
					echo $this->Bl->h4Dry(__d('dashboard','Type', true));

					echo $this->Bl->sdiv(array('class' => 'list_container'));
						echo $this->Text->toList($linkFilters, ' ', ' ');
					echo $this->Bl->ediv();
				echo $this->Bl->ediv();
					
				echo $this->Bl->floatBreak();
			echo $this->Bl->ediv();
		echo $this->Bl->ediv();
		
	echo $this->Bl->eboxContainer();
	
	$ajax_request = $ajax->remoteFunction(array(
		'url' => array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'render_table'),
		'update' => 'dashboard_table',
		'loading' => "$('dashboard_table').setLoading();",
		'complete' => "$('dashboard_table').unsetLoading();"
	));
	
	// The popups called after success or failure of "Mark as draft" or "Publish"
	echo $this->Popup->popup('draft_alert_ok', array(
		'type' => 'notice',
		'title' => __d('dashboard','Notice of marking as draft success - TITLE',true),
		'content' => __d('dashboard','Notice of marking as draft success - TEXT',true),
		'actions' => array('ok' => 'OK'),
		'callback' => "if (action == 'ok') { ".$ajax_request." }"
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
		'callback' => "if (action == 'ok') { ".$ajax_request." }"
	));
			
	echo $this->Popup->popup('publish_alert_failure', array(
		'type' => 'error',
		'title' => __d('dashboard','Notice of publishing failure - TITLE',true),
		'content' => __d('dashboard','Notice of publishing failure - TEXT',true),
		'actions' => array('ok' => 'OK')
	));
	
	
	echo $this->Popup->popup('delete_alert_confirmation', array(
		'type' => 'notice',
		'title' => __d('dashboard','Confirm the delete - TITLE',true),
		'content' => __d('dashboard','Confirm the delete - TEXT',true),
		'actions' => array('yes' => __d('dashboard','DELETE - YES',true), 'no' => __d('dashboard','DELETE - NO',true)),
		'callback' => "
			if (action == 'yes')
			{
				new Ajax.Request(deleteID, { 
					parameters: {
						format: 'json'
					},
					onLoading : function() { $('dashboard_table').setLoading(); },
					onSuccess: function (response,json) { 
						$('dashboard_table').unsetLoading();
						if (response.responseJSON.success)
							showPopup('delete_alert_ok'); 
						else
							showPopup('delete_alert_failure');
					}
				});
			}"
	));
	
	echo $this->Popup->popup('delete_alert_ok', array(
		'type' => 'notice',
		'title' => __d('dashboard','Notice of delete success - TITLE',true),
		'content' => __d('dashboard','Notice of delete success - TEXT',true),
		'actions' => array('ok' => 'OK'),
		'callback' => "if (action == 'ok') { ".$ajax_request." }"
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
