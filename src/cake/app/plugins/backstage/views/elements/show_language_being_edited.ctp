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

	$languages = Configure::read('Tradutore.languages');
	if (count($languages) > 1)
	{
		echo $this->Bl->scontrolBox();
			
			$lang = 'Language name: '.$this->Session->read('Tradutore.currentLanguage');
			echo $this->Bl->h3Dry(
				$this->Bl->spanDry(__d('backstage','Editing', true))
				. ' '
				.  sprintf(__d('backstage',' the %s version.',true),__d('backstage',$lang,true))
			);

			if (isset($this->data[$modelName]['translate_publishing_status']) && $can_edit_publishing_status)
			{
				if ($this->data[$modelName]['translate_publishing_status'] == 'draft')
				{
					$publishStyle = 'display: none';
					$draftStyle = ''; 
				}
				else
				{
					$publishStyle = '';
					$draftStyle = 'display: none';
				}
				
				$draftLink = $ajax->link(__('Backstage edit page: publish', true), 
					array('controller' => 'back_contents', 'action' => 'set_publishing_status', $moduleName, $this->data[$modelName]['translate_id'], 'published', $this->Session->read('Tradutore.currentLanguage')),
					array('complete' => "if(request.responseJSON.success) { $('edit_page_translate_title_draft').hide(); $('edit_page_translate_title_published').show()} else {alert('".__('Backstage edit page: Could change publishing status: communication error.',true)."')}"));
				$draftText = sprintf(__d('backstage', 'Now, this version is hidden. You can %s.', true), $draftLink);
				
				$publishLink = $ajax->link(__('Backstage edit page: mark it as draft', true), 
					array('controller' => 'back_contents', 'action' => 'set_publishing_status', $moduleName, $this->data[$modelName]['translate_id'],'draft', $this->Session->read('Tradutore.currentLanguage')),
					array('complete' => "if(request.responseJSON.success) { $('edit_page_translate_title_published').hide(); $('edit_page_translate_title_draft').show()} else {alert('".__('Backstage edit page: Could change publishing status: communication error.',true)."')}"));
				$publishText = sprintf(__d('backstage', 'Now, this version is published. You can %s.',true), $publishLink);
				
				echo $this->Bl->p(
					array('id' => 'edit_page_translate_title_draft', 'class' => 'small_text', 'style' => $draftStyle), 
					array('escape' => false),
					$draftText
				);
				
				echo $this->Bl->p(
					array('id' => 'edit_page_translate_title_published', 'class' => 'small_text', 'style' => $publishStyle), 
					array('escape' => false),
					$publishText
				);
			}
			
		echo $this->Bl->econtrolBox();
	}
