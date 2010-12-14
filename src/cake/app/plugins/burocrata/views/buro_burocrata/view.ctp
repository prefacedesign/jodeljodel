<?php
	
	$object['error'] = $error;
	$object['content'] = null;
	
	if(!$error)
	{
		$object['content'] = $this->Bl->div(array('id' => $div_id = uniqid('div')), array('escape' => false), 
			$this->element(Inflector::underscore($model_name),
				array(
					'plugin' => Inflector::underscore($model_plugin),
					'data' => $data,
					'type' => array('buro', 'view')
				)
			)
		);
		$url = array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'edit');
		$ajax = $this->Buro->BuroOfficeBoy->ajaxRequest(array(
					'url' => $url,
					'params' => array(
						$this->Buro->securityParams($url, $model_plugin, $model_name),
						$this->Buro->internalParam('id', $data[$model_name]['id'])
					),
					'callbacks' => array(
						'onSuccess' => array('contentUpdate' => $div_id)
					)
			  ));
		$object['content'] .= $this->Bl->anchor(array('id' => $link_id = uniqid('link')), array('url' => false), __('Belongsto edit related data', true));
		$object['content'] .= $this->Html->scriptBlock("$('$link_id').observe('click', function(ev){ev.stop(); $ajax;})");
	}
	
	echo $this->Js->object($object);