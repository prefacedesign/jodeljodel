<?php

	$this->Html->script('prototype', array('inline' => false));
	$this->Html->script('/popup/js/popup', array('inline' => false));
	
	extract(array('links_callbacks' => array(), 'list_links' => false), EXTR_SKIP);
	
	if (!empty($actions) && is_array($actions))
	{
		foreach($actions as $box_action => $box_link)
		{
			$box_link_id = uniqid('link_');
			$box_link_class = 'link_button';
			$links_callbacks[] = $this->Bl->a(
				array('id' => $box_link_id, 'class' => $box_link_class, 'href' => $this->here),
				array(),
				$box_link
			);
			$list_links[$box_action] = $box_link_id;
		}
		$links_callbacks = implode('&emsp;', $links_callbacks);
	}
	
	$list_links = $this->Js->object($list_links);
	
	if (!empty($actions) && is_string($actions))
	{
		$links_callbacks = $actions;
	}
	
	// Title
	$typeTitle = 'Popup plugin ' . $type . ' type';
	$typeTitle = trim(__d('popup', $typeTitle, true));
	if (!empty($typeTitle))
		$title = $typeTitle . ': ' . $title;
	
	if (empty($title))
		$title .= ' ';
	
	// The HTML
	echo $this->Bl->sboxcontainer(array('id' => $id, 'class' => 'box_popup '. $type.'_box' ), array());
		echo $this->Bl->sbox(array(), array('size' => array('M' => 7, 'g' => -3)));
			echo $this->Bl->h2Dry($title);
			echo $this->Bl->divDry($content);
			echo $this->Bl->div(array('class' => 'callbacks'), array(), $links_callbacks);
			echo $this->Bl->floatBreak();
		echo $this->Bl->ebox();
	echo $this->Bl->eboxcontainer();
	
	echo $this->Html->scriptBlock("new Popup('$id', $list_links).addCallback(function(action){ $callback; });");

