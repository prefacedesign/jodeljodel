<?php

echo $this->Buro->sform(array(),
	array(
		'model' => 'BurocrataUser.Galery', // Somente o Model pai, assim como no FormHelper::create
		'callbacks' => array(
			'onStart'	=> array('lockForm', 'js' => 'form.setLoading()'),
			'onComplete'=> array('unlockForm', 'js' => 'form.unsetLoading()'),
			'onSave'    => array('popup' => 'Salvou a gabaça', 'contentUpdate' => 'replace'),
			'onReject'	=> array('popup' => 'Rejeitou!', 'contentUpdate' => 'replace'),
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
		
		echo $this->Buro->input(array(),
			array(
				'label' => __d('buro_user','Color input', true),
				'fieldName' => 'color',
				'type' => 'color'
			)
		);
		
	echo $this->Buro->einput();

	// echo $this->Buro->input(array(),
		// array(
			// 'type' => 'relational',
			// 'fieldName' => 'person_id',
			// 'options' => array(
				// 'type' => 'combo',
				// 'model' => 'BuroUser.Person',
			// )
		// )
	// );
	
	echo $this->Buro->input(array(),
			array(
				'label' => __d('buro_user','Another color input', true),
				'fieldName' => 'another_color',
				'type' => 'color'
			)
		);
	
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
					'reset_item' => __d('buro_user', 'Choose another person', true),
					'undo_reset' => __d('buro_user', 'Bring last person back', true),
					'nothing_found' => __d('buro_user', 'Person not found', true),
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