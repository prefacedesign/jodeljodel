<?php

echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	
	echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Video', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart' => array('lockForm', 'js' => 'form.setLoading()'),
				'onComplete' => array('unlockForm', 'js' => 'form.unsetLoading()'),
				'onSave'    => array('popup' => 'Salvou a gabaça')
			)
		)
	);
	
		echo $this->Buro->input(array(),
			array(
				'label' => 'Video id',
				'fieldName' => 'Video.id',
				'type' => 'hidden'
			)
		);
		
		echo $this->Buro->input(array(),
			array(
				'label' => 'Video title',
				'fieldName' => 'Video.title'
			)
		);
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'tags',
				'label' => 'Algumas tags',
				'instructions' => 'Enumere as tags separadas por vírgula',
				'fieldName' => 'tags', // default tags
				'options' => array(
					'type' => 'comma', // (default comma)
				)
			)
		);
		
		
		/*
		echo $this->Buro->input(array(), 
			array(
				'type' => 'relational',
				'label' => 'Owner',
				'instructions' => 'Selecione um ou mais',
				'fieldName' => 'Person',
				'options' => array(
					'type' => 'list',
					'multiple' => true,
					'size' => 3,
					'model' => 'BurocrataUser.Person',
				)
			)
		);
		
		*/
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'relational',
				'label' => 'Owner',
				'instructions' => 'Selecione um ou mais',
				'options' => array(
					'type' => 'editable_list',
					'model' => 'BurocrataUser.Person',
					'allow' => array('create', 'modify', 'preview', 'relate')
				)
			)
		);
		
		
		echo $this->Buro->submit();
		
	echo $this->Buro->eform();

echo $this->Bl->ebox();