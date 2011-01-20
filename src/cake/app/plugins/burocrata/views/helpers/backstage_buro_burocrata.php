<?php

App::import('Helper', 'Burocrata.BuroBurocrata');

class BackstageBuroBurocrataHelper extends BuroBurocrataHelper
{
	function submitBox($options = array())
	{
		$htmlAttributes = array();
		$htmlAttributes = $this->addClass($htmlAttributes, BuroBurocrataHelper::$defaultContainerClass);
		$htmlAttributes = $this->addClass($htmlAttributes, 'input');
		echo  $this->Bl->sdiv($htmlAttributes,array());
			if (!isset($options['label']))
				$options['label'] = 'Save';

			echo $this->Bl->scontrolBox();

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
				
				echo $this->submit(array(), array('label' => $options['label']));
				$a = $this->Bl->anchor(array(),array(
						'url' => array('plugin' => 'dashboard', 'controller' => 'dash_dashboard')
					),
					__('Save box: cancel this change.',true)
				);
				echo $this->Bl->sp(array('class' => 'alternative_option'), array());
					echo ', ';
					echo __('anchorList or',true);
					echo __($a,false);
				echo $this->ep();
				echo $this->Bl->floatBreak();
			echo $this->Bl->econtrolBox();
			echo $this->Bl->floatBreak();
		echo  $this->Bl->ediv();
		
	}
}



?>
