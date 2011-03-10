<?php
	class PrincipalController extends AppController
	{
		var $name = 'Principal';
		var $uses = array('Person.PersPerson','Event.EveEvent','New.NewsNew','Paper.PapPaper');
	
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
			$this->set('event', $this->EveEvent->find(
				'first',
				array(
					'contain' => array(),
					'order' => array('EveEvent.begins DESC')
				)
			));
			
			$this->set('news', $this->NewsNew->find(
				'all',
				array(
					'contain' => array('AuthAuthor'),
					'order' => array('NewsNew.date DESC'),
					'limit' => 4
				)
			));
			
			$this->set('papers', $this->PapPaper->find(
				'all',
				array(
					'contain' => array('AuthAuthor','JourJournal','TagsTag'),
					'order' => array('PapPaper.date DESC'),
					'limit' => 2
				)
			));
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
		
		function contact()
		{
		}
	}
?>