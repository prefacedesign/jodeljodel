<?php
echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	echo $this->Jodel->insertModule('BurocrataUser.Galery', array('buro', 'form'));

echo $this->Bl->ebox();

/* 	
	Example of Corcktile of content stream
	
	echo $this->Cork->tile(array(), array(
		'key' => 'content_stream_test',
		'type' => 'cs_cork',
		'title' => 'Esse é um título',
		'options' => array(
			'type' => 'tipo_a', // type of module 
			'cs_type' => 'document' // type of content stream
		)
	));
	
	
	Exemple of a textile input
	
	echo $this->Buro->input(array('id' => 'meu_textile'),
		array(
			'type' => 'textile',
			'label' => 'Um input de textile',
			'fieldName' => 'about'
		)
	);
	 */

/* 
	Two examples of upload input
	
	echo $this->Buro->input(array(), 
		array(
			'type' => 'image',
			'label' => 'Faça seu upload de imagem',
			'fieldName' => 'img_id',
			'error' => array(
				'size' => 'Arquivo muito grande!',
				'pixels' => 'Foto muito grande!',
				'mimeType' => 'Aceitamos somente imagens, ok?'
			),
			'options' => array(
				'version' => 'backstage_preview',
				'callbacks' => array(
					'onStart' => array('popup' => 'Começando o upload...')
				),
				'change_file_text' => 'Mudar esse arquivo'
			)
		)
	);

	echo $this->Buro->input(array(), 
		array(
			'type' => 'upload',
			'label' => 'Arquivo',
			'fieldName' => 'file_id',
			'error' => array(
				'size' => 'Arquivo muito grande!',
				'pixels' => 'Foto muito grande!',
				'mimeType' => 'Aceitamos somente imagens, ok?'
			),
			'options' => array(
				'callbacks' => array(
					'onStart' => array('popup' => 'Começando o upload...')
				),
				'change_file_text' => 'Mudar esse arquivo'
			)
		)
	);
 */


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
	
