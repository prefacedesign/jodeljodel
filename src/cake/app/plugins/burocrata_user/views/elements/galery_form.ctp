<?php
/*
echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
	array(
		// 'url' => array('action' => 'recebedor'), // Action que vai receber o POST
		'model' => 'BurocrataUser.Galery', // Somente o Model pai, assim como no FormHelper::create
		'callbacks' => array(
			'onStart'	=> array('lockForm'),
			'onComplete'=> array('unlockForm'),
			'onSuccess' => array('contentUpdate' => 'replace'),
			'onSave'    => array('popup' => 'Salvou a gabaça'),
			// 'onReject'  => array('popup' => 'Existe algum erro de validação.'),
			'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else alert(error);"),
			'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
		)
	)
);
	echo $this->Buro->sinput(
		array(),
		array(
			'type' => 'super_field',
			'label' => 'About this galery'
		)
	);
	
		echo $this->Buro->input(
			array(), 
			array('fieldName' => 'title')
		);
		
		echo $this->Buro->input(
			array(), 
			array(
				'fieldName' => 'date',
				'type' => 'datetime',
				'options' => array(
					'dateFormat' => 'DMY',
					'timeFormat' => null
				)
			)
		);
		
		
		echo $this->Buro->input(
			array(), 
			array('fieldName' => 'about', 'type' => 'textarea')
		);
		
	echo $this->Buro->einput();
	
	echo $this->Buro->input(
		array(),
		array(
			'type' => 'belongs_to',
			'label' => 'Owner',
			'instructions' => 'Find the user by his/her name or register a new one right here, right now!',
			'options' => array(
				'type' => 'autocomplete',
				'model' => 'BurocrataUser.User',
				// 'queryField' => 'User.name',
				'callbacks' => array(
					// 'onSelect' => array('js' => 'this.input.value = pair.value')
				)
			)
		)
	);
	
	echo $this->Bl->br();
	echo $this->Bl->br();
	echo $this->Bl->br();
	echo $this->Bl->br();
	
	echo $this->Buro->submit(array(), array('label' => 'Send this :)', 'cancel' => 'Cancelar'));

echo $this->Buro->eform();
*/


echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Galery', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart'	=> array('lockForm'),
				'onComplete'=> array('unlockForm'),
				'onSuccess' => array('contentUpdate' => 'replace'),
				'onSave'    => array('popup' => 'Salvou a gabaça'),
				'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else alert(error);"),
				'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!')
			)
		)
	);
		
		echo $this->Buro->input(array(),
			array(
				'label' => 'Galery title',
				'fieldName' => 'Galery.title'
			)
		);
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'relational',
				'label' => 'Owner',
				'options' => array(
					'type' => 'unitary_autocomplete', // Former belongsTo, that now is also hasOne
					'model' => 'BurocrataUser.Person'
				)
			)
		);
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'relational',
				'label' => 'Owner',
				'instructions' => 'Selecione um ou mais',
				'options' => array(
					'type' => 'list', // Former belongsTo, that now is also hasOne
					'multiple' => true,
					'model' => 'BurocrataUser.Person'
				)
			)
		);
		
		
		echo $this->Buro->input(array(),
			array(
				'label' => 'Something about this galery',
				'fieldName' => 'Galery.about',
				'type' => 'textile',
				'options' => array(
					'enabled_buttons' => array('bold', 'italic')
				)
			)
		);
		
		
		echo $this->Buro->submit();
	
	echo $this->Buro->eform();