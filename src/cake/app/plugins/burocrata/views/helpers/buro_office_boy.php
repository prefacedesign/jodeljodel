<?php

/**
 * BuroOfficeBoy helper.
 *
 * Creates all javascript necessary for BuroBurocrataHelper work.
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.view.helpers
 */
class BuroOfficeBoyHelper extends AppHelper
{

/**
 * Other helpers used by OfficeBoy
 * 
 * @var array
 * @access public
 */
	public $helpers = array('Html', 'Ajax', 'Js' => 'prototype');


/**
 * Callbacks tamplate
 *
 * @var array
 * @access protected
 */
	protected $callbacks = array(
		'form' => array(
			'onStart' => 'function(form){%s}',
			'onSave' => 'function(form, response, json, saved){%s}',
			'onReject' => 'function(form, response, json, saved){%s}',
			'onSuccess' => 'function(form, response, json){%s}',
			'onComplete' => 'function(form, response){%s}',
			'onFailure' => 'function(form, response){%s}',
			'onError' => 'function(code, error){%s}'
		),
		'autocomplete' => array(
			'onStart' => 'function(input){%s}',
			'onShow' => 'function(element, update){%s}',
			'onHide' => 'function(element, update){%s}',
			'onSelect' => 'function(input, pair, element){%s}',
			'onSuccess' => 'function(input, response, json){%s}',
			'onUpdate' => 'function(input, response){%s}',
			'onFailure' => 'function(input, response){%s}',
			'onError' => 'function(code, error){%s}'
		),
		'ajax' => array(
			'onStart' => 'function(){%s}',
			'onSuccess' => 'function(response, json){%s}',
			'onComplete' => 'function(response){%s}',
			'onFailure' => 'function(response){%s}',
			'onError' => 'function(code, error){%s}'
		),
		'belongsto' => array(
			'onShowForm' => 'function(to_edit){%s}',
			'onShowPreview' => 'function(id){%s}'
		)
	);


/**
 * Creates the javascript counter-part of one autocomplete input.
 *
 * @access public
 * @param string $form_id The form dom ID
 * @param array $options An array that must contains some attributes that defines the current form
 * @return string The javascript code generated
 */
	public function autocomplete($options = array())
	{
		$this->_includeScripts();
		
		$options = am(array('callbacks' => array()), $options);
		extract($options);
		
		unset($options['url']);
		unset($options['baseID']);
		unset($options['callbacks']);
		
		$options = $this->Js->object($options);
		$script = sprintf("new BuroAutocomplete('%s','%s', %s)", $this->url($url), $baseID, $options);
		
		if(!empty($callbacks) && is_array($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatCallbacks('autocomplete', $callbacks));
		
		return $this->addHtmlEmbScript($script);
	}


/**
 * Creates the javascript counter-part of one form.
 *
 * @access public
 * @param string $form_id The form dom ID
 * @param array $options An array that must contains some attributes that defines the current form
 * @return string The javascript code generated
 */
	public function newForm($options)
	{
		$this->_includeScripts();
		
		$options = am(array('callbacks' => array()), $options);
		extract($options);
		
		$script = sprintf("new BuroForm('%s','%s')",$this->url($url), $baseID);
		
		if(!empty($callbacks) && is_array($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatCallbacks('form', $callbacks));
		
		return $this->addHtmlEmbScript($script);
	}


/**
 * Create a javascript thats performs a ajax request.
 *
 * ### Possible attributes passed
 *
 * - `url` - URL. No default.
 * - `params` - A list of params that will populate the POST data. Defaults to nothing.
 * - `callbacks` - The list of callbacks. Defaults to nothing.
 *
 * @access public
 * @param array $options
 * @return string The javascript of a new Ajax call
 */
	public function ajaxRequest($options)
	{
		$this->_includeScripts();
		
		$defaults = array(
			'url' => false,
			'params' => array(),
			'callbacks' => array()
		);
		$options = am($defaults, $options);
		extract($options);
		unset($options);
		
		if(!is_array($params))
			$params = array($params);
		
		$View = ClassRegistry::getObject('View');
		if(isset($View->viewVars['layout_scheme']))
			$params['data[_b][layout_scheme]'] = $View->viewVars['layout_scheme'];
		
		$url = $this->url($url);
		$callbacks = $this->formatCallbacks('ajax', $callbacks);
		$ajax_options = array();
		
		foreach($params as $k => $param)
		{
			if(is_numeric($k))
			{
				$ajax_options['parameters'][] = $param;
				continue;
			}
			
			if(substr($param,0,1) == '@' && substr($param,-1) == '@')
				$param = '"+(' . substr($param,1,-1) . ')+"';
			
			if(is_string($k))
				$ajax_options['parameters'][] = $k . '=' . $param;
		}
		$ajax_options = '{parameters: "' . implode('&', $ajax_options['parameters']) . '"}';
		
		return sprintf("new BuroAjax('%s',%s,%s)", $url, $ajax_options, $callbacks);
	}


/**
 * Creates the javascript counter-part of the belongsTo input
 *
 * @access public
 * @param array $options
 * @return string The HTML <script> tag
 */
	public function belongsTo($options)
	{
		$defaults = array('callbacks' => array());
		extract(am($defaults, $options));
		
		$callbacks = $this->formatCallbacks('belongsto', $callbacks);
		$script = sprintf("new BuroBelongsTo('%s','%s'%s);", $baseID, $autocomplete_baseID, (empty($callbacks) ? '':','.$callbacks));
		return $this->addHtmlEmbScript($script);
	}


/** 
 * Function to add the script in HTML
 *
 * @access protected
 * @param string $script The script that will be appended
 * @return string The pice of code ready for HTML
 */
	protected function addHtmlEmbScript($script)
	{
		if(!$this->Ajax->isAjax())
			$script = $this->Js->domReady($script);
		return $this->Html->scriptBlock($script);
	}


/** 
 * Handles the array of callbacks and converts it to javascript
 *
 * @access protected
 * @param string $type Type of interface where the callbacks will be attached
 * @param array $callbacks One associative array that contains all configurable callbacks for the form
 * @return string An javascript object that contains all registred callbacks
 */
	protected function formatCallbacks($type, $callbacks)
	{
		if(!is_array($callbacks))
			return null;
		
		$out = array();
		foreach($callbacks as $callback => $script)
		{
			if(!isset($this->callbacks[$type][$callback]))
				continue;
			
			if(is_string($script))
				$script = array($script => null);
			
			$js = sprintf($this->callbacks[$type][$callback], $this->_parseScript($script));
			
			$out[] = $callback . ':' . $js;
		}
		
		return '{' . implode(', ', $out) . '}';
	}


/**
 * Converts an array to javascript using the jodel convention
 *
 * @access protected
 * @param mixed $script
 * @return string The adequate function script for context
 */
	protected function _parseScript($script)
	{
		if(!is_array($script)) return null;
		
		$js = '';
		foreach($script as $type => $code)
		{
			if(is_numeric($type))
				$type = $code;
			$js .= $this->{'_'.$type}($code) . ' ';
		}
		
		return $js;
	}


/**
 * Generates the script that resets the content of form
 * Only works with forms callbacks
 *
 * @access protected
 * @param mixed $script
 * @return string The formated script
 */
	protected function _resetForm($script)
	{
		return 'form.reset();';
	}


/**
 * Generates the script that locks the content of form
 * Only works with forms callbacks
 *
 * @access protected
 * @param mixed $script
 * @return string The formated script
 */
	protected function _lockForm($script)
	{
		return 'form.lock();';
	}


/**
 * Generates the script that locks the content of form
 * Only works with forms callbacks
 *
 * @access protected
 * @param mixed $script
 * @return string The formated script
 */
	protected function _unlockForm($script)
	{
		return 'form.unlock();';
	}


/**
 * Generates the script that updates the content of form, based on json response content
 *
 * ###It may be called in many formats:
 *
 *  - `array('contentUpdate')` - updates the form content with the returned content
 *  - `array('contentUpdate' => 'update')` - same of previous item
 *  - `array('contentUpdate' => 'replace')` - replaces the form by the returned content
 *  - `array('contentUpdate' => array('update' => 'my_element_id'))` - updates the element "my_element_id" content with the returned content
 *  - `array('contentUpdate' => array('replace' => 'my_element_id'))` - replaces the element "my_element_id" by the returned content
 *
 * Note that if no element_id was given, is assumed that it is a form callback
 * 
 * @access protected
 * @param mixed $script
 * @return string The formated script
 */
	protected function _contentUpdate($script)
	{
		if(!is_array($script))
			$script = array($script);
		
		foreach($script as $action => $id)
		{
			if(!in_array($action, array('update', 'replace'), true))
				$action = $id;
				
			if($action == 'contentUpdate')
				$action = $id = 'update';
			
			switch($action)
			{
				case 'replace':
				case 'update':
					if($id == $action)
						$script = "form.$action(json.content);";
					else
						$script = "$('$id').$action(json.content);";
					break;
				
				default:
					$script = "$('$id').update(json.content);";
					break;
			}
			break;
		}
		return $script;
	}


/**
 * Just escapes a string to be JSON friendly.
 *
 * @access protected
 * @param mixed $script 
 * @return string The formated script
 */
	protected function _js($script)
	{
		return $script;
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
 * @access protected
 * @param mixed $msg
 * @return string The formated script
 */
	protected function _popup($msg)
	{
		return $this->Js->alert((string) $msg);
	}


/**
 * Renders a Ajax.Resquest or a Ajax.Updater
 *
 * @access protected
 * @param array $options
 * @return string The formated script
 */
	protected function _ajax($options)
	{
		return $this->ajaxRequest($options);
	}


/**
 * Includes the necessary script files to burocrata works
 *
 * @access protected
 */
	protected function _includeScripts()
	{
		$this->Html->script('prototype', array('inline' => false));
		$this->Html->script('effects', array('inline' => false));
		$this->Html->script('controls', array('inline' => false));
		$this->Html->script('/burocrata/js/burocrata.js', array('inline' => false));
	}
}