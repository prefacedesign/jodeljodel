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
	'public_page' => array(
		'linkCaption' => __('Sections: public_page linkCaption', true),
		'url' => array(
			'plugin' => false,
			'controller' => 'principal',
			'action' => 'index'
		),
		'display' => false,		
		'pageTitle' => array(__('Sections: public_page pageTitle',true)),
		'headerCaption' => __('Sections: public_page pageTitle', true),
		'humanName' => __('Sections: public_page humanName',true),
		
		'subSections' => array(
			'about' => array(
				'linkCaption' => __('Sections: about linkCaption', true),
				'url' => array(
					'plugin' => false,
					'controller' => 'principal',
					'action' => 'about'
				),
				'pageTitle' => array(null,__('Sections: about pageTitle',true)),
				'headerCaption' => __('Sections: about headerCaption', true),
				'humanName' => __('Sections: about humanName',true)
			),
			'contact' => array(
				'linkCaption' => __('Sections: contact linkCaption', true),
				'url' => array(
					'plugin' => false,
					'controller' => 'principal',
					'action' => 'contact'
				),
				'pageTitle' => array(null,__('Sections: contact pageTitle',true)),
				'headerCaption' => __('Sections: contact headerCaption', true),
				'humanName' => __('Sections: contact humanName',true)
			),
			'papers' => array(
				'linkCaption' => __('Sections: papers linkCaption', true),
				'url' => array(
					'plugin' => 'papers',
					'controller' => 'pap_papers',
					'action' => 'index'
				),
				'pageTitle' => array(null,__('Sections: papers pageTitle',true)),
				'headerCaption' => __('Sections: papers headerCaption', true),
				'humanName' => __('Sections: papers humanName',true)
			),
			'events' => array(
				'linkCaption' => __('Sections: events linkCaption', true),
				'url' => array(
					'plugin' => 'events',
					'controller' => 'eve_events',
					'action' => 'index'
				),
				'pageTitle' => array(null,__('Sections: events pageTitle',true)),
				'headerCaption' => __('Sections: events headerCaption', true),
				'humanName' => __('Sections: events humanName',true)
			),
			'news' => array(
				'linkCaption' => __('Sections: news linkCaption', true),
				'url' => array(
					'plugin' => 'news',
					'controller' => 'new_news',
					'action' => 'index'
				),
				'pageTitle' => array(null,__('Sections: news pageTitle',true)),
				'headerCaption' => __('Sections: news headerCaption', true),
				'humanName' => __('Sections: news humanName',true),
				'subSections' => array(
					'news_index' => array(
						'linkCaption' => __('Sections: news_index linkCaption', true),
						'url' => array(
							'plugin' => 'news',
							'controller' => 'new_news',
							'action' => 'index'
						),
						'pageTitle' => array(null, null, __('Sections: news_index pageTitle',true)),
						'headerCaption' => __('Sections: news_index headerCaption', true),
						'humanName' => __('Sections: news_index humanName',true)
					),					
					'news_item' => array(
						'linkCaption' => __('Sections: * linkCaption', true),
						'url' => array(
							'plugin' => 'news',
							'controller' => 'new_news',
							'action' => 'view'
						),
						'display' => false,
						'pageTitle' => array(null, null, __('Sections: news_item pageTitle',true)),
						'headerCaption' => __('Sections: news_item headerCaption', true),
						'humanName' => __('Sections: news_item humanName',true),
					),
				),
			),
		),
	),
	'backstage' => array(
		'linkCaption' => __('Sections: backstage linkCaption', true),
		'url' => array(
			'plugin' => 'backstage',
			'controller' => 'back_contents',
			'action' => 'index'
		),
		'acos' => array(
			'backstage_area' => array('read')
		),
		'pageTitle' => array(__('Sections: backstage pageTitle',true)),
		'headerCaption' => __('Sections: backstage headerCaption', true),
		'humanName' => __('Sections: backstage humanName',true),
		'subSections' => array(
			'login' => array(
				'linkCaption' => __('Sections: login linkCaption', true),
				'url' => array(
					'plugin' => 'JjUsers',
					'controller' => 'user_users',
					'action' => 'login'
				),
				'acos' => array(),
				'pageTitle' => array(null, __('Sections: login pageTitle',true)),
				'headerCaption' => __('Sections: login headerCaption', true),
				'humanName' => __('Sections: login humanName',true),
			),
			'dashboard' => array(
				'linkCaption' => __('Sections: dashboard linkCaption', true),
				'url' => array(
					'plugin' => 'dashboard',
					'controller' => 'dashboard',
					'action' => 'index'
				),
				'acos' => array('backstage_area' => array('read')),
				'pageTitle' => array(null, __('Sections: dashboard pageTitle',true)),
				'headerCaption' => __('Sections: dashboard headerCaption', true),
				'humanName' => __('Sections: dashboard humanName',true),
			),
			'burocrata_save' => array(
				'linkCaption' => __('Sections: burocrata_save linkCaption', true),
				'url' => array(
					'plugin' => 'burocrata',
					'controller' => 'buro_burocrata',
					'action' => 'save'
				),
				'display' => false,
				'acos' => array('backstage_area' => array('edit','create')),
			),
			'set_publishing_status' => array(
				'linkCaption' => __('Sections: set_publishing_status linkCaption', true),
				'url' => array(
					'plugin' => 'backstage',
					'controller' => 'back_contents',
					'action' => 'set_publishing_status'
				),
				'display' => false,
				'acos' => array('backstage_area' => array('publish')),
			),
			'dashboard_delete' => array(
				'linkCaption' => __('Sections: set_publishing_status linkCaption', true),
				'url' => array(
					'plugin' => 'dashboard',
					'controller' => 'dash_dashboard',
					'action' => 'delete_item'
				),
				'display' => false,
				'acos' => array('backstage_area' => array('delete')),
			),
			'corktile_edit' => array(
				'linkCaption' => __('Sections: corktile_edit linkCaption', true),
				'url' => array(
					'plugin' => 'cork',
					'controller' => 'cork_corktiles',
					'action' => 'edit'
				),
				'display' => false,
				'acos' => array('backstage_area' => array('edit','create')),
				'pageTitle' => array(null, __('Sections: corktile_edit pageTitle',true)),
				'headerCaption' => __('Sections: corktile_edit headerCaption', true),
				'humanName' => __('Sections: corktile_edit humanName',true),
			),
			'edit' => array(
				'linkCaption' => __('Sections: edit linkCaption', true),
				'url' => array(
					'plugin' => 'backstage',
					'controller' => 'back_contents',
					'action' => 'edit'
				),
				'display' => false,
				'acos' => array('backstage_area' => array('read')),
				'pageTitle' => array(null, __('Sections: edit pageTitle',true)),
				'headerCaption' => __('Sections: edit headerCaption', true),
				'humanName' => __('Sections: edit humanName',true),
				'subSections' => array(
					'news_edit' => array(
						'linkCaption' => __('Sections: news_edit linkCaption', true),
						'url' => array(
							'plugin' => 'backstage',
							'controller' => 'back_contents',
							'action' => 'edit',
							0 => 'person',
							1 => 'pers_person'
						),
						'acos' => array('new_news' => array('edit','read','create')),
						'pageTitle' => array(null, null, __('Sections: news_edit pageTitle',true)),
						'headerCaption' => __('Sections: news_edit headerCaption', true),
						'humanName' => __('Sections: news_edit humanName',true),
						'subSections' => array(
							'news_form' => array(
								'linkCaption' => __('Sections: news_form linkCaption', true),
								'url' => array(
									'plugin' => 'burocrata',
									'controller' => 'buro_burocrata',
									'action' => 'save',
									//We need an extra parameter to identify this subSection
								),
								'acos' => array('backstage_area' => 'read'),
								'humanName' => __('Sections: news_form humanName',true),
							),
						),
					),
				)
			),
		),
	),
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
		'acos' => array()
 	 ),
	 'section2' => array(
 		'linkCaption' => __('Section Two', true),
		'acos' => array('section2'),
 		'url' => array(
 			'plugin' => 'page_sections',
 			'controller' => 'testing',
 			'action' => 'section_two'
 		),
		'subSections' => array(
			'section21' => array(
				'linkCaption' => 'Section Two.One',
				'acos' => array('section21'),
				'url' => array(
					'plugin' => 'page_sections',
					'controller' => 'testing',
					'action' => 'section_two_one'
				)
			)
		),
 	 )
);
	 
$sectionMap = array(
	array(
		'rule' => array('controller' => 'principal', 'action' => 'index'),
		'location' => array('public_page')
	),
	array(
		'rule' => array('plugin' => 'news', 'controller' => 'new_news'),
		'location' => array('public_page','news'),
		'subRules' => array(
			array(
				'rule' => array('action' => 'index'),
				'location' => array('public_page','news','news_index'),
			),
			array(
				'rule' => array('action' => 'view'),
				'location' => array('public_page','news','news_item'),
			)
		),
	),
	array(
		'rule' => array('plugin' => 'backstage'),
		'location' => array('backstage'),
		'subRules' => array(
			array(
				'rule' => array('controller' => 'back_contents', 'action' => 'edit'),
				'location' => array(null,'edit'),
			),
			array(
				'rule' => array('controller' => 'back_contents', 'action' => 'set_publishing_status'),
				'location' => array(null,'set_publishing_status'),
			),
		),
	),
	array(
		'rule' => array('plugin' => 'dashboard'),
		'location' => array('backstage'),
		'subRules' => array(
			array(
				'rule' => array('controller' => 'dash_dashboard', 'action' => 'index'),
				'location' => array(null,'dashboard'),
			),
			array(
				'rule' => array('controller' => 'dash_dashboard', 'action' => 'delete_item'),
				'location' => array(null,'dashboard_delete'),
			),
		),
	),
	array(
		'rule' => array('plugin' => 'cork', 'controller' => 'cork_corktiles', 'action' => 'edit'),
		'location' => array('backstage','corktile_edit'),
	),
	array(
		'rule' => array('plugin' => 'burocrata', 'controller' => 'buro_burocrata', 'action' => 'save'),
		'location' => array('backstage','burocrata_save'),
	),
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