<?php
	class BuroOfficeBoyHelper extends AppHelper
	{
		var $helpers = array('Html', 'Js' => 'prototype');
		
		
		public function newForm($url, $form_id, $submit_id, $callbacks = array())
		{
			$this->Html->script('prototype', array('inline' => false));
			$this->Html->script('/burocrata/js/burocrata.js', array('inline' => false));
			
			$script = sprintf(
				"new BuroForm('%s','%s','%s')",
				$this->url($url), $form_id, $submit_id
			);
			if(!empty($callbacks) && is_array($callbacks))
				$script .= sprintf('.addCallbacks(%s)', $this->formatFormCallbacks($callbacks));
			
			$this->Js->buffer($script);
			$this->Js->writeBuffer(array('inline' => false));
		}
		
		
		protected function formatFormCallbacks($callbacks)
		{
			if(!is_array($callbacks))
				return null;
			
			foreach($callbacks as $callback=>$script)
			{
				if(is_string($script))
				{
					if($script == 'contentUpdate')
					{
						$updateScript = 'form.update(json.content);';
						if(!isset($callbacks['onSuccess'])) {
							$callbacks['onSuccess'] = array('js' => $updateScript);
						} else {
							if(!isset($callbacks['onSuccess']['js']))
								$callbacks['onSuccess']['js'] = '';
							$callbacks['onSuccess']['js'] = $updateScript.$callbacks['onSuccess']['js'];
						}	
					}
					unset($callbacks[$callback]);
				}
			}
			
			$out = array();
			foreach($callbacks as $callback=>$script)
				$out[] = $callback . ': ' . $this->_parseScript($script, $callback);
			
			return '{'.implode(', ', $out).'}';
		}
		
		
		/**
		 *
		 * @access public
		 * @param mixed $script
		 * @param script $callback
		 * @return string The adequate script for context
		 */
		protected function _parseScript($script, $callback)
		{
			if(!is_array($script)) return null;
			
			$js = '';
			foreach($script as $type => $code)
				$js .= $this->{'_'.$type}($code) . ' ';
			
			$out = '';
			switch($callback)
			{
				case 'onStart': $out = sprintf('function(form) { %s}', $js); break;
				case 'onComplete': $out = sprintf('function(form) { %s}', $js); break;
				default: $out = sprintf('function(form) { %s}', $js); break;
			}
			return $out;
		}
		
		
		/**
		 *
		 * @access public
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
		 * @access public
		 * @param mixed $msg
		 * @return string The formated script
		 */
		protected function _popup($msg)
		{
			return $this->Js->alert((string) $msg);
		}
	}