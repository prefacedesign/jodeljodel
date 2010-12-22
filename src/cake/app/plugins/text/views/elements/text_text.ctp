<?php
echo $this->Buro->sform(array('class' => 'azul'), // Parâmetros HTML
	array(
		// 'url' => array('action' => 'recebedor'), // Action que vai receber o POST
		'model' => 'TextText.Text', // Somente o Model pai, assim como no FormHelper::create
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


	echo $this->Buro->input(
		array(),
		array('fieldName' => 'id')
	);

	echo $this->Buro->input(
		array(),
		array('fieldName' => 'author')
	);



	echo $this->Buro->input(
		array(),
		array('fieldName' => 'text_content', 'type' => 'textarea')
	);




	echo $this->Bl->br();
	echo $this->Bl->br();
	echo $this->Bl->br();
	echo $this->Bl->br();

	echo $this->Buro->submit(array(), array('label' => 'Send this :)', 'cancel' => 'Cancelar'));

echo $this->Buro->eform();