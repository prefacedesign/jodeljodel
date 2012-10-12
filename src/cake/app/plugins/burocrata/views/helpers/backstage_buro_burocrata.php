<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/**
 * Version of Burocrata Helper for backstage
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 */
 
/**
 * Importing of main burocrata class.
 */
App::import('Helper', 'Burocrata.BuroBurocrata');

/**
 * Version of Burocrata Helper for backstage
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 */
class BackstageBuroBurocrataHelper extends BuroBurocrataHelper
{

/**
 * Creates a box containing a submit button, a cancel link and some publising controls
 * 
 * @access public
 * @todo Use return intead using echo
 */
	function submitBox($htmlAttributes = array(), $options = array())
	{
		$defaultHtmlAttr = array(
			'class' => array('save_box')
		);
		$defaultOptions = array(
			'submitLabel' => __d('backstage','Save', true),
			'cancelLabel' => __d('backstage','Save box: cancel this change.',true),
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
							array('name' => __d('backstage','mark it as ready',true), 'url' => "#"),
							array('name' => __d('backstage','remove it',true), 'url' => "#")
						)
					)
				);
				echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
						sprintf(__d('backstage','Version marked as draft. You can %s.',true), $tmp));
			}	
			echo $this->submit(array(), array('label' => $options['submitLabel']));
			
			echo $this->Bl->sp(array('class' => 'alternative_option'), array());
				echo ', ';
				echo __('anchorList or',true);
				echo ' ';
				echo $this->Bl->anchor(array(),array('url' => $options['cancelUrl']),$options['cancelLabel']);
			echo $this->ep();
			echo $this->Bl->floatBreak();
		echo $this->Bl->econtrolBox();
	}
}