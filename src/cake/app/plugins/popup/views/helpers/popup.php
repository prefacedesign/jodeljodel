<?php

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
	var $helpers = array('Html', 'Ajax', 'Javascript', 'Js' => 'prototype',
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
 * Call the popup element
 * 
 * @access protected
 * @param array $options
 * @return string The element rendered
 */
	protected function _popup($options)
	{
		$View =& ClassRegistry::getObject('View');
		return $View->element('popup', $options);
	}
	
	
	
	
	//@todo: translate to english and test the Progress
	
	
	/**
	 * progresso
	 *
	 * Monta um popup com uma barra de progresso e um sistema para acionar a barra.
	 * 
	 * @access	public
	 * @param	string $id O ID do popup pelo qual será chamado
	 * @param	array $parametros O array com os parâmetros de configuração
	 */
	function progresso($id, $parametros = array())
	{
		$url = $this->Html->url($parametros['url']);
		$url_cancelar = isset($parametros['url_cancelar']) ? $this->Html->url($parametros['url_cancelar']) : '';
		
		// montando o conteúdo do popup
		$conteudo[] = '<div class="carregando"></div>';
		$conteudo[] = '<div class="mensagem"></div>';
		$conteudo[] = '
			<div class="barra_de_progresso">	
				<div class="enchimento_da_barra"></div>
			</div>';
		$conteudo[] = $this->Javascript->codeBlock("
			$('$id').observe('popup:abriu', function(ev){
				$('$id').down('.mensagem').update();
				$('$id').down('.enchimento_da_barra').setStyle('width: 0;');
				new ChamadasProgresso('$url', '$id');
			});
		");
		
		// montando o callback dos botões
		$callback = "if(acao == 0) cancelaProgresso('$id', '$url_cancelar');";
		
		
		$parametros['callback'] = $callback;
		$parametros['conteudo'] = implode($conteudo);
		$parametros['acoes'] = array('Cancelar', 'Ok');
		return 
			$this->generico($id, $parametros)
			. $this->generico($id.'_cancelando', array(
				'titulo' => 'Aguarde enquando o pedido é cancelado',
				'conteudo' => '<div class="carregando"></div>',
				'acoes' => array()
			));
	}
}