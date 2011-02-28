<?php
	class PrincipalController extends AppController
	{
		var $name = 'Principal';
		var $uses = array('Person.PersPerson');
	
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
			'Kulepona',
			'Corktile.Cork',
			'Text'
		);
		var $layout = 'dinafon';

		function beforeFilter()
		{
			parent::beforeFilter();
			StatusBehavior::setGlobalActiveStatuses(array(
				'publishing_status' => array('active' => array('published'), 'overwrite' => true),
			));
		}

		function beforeRender()
		{
			parent::beforeRender();
			$this->TypeLayoutSchemePicker->pick('dinafon'); 
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
			$allPeople = $this->PersPerson->find('all', array('contain' => false));	// find 'list' doesn't work with Tradutore	
			$allPeopleIds = Set::extract($allPeople,'{n}.PersPerson.id');
			shuffle($allPeopleIds);
			$chosenIds = array_chunk($allPeopleIds, 4);
			
			if (isset($chosenIds[0])) {

				$this->set(
					'people',
					$this->PersPerson->find(
						'all', array(
							'contain' => array('AuthAuthor'),
							'conditions' => array('PersPerson.id' => $chosenIds[0])
						)
					)
				);
			}
		}
		
		function contato()
		{
			Configure::load('bd_textos');
			$this->set('texto_contato', Configure::read('BDtemp.textos.texto_contato'));
			$this->set('contatos', Configure::read('BDtemp.textos.contatos'));
		}
	}
?>