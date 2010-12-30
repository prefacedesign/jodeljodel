<?php
	class PopupHelper extends AppHelper
	{
		var $helpers = array('Html', 'Ajax', 'Javascript');
		var $View = null;
		
		/**
		 * erro
		 *
		 * Monta e retorna o element de popup. Essa função recebe um array com os 
		 * seguintes parâmetros:
		 *   titulo - (opcional) O título da caixa
		 *   conteudo - (opcional) O conteúdo da caixa (que poderá ser qq código em HTML)
		 *   acoes - (opcional) Um array com os links e seus respectivos valores que serão colocados na parte inferior
		 *   callback - (opcional) Código javascript que receberá o link escolhido
		 *
		 * @access	public
		 * @param	string $id O ID do popup pelo qual será chamado
		 * @param	array $parametros O array com os parâmetros de configuração
		 */
		function caixaErro($id, $parametros = array())
		{
			$this->View =& ClassRegistry::getObject('View');
			$parametros = am(
				array(
					'titulo' => '',
					'conteudo' => '',
					'acoes' => array('ok' => 'Ok'),
					'callback' => ''
				),
				$parametros
			);
			$parametros['id'] = $id;
			$parametros['plugin'] = 'popup';
			
			return $this->View->element('caixa_erro', $parametros);
		}
		
		
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