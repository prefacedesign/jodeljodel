<?php
	class PopupHelper extends AppHelper
	{
		var $helpers = array('Html', 'Ajax', 'Javascript');
		var $View = null;
		
		/**
		 * popup
		 *
		 * Create and return the popup element. The array of options accept:
		 *   type - (required) type of the popup (the options are: error, success)
		 *   title - (not required) the title
		 *   content - (not required) the content of the message (accept html code)
		 *   actions - (not required) an array with the callbacks links 
		 *   callback - (not required) javascript that recieve the link chosen
		 *
		 * @access	public
		 * @param	string $id ID who identifies the popup
		 * @param	array $options array with the options
		 */
		function popup($id, $options = array())
		{
			$this->View =& ClassRegistry::getObject('View');
			$options = am(
				array(
					'type' => '',
					'title' => '',
					'content' => '',
					'actions' => array('ok' => 'Ok'),
					'callback' => ''
				),
				$options
			);
			$options['id'] = $id;
			$options['plugin'] = 'popup';
			
			return $this->View->element('popup', $options);
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
?>