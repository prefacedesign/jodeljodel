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
 * 		'section_name' => array(
 *		
 *		// This is the text that will be used in the menu link.
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
 *		)
 *	 );
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
 
 
 $config['sections'] = array(
 
  	'section_name' => array(
 		'linkCaption' => __('The Section', true),		
 		'url' => array(
 			'plugin' => 'module',
 			'controller' => 'controller',
 			'action' => 'sobre'
 		),
 
        'display' => true,
		'active' => 'adminTechie', 
		
 		'pageTitle' => array(null, __('The title of this section', true)), 
 		
		'headerCaption' => __('The Section', true),
		
 		'humanName' => __('The Section', true),
 		'module' => 'SectionModule',
 		
		'acos' => array('dinafon_publico' => array('read')),
        
		'sectionGroup' => 'this_group' 
 		'subSections' => array(
 			'other_section_name' => 
 			'another_section_name' => 			
 		)
 	 );
	
	 $config['sectionMap'] => array(
		array( //an entry in the sectionMap - it provides a match rule the equivalent
			   //section, and the subRules for matching.
			'rule' => array('controller' => 'section_controller'),
			'location' => array('section_name'),
			'subRules' => array(
				array(),
				array(),
				array(),
			)
		)
	 );
?>
