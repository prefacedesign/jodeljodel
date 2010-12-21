<?php
/* 
 * This view take care of edit
 */
	echo $bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));
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

		$tmp = $bl->anchorList(array(),array(
				'lastSeparator' => __('anchorList and', true),
				'linkList' => array(
					array('name' => __('english',true), 'url' => "www.google.com.br"),
					array('name' => __('portuguese',true), 'url' => "www.google.com.br"),
					array('name' => __('japanese',true), 'url' => "www.google.com.br"),
					array('name' => __('javanese',true), 'url' => "www.google.com.br")
				)
			)
		);
		echo $bl->sbox(array(), array('size'=> array('M' => 7, 'g' => -1)));

			echo $bl->p(array('class' => 'small_text'), array('escape' => false),
			sprintf (__('This %s already has translations for %s.',true), 'article', $tmp));

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

		echo $bl->ebox();

		echo $bl->sbox(array('align' => 'left'), array('size'=> array('M' => 4, 'g' => -1)));
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

		echo $bl->ebox();

	echo $bl->ebox();
?>
