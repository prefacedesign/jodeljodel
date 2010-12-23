<?php
/* 
 * This view take care of edit
 */
	echo $bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));
		//@TODO não consigo inserir o text 'Edição de um conteúdo fixo'
		//com o formato para internacionalizacao, quando o faco quebra
		//o layout
		echo $bl->h1(
			array(),
			array(),
			'Edição de um conteúdo fixo'
		);
	echo $bl->ebox();

	echo $bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
	
		echo $bl->sinfoBox();
			echo $bl->sbox(array(),array('size' => array('M' => 3, 'g' => -1)));
				echo $bl->h3(array(), array('escape' => false), $bl->spanDry(
			__('Localização no Site', true)));
				echo $bl->h3(array(), array('escape' => false), $bl->spanDry(
			__('Descrição', true)));
			echo $bl->ebox();

			echo $bl->sbox(array(),array('size' => array('M' => 4, 'g' => -1)));
				echo $bl->p(array(), array('escape' => false),
				$this->data['CorkCorktile']['location']);

				echo $bl->p(array(), array('escape' => false),
				$this->data['CorkCorktile']['description']);

			echo $bl->ebox();

			echo $bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
				echo $bl->p(array('class' => 'small_text'), array('escape' => false),
				$this->data['CorkCorktile']['editor_recommendation']);

			echo $bl->ebox();



		echo $bl->einfoBox();

	echo $bl->ebox();

	echo $bl->sbox(array(),array('size' => array('M' => 12, 'g' => -1)));
		
		
		echo $bl->sbox(array(), array('size'=> array('M' => 6, 'g' => -1)));

			$a = $bl->anchor(array(),array('url' => 'www.google.com.br'),'ingles');
			echo $bl->p(array('class' => 'small_text'), array('escape' => false),
			sprintf (__('Este conteúdo tem apenas uma versão em %s.',true), $a));

			echo $bl->scontrolBox();
				echo $bl->h3(array(), array('escape' => false), $bl->spanDry(
					__('backstage edit page: Editing', true))
					.  sprintf(__(' the %s version.',true),__('portuguese',true))
				);

				$tmp = $bl->anchorList(array(),array(
						'lastSeparator' => __('anchorList or', true),
						'linkList' => array(
							array('name' => __('mark it as ready',true), 'url' => "www.google.com.br"),
							array('name' => __('remove it',true), 'url' => "www.google.com.br")
						)
					)
				);
				echo $bl->p(array('class' => 'small_text'), array('escape' => false),
						sprintf(__('Version marked as draft. You can %s.',true), $tmp));

			echo $bl->econtrolBox();

			//box para a parte do conteúdo que será editado
			echo $bl->sbox(array(), array('size'=> array('M' => 6, 'g' => -1)));
				//usar insertForm
				echo $buro->insertForm('Text.TextText',array('id' => 1));

			echo $bl->ebox();

			//control box para salvar as alterações
			echo $bl->scontrolBox();
				echo 'salvar ou cancelar as alterações';
			echo $bl->econtrolBox();

			

		echo $bl->ebox();

		echo $bl->sbox(array('position' => 'left'), array('size'=> array('M' => 5, 'g' => -1)));
			$a = $bl->anchor(array(),array('url' => 'www.google.com.br'),'português');
			echo $bl->p(array('class' => 'small_text'), array('escape' => false),
			sprintf (__('Você pode ainda criar uma versão em %s.',true), $a));

			echo $bl->scontrolBox();

			$a = $bl->anchor(array(),array('url' => 'www.google.com.br'),'visualizar');
			echo $bl->p(array('class' => 'small_text'), array('escape' => false),
						sprintf(__('Nesta coluna você pode %s uma das versões',true), $a));

			echo $bl->econtrolBox();

		echo $bl->ebox();

	echo $bl->ebox();
?>
