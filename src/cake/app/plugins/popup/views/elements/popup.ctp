<?php

	$this->Html->script('prototype', array('inline' => false));
	$this->Html->script('/popup/js/popup', array('inline' => false));
	
	$links_callbacks = array();
	$list_links = array();
	if(!empty($actions))
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
			$list_links[] = '"'.$box_action.'":"'.$box_link_id.'"';
		}
	}
	
	$typeTitle = trim(__('Popup plugin ' . $type . ' type',true));
	if (!empty($typeTitle))
		$title = $typeTitle . ': ' . $title;
	
	if (empty($title))
		$title .= ' ';
	
	echo $this->Bl->sboxcontainer(array('id' => $id, 'class' => 'box_popup '. $type.'_box' ), array());
		echo $this->Bl->sbox(array(), array('size' => array('M' => 7, 'g' => -3)));
			echo $this->Bl->h2Dry($title);
			echo $this->Bl->sdiv();
				echo $content;
			echo $this->Bl->ediv();
			echo $this->Bl->sdiv(array('class' => 'callbacks'));
				echo implode('&emsp;', $links_callbacks);
			echo $this->Bl->ediv();
			echo $this->Bl->floatBreak();
		echo $this->Bl->ebox();
	echo $this->Bl->eboxcontainer();
	
	
	$list_links = '{'.implode(',', $list_links).'}';
	
	echo $this->Html->scriptBlock("
		new Popup('$id', $list_links).addCallback(function(action){ $callback; });
	");
