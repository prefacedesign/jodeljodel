<?php
	$params = array('controller' => 'back_contents', 'action' => 'index');
	foreach($paginator->params['pass'] as $param)
		$params[] = $param;
	
	$paginator->options(
		array(
			'update'=>'backstage_custom_table', 
			'url' => $params,
			'before' => "$('backstage_custom_table').setLoading();",
			'complete' => "$('backstage_custom_table').unsetLoading();"
		)
	); 
	
	echo $this->Bl->sdiv(array('class' => 'pagination'));
		echo $this->Paginator->first('<<');
		if ($this->Paginator->hasPrev())
			echo $this->Paginator->prev('<');	
		echo $this->Paginator->numbers(array('modulus' => 9, 'separator' => ''));
		if ($this->Paginator->hasNext())
			echo $this->Paginator->next('>');
		echo $this->Paginator->last('>>');
	echo $this->Bl->ediv();
	
	$lastCol = count($backstageSettings['columns']);
	
	$smartTableColumns = array();
	$totalSize = 0;
	$count = 1;
	foreach($backstageSettings['columns'] as $col)
	{
		$totalSize += $col['size'];
		$border_width = $hg->size(array('u'=> 1), false);
		$cell_padding_left  = $hg->size(array('m'=> 2),false);
		$cell_padding_right = $hg->size(array('m'=> 1), false);
		
		if ($count == 1)
			$size = array('M' => $col['size'], 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width));
		elseif ($count == $lastCol)
			$size = array('M' => $col['size'], 'm' => -2, 'u' => (-$cell_padding_right - $cell_padding_left - 2 * $border_width));
		else
			$size = array('M' => $col['size'], 'u' => (-$cell_padding_right - $cell_padding_left - $border_width));
		
		$this->Bl->TypeStyleFactory->widthGenerateClasses(array(0 => $size));
		if (isset($col['field']))
			$smartTableColumns[] = array(array('class' => $this->Bl->TypeStyleFactory->widthClassNames($size)), array(), $this->Paginator->sort($col['label'],$col['field']));
		else	
			$smartTableColumns[] = array(array('class' => $this->Bl->TypeStyleFactory->widthClassNames($size)), array(), $col['label']);
		$count++;
	}
	
	if ($totalSize == 12)
	{
		$classSize = array('M' => $totalSize);
		$this->Bl->TypeStyleFactory->widthGenerateClasses(array(0 => $classSize));
		$className = $this->Bl->TypeStyleFactory->widthClassNames($classSize);
		$className = $className[0];
		echo $this->Html->scriptBlock("
			$('backstage_custom_table').addClassName('".$className."');
		");
	}
	
	$classSize = array('M' => $totalSize, 'g' => -1);
	$this->Bl->TypeStyleFactory->widthGenerateClasses(array(0 => $classSize));
	$className = $this->Bl->TypeStyleFactory->widthClassNames($classSize);
	$className = $className[0];
	
	$modules = Configure::read('jj.modules');		
	if (isset($backstageSettings['customRow']) && $backstageSettings['customRow'])
		echo $this->Jodel->insertModule($modules[$moduleName]['model'], array('view', 'backstage_custom', 'table'));
	else
	{
		echo $this->Bl->ssmartTable(array('class' => 'backstage '.$className), array(
			'automaticColumnNumberHeaderClasses' => true, 
			'automaticRowNumberClasses' => true, 
			'rows' => array(
				'every1of3' => array('class' => 'main_info'), 
				'every2of3' => array('class' => 'extra_info'),
				'every3of3' => array('class' => 'actions')
			),
			'columns' => array(
				1 => array('class' => 'first_col'),
				$lastCol => array('class' => 'last_col')
			)
		));
	}
			echo $this->Bl->smartTableHeaderDry($smartTableColumns);
			
			foreach ($this->data as $k => $item)
			{
				if (isset($backstageSettings['customRow']) && $backstageSettings['customRow'])
					echo $this->Jodel->insertModule($modules[$moduleName]['model'], array('view', 'backstage_custom', 'row'), $item);
				else
				{
					$row_number = $k*3 + 2;
					$arrow = $this->Bl->sdiv(array('class' => 'arrow'))
							 . $this->Bl->anchor(array(), array('url' => ''), ' ')
							 . $this->Bl->ediv();
							 
					
					$smartTableRow = array();
					$count = 0;
					foreach($item[$modelName] as $index => $field)
					{
						$rowContent = '';
						if (array_key_exists($index, $backstageSettings['columns'])) 
						{
							if ($index == 'created' || $index == 'modified')
								$rowContent = strftime("%d/%m/%y", strtotime($field));
							elseif ($index == 'publishing_status')
								$rowContent = __d('dashboard', 'Dashboard status: ' . $field, true);
							else
								$rowContent = $field;
						}
						else
						{
							foreach($backstageSettings['columns'] as $key => $value)
							{
								if ($index == $value['field'])
								{
									if ($index == 'created' || $index == 'modified')
										$rowContent = strftime("%d/%m/%y", strtotime($field));
									elseif ($index == 'publishing_status')
										$rowContent = __d('dashboard', 'Dashboard status: ' . $field, true);
									else
										$rowContent = $field;
								}
							}
						}
						if (!empty($rowContent))
						{
							$count++;
							if($count == $lastCol)
								$smartTableRow[] = $arrow . $rowContent;
							else
								$smartTableRow[] = $rowContent;
						}
					}
					echo $this->Bl->smartTableRow(array('id' => 'row_'.$row_number), array(), $smartTableRow);
			
					//@todo Substitute this with an AJAX call.
					echo $this->Bl->smartTableRowDry(array(
						array(array(),array('colspan' => 3),' '), 
						array(array('id' => "item_info_$k"),array('colspan' => 4, 'rowspan' => 2), '')
					));
					
					
					// Does this entry has publishing and drafting capabilities?
					if (in_array('publish_draft', $backstageSettings['actions']))
					{
						$draftLink = $ajax->link(__d('dashboard','Hide from public', true), 			
							array(
								'plugin' => 'backstage',
								'controller' => 'back_contents',
								'action' => 'set_publishing_status',
								$moduleName,
								$item[$modelName]['id'], 'draft'
							), array(
								'complete' => "if(request.responseJSON.success) {showPopup('draft_alert_ok');} else {showPopup('draft_alert_failure');}",
								'class' => 'link_button'
							)
						);
					
						$publishLink = $ajax->link(__d('dashboard','Publish to the great public', true),
							array(
								'plugin' => 'backstage', 
								'controller' => 'back_contents',
								'action' => 'set_publishing_status',
								$moduleName,
								$item[$modelName]['id'], 'published'
							), array(
								'complete' => "if(request.responseJSON.success) {showPopup('publish_alert_ok');} else {showPopup('publish_alert_failure');}",
								'class' => 'link_button'
							)
						);
					}
					
					$links = $this->Bl->sdiv();
					
					if (in_array('delete', $backstageSettings['actions']))
					{
						$delete_url = $this->Html->url(array('plugin' => 'backstage', 'controller' => 'back_contents', 'action' => 'delete_item', $moduleName, $item[$modelName]['id']));
						$links .= $this->Bl->anchor(
							array(
								'class' => 'link_button',
								'onclick' => "deleteID = '". $delete_url . "'; showPopup('delete_alert_confirmation'); event.returnValue = false; return false;",
							), 
							array('url' => ''),
							__d('dashboard','Delete content', true)
						);
					}
					
					if (in_array('publish_draft', $backstageSettings['actions']))
					{
						$links .= $item[$modelName]['publishing_status'] == 'published' ? $draftLink : $publishLink;
					}
					
					// Default view action
					if (in_array('see_on_page', $backstageSettings['actions']))
					{
						$standardUrl = $this->Bl->moduleViewURL($moduleName,$item[$modelName]['id']);
						$links .= $this->Bl->anchor(
							array('class' => 'link_button'),
							array('url' => $standardUrl), 
							__d('dashboard', 'Dashboard: See on the page', true)
						);
					}
					
					if (in_array('edit', $backstageSettings['actions']))
					{
						 
						 $links .= $this->Bl->anchor(array('class' => 'link_button'), array('url' => array(
										'plugin' => 'backstage',
										'controller' => 'back_contents',
										'action' => 'edit',
										$moduleName,
										$item[$modelName]['id']
								 )
							 ), __d('dashboard','Dashboard: Edit', true)
						 );
					}
						 
					$links .= $this->Bl->ediv();
					
					echo $this->Bl->smartTableRowDry(array(
						array(array(),array('escape' => false, 'colspan' => 3),$links)
					));
					
					echo $this->Html->scriptBlock("
						new TableRow('row_$row_number');
					");
				}
			}
			
		echo $this->Bl->esmartTable();
	

?>