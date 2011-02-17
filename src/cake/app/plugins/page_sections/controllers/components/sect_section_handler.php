<?php

// @todo Add ACL handling.

/** Merges two arrays also in its numeric keys. Instead of appending the
 *  numeric keys.
 */
// function am_numeric_keys($a1, $a2)
// {
	// $aNew = array();
	
	// foreach($a1 as $k => $value)
	// {
		// if (isset($a2[$k]))
		// {
			// $aNew[$k] = $a2[$k];
			// unset($a2[$k]);
		// }
		// else
			// $aNew[$k] = $value;
	// }
	
	// $aNew += $a2;
	
	// return $aNew;
// }


class SectSectionHandlerComponent extends Object {

	var $controller;
	var $pageTitleArray = array();
	var $ourLocation = array();
	var $sectionMap = array();
	var $sections = array();
	
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
	}
	
	/**
	 * Sends the view vars.
	 */
	function beforeRender(&$controller) 
	{
		$this->_setTheViewVars();
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
			if ($value === null)
				$newArray[$k] == $this->pageTitleArray[$k];
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
			if (isset($c[$section]))
			{
				if (isset($currentSectionContext[$section]['pageTitle']))
					$this->addToPageTitleArray($currentSectionContext[$section]['pageTitle']);
				
				if (isset($$currentSectionContext[$section]['subSections']))
					$currentSectionContext =& $$currentSectionContext[$sectioin]['subSections'];
				else
					break;
			}
		}
	}
	
	/** Uses the pageTitle array to get the PageTitle .
	 * 
	 * @return string With the pageTitle.
	 */
	function _getPageTitle()
	{
		if (empty($this->pageTitleArray))
			return '';
		
		$titleArray = $this->pageTitleArray;		
		$title = array_pop($titleArray);
		
		while(!empty($titleArray))
			$titleArray =  $titleArray . ' – ' . array_pop($titleArray);
			
		return $title;
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
	 * @param array $actionInfo Cake's action parameters.
	 * @param array $forcedLocation Sets to the given location, instead of 
	 * 		calculating it.
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
	 * Sees whether the action params fits the matching rule.
	 * 
	 * @param array $actionInfo Cake's action parameters.
	 * @param array $rules How should it be to match?
	 */
	
	function _matchActionData($actionInfo, $rules)
	{
		foreach($rules as $type => $rule)
		{
			if (!isset($actionInfo[$type]))
				return false;
			if($actionInfo[$type] != $rule)
				return false;
		}
		return true;
	}
	
	/**
	 * Send to the view, information about where we are now and sets the pageTitle.
	 */
	function _setTheViewVars()
	{
		$this->controller->pageTitle = $this->_getPageTitle();
		$this->controller->set('ourLocation', $this->ourLocation);
		$this->controller->set('pageSections', $this->sections);
	}
	
	/**
	 * Fills the blanks in the sections' configurations.
	 */
	function _insertDefaultsIntoSections($sectionsContext = null, $depth = 0)
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
				$sectionsContext[$k]['acos'] = array($k => array('read'));
			
			if (isset($section['subSections']))
				$this->_insertDefaultsIntoSections($sectionsContext[$k]['subSections'], $depth + 1);
		}
	}
}
?>