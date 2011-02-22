<?php

App::import('Helper', 'Burocrata.BuroBurocrata');

class BackstageBuroBurocrataHelper extends BuroBurocrataHelper
{
	function submitBox($htmlAttributes = array(), $options = array())
	{
		$defaultHtmlAttr = array(
			'class' => array('save_box')
		);
		$defaultOptions = array(
			'submitLabel' => __('Save', true),
			'cancelLabel' => __('Save box: cancel this change.',true),
			'publishControls' => false,
			'cancelUrl' => array('plugin' => 'dashboard', 'controller' => 'dash_dashboard')
		);
		$htmlAttributes = $this->_mergeAttributes($defaultHtmlAttr, $htmlAttributes);
		$options = am($defaultOptions, $options);
	
		echo $this->Bl->scontrolBox($htmlAttributes);

			if ($options['publishControls'])
			{
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
			}	
			echo $this->submit(array(), array('label' => $options['submitLabel']));
			
			echo $this->Bl->sp(array('class' => 'alternative_option'), array());
				echo ', ';
				echo __('anchorList or',true);
				echo $this->Bl->anchor(array(),array('url' => $options['cancelUrl']),$options['cancelLabel']);
			echo $this->ep();
			echo $this->Bl->floatBreak();
		echo $this->Bl->econtrolBox();
	}
}



?>
