<?php
//debug($type);
switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				$dashboard_url = $this->Html->url(array('plugin' => 'backstage', 'controller' => 'back_contents', 'action' => 'index', 'user_permissions'));
					
				echo $this->Popup->popup('custom_notice',
					array(
						'type' => 'notice',
						'title' => __d('backstage', 'Your data has been saved - TITLE.',true),
						'content' => __d('backstage', 'Your data has been saved - TEXT.',true),
						'actions' => array(
							'ok' => __d('backstage', 'Your data has been saved - BACK TO DASHBOARD', true), 
							'edit' => __d('backstage', 'Your data has been saved - CONTINUE EDITING', true),
						),
						'callback' => "if (action=='ok') window.location = '$dashboard_url';"
					)
				);
				
				echo $this->Buro->sform(array(), array(
					'model' => $fullModelName,
					'callbacks' => array(
						'onStart' => array('lockForm', 'js' => 'form.setLoading()'),
						'onComplete' => array('unlockForm', 'js' => 'form.unsetLoading()'),
						'onReject' => array('js' => '$("content").scrollTo(); showPopup("error");', 'contentUpdate' => 'replace'),
						'onSave' => array('js' => '$("content").scrollTo(); showPopup("custom_notice");'),
					)
				));

					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'id',
							'type' => 'hidden',
						)
					);
	
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'name',
							'type' => 'text',
							'label' => __d('jj_users', 'user_permisson name label', true),
							'instructions' => __d('jj_users', 'user_permission name instructions', true)
						)
					);

					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'slug',
							'type' => 'text',
							'label' => __d('jj_users', 'user_permission slug label', true),
							'instructions' => __d('jj_users', 'user_permission slug instructions', true)
						)
					);
			
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'description',
							'type' => 'textarea',
							'label' => __d('jj_users', 'user_permission description label', true),
							'instructions' => __d('jj_users', 'user_permission description instructions', true)
						)
					);

					
					//Submit Box
					echo $this->Buro->submitBox(
						array(),
						array(
							'submitLabel' => __d('jj_users', 'submit label', true),
							'cancelUrl' => array('action' => 'index','user_permissions'), 'publishControls' => false
						)
					);
		
				echo $this->Buro->eform();
			break;
		
			
		
			default:
				# code...
			break;
		}
	break;
	
	case 'view':
		switch ($type[1])
		{
			case 'backstage_custom':
				switch ($type[2])
				{
					case 'search':
					
					break;
					
					case 'table':
						$classSize = array('M' => 12, 'g' => -1);
						$this->Bl->TypeStyleFactory->widthGenerateClasses(array(0 => $classSize));
						$className = $this->Bl->TypeStyleFactory->widthClassNames($classSize);
						$className = $className[0];
						
						echo $this->Bl->ssmartTable(array('class' => 'admin_users '.$className), array(
							'automaticColumnNumberHeaderClasses' => true, 
							'automaticRowNumberClasses' => true, 
							'rows' => array(
								'every1of1' => array('class' => 'main_info'), 
							),
							'columns' => array(
								1 => array('class' => 'first_col'),
								3 => array('class' => 'last_col')
							)
						));
						
					break;
					
					case 'row':
						$smartTableRow = array();
						$smartTableRow[] = $data['UserPermission']['name'];
						$smartTableRow[] = $data['UserPermission']['description'];
						
						
						$links = $this->Bl->sdiv(array('class' => 'actions', array()));
							
							$links .= $this->Bl->anchor(
								array('class' => 'link_button'), 
								array('url' => array(
									'action' => 'edit', 'user_permissions',
									$data['UserPermission']['id']
								)),
								__d('backstage','Edit', true)
							);
							
							$delete_url = $this->Html->url(array('action' => 'delete_item','user_permissions', $data['UserPermission']['id']));
							$links .= $this->Bl->anchor(
								array(
									'class' => 'link_button',
									'onclick' => "deleteID = '". $delete_url . "'; showPopup('delete_alert_confirmation'); event.returnValue = false; return false;",
								), 
								array('url' => ''),
								__d('backstage','Delete', true)
							);
							
								
						$links .= $this->Bl->ediv();
						$smartTableRow[] = $links;
						
						echo $this->Bl->smartTableRow(array('id' => 'row_'.$data['UserPermission']['id']), array(), $smartTableRow);

					break;
				}
			break;
		}
	break;
}
