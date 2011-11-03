<?php
/**
 * Office boy Helper for burocrata.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 */

/**
 * BuroOfficeBoy helper.
 *
 * Creates all javascript necessary for {@link BuroBurocrataHelper} work.
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 */
class BuroOfficeBoyHelper extends AppHelper
{

/**
 * Other helpers used by OfficeBoy
 * 
 * @access public
 * @var array
 */
	public $helpers = array('Html', 'Ajax', 'Js' => 'prototype');

/**
 * Callbacks template
 *
 * @access protected
 * @var array
 */
	protected $callbacks = array(
		'form' => array(
			'onStart' => 'function(form){%s}',
			'onSave' => 'function(form, response, json, saved){%s}',
			'onReject' => 'function(form, response, json, saved){%s}',
			'onSuccess' => 'function(form, response, json){%s}',
			'onComplete' => 'function(form, response){%s}',
			'onCancel' => 'function(form){%s}',
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
			'onError' => 'function(code, error, json){%s}'
		),
		'relational_unitary' => array(
			'onAction' => 'function(action, id){%s}',
			'onShowForm' => 'function(to_edit){%s}',
			'onShowPreview' => 'function(id){%s}'
		),
		'relational_editable' => array(
			'onAction' => 'function(action, id){%s}',
			'onShowForm' => 'function(to_edit){%s}',
			'onShowPreview' => 'function(id){%s}',
			'onAddNew' => 'function(id){%s}'
		),
		'upload' => array(
			'onStart' => 'function(input){%s}',
			'onSave' => 'function(input, json, saved){%s}',
			'onReject' => 'function(input, json, saved){%s}',
			'onSuccess' => 'function(input, json){%s}',
			'onFailure' => 'function(input, json){%s}',
			'onComplete' => 'function(input, response){%s}',
			'onRestart' => 'function(){%s}',
			'onError' => 'function(code, error, json){%s}'
		),
		'listOfItems' => array(
			'onShowForm' => 'function(id){%s}',
			'onAction' => 'function(action, id, content_type){%s}',
			'onError' => 'function(json){%s}',
		),
		'color' => array(
			'onPickColor' => 'function(ev){%s}',
			'onDragPicker' => 'function(ev){%s}',
		)
	);

/**
 * An array of all created scripts. If is not a Ajax call, then it
 * is used to print all script in one single blok on <head>
 * 
 * @access protected
 * @var array
 */
	protected $scripts = array();

/**
 * afterRender callback used for print automagically all created scripts on HTML <head>
 * when it is not a Ajax request
 * 
 * @access public
 */
	public function afterRender()
	{
		$View = ClassRegistry::getObject('view');
		if ($View && !$this->Ajax->isAjax())
		{
			
			$this->Html->script('prototype', array('inline' => false));
			$this->Html->script('effects', array('inline' => false));
			$this->Html->script('controls', array('inline' => false));
			$this->Html->script('slider', array('inline' => false));
			$this->Html->script('/dashboard/js/core.js', array('inline' => false));
			$this->Html->script('/burocrata/js/burocrata.js', array('inline' => false));
			$this->Html->script('/burocrata/js/color-picker.js', array('inline' => false));
			$this->Html->script('/popup/js/popup.js', array('inline' => false));
			$this->Html->scriptBlock('var debug = ' . Configure::read() . ';', array('inline' => false));

			$script = implode("\n", $this->scripts);
			if (Configure::read('debug'))
				$script = sprintf('try{ %s }catch(e){ console.log(e); }', $script);
			
			$View->addScript($this->Html->scriptBlock($this->Js->domReady($script)));
		}
	}

/**
 * Creates the javascript counter-part of one autocomplete input.
 *
 * @access public
 * @param string $form_id The form dom ID
 * @param array $options An array that must contains some attributes that defines the current form
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function autocomplete($options = array())
	{
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
 * ### The list of options is:
 *
 * - `baseID` string Used to identify this form (all inputs inside this form will have the `form` param with this string)
 * - `url` string|array The url for POSTing the form data
 * - `callbacks` array An list of accepted callbacks
 *
 * @access public
 * @param string $form_id The form dom ID
 * @param array $options An array that must contains some attributes that defines the current form
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function newForm($options)
	{
		$options = am(array('callbacks' => array()), $options);
		extract($options);
		
		$script = sprintf("new BuroForm('%s','%s')",$this->url($url), $baseID);
		
		if(!empty($callbacks) && is_array($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatCallbacks('form', $callbacks));
		
		if (!empty($parameters))
			$script .= sprintf('.addParameters(%s)', $this->Js->object($parameters));
		
		return $this->addHtmlEmbScript($script);
	}

/**
 * Creates the javascript counter-part of the RelationalUnitaryAutocomplete input
 *
 * ### The list of options is:
 *
 * - `baseID` string Used to build all DOM ID of this input
 * - `autocomplete_baseID` string Used to build all DOM ID of the autocomplete input
 * - `callbacks` array An list of accepted callbacks
 *
 * @access public
 * @param array $options
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function relationalUnitaryAutocomplete($options)
	{
		$defaults = array('callbacks' => array());
		extract(am($defaults, $options));
		
		$callbacks = $this->formatCallbacks('relational_unitary', $callbacks);
		$script = sprintf("new BuroBelongsTo('%s','%s',%s%s);", $baseID, $autocomplete_baseID, $update_on_load?'true':'false', (empty($callbacks) ? '':','.$callbacks));
		return $this->addHtmlEmbScript($script);
	}

/**
 * Creates the javascript counter-part of the RelationalEditableList input
 * 
 * - `edit_item_text` string The label for the link 'edit'
 * - `view_item_text` string The label for the link 'view'
 * - `delete_item_text` string The label for the link 'delete'
 *
 * @access public
 * @param array $options
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function relationalEditableList($options)
	{
		$options += array('callbacks' => array());
		extract($options);
		
		$content = $this->Js->object(compact('texts', 'templates', 'contents'));
		$callbacks = $this->formatCallbacks('relational_editable', $callbacks);
		$script = sprintf("new BuroEditableList('%s','%s',%s,%s)", $baseID, $autocomplete_baseID, $content, $callbacks);
		
		return $this->addHtmlEmbScript($script);
		
	}

/**
 * Creates the javascript counter-part of the ordered list of items based on the given options
 * 
 * ### The options are:
 * - `texts` array An string indexed array containing all the texts needed on interface
 * - `templates` array An string indexed array containing HTML templates to be filled with content
 * - `contents` array An numeric indexed array with the data generated by the elements, already ordered by weight
 * 
 * @access public
 * @param array $options a list of options including `callbacks`,`baseID`
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function listOfItems($options)
	{
		$options += array('callbacks' => array(), 'baseID' => uniqid(), 'texts' => array());
		extract($options);
		unset($options);
		
		$parameters = $this->Js->object($parameters);
		$content = $this->Js->object(compact('texts', 'templates', 'contents', 'url'));
		
		$className = $auto_order ? 'BuroListOfItemsAutomatic' : 'BuroListOfItems';
		
		$script = sprintf("new %s('%s', %s, %s)", $className, $baseID, $parameters, $content);
		if (!empty($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatCallbacks('listOfItems', $callbacks));
		return $this->addHtmlEmbScript($script);
	}

/**
 * Creates the javascript for upload input.
 * 
 * @access public
 * @param array $options
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function upload($options)
	{
		$defaults = array('callbacks' => array(), 'baseID' => uniqid(), 'url' => '', 'error' => array());
		extract(am($defaults, $options));
		unset($defaults);
		
		if (!empty($error)) $error = $this->Js->object($error);
		else $error = '{}';
		
		if (!empty($parameters)) $parameters = $this->Js->object($parameters);
		else $parameters = '{}';
		
		$script = sprintf("new BuroUpload('%s', '%s', %s, %s)", $baseID, $url, $error, $parameters);
		if(!empty($callbacks) && is_array($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatCallbacks('upload', $callbacks));
		
		return $this->addHtmlEmbScript($script);
	}

/**
 * Creates the javascript for textile input.
 * 
 * @access public
 * @param array $options
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function textile($options)
	{	
		$defaults = array('callbacks' => array(), 'baseID' => uniqid());
		extract(am($defaults, $options));
		
		$script = sprintf("new BuroTextile('%s')", $baseID);
		
		return $this->addHtmlEmbScript($script);
	}

/**
 * Creates the JS object for the input.
 * 
 * @access public
 * @param array $options
 * @return string|void The the result of addHtmlEmbScript
 * @see BuroOfficeBoyHelper::addHtmlEmbScript()
 */
	public function color($options)
	{
		$options += array('callbacks' => array(), 'baseID' => uniqid());
		extract($options);
		
		$script = sprintf("new BuroColorPicker('%s')", $baseID);
		if(!empty($callbacks) && is_array($callbacks))
			$script .= sprintf('.addCallbacks(%s)', $this->formatCallbacks('upload', $callbacks));
		
		return $this->addHtmlEmbScript($script);
	}

/** 
 * Function to add the script in HTML.
 * 
 * It is an Ajax request, this method returns the javascript inside 
 * an <script> tag. If is not an Ajax request, it puts the script on
 * buffer to be echoed on <head> tag of HTML.
 *
 * @access public
 * @param string $script The script that will be appended
 * @return string|void The pice of code ready for HTML or nothing (if the script was put on buffer)
 */
	public function addHtmlEmbScript($script)
	{
		if($this->Ajax->isAjax())
			return $this->Html->scriptBlock($script);
		else
			$this->scripts[] = $script;
	}

/**
 * Create a javascript thats performs a ajax request.
 *
 * Beacuse this is usually a event related method, the script
 * is returned without the <script> tag.
 *
 * Possible attributes passed:
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
		$template = array();
		
		foreach($params as $k => $param)
		{
			if(is_numeric($k))
			{
				$ajax_options['parameters'][] = $param;
				continue;
			}
			
			if(substr($param,0,1) == '@' && substr($param,-1) == '@')
				$param = '"+(' . substr($param,1,-1) . ')+"';
			
			$matches = array();
			if (preg_match_all('/#\{(\w+)\}+/', $param, $matches))
				foreach ($matches[1] as $match)
					$template[$match] = $match.':'.$match;
			
			if(is_string($k))
				$ajax_options['parameters'][] = sprintf('%s=%s', $k, $param);
		}
		
		$parameters = implode('&', $ajax_options['parameters']);
		$template = sprintf('{%s}', implode(',', $template));
		$ajax_options = sprintf('{parameters: new Template("%s").evaluate(%s)}', $parameters, $template);
		
		return sprintf("new BuroAjax('%s',%s,%s)", $url, $ajax_options, $callbacks);
	}

/** 
 * Handles the array of callbacks
 *
 * This method converts the array to javascript code, using the {@link $callbacks} variable for templating the script codes.
 *
 * @access protected
 * @param string $type Type of interface where the callbacks will be attached
 * @param array $callbacks One associative array that contains all configurable callbacks for the form
 * @return string An javascript object that contains all registred callbacks
 * @see BuroOfficeBoyHelper::$callbacks
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
 *
 * Note that it only works with forms callbacks
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
 * Generates the script that locks the form
 * 
 * Once executed, each input inside the form is disabled and
 * than can't accept changes by user or by javascript code.
 *
 * Note that this only works with forms callbacks
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
 * Generates the script that unlocks the form
 *
 * Note that this only works with forms callbacks
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
 * ### It may be called in many formats:
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
						$obj = 'form';
					else
						$obj = "$('$id')";
					break;
				
				default:
					$action = 'update';
					$obj = "$('$id')";
					break;
			}
			
			$script = "{$obj}.{$action}(json.content);";
			break;
		}
		return $script;
	}

/**
 * Do nothing with the script. Just repasses it.
 *
 * @access protected
 * @param mixed $script 
 * @return string Return the $script content untouched
 */
	protected function _js($script)
	{
		return $script;
	}

/**
 * Formats a redirect script.
 *
 * This method uses the JsHelper, that uses `window.location.href()` function
 * of javascript. It accepts the <var>$url</var> paramater ether on string or on array formats.
 *
 * @access protected
 * @param array|string $url
 * @return string The formated script
 */
	protected function _redirect($url)
	{
		return $this->Js->redirect($url);
	}

/**
 * A way of comunication with the user.
 * 
 * For while, it is just an alias to <code>array('js' => "alert('$msg')")</code>
 * 
 * @todo Link with PopupHelper
 * @access protected
 * @param mixed $msg
 * @return string The formated script
 */
	protected function _popup($msg)
	{
		return $this->Js->alert((string) $msg);
	}

/**
 * Renders an Ajax.Resquest or an Ajax.Updater
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
 * Shows that a element, specified by $element_id, is waiting for a call to be finished
 * 
 * @access protected
 * @param string $element_id The DOM ID of the element
 * @return string The formated script
 */
	protected function _setLoading($element_id)
	{
		return "$('$element_id').setLoading();";
	}

/**
 * Reverses the BuroOfficeBoyHelper::_setLoading method effect
 * 
 * @access protected
 * @param string $element_id The DOM ID of the element
 * @return string The formated script
 */
	protected function _unsetLoading($element_id)
	{
		return "$('$element_id').unsetLoading();";
	}
}
