<?php 

echo $this->Bl->sbox(null, array('size' => array('M' => 7, 'g' => -1)));

	echo $this->Buro->sform(null, array('url' => $this->here));

		// Text
		echo $this->Buro->input(
			null,
			array(
				'type' => 'text',
				'fieldName' => 'text',
				'label' => 'Label for text input',
				'instructions' => 'Instructions for text input',
				'options' => array(
					'default' => 'Integer at enim eget tortor'
				)
			)
		);
	
		// Password
		echo $this->Buro->input(
			null,
			array(
				'type' => 'password',
				'fieldName' => 'password',
				'label' => 'Label for password input',
				'instructions' => 'Instructions for password input',
				'options' => array(
					'default' => 'Integer at enim eget tortor'
				)
			)
		);
		
		
		// Textarea
		echo $this->Buro->input(
			null,
			array(
				'type' => 'textarea',
				'fieldName' => 'textarea',
				'label' => 'Label for textarea input',
				'instructions' => 'Instructions for textarea input',
				'options' => array(
					'default' => 'Suspendisse dignissim ante sit amet leo bibendum rhoncus? Integer at enim eget tortor cursus tristique. Cras vel vehicula nisi? Phasellus nisl massa, commodo sed porttitor quis, imperdiet quis lacus. Aliquam erat volutpat. Sed dictum, dui blandit sodales dapibus, sapien massa mollis augue, in porta ligula odio vel sapien. Donec interdum metus eu nunc tristique mattis. Donec luctus aliquam lectus, quis fermentum arcu dignissim at.'
				)
			)
		);		
		
		// Textarea with textile controll
		echo $this->Buro->input(
			array(),
			array(
				'type' => 'textile',
				'fieldName' => 'textile',
				'label' => 'Label for textile input',
				'instructions' => 'Instructions for textile input',
				'options' => array(
					'allow' => array('bold', 'italic', 'link', 'title', 'image', 'file', 'subscript', 'superscript'),
					'allow_preview' => false,
					'default' => 'Enim eget tortor cursus tristique. Cras vel vehicula nisi? Phasellus nisl massa, commodo sed porttitor quis, imperdiet quis lacus. Aliquam erat volutpat. Sed dictum, dui blandit sodales dapibus, sapien massa mollis augue, in porta ligula odio vel sapien. Donec interdum metus eu nunc tristique mattis. Donec luctus aliquam lectus, quis fermentum arcu dignissim at.',
				)
			)
		);
	
		
		// One Checkbox
		// No default parameter, sadly
		$this->Form->data['checkbox'] = true;
		echo $this->Buro->input(
			null,
			array(
				'type' => 'checkbox',
				'fieldName' => 'checkbox',
				'label' => 'Label for checkbox input',
				'instructions' => 'Instructions for checkbox input',
				'options' => array(
					'label' => 'Sub-label for checkbox input'
				)
			)
		);
		
		
		// Radio boxes
		echo $this->Buro->input(
			null,
			array(
				'type' => 'radio',
				'fieldName' => 'radio',
				'label' => 'Label for radio input',
				'instructions' => 'Instructions for radio input',
				'options' => array(
					'default' => 'option_1',
					'options' => array(
						'option_1' => 'Option 1',
						'option_2' => 'Option 2',
						'option_3' => 'Option 3',
					)
				)
			)
		);
		
		// A set of checkboxes
		echo $this->Buro->input(
			null,
			array(
				'type' => 'multiple_checkbox',
				'fieldName' => 'multiple_checkbox',
				'label' => 'Label for multiple_checkbox input',
				'instructions' => 'Instructions for multiple_checkbox input',
				'options' => array(
					'default' => array('option_1', 'option_3'),
					'options' => array(
						'option_1' => 'Option 1',
						'option_2' => 'Option 2',
						'option_3' => 'Option 3',
					)
				)
			)
		);
		
		
		// A drop-down box 
		echo $this->Buro->input(
			null,
			array(
				'type' => 'select',
				'fieldName' => 'select',
				'label' => 'Label for select input',
				'instructions' => 'Instructions for select input',
				'options' => array(
					'empty' => true,
					'default' => 'option_2',
					'options' => array(
						'option_1' => 'Option 1',
						'option_2' => 'Option 2',
						'option_3' => 'Option 3',
					)
				)
			)
		);
		
		
		// Datetime without time
		echo $this->Buro->input(
			null,
			array(
				'type' => 'datetime',
				'fieldName' => 'datetime_wo_time',
				'label' => 'Label for datetime input without time',
				'instructions' => 'Instructions for datetime input without time',
				'options' => array(
					'empty' => false,
					'dateFormat' => 'DMY',
					'timeFormat' => null,
					'separator' => '-',
					'minYear' => date('Y')-50,
					'maxYear' => date('Y')
				)
			)
		);
		
		
		// Datetime without date
		echo $this->Buro->input(
			null,
			array(
				'type' => 'datetime',
				'fieldName' => 'datetime_wo_date',
				'label' => 'Label for datetime input without date',
				'instructions' => 'Instructions for datetime input without date',
				'options' => array(
					'empty' => false,
					'dateFormat' => 'NONE',
					'timeFormat' => '24'
				)
			)
		);
		
	
		// Datetime without complete
		echo $this->Buro->input(
			null,
			array(
				'type' => 'datetime',
				'fieldName' => 'datetime_complete',
				'label' => 'Label for datetime input complete',
				'instructions' => 'Instructions for datetime input complete',
				'options' => array(
					'empty' => true,
					'dateFormat' => 'DMY',
					'timeFormat' => '24',
					'separator' => '-',
					'minYear' => date('Y')-50,
					'maxYear' => date('Y')
				)
			)
		);
		
		// Upload of a file
		echo $this->Buro->input(
			null,
			array(
				'type' => 'upload',
				'fieldName' => 'upload',
				'label' => 'Label for a upload input',
				'instructions' => 'Instructions for a upload input'
			)
		);
		
		// Upload of a image
		echo $this->Buro->input(
			null,
			array(
				'type' => 'image',
				'fieldName' => 'upload',
				'label' => 'Label for a image upload input',
				'instructions' => 'Instructions a image for upload input',
				'options' => array(
					'version' => 'one_of_media_versions'
				)
			)
		);
		
		
	
		echo $this->Buro->sinput(
			null, 
			array(
				'type' => 'super_field',
				'label' => 'Label for super_field',
				'instructions' => 'Instructions for super_field'
			)
		);
		
			echo $this->Buro->input(
				null,
				array(
					'type' => 'text',
					'fieldName' => 'text_inside',
					'label' => 'Label for text input inside a super_field',
					'description' => 'Description for text input inside a super_field'
				)
			);
	
			echo $this->Buro->input(
				null,
				array(
					'type' => 'password',
					'fieldName' => 'password_inside',
					'label' => 'Label for password input inside a super_field',
					'description' => 'Description for password input inside a super_field'
				)
			);
	
		echo $this->Buro->einput();
		
		
		
	echo $this->Buro->eform();

echo $this->Bl->ebox();