<?php

echo $this->Bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));

	$editing = 'Editing a '. $type;
	$h1Text = __d('backstage', $editing, true);

	if (isset($this->data[$modelName]['publishing_status']))
	{
		$publishStyle = $draftStyle = '';
		if ($this->data[$modelName]['publishing_status'] == 'draft')
			$publishStyle = 'display: none';
		else
			$draftStyle = 'display: none';
		
		//@todo Implement the ajax funcionality through the Bricklayer, to make it customizable.
		//@todo Publish option should only be available when the document is validated.
		
		$draftLink = $ajax->link(__d('backstage', 'publish', true), 
			array('action' => 'set_publishing_status', $type, $this->data[$modelName]['id'],'published'),
			array('complete' => "if(request.responseJSON.success) { $('edit_page_title_draft').hide(); $('edit_page_title_published').show()} else {alert('".__d('backstage','Could not change publishing status: communication error.',true)."')}"));
		$draftText = sprintf(__d('backstage', 'Now, this document is hidden. You can %s.', true), $draftLink);
		
		$publishLink = $ajax->link(
			__d('backstage', 'mark it as draft', true), 
			array('action' => 'set_publishing_status', $type, $this->data[$modelName]['id'],'draft'),
			array('complete' => "if(request.responseJSON.success) { $('edit_page_title_published').hide(); $('edit_page_title_draft').show()} else {alert('".__d('backstage', 'Could not change publishing status: communication error.',true)."')}")
		);
		$publishText = sprintf(__d('backstage', 'Now, this document is published. You can %s.',true), $publishLink);
			
		echo $this->Bl->h1(array(), array(
				'additionalText' => $draftText, 
				'escape' => false,
				'contentDivAttr' => array('id' => 'edit_page_title_draft', 'style' => $draftStyle)
			), $h1Text);
		
		echo $this->Bl->h1(array(), array(
				'additionalText' => $publishText, 
				'escape' => false,
				'contentDivAttr' => array('id' => 'edit_page_title_published', 'style' => $publishStyle)
			), $h1Text);
	}
	else
	{
		//if it does not have publishing status you should not show the "publish" mini menu
		echo $this->Bl->h1(array(), array('escape' => false), $h1Text);
	}
echo $this->Bl->ebox();

echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	if (isset($this->data[$modelName]['languages']))
	{
		echo $this->element('language_edit_select', array('plugin' => 'backstage', 'translatedLanguages' => $this->data[$modelName]['languages']));
		echo $this->element('show_language_being_edited',array('plugin' => 'backstage'));
	}	
	
	
	echo $this->Popup->popup('error',
		array(
			'type' => 'error',
			'title' => __d('backstage','Your data cannot be saved - TITLE.',true),
			'content' => __d('backstage', 'Your data cannot be saved - TEXT.', true)
		)
	);
	$dashboard_url = $this->Html->url(array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'));
	echo $this->Popup->popup('notice',
		array(
			'type' => 'notice',
			'title' => __d('backstage', 'Your data has been saved - TITLE.',true),
			'content' => __d('backstage', 'Your data has been saved - TEXT.',true),
			'actions' => array(
				'ok' => __d('backstage', 'Your data has been saved - BACK TO DASHBOARD', true), 
				'edit' => __d('backstage', 'Your data has been saved - CONTINUE EDITING', true)
			),
			'callback' => "if (action=='ok') window.location = '$dashboard_url';"
		)
	);
	
	
	echo $buro->insertForm($fullModelName);
	
echo $this->Bl->ebox();
