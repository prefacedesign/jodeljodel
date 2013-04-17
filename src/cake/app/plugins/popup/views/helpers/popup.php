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


/**
 * Popup helper.
 *
 * Creates the HTML and the Javascript for firing popups on the page
 *
 * @package       jodel
 * @subpackage    jodel.popup.view.helpers
 */
class PopupHelper extends AppHelper
{

/**
 * List of used helpers
 * 
 * @var array
 * @access public
 */
	var $helpers = array(
		'Html', 'Js' => 'prototype',
		'Burocrata.BuroOfficeBoy',
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl'
		),
		'Burocrata.*BuroBurocrata' => array(
			'name' => 'Buro'
		)
	);

	
/**
 * Create and return the popup element. The array of options accept:
 *   type - (required) type of the popup (the options are: error, success, notice, form)
 *   title - (not required) the title
 *   content - (not required) the content of the message (accept html code)
 *   actions - (not required) an array with the callbacks links 
 *   callback - (not required) javascript that recieve the link chosen
 *
 * @access public
 * @param string $id ID who identifies the popup
 * @param array $options array with the options
 * @return string The HTML and the Js of popup 
 */
	function popup($id, $options = array())
	{
		$options = am(
			array(
				'type' => 'notice',
				'title' => '',
				'content' => '',
				'actions' => array('ok' => 'Ok'),
				'callback' => ''
			),
			$options
		);
		$options['id'] = $id;
		$options['plugin'] = 'popup';
		
		$method = '_'.$options['type'];
		if (method_exists($this, $method))
			return call_user_func(array($this, $method), $options);
		
		return $this->_popup($options);
	}


/**
 * Creates a popup for data insertion. This method overwrites the action links,
 * to the classic OK oe cancel.
 * 
 * @access protected
 * @param array $options
 * @return string The element rendered
 */
	protected function _form($options)
	{
		$options['actions'] = $options['actions'] + array(
			'ok' => __d('popup','PopupHelper::_form - Ok button', true),
			'cancel' => __d('popup','PopupHelper::_form - Cancel link', true)
		);
		
		$buttonHtmlAttributes = array(
			'id' => uniqid('btn')
		);	
		$buttonOptions = array(
			'close_me' => false,
			'label' => $options['actions']['ok'],
			'cancel' => array(
				'label' => $options['actions']['cancel'],
				'htmlAttributes' => array('id' => uniqid('cancel'))
			)
		);
		$options['actions'] = $this->Buro->okOrCancel($buttonHtmlAttributes, $buttonOptions);
		$options['list_links'] = $this->Js->object(array(
			'ok' => $buttonHtmlAttributes['id'],
			'cancel' => $buttonOptions['cancel']['htmlAttributes']['id']
		));
		
		return $this->_popup($options);
	}
	
/**
 * Creates a popup with a progress bar and the necessary JS for the progress bar to work
 * 
 * The options for this popup are:
 *  -`url` array|string The URL that will be called after opening the popup
 *  -`url_cancel` array|string The URL that will be called after the user abort the proccess
 * 
 * 
 * @access protected
 */
	protected function _progress($options)
	{
		$options += array(
			'url' => null,
			'url_cancel' => null
		);
		
		$url = $this->Html->url($options['url']);
		$url_cancelar = isset($options['url_cancel']) ? $this->Html->url($options['url_cancel']) : '';
		
		// montando o conteúdo do popup
		$content[] = $this->Bl->div(array('class' => 'popup_loading'));
		$content[] = $this->Bl->div(array('class' => 'popup_message'));
		$content[] = $this->Bl->div(array('class' => 'popup_progress_bar'), array(), 
			$this->Bl->div(array('class' => 'popup_progress_bar_filler'))
		);
		$content[] = $this->BuroOfficeBoy->addHtmlEmbScript("
			$('{$options['id']}').observe('popup:opened', function(ev){
				$('{$options['id']}').down('.popup_message').update();
				$('{$options['id']}').down('.popup_progress_bar_filler').setStyle({width: 0});
				new ProgressPopup('$url', '{$options['id']}');
			});
		");
		
		// creating the JS callback for the buttons
		$callback = "if(action == 0) cancelProgress('{$options['id']}', '{$options['url_cancel']}');";
		
		// creting $options array
		$options['callback'] = $callback;
		$options['content'] = implode($content);
		$options['actions'] = array(__d('popup', 'Cancelar', true), __d('popup','Ok', true));
		
		return 
			$this->_popup($options)
			. $this->_popup(array(
				'type' => 'notice',
				'id' => $options['id'].'_cancelling',
				'title' => __d('popup', 'Wait for cancelling proccess', true),
				'content' => $this->Bl->div(array('class' => 'popup_loading')),
				'links_callbacks' => ''
			));
	}
	
/**
 * Call the popup element (base for every popup)
 * 
 * @access protected
 * @param array $options
 * @return string The element rendered
 */
	protected function _popup($options)
	{
		$View =& ClassRegistry::getObject('View');
		$options += array(
			'plugin' => 'popup',
			'callback' => ''
		);
		return $View->element('popup', $options);
	}
}
