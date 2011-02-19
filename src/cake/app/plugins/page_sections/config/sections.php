<?php
$config = array();

/**
 * Config file for the Section Handler, it has basically two important
 * indexes: 'sections' and 'sectionMap'.
 *
 * Usage:
 * 'sections' =>
 * <code>
 * 	$config['sections'] = array(
 * 	'section_name' => array(
 *		
 *		// This is the text that will be used in the menu link.
 *		// DEFAULTS: To humanized section name
 *		'linkCaption' => __('The Section', true),		
 *		
 *		// To were the link points - the section's address
 *		'url' => array(
 *			'plugin' => 'module',
 *			'controller' => 'controller',
 *			'action' => 'sobre'
 *		),
 *
 *		// If it should be displayed in a menu:
 *		// DEFAULTS: To true
 *		'display' => true,
 *
 *      // If the section is active, defaults to TRUE.
 *      'active' => false // or true, or 'admin', or 'adminTechie', or 'debug'
 *			
 *		// Array of titles given in the page title, 'null' indicates to use the previous section
 *		// title in this specific array position.
 *		// DEFAULTS: To the array of previous section appended with ['linkCaption']	
 *		'pageTitle' => array(null, __('The title of this section', true)), 
 *			
 *		// If the page has a header, this will be the Heading (h1 probably) that will be displayed
 *		// DEFAULTS: To ['linkCaption']	
 *		'headerCaption' => __('The Section', true),
 *			
 *		// If somewhere it's needed to show a human name other than for Heading, this is 
 *		// used.
 *		// DEFAULTS: To ['The Section']	
 *		'humanName' => __('The Section', true),
 *			
 *		//optional:  The module this section corresponds.
 *		'module' => 'SectionModule',
 *			
 *		// To wich ACO one must be authenticated in order to access this Sesssion.
 *		// If there is more than one it will be checked against all of them.
 *		// DEFAULTS TO: array('section_name' => array('read'))	
 *		'acos' => array('permission_area' => array('read')),
 *
 *      // In case if there is some agroupment in the same menu level.
 *      'sectionGroup' => 'this_group' 
 *		
 *		// The sub sections of this section
 *		'subSections' => array(
 *			'other_section_name' => 
 *			'another_section_name' => 			
 * )
 * );
 * </code>
 *
 * 'sectionMap':
 *	  $config['sectionMap'] => array(
 *			array( //an entry in the sectionMap - it provides a match rule the equivalent
 *				   //section, and the subRules for matching.
 *				'rule' => array('controller' => 'section_controller'), //it will match any action that has these parameters
 *				'location' => array('section_name'),
 *				'subRules' => array( //if the parent matches it searches 
 *					array(), 
 *					array(),
 *					array(),
 *				)
 *			)
 *		 );
 *
 */
 
 
$sections = array( 
  	'section1' => array(
 		'linkCaption' => __('Section One', true),		
 		'url' => array(
 			'plugin' => 'page_sections',
 			'controller' => 'testing',
 			'action' => 'section_one'
 		),
        'display' => true,
		'active' => true, 
		'pageTitle' => array(null, __('The Section One', true)),
		'headerCaption' => __('The Section One Header', true),
 		'humanName' => __('The Human Section One name', true),
		'acos' => array(),
		'subSections' => array(
			'section21' => array(
				'linkCaption' => 'Section Two.One',
				'url' => array(
					'plugin' => 'page_sections',
					'controller' => 'testing',
					'action' => 'section_two_one'
				)
			)
		),
 	 ),
	 'section2' => array(
 		'linkCaption' => __('Section Two', true),
		'acos' => array('section2'),
 		'url' => array(
 			'plugin' => 'page_sections',
 			'controller' => 'testing',
 			'action' => 'section_one'
 		)
 	 )
);
	 
$sectionMap = array(
	array(
		'rule' => array('plugin' => 'page_sections', 'controller' => 'testing', 'action' => 'section_one'),
		'location' => array('section1')
	),
	array(
		'rule' => array('plugin' => 'page_sections',  'controller' => 'testing', 'action' => 'section_two'),
		'location' => array('section2')
	),
	array(
		'rule' => array('plugin' => 'page_sections',  'controller' => 'testing', 'action' => 'section_two_one'),
		'location' => array('section2', 'section21')
	)
);

Configure::write('PageSections.sections', $sections);
Configure::write('PageSections.sectionMap', $sectionMap);

?>
