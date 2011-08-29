<?php
	//@todo Make it different when it doesn't have any languages
	if ($this->Session->check('Tradutore.currentLanguage'))
	{
		echo $this->Bl->scontrolBox();
			
			$lang = 'Language name: '.$this->Session->read('Tradutore.currentLanguage');
			echo $this->Bl->h3Dry(
				$this->Bl->spanDry(__('backstage','Editing', true))
				.  sprintf(__('backstage',' the %s version.',true),__('backstage',$lang,true))
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