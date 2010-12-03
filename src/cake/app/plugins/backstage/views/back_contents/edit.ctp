<?php

echo $bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));
	echo $bl->h1(
		array(),
		array('additionalText' => __('Now, this document is hidden.', true) . __('You can publish it or delete it.', true)),
		'Edição de um artigo'
	);
echo $bl->ebox();

echo $bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
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
        
	echo $bl->floatBreak();
//        echo $buro->form(array(), array(
//            'model' => $contentPlugin . '.' .$modelName,
//            'writeForm' => true
//        ));
        echo $buro->sform(array(), array(
            'model' => $fullModelName,
            'writeForm' => true
        ));
        echo $buro->eform();
	
echo $bl->ebox();

					 
?>