<?php
	class PrincipalController extends AppController
	{
		var $name = 'Principal';
		var $pageTitle = 'Dinafon';
		var $uses = array();
	
		var $components = array('Typographer.TypeLayoutSchemePicker');
		var $helpers = array(
			'Typographer.TypeDecorator' => array(
				'name' => 'Decorator',
				'compact' => false,
				'receive_tools' => true
			),
			'Typographer.*TypeStyleFactory' => array(
				'name' => 'TypeStyleFactory',
				'receive_automatic_classes' => true, 
				'receive_tools' => true,
				'generate_automatic_classes' => false //significa que eu que vou produzir as classes automaticas
			),
			'Typographer.*TypeBricklayer' => array(
				'name' => 'Bl',
				'receive_tools' => true,
			),
			'Burocrata.*BuroBurocrata' => array(
				'name' => 'Buro'
			),
			'Kulepona'
		);
		var $layout = 'dinafon';

		function beforeFilter()
		{
			parent::beforeFilter();
			$this->Auth->allow('index');
		}

		function beforeRender()
		{
			parent::beforeRender();
			//Configure::write('Config.language','por');
			//debug(Configure::read('Config.language'));
			$this->TypeLayoutSchemePicker->pick('dinafon'); //aten��o que isto sobre-escreve a view escolhida
		}



		function index()
		{
			Configure::load('bd_textos');
			Configure::load('bd_noticias');
			Configure::load('bd_publicacoes');
			
			$this->set('sobre_dinafon_pequeno', Configure::read('BDtemp.textos.sobre_dinafon_pequeno'));
			
			$noticias = Configure::read('BDtemp.noticias');			
			foreach($noticias as $k => $noticia)
			{
				$noticias[$k]['id'] = $k;
			}
			
			$noticias = array_chunk($noticias, 5);
			$noticias = $noticias[0];
			
			$this->set('noticias', $noticias);
			
			$publicacoes = Configure::read('BDtemp.publicacoes');
			foreach($publicacoes as $k => $publicacao)
			{
				$publicacoes[$k]['id'] = $k;
			}
			$this->set('publicacoes', $publicacoes);
		}
		
		function about()
		{
			Configure::load('bd_textos');
			Configure::load('bd_pessoas');
			
			$this->set('sobre_dinafon', Configure::read('BDtemp.textos.sobre_dinafon'));
			$pessoas = Configure::read('BDtemp.pessoas');
			
			$ids = array_keys($pessoas);
			shuffle($ids);			
			$ids_escolhidos = array_chunk($ids, 4);
			
			$this->set('pessoas', array(
					$ids_escolhidos[0][0] => $pessoas[$ids_escolhidos[0][0]],
					$ids_escolhidos[0][1] => $pessoas[$ids_escolhidos[0][1]],
					$ids_escolhidos[0][2] => $pessoas[$ids_escolhidos[0][2]],
					$ids_escolhidos[0][3] => $pessoas[$ids_escolhidos[0][3]]
				)
			);
		}
		
		function contato()
		{
			Configure::load('bd_textos');
			$this->set('texto_contato', Configure::read('BDtemp.textos.texto_contato'));
			$this->set('contatos', Configure::read('BDtemp.textos.contatos'));
		}
	}
?>