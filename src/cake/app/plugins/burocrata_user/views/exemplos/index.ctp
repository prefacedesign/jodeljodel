<?php
	// echo $this->Buro->insertForm('BurocrataUser.Galery', 'teste');	

	echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'Person.PersPerson', // Somente o Model pai, assim como no FormHelper::create
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
		// echo $this->Bl->img(array('class' => 'teste', 'alt' => 'img8'), array('id' => 8, 'version' => 'sala'));
		echo $this->Buro->input(array(), 
			array(
				'type' => 'upload',
				'label' => 'Faça seu upload de imagem',
				'error' => array(
					'size' => 'Arquivo muito grande!',
					'pixels' => 'Foto muito grande!',
					'mimeType' => 'Aceitamos somente imagens, ok?'
				),
				'fieldName' => 'PersPerson.sfil_storage_file_id',
				'options' => array(
					// 'version' => 'people',
					'callbacks' => array(
						'onStart' => array('popup' => 'Começando o upload...'),
						// 'onError' => array('popup' => '... vixe, deu erro...'),
						// 'onSave' => array('popup' => '... thubiru! ...'),
						// 'onReject' => array('js' => 'alert(json.error)'),
						// 'onFailure' => array('popup' => '... não deu certo...'),
						// 'onComplete' => array( 'popup' => '... e acabou.')
					)
				)
			)
		);
		echo $this->Buro->submit();
	
	echo $this->Buro->eform();

/* 
	An autocomplete input
	
	echo $this->Buro->input(array(),
		array(
			'type' => 'autocomplete',
			'label' => 'User',
			'options' => array(
				'model' => 'BurocrataUser.User',
				'fieldName' => 'User.name',
				'callbacks' => array(
					'onSelect' => array('js' => "input.value = ''; alert(pair.value);"),
					'onSuccess' => array('popup' => 'Ahá!')
				)
			)
		)
	);

 */




/* 
	An auto-form that prints all that is needed.
	
	echo $this->Buro->form(
		array(),
		array(
			'model' => 'BurocrataUser.Local',
			'writeForm' => true,
			'callbacks' => array(
				'onStart' => array('lockForm'),
				'onComplete' => array('unlockForm'),
				'onSave'     => array('popup' => 'Salvou!'),
				'onRejected' => array('popup' => 'Não salvou!'),
				'onFailure'	 => array('popup' => 'Não foi possível conectar-se ao servidor!')
			)
		)
	);
*/
	
