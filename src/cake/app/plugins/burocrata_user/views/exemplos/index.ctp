<?php
echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	
	echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
		array(
			'model' => 'BurocrataUser.Galery', // Somente o Model pai, assim como no FormHelper::create
			'callbacks' => array(
				'onStart'	=> array('lockForm'),
				'onComplete'=> array('unlockForm'),
				'onSave'    => array('popup' => 'Salvou a gabaça'),
				'onError'   => array('js' => "if(code == E_NOT_JSON) alert('Não é json! Não é json!'); else if(code == E_JSON) alert(error); else if(code == E_NOT_AUTH) alert('Você não tem autorização para isso.');"),
				'onFailure'	=> array('popup' => 'Erro de comunicação com o servidor!'),
			)
		)
	);
		echo $this->Buro->input(array(),
			array(
				'type' => 'hidden',
				'fieldName' => 'id'
			)
		);
		
		
		echo $this->Buro->sinput(array(), array('type' => 'super_field', 'label' => __d('buro_user','This gallery',true)));
		
			echo $this->Buro->input(array(),
				array(
					'label' => __d('buro_user','Gallery title', true),
					'fieldName' => 'title'
				)
			);
			
			echo $this->Buro->input(array(),
				array(
					'label' => __d('buro_user','Gallery release date', true),
					'fieldName' => 'date',
					'type' => 'datetime',
					'options' => array(
						'dateFormat' => 'DMY',
						'timeFormat' => null,
						'separator' => ''
					)
				)
			);
			
		echo $this->Buro->einput();
			
		echo $this->Buro->input(array(),
			array(
				'label' => __d('buro_user','Something about this gallery', true),
				'fieldName' => 'about',
				'type' => 'textile',
				'options' => array(
					'enabled_buttons' => array('bold', 'italic', 'link', 'image'),
					'allow_preview' => false
				)
			)
		);
		
		
		echo $this->Buro->input(array(), 
			array(
				'type' => 'relational',
				'label' => __d('buro_user','Owner of this gallery', true),
				'instructions' => __d('buro_user','First, search if he/she already has a account, using his/her name. If does not, you will be able to create a new one.', true),
				'options' => array(
					'type' => 'unitary_autocomplete',
					'model' => 'BurocrataUser.Person',
					'texts' => array(
						'new_item' => __d('buro_user', 'Create a new person', true),
						'edit_item' => __d('buro_user', 'Edit this person', true),
						'reset_item' => __d('buro_user', 'Chose another person', true),
						'nothing_found' => __d('buro_user', 'Person not found', true)
					)
				)
			)
		);
		
		echo $this->Buro->input(array(),
			array(
				'label' => __d('buro_user','Pictures for this gallery', true),
				'type' => 'relational',
				'instructions' => __d('buro_user','Click on plus sign (on right) to add more pictures. You can also change the order of appearance, edit, delete and duplicate each picture.', true),
				'options' => array(
					'type' => 'many_children',
					'model' => 'BurocrataUser.Picture',
					'callbacks' => array(
						'onError' => array('js' => "alert('Deu erro ao fazer o `'+json.action+'`. Controller voltou:\\n\\n\\t'+json.error);")
					),
					'texts' => array(
						'confirm' => array(
							'delete' => __d('buro_user','Do you really want to delete this image?', true)
						),
						'title' => __d('buro_user','Image', true)
					)
				)
			)
		);
		
		echo $this->Buro->input(array(),
			array(
				'label' => __d('buro_user','Something else for this gallery', true),
				'type' => 'relational',
				'instructions' => __d('buro_user','Some instructions here.', true),
				'options' => array(
					'type' => 'many_children',
					'model' => 'BurocrataUser.Something',
					'callbacks' => array(
						'onError' => array('js' => "alert('Deu erro ao fazer o `#{action}`. Controller voltou:\\n\\n\\t#{error}'.interpolate(json));")
					),
					'texts' => array(
						'confirm' => array(
							'delete' => __d('buro_user','Do you really want to delete this thing?', true)
						),
						'title' => __d('buro_user','Something', true)
					)
				)
			)
		);
		
		echo $this->Buro->submit();
	
	echo $this->Buro->eform();

echo $this->Bl->ebox();

/* 	
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
	
