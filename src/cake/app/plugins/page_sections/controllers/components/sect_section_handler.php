<?php

class SectSectionHandlerComponent extends Object {	
	var $controller;
	var $pageTitleArray = array();
	var $ourLocation = array();
	var $sectionMap = array();
	var $sections = array();
	var $thisSection = null;
	var $breadcrumb = array();
	
	/** Gets the controller action params, retrieves the configuration
	 *  and fetchs the current section and the current pageTitleArray.
	 */
	
	function initialize(&$controller) 
	{
		$this->controller =& $controller;
		
		App::import('Config', 'PageSections.sections');
		$this->sectionMap = Configure::read('PageSections.sectionMap');
		$this->sections = Configure::read('PageSections.sections');
		
		$this->_insertDefaultsIntoSections();		
		$this->_setOurLocation($this->controller->params);		
		$this->_mountPageTitleArray();		
		$this->_populateThisSectionOptions();
		$this->_createBreadcrumb();
	}
	
	/**
	 * Sends the view vars.
	 */
	function beforeRender(&$controller) 
	{
		$this->_setTheViewVars();
	}
	
	/**
	 * Allows/denys access to the action according to the permissions
	 * set. It only checks wheter it's a public action or controlled
	 * access action.
	 */
	function startup(&$controller)
	{
		if (isset($controller->Auth))
		{
			if (empty($this->thisSection['acos']))
				$controller->Auth->allow($controller->params['action']);
			else
				$controller->Auth->deny($controller->params['action']);
		}
	}
	 
	
	/**
	 * Adds an array to the existing page title array.
	 *
	 * @param array $newArray The array that will be added. If it has null entries,
	 *				the corresponding key of the existing array will be used.
	 */
	function addToPageTitleArray($newArray)
	{
		foreach($newArray as $k => $value)
		{
			if ($value == null)
				$newArray[$k] = $this->pageTitleArray[$k];
		}
		
		$this->pageTitleArray = $newArray;
	}
	
	/**
	 * Appends to the pageTitleArray another title.
	 *
	 * @param string $title The title that will be appended.
	 */
	function appendToPageTitleArray($title)
	{
		$this->pageTitleArray[] = $title;
	}

	/** Uses the 'sections' array to set the pageTitleArray,
	 *  according to OurLocation.
	 * 
	 */
	function _mountPageTitleArray()
	{	
		$currentSectionContext =& $this->sections;
		
		foreach($this->ourLocation as $section)
		{
			if (isset($currentSectionContext[$section]))
			{
				if (isset($currentSectionContext[$section]['pageTitle']))
				{
					if (!is_array($currentSectionContext[$section]['pageTitle']))
					{
						trigger_error('SectSectionsHandler::_mountPageTitleArray - pageTitle must be an array (section "'.$section.'")');
						return false;
					}
					$this->addToPageTitleArray($currentSectionContext[$section]['pageTitle']);
				}
				if (isset($currentSectionContext[$section]['subSections']))
					$currentSectionContext =& $currentSectionContext[$section]['subSections'];
				else
					break;
			}
		}
	}

/** 
 * Uses the pageTitle array to get the PageTitle.
 * 
 * @access protected
 * @return string With the pageTitle.
 */
	function _getPageTitle()
	{
		if (empty($this->pageTitleArray))
			return '';
		
		$titleArray = $this->pageTitleArray;		
		$title = array_pop($titleArray);
		
		while(!empty($titleArray))
			$title = $title . ' – ' . array_pop($titleArray);
			
		return $title;
	}
	
/** 
 * Sets $this->_thisSection with the current section options()
 * 
 * @access protected
 * @return string With the pageTitle.
 */
	function _populateThisSectionOptions()
	{
		$section =& $this->sections;
	
		$theFirst = true;
		foreach ($this->ourLocation as $k => $sectionName)
		{
			if ($sectionName != null)
			{
				$ourSectionName = $sectionName;
				if ($theFirst)
				{
					$section =& $section[$sectionName];
					$theFirst = false;
				}
				else
				{
					$section =& $section['subSections'][$sectionName];
				}
			}
		}
		
		if (isset($ourSectionName))
			$this->thisSection = am(array('sectionName' => $sectionName), $section);
		else
			$this->thisSection = null;
	}
	
/**
 * Sets the ourLocationArray, using the action parameters and the sectionMap.
 * If one sets the $forceLocation, it will be used instead of the calculated
 * location.
 * 
 * @param array $actionInfo Cake's action parameters.
 * @param array $forcedLocation Sets to the given location, instead of 
 * 		calculating it.
 */
	function _setOurLocation($actionInfo, $forcedLocation = null)
	{
		if ($forcedLocation !== null)
		{
			$this->ourLocation = $forcedLocation;
		}
		else
		{
			$this->ourLocation = array();
			
			$sectionMapContext =& $this->sectionMap;
			while(($sectionIndex = $this->_findTheActionsSection($actionInfo, $sectionMapContext)) !== false)
			{
				//in this context $sectionIndex is a number
				$this->ourLocation = $this->_joinLocations($this->ourLocation, $sectionMapContext[$sectionIndex]['location']);
				if (!isset($sectionMapContext[$sectionIndex]['subRules']))
				    break;
				else
					$sectionMapContext =& $sectionMapContext[$sectionIndex]['subRules'];
			}
		}
	}
	
/**
 * Merges $over on $base, but does not include keys that aren't in $over.
 * The values that will merge are those that are set to null.
 *
 * @access protected
 * @param array $base Base location.
 * @param array $over New location (if one value is null uses the base's equivalent position)
 */
	function _joinLocations($base, $over)
	{
		foreach($over as $k => $overItem)
		{
			if ($overItem === null)
				$over[$k] = $base[$k];
		}
		
		return $over;
	}

/**
 * Sets the ourLocationArray, using the action parameters and the sectionMap.
 * If one sets the $forceLocation, it will be used instead of the calculated
 * location.
 * 
 * @access protected
 * @param array $actionInfo Cake's action parameters.
 * @param array $subSectionMap
 * @return 
 */
	function _findTheActionsSection($actionInfo, &$subSectionMap)
	{
		foreach ($subSectionMap as $k => $sectionData)
		{
			if ($this->_matchActionData($actionInfo, $sectionData['rule']))
				return $k;
		}
		return false;
	}

/**
 * Create an array with all nested section names and stores it on $this->breadcrumb
 * 
 * @access protected
 * @return void
 */
	function _createBreadcrumb()
	{
		$breadcrumb = array();
		$currentSectionContext =& $this->sections;
		
		foreach($this->ourLocation as $section)
		{
			if (isset($currentSectionContext[$section]))
			{
				if (isset($currentSectionContext[$section]['humanName']))
					$breadcrumb[] = $currentSectionContext[$section]['humanName'];
				
				if (isset($currentSectionContext[$section]['subSections']))
					$currentSectionContext =& $currentSectionContext[$section]['subSections'];
				else
					break;
			}
		}
		$this->breadcrumb = $breadcrumb;
	}

/**
 * Checks whether the action params fits the matching rule.
 * 
 * @access protected
 * @param array $actionInfo Cake's action parameters.
 * @param array $rules How should it be to match?
 * @return boolean Returns true if matches, and false, otherwise.
 */
	function _matchActionData($actionInfo, $rules)
	{
		foreach($rules as $type => $rule)
		{
			if (!isset($actionInfo[$type]))
				return false;
			if (is_array($rule))
			{
				foreach($rule as $subType => $subRule)
				{
					if (isset($actionInfo[$type][$subType]) &&  $actionInfo[$type][$subType] != $subRule)
						return false;
				}
			}
			else
			{
				if($actionInfo[$type] != $rule)
					return false;
			}
		}
		return true;
	}
	
/**
 * Send to the view, information about where we are now and sets the pageTitle.
 *
 * @access protected
 */
	function _setTheViewVars()
	{
		$this->controller->set('title_for_layout', $this->_getPageTitle());
		$this->controller->set('ourLocation', $this->ourLocation);
		$this->controller->set('breadcrumb', $this->breadcrumb);
		$this->controller->set('pageSections', $this->sections);
		$this->controller->set('sectionInfo', $this->thisSection);
	}
	
/**
 * Fills the blanks in the sections' configurations, recusively.
 *
 * @access protected
 * @param array $sectionsContext
 * @param int $depth
 * @return void
 */
	function _insertDefaultsIntoSections(&$sectionsContext = null, $depth = 0)
	{ 
		if ($sectionsContext == null)
			$sectionsContext =& $this->sections;
	
		foreach ($sectionsContext as $k => $section)
		{
			if (!isset($section['linkCaption']))
				$sectionsContext[$k]['linkCaption'] = Inflector::humanize($k); 
		
			if (!isset($section['active']))
				$sectionsContext[$k]['active'] = true;
				
			if (!isset($section['display']))
				$sectionsContext[$k]['display'] = true;
				
			if (!isset($section['pageTitle']))
			{
				$pageTitle = array();
				for ($i = 0; $i < $depth; $i++)
					$pageTitle[] = null;
				$pageTitle[] = $section['linkCaption'];
				
				$sectionsContext[$k]['pageTitle'] = $pageTitle;
			}
			
			if (!isset($section['headerCaption']))
				$sectionsContext[$k]['headerCaption'] = $section['linkCaption'];
				
			if (!isset($section['humanName']))
				$sectionsContext[$k]['humanName'] = $section['linkCaption'];
				
			if (!isset($section['acos']))
				$sectionsContext[$k]['acos'] = array();
			
			if (isset($section['subSections']))
				$this->_insertDefaultsIntoSections($sectionsContext[$k]['subSections'], $depth + 1);
		}
	}
}
?>