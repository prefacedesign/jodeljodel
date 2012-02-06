<?php

class TypeStylesheetController extends TypographerAppController
{
	var $name = 'TypeStylesheet';
	var $layout = 'css';
	var $components = array('Typographer.TypeLayoutSchemePicker');
	var $uses = array();
	var $helpers = array(
		'Typographer.TypeDecorator' => array(
			'name' => 'Decorator',
			'compact' => false,
			'mode' => 'inline_echo',
			'receive_tools' => true
		),
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'StyleFactory', 
			'receive_automatic_classes' => false, 
			'receive_tools' => true,
			'generate_automatic_classes' => true //significa que eu que vou produzir as classes automaticas
		)
	);

/**
 * AuthComponent access hardcoded
 * 
 * @access public
 * @return void
 */
	function  beforeFilter()
	{
		parent::beforeFilter();

		if (isset($this->Auth))
		{
			$this->Auth->allow('*');
		}
	}

/**
 * Avoid the parent beforeRender triggering.
 * 
 * @access public
 * @return void
 */
	function beforeRender()
	{
	}

/**
 * Action for rendering CSS
 * 
 * @access public
 * @return view
 */	
	function style($layout_scheme = 'standard', $type = 'main')
	{
		$this->TypeLayoutSchemePicker->pick($layout_scheme);
		
		$element = $layout_scheme . '_css';
		
		$assetFile = implode(DS, array(ROOT, 'app', 'plugins', 'typographer', 'views', 'elements', $element . $this->ext));
		$assetFilemTime = filemtime($assetFile);
		$eTag = md5_file($assetFile);
		
		if (env('HTTP_IF_NONE_MATCH') && env('HTTP_IF_NONE_MATCH') == $eTag)
		{
			$this->header("HTTP/1.1 304 Not Modified");
			$this->_stop();
		}
		
		header("Last-Modified: " . gmdate("D, j M Y G:i:s ", $assetFilemTime) . 'GMT');
		header("Etag: " . $eTag);
		header('Content-type: text/css');
		
		$this->set(compact('element'));		
	}
}
