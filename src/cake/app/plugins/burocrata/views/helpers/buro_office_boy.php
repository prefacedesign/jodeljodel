<?php
class BuroOfficeBoyHelper extends AppHelper
{
	var $helpers = array('Html', 'Js' => 'prototype');
	

/**
 * Creates the javascript counter-part of one form.
 *
 * @access public
 * @param string $form_id The form dom ID
 * @param array $attributes An array that must contains some attributes that defines the current form
 * @return boolean True if the javascript was sucefully generated, false, otherwise
 */
	public function newForm($form_id, $attributes)
	{
		$this->Html->script('prototype', array('inline' => false));
		$this->Html->script('/burocrata/js/burocrata.js', array('inline' => false));
		
		$attributes = am(array('callbacks' => array()), $attributes);
		extract($attributes);
		
		$script = sprintf(
			"new BuroForm('%s','%s','%s')",
			$this->url($url), $form_id, $submit
		);
		if(!empty($callbacks) && is_array($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatFormCallbacks($callbacks));
		
		$this->Js->buffer($script);
		$this->Js->writeBuffer(array('inline' => false));
	}
	

/**
 * Handles the array of callbacks and converts it to javascript
 *
 * @access protected
 * @param array $callbacks One associative array that contains all configurable callbacks for the form
 * @return string An javascript object that contains all registred callbacks
 */	
	protected function formatFormCallbacks($callbacks)
	{
		if(!is_array($callbacks))
			return null;
		
		$out = array();
		foreach($callbacks as $callback => $script)
		{
			if(is_string($script))
				$script = array($script => null);
			$out[] = $callback . ': ' . $this->_parseScript($script, $callback);
		}
		
		return '{' . implode(', ', $out) . '}';
	}
	

/**
 * Converts one callback to its specific format script
 *
 * @access public
 * @param mixed $script
 * @param script $callback
 * @return string The adequate function script for context
 */
	protected function _parseScript($script, $callback)
	{
		if(!is_array($script)) return null;
		
		$js = '';
		foreach($script as $type => $code)
		{
			if(is_numeric($type))
				$type = $code;
			$js .= $this->{'_'.$type}($code) . ' ';
		}
		
		$out = '';
		switch($callback)
		{
			case 'onStart':
				$out = sprintf('function(form) { %s}', $js);
				break;
			
			case 'onSave':
			case 'onReject':
				$out = sprintf('function(form, response, json, saved) { %s}', $js);
				break;
			
			case 'onSuccess':
				$out = sprintf('function(form, response, json) { %s}', $js);
				break;
			
			case 'onComplete':
			case 'onFailure':
			default:
				$out = sprintf('function(form, response) { %s}', $js);
				break;
		}
		return $out;
	}


/**
 * Generates the script that locks the content of form
 *
 * @access public
 * @param mixed $script
 * @return string The formated script
 */
	protected function _lockForm($script)
	{
		return 'form.lock();';
	}


/**
 * Generates the script that locks the content of form
 *
 * @access public
 * @param mixed $script
 * @return string The formated script
 */
	protected function _unlockForm($script)
	{
		return 'form.unlock();';
	}


/**
 * Generates the script that updates the content of form, based on json response
 *
 * @access public
 * @param mixed $script
 * @return string The formated script
 */
	protected function _contentUpdate($script)
	{
		return 'form.update(json.content);';
	}


/**
 * Just escapes a string to be JSON friendly.
 *
 * @access public
 * @param mixed $script 
 * @return string The formated script
 */
	protected function _js($script)
	{
		return $this->Js->escape($script);
	}


	/**
	 * Formats a redirect script
	 *
	 * @access protected
	 * @param mixed $url
	 * @return string The formated script
	 */
	protected function _redirect($url)
	{
		return $this->Js->redirect($url);
	}


	/**
	 *
	 * @access public
	 * @param mixed $msg
	 * @return string The formated script
	 */
	protected function _popup($msg)
	{
		return $this->Js->alert((string) $msg);
	}
}