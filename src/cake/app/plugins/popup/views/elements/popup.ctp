<?php

	$box_links = array();
	$caixa_scripts = array();
	
	$javascript->link('/js/prototype', false);
	$javascript->link('/popup/js/popup', false);
	
	$links_callbacks = array();
	$list_links = array();
	if(!empty($actions))
	{
		foreach($actions as $box_action => $box_link)
		{
			$box_link_id = uniqid('link_');
			$links_callbacks[] = $html->link($box_link, $this->here, array('id' => $box_link_id, 'class' => 'link_button'));
			$list_links[] = '"'.$box_action.'":"'.$box_link_id.'"';
		}
	}
	
	echo $this->Bl->sboxcontainer(array('id' => $id, 'class' => 'box_popup '. $type.'_box' ), array());
		echo $this->Bl->sbox(array(), array('size' => array('M' => 7, 'g' => -3)));
			echo $this->Bl->sh2();
				$typeTitle = __('Popup plugin ' . $type . ' type',true);				
				if (!empty($typeTitle) && $typeTitle !== ' ')
					echo $typeTitle . ': ';
				echo $title;
			echo $this->Bl->eh2();
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
	
	echo $javascript->codeBlock("
		new Popup('$id', $list_links).addCallback(function(action){ $callback; });
	");
?>