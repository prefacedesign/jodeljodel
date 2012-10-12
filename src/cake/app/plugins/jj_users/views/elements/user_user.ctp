<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				
				if (isset($type[2]) && $type[2] == 'preferences')
				{
					echo $this->Buro->sform(array(), 
						array(
							'model' => 'JjUsers.UserUser',
							'url' => array('plugin' => 'jj_users', 'controller' => 'user_users', 'action' => 'preferences'),
							'callbacks' => array(
								'onSave' => array('contentUpdate' => 'replace', 'js' => 'showPopup("notice")'),
								'onReject' => array('contentUpdate' => 'replace', 'js' => 'showPopup("error")')
							)
						)
					);
				}
				else
				{
					$dashboard_url = $this->Html->url(array('plugin' => 'backstage', 'controller' => 'back_contents', 'action' => 'index', 'user_users'));
					
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
				}

					echo $this->Buro->sinput(
						array(),
						array(
							'type' => 'super_field',
							'label' => __d('jj_users', 'name_surname super_field label', true),
							'instructions' => __d('jj_users', 'name_surname super_field instructions', true)
						)
					);
	
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'name',
								'type' => 'text',
								'label' => __d('jj_users', 'name label', true),
								'instructions' => __d('jj_users', 'name instructions', true)
							)
						);
	
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'surname',
								'type' => 'text',
								'label' => __d('jj_users', 'surname label', true),
								'instructions' => __d('jj_users', 'surname instructions', true)
							)
						);
			
	
					echo $this->Buro->einput();
		
					echo $this->Buro->sinput(
						array(),
						array(
							'type' => 'super_field',
							'label' => __d('jj_users', 'account super_field label', true),
							'instructions' => __d('jj_users', 'account super_field instructions', true)
						)
					);
		
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'username',
								'type' => 'text',
								'label' => __d('jj_users', 'username label', true),
								'instructions' => __d('jj_users', 'username instructions', true)
							)
						);
			
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'password_change',
								'type' => 'text',
								'label' => __d('jj_users', 'password_change label', true),
								'instructions' => __d('jj_users', 'password_change instructions', true)
							)
						);
			
						echo $this->Buro->input(
							array(),
							array(
								'fieldName' => 'password_retype',
								'type' => 'text',
								'label' => __d('jj_users', 'password_retype label', true),
								'instructions' => __d('jj_users', 'password_retype instructions', true)
							)
						);
					echo $this->Buro->einput();
		
					if (!isset($type[2]))
					{	
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
								'fieldName' => 'validate_profiles',
								'type' => 'hidden',
							)
						);
						
						echo $this->Buro->input(
							null,
							array(
								'type' => 'relational',
								'fieldName' => 'UserProfile',
								'label' => __d('jj_users', 'UserProfile label', true),
								'instructions' => __d('jj_users', 'UserProfile instructions', true),
								'options' => array(
									'type' => 'multiple_checkbox',
									'model' => 'JjUser.UserProfile'
								)
							)
						);
						
					}
					
					if (!isset($type[2]))
					{
						//Submit Box
						echo $this->Buro->submitBox(
							array(),
							array(
								'submitLabel' => __d('jj_users', 'submit label', true),
								'cancelUrl' => array('action' => 'index','user_users'), 'publishControls' => false
							)
						);
					}
					else
					{
						echo $this->Buro->submitBox(
							array(),
							array(
								'submitLabel' => __d('jj_users', 'submit label', true)
							)
						);
					}
		
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
						$classSize = array('M' => 9, 'g' => -1);
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
						
								
						echo $this->Popup->popup('new_password_ok', array(
							'type' => 'notice',
							'title' => __d('backstage','New password success title',true),
							'content' => __d('backstage','New password success content.',true),
							'actions' => array('ok' => 'OK')
						));
						
						echo $this->Popup->popup('new_password_failure', array(
							'type' => 'error',
							'title' => __d('backstage','New password new_password_failure title',true),
							'content' => __d('backstage','New password new_password_failure content.',true),
							'actions' => array('ok' => 'OK')
						));
						
					break;
					
					case 'row':
						$smartTableRow = array();
						$smartTableRow[] = $data['UserUser']['name'];
						
						if (!empty($data['UserProfile']))
						{
							$profiles = '';
							foreach($data['UserProfile'] as $profile)
								$profiles .= $profile['name'] . ', ';
							$profiles = substr($profiles, 0, strlen($profiles) -2);
							$smartTableRow[] = $profiles;
						}
						else
							$smartTableRow[] = '&nbsp;';
						
						
						$links = $this->Bl->sdiv(array('class' => 'actions', array()));
							
							$curModule = Configure::read('jj.modules.user_users');
							
							$class = 'link_button';
							$onclick = '';
							if (isset($curModule['permissions']) && isset($curModule['permissions']['edit']))
							{
								if (!$this->JjAuth->can($curModule['permissions']['edit']))
								{
									$onclick = "return false;";
									$class = 'link_button disabled';
								}
							}
							
							$links .= $this->Bl->anchor(
								array('class' => $class, 'onclick' => $onclick), 
								array('url' => array(
									'action' => 'edit', 'user_users',
									$data['UserUser']['id']
								)),
								__d('backstage','Edit', true)
							);
							
							$delete_url = $this->Html->url(array('action' => 'delete_item','user_users', $data['UserUser']['id']));
							$class = 'link_button';
							$onclick = "deleteID = '". $delete_url . "'; showPopup('delete_alert_confirmation'); event.returnValue = false; return false;";
							if (isset($curModule['permissions']) && isset($curModule['permissions']['delete']))
							{
								if (!$this->JjAuth->can($curModule['permissions']['delete']))
								{
									$onclick = "return false;";
									$class = 'link_button disabled';
								}
							}
							
							$links .= $this->Bl->anchor(
								array(
									'class' => $class,
									'onclick' => $onclick,
								), 
								array('url' => ''),
								__d('backstage','Delete', true)
							);
							
							/*
							//@TODO implement the new_password method			
							$links .= $ajax->link(__d('backstage','New password', true), 			
								array(
									'plugin' => 'jj_users',
									'controller' => 'user_users',
									'action' => 'new_password', $data['UserUser']['id']
								), array(
									'complete' => "if(request.responseJSON.success) {showPopup('new_password_ok');} else {showPopup('new_password_failure');}",
									'class' => 'link_button'
								)
							);
							*/
							
						$links .= $this->Bl->ediv();
						$smartTableRow[] = $links;
						
						echo $this->Bl->smartTableRow(array('id' => 'row_'.$data['UserUser']['id']), array(), $smartTableRow);

					break;
				}
			break;
		}
	break;
}
