<?php

echo $this->Bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));

	$h1Text = __('Backstage edit page: Editing a "'. $fullModelName . '"', true);

	if (isset($this->data[$modelName]['publishing_status']))
	{
		if ($this->data[$modelName]['publishing_status'] == 'draft')
		{
			$publishStyle = 'display: none';
			$draftStyle = ''; 
		}
		else
		{
			$publishStyle = '';
			$draftStyle = 'display: none';
		}
		
		//@todo Implement the ajax funcionality through the Bricklayer, to make it customizable.
		//@todo Publish option should only be available when the document is validated.
		
		$draftLink = $ajax->link(__('Backstage edit page: publish', true), 
			array('action' => 'set_publishing_status', $contentPlugin, Inflector::underscore($modelName), $this->data[$modelName]['id'],'published'),
			array('complete' => "if(request.responseJSON.success) { $('edit_page_title_draft').hide(); $('edit_page_title_published').show()} else {alert('".__('Backstage edit page: Could change publishing status: communication error.',true)."')}"));
		$draftText = sprintf(__('Now, this document is hidden. You can %s.', true), $draftLink);
		
		$publishLink = $ajax->link(__('Backstage edit page: mark it as draft', true), 
			array('action' => 'set_publishing_status', $contentPlugin, Inflector::underscore($modelName), $this->data[$modelName]['id'],'draft'),
			array('complete' => "if(request.responseJSON.success) { $('edit_page_title_published').hide(); $('edit_page_title_draft').show()} else {alert('".__('Backstage edit page: Could change publishing status: communication error.',true)."')}"));
		$publishText = sprintf(__('Now, this document is published. You can %s.',true), $publishLink);
			
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
	//@todo Really use the Tradutore tool.
	//debug($this->params);
	if (isset($this->data[$modelName]['languages']))
	{
		$linkList = array();
		foreach($this->data[$modelName]['languages'] as $lang)
		{
			$linkList[] = array('name' => __('Language name: '.$lang, true), 'url' => Router::url(am(array('language' => $lang), $this->params['pass'])));
		}
		$tmp = $this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList and', true), 'linkList' => $linkList));	
		
		echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
			sprintf (__('This content already has translations for %s.',true), $tmp));
			
		echo $this->Bl->brDry();
			
		$missingLanguages =	array_diff(Configure::read('Tradutore.languages'), $this->data[$modelName]['languages']);
		
		if (!empty($missingLanguages))
		{
			$linkList = array();
			foreach($missingLanguages as $lang)
			{
				$linkList[] = array('name' => __('Language name: '.$lang, true), 'url' => Router::url(am(array('language' => $lang), $this->params['pass'])));
			}
			echo $this->Bl->p(
				array('class' => 'small_text'), 
				array('escape' => false),
				sprintf (
					__('Backstage edit page: If you want you can create a version for %s',true),
					$this->Bl->anchorList(array(),array('lastSeparator' => __('anchorList or', true), 'linkList' => $linkList))
				)
			);
		}		
	}
	if ($this->Session->check('Tradutore.currentLanguage'))
	{
		echo $this->Bl->scontrolBox();
			
			echo $this->Bl->h3(array(), array('escape' => false), $this->Bl->spanDry(
				__('backstage edit page: Editing', true))
				.  sprintf(__(' the %s version.',true),__('Language name: '.$this->Session->read('Tradutore.currentLanguage'),true))
			);

			$tmp = $this->Bl->anchorList(array(),array(
					'lastSeparator' => __('anchorList or', true),
					'linkList' => array(
						array('name' => __('mark it as ready',true), 'url' => "www.google.com.br"),
						array('name' => __('remove it',true), 'url' => "www.google.com.br")
					)
				)
			);
			/*
			echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
					sprintf(__('Version marked as draft. You can %s.',true), $tmp));
			*/
			
		echo $this->Bl->econtrolBox();
	}
	
	
	echo $this->Popup->popup('error',
		array(
			'type' => 'error',
			'title' => __('Backstage edit page: Your data cannot be saved - TITLE.',true),
			'content' => __('Backstage edit page: Your data cannot be saved - TEXT.', true)
		)
	);
	$dashboard_url = $this->Html->url(array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'));
	echo $this->Popup->popup('notice',
		array(
			'type' => 'notice',
			'title' => __('Backstage edit page: Your data has been saved - TITLE.',true),
			'content' => __('Backstage edit page: Your data has been saved - TEXT.',true),
			'actions' => array('ok' => 'ok'),
			'callback' => "if (action=='ok') window.location = '$dashboard_url';"
		)
	);
	
	
	echo $buro->insertForm($fullModelName);
	
	
echo $this->Bl->ebox();

					 
?>