<?php
	//@todo Make it different when it doesn't have any languages
	if ($this->Session->check('Tradutore.currentLanguage'))
	{
		echo $this->Bl->scontrolBox();
			
			echo $this->Bl->h3(array(), array('escape' => false), $this->Bl->spanDry(
				__('backstage edit page: Editing', true))
				.  sprintf(__(' the %s version.',true),__('Language name: '.$this->Session->read('Tradutore.currentLanguage'),true))
			);

			/* When we will have the ready versions
			$tmp = $this->Bl->anchorList(array(),array(
					'lastSeparator' => __('anchorList or', true),
					'linkList' => array(
						array('name' => __('mark it as ready',true), 'url' => "www.google.com.br"),
						array('name' => __('remove it',true), 'url' => "www.google.com.br")
					)
				)
			);
			
			echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
					sprintf(__('Version marked as draft. You can %s.',true), $tmp));
			*/
			
		echo $this->Bl->econtrolBox();
	}