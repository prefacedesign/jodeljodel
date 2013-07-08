<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

switch ($type[0])
{
	case 'full':
		switch ($type[1])
		{
			case 'cork':
				if ($data['PieEntity']['type'] == 'general' && !empty($data['PieEntity']['url']))
				{
					echo $this->Bl->sanchor(
						array('class' => 'url'), 
						array('url' => $data['PieEntity']['url'])
					);
						echo $this->Bl->span(
							array('class' => 'full_name'), 
							array(), 
							$data['PieEntity']['full_name']
						);
					echo $this->Bl->eanchor();
				}
				else
				{
					echo $this->Bl->para(
						array('class' => 'full_name'), 
						array(), 
						array($data['PieEntity']['full_name'])
					);
				}
				if ($data['PieEntity']['type'] == 'person')
				{
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->sanchor(
							array('class' => 'url'), 
							array('url' => $data['PieEntity']['url'])
						);
					}
					echo $this->Bl->img(
						array('class' => 'photo'), 
						array('id' => $data['PieEntity']['photo'])
					);
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->eanchor();
					}
				}
				elseif ($data['PieEntity']['type'] == 'org')
				{
					echo $this->Bl->para(
						array('class' => 'org'), 
						array(), 
						array($data['PieEntity']['org'])
					);
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->sanchor(
							array('class' => 'url'), 
							array('url' => $data['PieEntity']['url'])
						);
					}
					echo $this->Bl->img(
						array('class' => 'logo'), 
						array('id' => $data['PieEntity']['logo'])
					);
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->eanchor();
					}
				}
				if (!empty($data['PieEntity']['note']))
				{
					echo $this->Bl->para(
						array('class' => 'note'), 
						array(), 
						array($data['PieEntity']['note'])
					);
				}
				if (!empty($data['PieEntity']['email']))
				{
					echo $this->Bl->anchor(
						array('class' => 'email'), 
						array('url' => 'mailto:'.$data['PieEntity']['email']), 
						$data['PieEntity']['email']
					);
				}
				if (!empty($data['PieEntity']['tel']))
				{
					echo $this->Bl->para(
						array('class' => 'tel'), 
						array(), 
						array($data['PieEntity']['tel'])
					);
				}
				if (!empty($data['PieEntity']['addr_street_address']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_street_address'), 
						array(), 
						array($data['PieEntity']['addr_street_address'])
					);
				}
				if (!empty($data['PieEntity']['addr_extended_address']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_extended_address'), 
						array(), 
						array($data['PieEntity']['addr_extended_address'])
					);
				}
				if (!empty($data['PieEntity']['addr_region']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_region'), 
						array(), 
						array($data['PieEntity']['addr_region'])
					);
				}
				if (!empty($data['PieEntity']['addr_country_name']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_country_name'), 
						array(), 
						array($data['PieEntity']['addr_country_name'])
					);
				}
				if (!empty($data['PieEntity']['addr_postal_code']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_postal_code'), 
						array(), 
						array($data['PieEntity']['addr_postal_code'])
					);
				}
				if (!empty($data['PieEntity']['addr_locality']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_locality'), 
						array(), 
						array($data['PieEntity']['addr_locality'])
					);
				}
				if (!empty($data['PieEntity']['category']))
				{
					echo $this->Bl->para(
						array('class' => 'category'), 
						array(), 
						array($data['PieEntity']['category'])
					);
				}
			break;
		}
	break;
	
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'PieEntity.PieEntity'));
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'id',
							'type' => 'hidden'
						)
					);
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'type',
							'type' => 'select',
							'label' => __d('content_stream', 'PieEntity.type label', true),
							'instructions' => __d('content_stream', 'PieEntity.type instructions', true),
							'options' => array('options' => array(
								'person' => __d('content_stream', 'PieEntity person type', true),
								'org' => __d('content_stream', 'PieEntity org type', true),
								'general' => __d('content_stream', 'PieEntity general type', true),
							))
						)
					);
					
					echo $this->Buro->input(
						array(), 
						array(
							'fieldName' => 'full_name',
							'type' => 'text',
							'label' => __d('content_stream', 'PieEntity.full_name label', true),
							'instructions' => __d('content_stream', 'PieEntity.full_name instructions', true),
						)
					);
					
					$style = '';
					if (!empty($data) && $data['PieEntity']['type'] == 'person')
					{
						$style = 'display: block';
					}
					elseif (!empty($data))
					{
						$style = 'display: none';
					}
					echo $this->Bl->sdiv(array('id' => 'person_fields', 'style' => $style), array());
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'photo',
								'type' => 'image',
								'label' => __d('content_stream', 'PieEntity.photo label', true),
								'instructions' => __d('content_stream', 'PieEntity.photo instructions', true),
								'options' => array('version' => 'backstage_preview'),
							)
						);
						
					echo $this->Bl->ediv();
					
					if (!empty($data) && $data['PieEntity']['type'] == 'org')
					{
						$style = 'display: block';
					}
					else
					{
						$style = 'display: none';
					}
					echo $this->Bl->sdiv(array('id' => 'org_fields', 'style' => $style), array());
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'org',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.org label', true),
								'instructions' => __d('content_stream', 'PieEntity.org instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'logo',
								'type' => 'image',
								'label' => __d('content_stream', 'PieEntity.logo label', true),
								'instructions' => __d('content_stream', 'PieEntity.logo instructions', true),
								'options' => array('version' => 'backstage_preview'),
							)
						);
					echo $this->Bl->ediv();
					
					echo $this->Bl->sdiv(
						array('id' => 'more_options_div', 'style' => 'margin-bottom:20px;'), 
						array()
					);
						echo $this->Bl->anchor(
							array('id' => 'more_options_link'), 
							array('url' => array()), 
							__d('content_stream', 'More options', true)
						);
					echo $this->Bl->ediv();
					echo $this->Bl->sdiv(
						array('id' => 'less_options_div', 'style' => 'display:none; margin-bottom: 10px;'), 
						array()
					);
						echo $this->Bl->anchor(
							array('id' => 'less_options_link'), 
							array('url' => array()), 
							__d('content_stream', 'Less options', true)
						);
					echo $this->Bl->ediv();
					
					echo $this->Bl->sdiv(array('id' => 'more_options_fields', 'style' => 'display:none'), array());
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'note',
								'type' => 'textarea',
								'label' => __d('content_stream', 'PieEntity.note label', true),
								'instructions' => __d('content_stream', 'PieEntity.note instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'url',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.url label', true),
								'instructions' => __d('content_stream', 'PieEntity.url instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'email',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.email label', true),
								'instructions' => __d('content_stream', 'PieEntity.email instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'tel',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.tel label', true),
								'instructions' => __d('content_stream', 'PieEntity.tel instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'addr_street_address',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.addr_street_address label', true),
								'instructions' => __d('content_stream', 'PieEntity.addr_street_address instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'addr_extended_address',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.addr_extended_address label', true),
								'instructions' => __d('content_stream', 'PieEntity.addr_extended_address instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'addr_region',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.addr_region label', true),
								'instructions' => __d('content_stream', 'PieEntity.addr_region instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'addr_country_name',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.addr_country_name label', true),
								'instructions' => __d('content_stream', 'PieEntity.addr_country_name instructions', true),
							)
						);
						
						
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'addr_postal_code',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.addr_postal_code label', true),
								'instructions' => __d('content_stream', 'PieEntity.addr_postal_code instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'addr_locality',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.addr_locality label', true),
								'instructions' => __d('content_stream', 'PieEntity.addr_locality instructions', true),
							)
						);
						
						echo $this->Buro->input(
							array(), 
							array(
								'fieldName' => 'category',
								'type' => 'text',
								'label' => __d('content_stream', 'PieEntity.category label', true),
								'instructions' => __d('content_stream', 'PieEntity.category instructions', true),
							)
						);
						
						echo $this->Bl->sdiv(
							array('id' => 'less_options_div2', 'style' => 'display:none; margin-bottom: 30px;'), 
							array()
						);
							echo $this->Bl->anchor(
								array('id' => 'less_options_link2'), 
								array('url' => array()), 
								__d('content_stream', 'Less options', true)
							);
						echo $this->Bl->ediv();
					echo $this->Bl->ediv();
					
					$this->Js->get('#PieEntityType')->event('change', '
						if ($("PieEntityType").value == "org")
						{
							$("org_fields").show();
							$("person_fields").hide();
						}
						else if ($("PieEntityType").value == "person")
						{
							$("org_fields").hide();
							$("person_fields").show();
						}
						else
						{
							$("org_fields").hide();
							$("person_fields").hide();
						}
					');
					
					$this->Js->get('#more_options_link')->event('click', '
						$("more_options_fields").show();
						$("more_options_div").hide();
						$("less_options_div").show();
						$("less_options_div2").show();
					');
					$this->Js->get('#less_options_link')->event('click', '
						$("more_options_fields").hide();
						$("more_options_div").show();
						$("less_options_div").hide();
						$("less_options_div2").hide();
						
						$("more_options_fields").select("input", "textarea").each(function (el) {
							el.value = "";
						});
					');
					$this->Js->get('#less_options_link2')->event('click', '
						$("more_options_fields").hide();
						$("more_options_div").show();
						$("less_options_div").hide();
						$("less_options_div2").hide();
						
						$("more_options_fields").select("input", "textarea").each(function (el) {
							el.value = "";
						});
					');
					echo $this->Js->writeBuffer();
					echo $this->Buro->submit(array(), array('cancel' => true));
					
				echo $this->Buro->eform();
				echo $this->Bl->floatBreak();
			break;
			
			case 'view':
				if ($data['PieEntity']['type'] == 'general' && !empty($data['PieEntity']['url']))
				{
					echo $this->Bl->sanchor(
						array('class' => 'url'), 
						array('url' => $data['PieEntity']['url'])
					);
						echo $this->Bl->span(
							array('class' => 'full_name'), 
							array(), 
							$data['PieEntity']['full_name']
						);
					echo $this->Bl->eanchor();
				}
				else
				{
					echo $this->Bl->para(
						array('class' => 'full_name'), 
						array(), 
						array($data['PieEntity']['full_name'])
					);
				}
				if ($data['PieEntity']['type'] == 'person')
				{
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->sanchor(
							array('class' => 'url'), 
							array('url' => $data['PieEntity']['url'])
						);
					}
					echo $this->Bl->img(
						array('class' => 'photo'), 
						array('id' => $data['PieEntity']['photo'], 'version' => 'backstage_preview')
					);
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->eanchor();
					}
				}
				elseif ($data['PieEntity']['type'] == 'org')
				{
					echo $this->Bl->para(
						array('class' => 'org'), 
						array(), 
						array($data['PieEntity']['org'])
					);
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->sanchor(
							array('class' => 'url'), 
							array('url' => $data['PieEntity']['url'])
						);
					}
					echo $this->Bl->img(
						array('class' => 'logo'), 
						array('id' => $data['PieEntity']['logo'], 'version' => 'backstage_preview')
					);
					if (!empty($data['PieEntity']['url']))
					{
						echo $this->Bl->eanchor();
					}
				}
				if (!empty($data['PieEntity']['note']))
				{
					echo $this->Bl->para(
						array('class' => 'note'), 
						array(), 
						array($data['PieEntity']['note'])
					);
				}
				if (!empty($data['PieEntity']['email']))
				{
					echo $this->Bl->anchor(
						array('class' => 'email'), 
						array('url' => 'mailto:'.$data['PieEntity']['email']), 
						$data['PieEntity']['email']
					);
				}
				if (!empty($data['PieEntity']['tel']))
				{
					echo $this->Bl->para(
						array('class' => 'tel'), 
						array(), 
						array($data['PieEntity']['tel'])
					);
				}
				if (!empty($data['PieEntity']['addr_street_address']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_street_address'), 
						array(), 
						array($data['PieEntity']['addr_street_address'])
					);
				}
				if (!empty($data['PieEntity']['addr_extended_address']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_extended_address'), 
						array(), 
						array($data['PieEntity']['addr_extended_address'])
					);
				}
				if (!empty($data['PieEntity']['addr_region']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_region'), 
						array(), 
						array($data['PieEntity']['addr_region'])
					);
				}
				if (!empty($data['PieEntity']['addr_country_name']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_country_name'), 
						array(), 
						array($data['PieEntity']['addr_country_name'])
					);
				}
				if (!empty($data['PieEntity']['addr_postal_code']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_postal_code'), 
						array(), 
						array($data['PieEntity']['addr_postal_code'])
					);
				}
				if (!empty($data['PieEntity']['addr_locality']))
				{
					echo $this->Bl->para(
						array('class' => 'addr_locality'), 
						array(), 
						array($data['PieEntity']['addr_locality'])
					);
				}
				if (!empty($data['PieEntity']['category']))
				{
					echo $this->Bl->para(
						array('class' => 'category'), 
						array(), 
						array($data['PieEntity']['category'])
					);
				}
				
			break;
		}
	break;
}
