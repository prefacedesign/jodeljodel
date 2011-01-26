<?php
echo $this->Bl->sbox(array(), array('size'=> array('M' => 12, 'g' => -1)));
	echo $this->Bl->h1Dry(__('Corktile edit page: Editing a fixed content', true));
	
	echo $this->Bl->sbigInfoBox();
		debug($data['CorkCorktile']);
		/*echo $this->Bl->propertyDry(array(
		);*/
	echo $this->Bl->ebigInfoBox();
	
echo $this->Bl->ebox();

echo $this->Bl->sbox(array(),array('size' => array('M' => 7, 'g' => -1)));
	//@todo Really use the Tradutore tool.
	//@todo transform this in a element:
	$tmp = $this->Bl->anchorList(array(),array(
			'lastSeparator' => __('anchorList and', true),
			'linkList' => array(
				array('name' => __('english',true), 'url' => "www.google.com.br"),
				array('name' => __('portuguese',true), 'url' => "www.google.com.br"),
				array('name' => __('japanese',true), 'url' => "www.google.com.br"),
				array('name' => __('javanese',true), 'url' => "www.google.com.br")
			)
		)
	);
	echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
		sprintf (__('This %s already has translations for %s.',true), 'article', $tmp));

	//@todo Transform this in a element
	echo $this->Bl->scontrolBox();
		echo $this->Bl->h3(array(), array('escape' => false), $this->Bl->spanDry(
			__('backstage edit page: Editing', true))
			.  sprintf(__(' the %s version.',true),__('portuguese',true))
		);

		echo $this->Bl->p(array('class' => 'small_text'), array('escape' => false),
				sprintf(__('Corktile: The edition to these contents will be automatically updated to the page where it appears.',true), $tmp));
	echo $this->Bl->econtrolBox();
	
	// @todo Transform this into a element.
	echo $this->Popup->popup('error',
		array(
			'type' => 'error',
			'title' => __('Backstage edit page: Your data cannot be saved.',true),
			'content' => __('Backstage edit page: Verify the fields marked with an error and try to save again.', true)
		)
	);
	echo $this->Popup->popup('notice',
		array(
			'type' => 'notice',
			'title' => __('Backstage edit page: Your data has been saved.',true),
			'content' => __('Backstage edit page: Remember to publish the content to make it visible to everyone.',true),
			'actions' => array('ok' => 'ok'),
			'callback' => "if (action=='ok') window.location = '/dashboard/dash_dashboard';"
		)
	);
	
	echo $buro->insertForm($fullModelName, array('cork'));
echo $this->Bl->ebox();