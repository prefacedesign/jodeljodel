<?php
$this->Html->script('prototype', array('inline' => false));
$this->Html->script('/backstage/js/core.js', array('inline' => false));
$this->Html->script('/backstage/js/backstage.js', array('inline' => false));

echo $this->Bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
	echo $this->Bl->h1Dry(__d('backstage','Page title header - BackstageCustom module '.$moduleName, true));
	echo $this->Bl->sboxContainer(array('class' => 'dash_toolbox'),array('size' => array('M' => 12, 'g' => -1)));	
		$url = array(
			'language' => $mainLanguage,
			'plugin' => 'backstage','controller' => 'back_contents',
			'action' => 'edit', $moduleName
		);
							
		echo $this->Bl->sdiv(array('id' => 'dash_link_to_additem', 'class' => 'expanded'));
			echo $this->Bl->anchor(array(), compact('url'), __d('backstage','Add new '.$moduleName,true));
		echo $this->Bl->ediv();
		echo $bl->floatBreak();
	echo $this->Bl->eboxContainer();
	
	echo $this->Bl->sboxContainer(array(),array('size' => array('M' => 12, 'g' => -1)));
		echo $this->Bl->sdiv(array('class' => array('dash_filter')));
			echo $this->Bl->sdiv(array('id' => 'dash_filter_list'));
				echo $this->Bl->sdiv(array('class' => 'filters'));
				
					// SEARCH INPUT		
					$this->Html->scriptBlock($this->Js->domReady("
						new SearchInput('dash_search');
					"), array('inline' => false));
					
					echo $this->Bl->h4Dry(__d('dashboard','Text', true));
					
					echo $this->Bl->sdiv(array('class' => array('dash_search')));
						echo $form->input('dash_search', array('label' => __d('dashboard','or search for a content previously inserted',true)));
						echo $ajax->observeField('dash_search', 
							array(
								'url' => array('action' => 'search', $moduleName),
								'frequency' => 2.5,
								'loading' => "$('backstage_custom_table').setLoading(); ",
								'complete' => "$('backstage_custom_table').unsetLoading();",
								'update' => 'backstage_custom_table'
							) 
						); 
					echo $this->Bl->ediv();
					echo $bl->floatBreak();
				echo $this->Bl->ediv();
				
				
				echo $this->Bl->sdiv(array('class' => 'filters'));
					echo $this->Bl->h4Dry(__d('dashboard','Status', true));
					$linkFilters = array();
					$modulesCount = count($backstageSettings['statusOptions']);
					foreach($backstageSettings['statusOptions'] as $module)
					{
						$filterLink = $ajax->link(__d('dashboard', 'Dashboard status: ' . $module, true), 			
							array(
								'plugin' => 'backstage',
								'controller' => 'back_contents',
								'action' => 'filter_published_draft',
								$module,
								$moduleName
							), 
							array(
								'before' => "$('backstage_custom_table').setLoading();",
								'complete' => "$('backstage_custom_table').unsetLoading();",
								'id' => 'filter_published_draft_'.$module,
								'update' => 'backstage_custom_table'
							)
						);
						$linkFilters[] = $filterLink;
						if ($filter_status == $module)
							$selected = true;
						else
							$selected = false;
						$this->Html->scriptBlock($this->Js->domReady("
							new StatusFilter('filter_published_draft_$module', '$selected');
						"), array('inline' => false));
					}
					$filterLink = $ajax->link(__d('dashboard','Show All', true), 			
						array(
							'plugin' => 'backstage',
							'controller' => 'back_contents',
							'action' => 'filter_published_draft',
							'all',
							$moduleName
						), 
						array(
							'before' => "$('backstage_custom_table').setLoading();",
							'complete' => "$('backstage_custom_table').unsetLoading();",
							'id' => 'filter_published_draft_all',
							'update' => 'backstage_custom_table'
						)
					);
					$linkFilters[] = $filterLink;
					if ($filter_status == 'all' || empty($filter_status))
						$selected = true;
					else
						$selected = false;
					$this->Html->scriptBlock($this->Js->domReady("
						new StatusFilter('filter_published_draft_all', '$selected');
					"), array('inline' => false));
					echo $this->Text->toList($linkFilters, ' ', ' ');
				echo $this->Bl->ediv();
				echo $bl->floatBreak();
				echo $this->Bl->floatBreak();
			echo $this->Bl->ediv();
		echo $this->Bl->ediv();
		
	echo $this->Bl->eboxContainer();
	
	$ajax_request = $ajax->remoteFunction(array(
		'url' => array('plugin' => 'backstage', 'controller' => 'back_contents', 'action' => 'after_delete', $moduleName),
		'update' => 'backstage_custom_table',
		'loading' => "$('backstage_custom_table').setLoading();",
		'complete' => "$('backstage_custom_table').unsetLoading();"
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
						format: 'json',
					},
					onLoading : function() { $('backstage_custom_table').setLoading(); },
					onSuccess: function (response,json) { 
						$('backstage_custom_table').unsetLoading();
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
	
	echo $ajax->div('backstage_custom_table');
		echo $this->element('filter');
	echo $ajax->divEnd('backstage_custom_table');
echo $this->Bl->ebox();

?>