<?php

class TypeBricklayerHelper extends AppHelper
{

/**
 * ???
 * 
 * @access public
 * @var array
 * @todo Something (this variable is not in use)
 */
	static $automatic_tags = array(
		'html','head','title','link','body',
		'h1','h2','h3','h4','div','br','span','hr','img',
		'form', 'input','textarea','p', 'em','a','script', 'small',
		'hr','script', 'object', 'param'
	);

/**
 * Used to avoid putting a new line caracter after closing the tag
 * 
 * @access public
 * @var array
 * @see TypeBricklayerHelper::etag
 */
	static $tags_without_space_after = array(
		'i', 'em', 'span', 'a', 'strong'
	);

/**
 * Defines witch tags will force close_me = false
 * 
 * @access public
 * @var array
 * @link http://www.w3schools.com/tags/default.asp
 * @see TypeBricklayerHelper::tag
 */
	static $tags_that_need_closing_tag = array(
		'a','abbr','acronym','address','b','bdo','big','blockquote','body','button','caption','cite',
		'code','colgroup','dd','del','dfn','div','dl','dt','em','fieldset','form','frameset','h1','h2','h3','h4','h5','h6',
		'head','html','i','iframe','ins','kbd','label','legend','li','map','noframes','noscript','object','ol','optgroup',
		'option','p','pre','q','samp','script','select','small','span','strong','style','sub','sup','table','tbody','td',
		'textarea','tfoot','th','thead','title','tr','tt','ul','var'
	);

/**
 * Avoid routing the tag method for a e{tag} (end tag method)
 * 
 * @access public
 * @var array
 */
	static $tags_that_begin_with_e = array(
		'em'
	);

/**
 * Avoid routing the tag method for a s{tag} (start tag method)
 * 
 * @access public
 * @var array
 */
	static $tags_that_begin_with_s = array(
		'samp','script','select','small','span','strong','style'
	);

/**
 * Helpers
 * 
 * @access public
 * @var array
 */
	var $helpers = array(
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'TypeStyleFactory'
		)
	);	
	

	
	
	function __construct($options)
	{
		parent::__construct($options);
	
		if (isset($options['receive_tools']) && $options['receive_tools'])
		{
			foreach($options['tools'] as $tool_name => $tool)
			{
				$this->{$tool_name} = $tool;
			}
		}
	}
	
	//@todo Find better placement for this function.
	public function _mergeAttributes($atr1, $atr2)
	{
		if ($atr1 == null)
			$atr1 = array();
		
		if ($atr2 == null)
			$atr2 = array();
			
		return array_merge_recursive($atr1, $atr2);
	}

	
/**
 * Creates a menu, given the menuLevel desired, and some options. It uses menuItem(), for each menuItem.
 * 
 * @access public
 * @param array $htmlAttr
 * @param array $options
 * @return string
 */
	function menu($htmlAttr = array(), $options = array())
	{
		$options += array(
			'menuLevel' => 0,
			'writeCaptions' => true,
			'specificClasses' => true,
			'hiddenCaptions' => false,
			'wrapTag' => 'div'
		);
		
		extract($options);
		$htmlAttr += array('class' => array('menu','menu_'.$menuLevel));
		
		$View = ClassRegistry::getObject('view');
		$ourLocation = $View->getVar('ourLocation');
		
		$sections = $View->getVar('pageSections');
		
		if (empty($ourLocation))
		{
			trigger_error('MexicoTypeBricklayerHelper::menu() - Unknown location. Check if you properly filled the $sectionMap on page_section plugin.config.');
			return false;
		}
		
		for ($i = 0; $i < $menuLevel; $i++)
		{
			if (isset($sections[$ourLocation[$i]]['subSections']))
				$sections = $sections[$ourLocation[$i]]['subSections'];
			else
				return false;
		}
		
		$items = array();
		foreach($sections as $sectionName => $sectionSettings)
			if ($sectionSettings['active'] && $sectionSettings['display'])
				$items[] = $this->menuItem(array(), compact('sectionName','sectionSettings','writeCaptions','specificClasses','menuLevel','hiddenCaptions'));
		
		return $this->tag($wrapTag, $htmlAttr, array('close_me' => false), implode("\n", $items));
	}
	
/**
 * Creates a menuItem, given the menuLevel desired, and some options. Used by menu().,
 * 
 * @access public
 * @param array $htmlAttr
 * @param array $options
 * @return string
 */
	function menuItem($htmlAttr = array(), $options = array())
	{

		$View = ClassRegistry::getObject('view');
		$ourLocation = $View->getVar('ourLocation');
	
		$options += array(
			'menuLevel' => 0,
			'writeCaptions' => true,
			'specificClasses' => true,
			'hiddenCaptions' => false
		);
		extract($options);
		
		$defaultHtmlAttr = array();
		if ($specificClasses)
			$defaultHtmlAttr['class'][] = 'menu_item_' . $menuLevel . '_' . $sectionName;
		
		if ($ourLocation[$menuLevel] == $sectionName)
			$defaultHtmlAttr['class'][] = 'selected';
		
		$htmlAttr += $defaultHtmlAttr;
		if (!isset($anchorOptions))
			$anchorOptions = array();
		
		$anchorOptions['url'] = $sectionSettings['url'];
		$content = $writeCaptions ? $sectionSettings['linkCaption'] : ' ';
		
		if ($hiddenCaptions)
			$content = $this->hiddenSpanDry($content);
		
		return $this->anchor($htmlAttr, $anchorOptions, $content);
	}

/**
 * Just an alias for fileURL
 *
 * @access public
 * @param integer $id The file id of the image
 * @param string $version The filter version of image to be displayed
 * @return string|boolean The URL that points to the picture or false, if wasn´t possible to create the url.
 */
	public function imageURL($id, $version = '')
	{
		return $this->fileURL($id, $version);
	}


/**
 * Returns a link for the requested image
 * 
 * @access public
 * @param integer $id The file id of the image
 * @param string $version The filter version of image to be displayed
 * @return string|boolean The URL that points to the picture or false, if wasn´t possible to create the url.
 */
	public function fileURL($id, $version = '', $force_download = false)
	{
		if (!$id)
			return false;
		
		$url = array('plugin' => 'jj_media', 'controller' => 'jj_media', 'action' => 'index');
		if ($force_download)
			array_push($url, '1');
		
		App::import('Lib', array('JjUtils.SecureParams'));
		$packed_params = SecureParams::pack(array($id, $version), true);
		array_push($url, $packed_params);
		
		return $this->url($url);
	}

/**
 * Returns properties of the image, like extension and sizes
 * 
 * @access public
 * @param integer $id The file id of the image
 * @param string $version The filter version of image to be displayed
 * @return array An array with the properties
 */
	public function imageProperties($id, $version = '')
	{
		if (!$id)
			return false;
		
		App::import('Model', array('JjMedia.SfilStoredFile'));
		$Media = new SfilStoredFile();
		
		return $Media->properties($id, $version);
	}
	
/**
 * Creates a img tag pointing the specific image, if an ID is provided.
 * 
 * @access public
 * @param $htmlAttributes
 * @param $options
 * @return The HTML of <img> tag
 */
	public function simg($htmlAttributes = array(), $options = array())
	{
		$options = $options + array('id' => null, 'version' => null);
		$htmlAttributes = $htmlAttributes + array('alt' => '', 'src' => '');
		$options['close_me'] = true;
		
		if (!empty($options['id']))
		{
			$htmlAttributes['src'] = $this->imageURL($options['id'], $options['version']);
			unset($options['version']);
			unset($options['id']);
		}
		return $this->stag('img', $htmlAttributes, $options);
	}


	/* $opcoes = array(
			'tam' => tamanho de grade
	 */
	
	function sboxContainer($attr, $options)
	{
		$own_attr = array(
			'class' => array('box_container')
		);
		
		if (isset($options['size']))
		{
			$this->TypeStyleFactory->widthGenerateClasses(array(0 => $options['size']));
			$own_attr['class'] = am($own_attr['class'], $this->TypeStyleFactory->widthClassNames($options['size']));
		}
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
		
		unset($options['size']);
		
		return $this->sdiv($attr, $options);
	}
	
	function eboxContainer()
	{
		return $this->ediv();
	}
	
	function sbox($attr, $options)
	{
		$own_attr = array(
			'class' => array('box')
		);
		
		//falta incorporar ainda um monte de opções possíveis para as caixas
		//e ainda um monte de coisas
		if (isset($options['size']))
		{
			$this->TypeStyleFactory->widthGenerateClasses(array(0 => $options['size']));
			$own_attr['class'] = am($own_attr['class'], $this->TypeStyleFactory->widthClassNames($options['size']));
		}
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
		
		unset($options['size']);
		
		return $this->sdiv($attr, $options);
	}
	
	function ebox()
	{
		return $this->ediv();
	}
	// This is the old "limpador"
	function floatBreak($attr = array(), $options = null)
	{
		$own_attr = array(
			'class' => array('float_break')
		);

		

		if (isset($options['height']))
		{
			$this->TypeStyleFactory->heightGenerateClasses(array(0 => $options['height']));
			$tmp = $this->TypeStyleFactory->heightClassNames($options['height']);
			$own_attr['class'][] = $tmp[0];
			unset($options['height']);
		}
		
		if (isset($options['width']))
		{
			$this->TypeStyleFactory->widthGenerateClasses(array(0 => $options['width']));
			$tmp = $this->TypeStyleFactory->widthClassNames($options['width']);
			$own_attr['class'][] = $tmp[0];
			unset($options['width']);
		}
		
		$attr = $this->_mergeAttributes($attr, $own_attr);

		return $this->div($attr, $options, ' ');
	}
	
	function spara($attr = array(), $options = array())
	{
		$own_attr = array(
			'class' => 'para'
		);
		
		$attr = $this->_mergeAttributes($attr, $own_attr);
	
		return $this->sdiv($attr, $options);
	}

	function epara()
	{
		return $this->ediv();
	}
	
	function para($attr = array(), $options = array(), $paras)
	{
		$t = $this->spara($attr, $options);
		
		foreach($paras as $para)
		{
			if (empty($para)) continue;
			
			$t .= $this->sp($attr, $options);
			if (isset($options['escape']) && $options['escape'])
				$t .= h($para);
			else
				$t .= $para;
			$t .= $this->ep();
		}
	
		$t .= $this->epara();
		return $t;
	}
	
	function stag($tag, $attr = null, $options = null)
	{
		$standard_options = array('close_me' => false);
		$options = am($standard_options, $options);
		extract($options);
		
		// Mount the attribute string
		$attr_string = '';
		
		if(is_array($attr))
		{
			foreach ($attr as $name => $value)
			{
				if(is_array($value))
				{
					switch($name)
					{
						case 'class':	
							$value = implode(' ', $value);
						break;
					}
				}
				$attr_string .= ' '.$name.'="'.$value.'"';
			}
		}
		return '<' . $tag . $attr_string . ($close_me ? ' /' : '') . '>';
	}

	function etag($tag)
	{
		return '</'.$tag.'>' . (in_array($tag, self::$tags_without_space_after) ? '' : "\n");
	}
	
	function tag($tag, $attr = null, $options = null, $content = null)
	{
		$standard_options = array();
		$standard_options['escape'] = false;
		$standard_options['close_me'] = empty($content);
		
		$options = am($standard_options, $options);
		extract($options);
		unset($options['escape']);
		
		if ($close_me && in_array($tag, self::$tags_that_need_closing_tag))
			$close_me = $options['close_me'] = false;
		
		$t = $this->stag($tag, $attr, $options);
		
		if (!$close_me)
		{
			if (isset($options['escape']) && $options['escape'])
				$content = h($content);
			$t .= $content . $this->etag($tag);
		}
		
		return $t;
	}
	
	
	function sanchor($attr = array(), $options = array())
	{
		if (isset($options['url']))
		{
			$View = ClassRegistry::getObject('view');
			if (!empty($View->params['language']) && is_array($options['url']))
				$options['url'] += array('language' => $View->params['language']);
		
			$attr['href'] = Router::url($options['url']);
		}
		
		return $this->sa($attr, $options);
	}
	
	function eanchor()
	{
		return $this->ea();
	}
	
	/** anchorList
	 * Make consecutive calls to anchor method.
	 * Everything is enclosed within a span tag.
	 * 
	 * @see TypeBricklayerHelper->anchor
	 * 
	 * @author Mazzoti, Fedel, Lucas
	 * @since  02 Dez. 2010
	 * @access public
	 * 
	 * @param Array $attr    HTML attributes of the enclosing span.
	 * @param Array $options One mandatory argument must be passed in $options array: $linkList.
     *                       It is an array of arrays, each one containing the parameters of anchor method.
	 *						 Each array has the following structure: ('attr' =>, 'options' =>, 'name')
	 *                       Two optional arguments can be supplied in $options array: $separator and $lastSeparator.
     *                       $separator is the connector string between items i - 1 and i, with i < n.
	 *                       $lastSeparator is the connector string between item n - 1 and n.
	 *                       If not supplied both separators defaults to ', '..
	 *						 
	 * @param       $content Ignored by this method, the content is created based on $options.
	 * @return String of HTML tags representing the anchor list.
	 */
	function anchorList($attr = array(), $options = array(), $content = null)
	{
		$options += array(
			'lastSeparator' => ', ',
			'separator' => ', ',
			'before' => '',
			'after' => ''
		);
		extract($options);
		
		if (!isset($linkList))
			return !trigger_error('TypeBricklayerHelper::anchorList() - \'anchorList\' must be set on $options.');
		
		$linksCount = count($linkList);
		$r = $this->sspan($attr, $options);
		
		if (!empty($before))
			$r .= $before;
		
		foreach($linkList as $key => $link)
		{
			$curAttr = array();
			if (isset($link['attr']))
				$curAttr = $link['attr'];
			
			$curOptions = array();
			if (isset($link['options']))
				$curOptions = $link['options'];
			
			if (isset($link['url']))
				$curOptions['url'] = $link['url'];
			
			$r .= $this->anchor($curAttr, $curOptions, $link['name']);
			
			if ($key == $linksCount - 2) 
				$r .= $lastSeparator;
			elseif ($key != $linksCount - 1) 
				$r .= $separator;			
		}
		
		if (!empty($after))
			$r .= $after;
		
		return $r . $this->espan();
	}

	function textile ($attr = array(), $options = array(), $content = null) {
		$own_attr = array(
			'class' => array('textile')
		);
		
		$attr = $this->_mergeAttributes($attr, $own_attr);

		$Textile =&	ClassRegistry::init('Textile','Vendor');
		$result = $this->sdiv($attr,$options);
		$result .= $Textile->textileThis($content);
		$result .= $this->ediv();
		
		return ($result);

	}
	/** Used by the smartTable to store the current Table settings used to
	 *  make table cells. The array format is internal to the smartTable
	 *	functions and is parsed from the options that ssmartTable receives.
	 *
	 *	The array format:
	 *		'columnSettings' => array(
	 *			1 => array($htmlAttributes, $options)  //passed forward to every cell of the 1st column
	 *			2 => array($htmlAttributes, $options)  //passed forward to every cell of the 2nd column
	 *			'every' =>
	 *      ),
	 *		'columnRhythmicSettings' => array(
	 *			3 => array(
	 *				1 => array($htmlAttributes, $options) //passed forward to every 1st cell out of a group of 3
	 *				2 => array($htmlAttributes, $options) //passed forward to evert 2nd cell out of a group of 3
	 *				3 => array($htmlAttributes, $options) //passed forward to evert 3rd cell out of a group of 3
	 *			)
	 *			5 => array(...) // the same but the rhythm will be given by 5 steps
	 *		'rowSettings' =>
	 *		'rowRhythmicSettings' =>
	 *		'cellSettings' =>
	 *		'automaticRowNumberClasses' => true,
	 *		'automaticColumnNumberClasses' => true,
	 *		'automaticColumnNumberHeaderClasses' => true
	 *
	 * @access protected
	 * @var array $tableSettings Stored table settings for smartTable functions.
	 */
	var $tableSettings;
	
	/**	Used by the smartTable functions to store current info on table creation:
	 *  in wich row are we? Which were spanned?
	 *
	 *	The array format:
	 *  	'nCols' => //stores the number of columns of the table, it gets bigger 
	 *					// as it finds a bigger row
	 *		'currentRow' => //the current row
	 *		'currentColumn' => //the current column, counted from 2
	 *		'currentCell'  => // the current cell, counted from 1
	 *		'maxColumn' => // how have we gone in the column count
	 *		'rowRhythmOffset' => // for cyclic attributes, the given offset (headers use to change this offset)
	 *		'pileOfRowspans' => array(
	 *			4 => 3 // means that at column 4, there are yet 3 rows in wich the 4th position should be ignored (no cell)
	 *		)
	 *
	 * @access protected
	 * @var array $tableStatus Stored table creation status for smartTable functions.
	 */
	var $tableStatus;
	
	/**	Parses a conjunct of settings and ryhtmic settings in a way that
	 *	is simpler for the creation code execute. Essentially it splits
	 *	the rhythmic and non-rhythmic settings in two arrays.
	 *
	 *	The array format:
	 *		'odd' => array($htmlAttr, $options) 
	 *		'even' => array($htmlAttr) // We can omit the options
	 *		1	=> $htmlAttr //We can omit the content array if we only have htmlAttr
	 *		2	=>  array($htmlAttr, $options) 
	 *		'every3of5'  => 
	 *
	 *  @param array $lines The settings for columns, tables, etc.
	 *	@return array An array with specific settings and another with the rhythmic settings (0 => settings, 1 => rhytmicSettings
	 */
	private function _parseTableColumnRowOptions($lines)
	{
		$settings = array();
		$rhythmicSettings = array();
		
		foreach ($lines as $k => $set)
		{
			if (is_numeric($k))
			{
				if ($k <= 0)
				{
					trigger_error('TypeBricklayerHelper::_parseTableColumnRowOptions - The first column is 1, not 0.');
					return false;
				}
				
				$settings[$k] = $set;
			}
			else if ($k === 'every')
				$settings[$k] = $set;
			else if ($k === 'odd')
				$rhythmicSettings[2][1] = $set;
			else if ($k === 'even')	
				$rhythmicSettings[2][2] = $set;
			else if (preg_match('/every([0-9]+)of([0-9]+)/',$k,$matches))
				$rhythmicSettings[$matches[2]][$matches[1]] = $set;
		}
		return array($settings, $rhythmicSettings);
	}
	
	/** Starts a new table, with a <table> opening tag, and sets tableSettings
	 *	and tableStatus.
	 *
	 *	The options array format:
	 *  	'columns' => array(
	 *			'odd' => array($htmlAttr, $options),   //settings for the odd numbered columns
	 *			'even' => $htmlAttr,   //shortcut, when options is not important
	 *			1 => array($htmlAttr),  //$options can be omitted
	 *			3 => ,
	 *			'every2of3' => '' //settings for every 2nd in 3 groups of rows
	 *		),
	 *		'rows' => array(
	 *			2 => array($htmlAttr, $options),
	 *			'odd' => 
	 *			'even' =>
	 *  	),
	 *  	'cells' => array(
	 * 			'every' => array($htmlAttr)
	 *	 	),
	 *	 	'automaticRowNumberClasses' => true,
	 *	 	'automaticColumnNumberClasses' => true,
	 *	 	'automaticColumnNumberHeaderClasses' => true,
	 *
	 *  @param array $htmlAttr The html attributes.
	 *  @param array $options The special options, format described above
	 *	@todo Test all this table functions deeply!
	 */
	
	public function ssmartTable($htmlAttr = array(), $options = array())
	{
		$options = am(array('automaticColumnNumberHeaderClasses' => true), $options); // the standard options
		extract($options);
		
		if (isset($automaticColumnNumberHeaderClasses))
			$this->tableSettings['automaticColumnNumberHeaderClasses'] = $automaticColumnNumberHeaderClasses;
		if (isset($automaticColumnNumberClasses))
			$this->tableSettings['automaticColumnNumberClasses'] = $automaticColumnNumberClasses;
		if (isset($automaticRowNumberClasses))
			$this->tableSettings['automaticRowNumberClasses'] = $automaticRowNumberClasses;
		
		if (isset($columns))
			list($this->tableSettings['columnSettings'], $this->tableSettings['columnRhythmicSettings']) 
				= $this->_parseTableColumnRowOptions($columns);
		if (isset($rows))
			list($this->tableSettings['rowSettings'], $this->tableSettings['rowRhythmicSettings']) 
				= $this->_parseTableColumnRowOptions($rows);
		
			
		$this->tableStatus['nCols'          ] = 0;
		$this->tableStatus['currentColumn'  ] = 1;
		$this->tableStatus['currentRow'     ] = 1;
		$this->tableStatus['currentCell'    ] = 1;
		$this->tableStatus['rowRhythmOffset'] = 1;
		$this->tableStatus['maxColumn'      ] = 1;
		$this->tableStatus['pileOfRowSpans' ] = array();
	
		return $this->stable($htmlAttr, $options);
	}
	
	public function esmartTable()
	{
		$this->tableSettings = array();
		$this->tableStatus = array();
		
		return $this->etable();
	}
	
	/** Merges simutaneausly the $options array and the $htmlAttributes array.
	 *  It do tolerates omissions of the $options array, or use of the $htmlAttributes as 
	 *  the array.
	 *
	 *  ### both parameters have the same format, that can be one of these:
	 *	array($htmlAttr, $options)
	 *  array($htmlAttr)
	 *  $htmlAttr
	 *
	 *	Both $htmlAttr and $options are arrays.
	 *
	 *	@param array $set1 Array of settings.
	 *	@param array $set2 Array of settings that will be merged into $set1.
	 */
	
	protected function _mergeSettings($set1, $set2)
	{
		$set1 = $this->_expandSettingsArray($set1);
		$set2 = $this->_expandSettingsArray($set2);
		
		$htmlAttr = $this->_mergeAttributes($set1[0], $set2[0]);
		$options = array_merge_recursive($set1[1],$set2[1]);
		
		return array($htmlAttr, $options);
	}
	
	protected function _expandSettingsArray($settings)
	{
		if (empty($settings))
			return array(array(),array());
		
		if (!isset($settings[0])) //it means it must be a $htmlAtrr only array
			return array($settings, array());
		
		if (!isset($settings[1])) //it means it must be array($htmlAttr) format
			return array($settings[0], array());
		
		return $settings; //it means it must be a array($htmlAttr,$options) formats
	}
	
	/** Writes a table row according to the table settings and status.
	 *  In this case, the $content expected is an array of cells with options.
	 *
	 *	@param array $htmlAttr Html attributes assigned to the <tr> tag.
	 *	@param array $options Special options for smartTableRow.
	 *		'header' -> It will write <th> instead of <td> tags. 
	 *  @param array $contentCells In this case the content is an array of cells.
	 *
	 *	The $contentCells array format:
	 *		array($htmlAttr, $options, $content),
	 *		array($htmlAttr, $options, $content),
	 *		$content // shorcut when you don't neet $htmlAttr or $options
	 */
	
	public function smartTableRow($htmlAttr, $options, $contentCells)
	{
		$settings = array($htmlAttr, $options);
		$stdSettings = array(array(),array());
		
		// clearing the pile of row spans for not written tds
		if (!empty($this->tableStatus['pileOfRowSpans'])) 
			foreach ($this->tableStatus['pileOfRowSpans'] as $k => $quant)
				if ($quant > 0 && $k >= $this->tableStatus['currentColumn'])
					$this->tableStatus['pileOfRowSpans'][$k]--;
		
		$this->tableStatus['currentColumn'] = 1;		
		extract($this->tableSettings);
		extract($this->tableStatus);
		
		$isHeader = isset($options['header']) ? $options['header'] : false;
		
		if ($isHeader)
		{
			$stdSettings = $this->_mergeSettings($stdSettings, array('class' => array('header')));
			$this->tableStatus['rowRhythmOffset'] = $currentRow;
		}
		
		if (isset($automaticRowNumberClasses) && $automaticRowNumberClasses)
			$stdSettings = $this->_mergeSettings($stdSettings, array('class' => array('row_'. $currentRow)));
	
		if (isset($rowRhythmicSettings) && !$isHeader)
		{
			foreach ($rowRhythmicSettings as $rhythm => $ordinalsSettings)
			{
				$currentOrdinality = (($currentRow - $this->tableStatus['rowRhythmOffset'] - 1)%$rhythm)+1;
				if (isset($ordinalsSettings[$currentOrdinality]))
					$stdSettings = $this->_mergeSettings($stdSettings, $ordinalsSettings[$currentOrdinality]);
			}
		}
		
		if (isset($rowSettings[$currentRow]))
			$stdSettings = $this->_mergeSettings($stdSettings, $rowSettings[$currentRow]);
			
		$settings = $this->_mergeSettings($settings, $stdSettings);
			
		$t = $this->str($settings[0], $settings[1]);
		
		foreach($contentCells as $k => $cellParams)
		{ 
			if (is_array($cellParams))
			{
				$cellAttr    = $cellParams[0];
				$cellOptions = $cellParams[1];
				$cellContent = $cellParams[2];
			} else {	
				$cellAttr    = array();
				$cellOptions = array();
				$cellContent = $cellParams;
			}
			
			if (isset($this->tableStatus['pileOfRowSpans'][$this->tableStatus['currentColumn']])
				&& $this->tableStatus['pileOfRowSpans'][$this->tableStatus['currentColumn']] > 0)
			{
				// We should jump this column because it's already filled by a cell with rowspans
				$this->tableStatus['pileOfRowSpans'][$this->tableStatus['currentColumn']]--; 
				$this->tableStatus['currentColumn']++;
			}
			
			$stdColumnSettings = array(array(),array());
		
			if (isset($columnRhythmicSettings))
			{
				foreach ($columnRhythmicSettings as $rhythm => $ordinalsSettings)
				{
					$currentOrdinality = (($this->tableStatus['currentColumn']-1)%$rhythm)+1;
					if (isset($ordinalsSettings[$currentOrdinality]))
						$stdColumnSettings = $this->_mergeSettings($stdColumnSettings, $ordinalsSettings[$currentOrdinality]);
				}
			}
			
			if (isset($columnSettings[$this->tableStatus['currentColumn']]))
				$stdColumnSettings = $this->_mergeSettings($stdColumnSettings, $columnSettings[$this->tableStatus['currentColumn']]);
		
			if (isset($automaticColumnNumberClasses) && $automaticColumnNumberClasses)
				$stdColumnSettings = $this->_mergeSettings($stdColumnSettings, array('class' => array('col_'. $this->tableStatus['currentColumn'])));
			else if (isset($options['header']) 
					 && $options['header']
					 && isset($automaticColumnNumberHeaderClasses) 
					 && $automaticColumnNumberHeaderClasses)
				$stdColumnSettings = $this->_mergeSettings($stdColumnSettings, array('class' => array('col_'. $this->tableStatus['currentColumn'])));

				
			list($cellAttr, $cellOptions) = $this->_mergeSettings($stdColumnSettings, array($cellAttr, $cellOptions));
			
			if (isset($cellOptions['colspan']))
				$cellAttr['colspan'] = $cellOptions['colspan'];
			if (isset($cellOptions['rowspan']))
				$cellAttr['rowspan'] = $cellOptions['rowspan'];
				
			//@todo Check for other params!
				
			if ((isset($options['header']) && $options['header'])
			   || (isset($cellOptions['header']) && $cellOptions['header']))
			{
				$t .= $this->th($cellAttr, $cellOptions, $cellContent);
			}
			else
			{
				$t .= $this->td($cellAttr, $cellOptions, $cellContent);
			}
			
			if (isset($cellOptions['rowspan']))
			{
				$colspan = isset($cellOptions['colspan']) ? $cellOptions['colspan'] : 1;
				
				for ($c = 0; $c < $colspan; $c++)
					$this->tableStatus['pileOfRowSpans'][$this->tableStatus['currentColumn'] + $c] =  $cellOptions['rowspan'] -1;
				//for us to remember that the cell is occupied!
			}
			if (isset($cellOptions['colspan']))
				$this->tableStatus['currentColumn'] += $cellOptions['colspan'];
			else
				$this->tableStatus['currentColumn']++;
			
			if ($this->tableStatus['currentColumn'] - 1 > $this->tableStatus['maxColumn'])
				$this->tableStatus['maxColumn'] = $this->tableStatus['currentColumn'] - 1;
			
			$this->tableStatus['currentCell']++;
		}
		$this->tableStatus['currentRow']++;
		$t .= $this->etr();
		return $t;
	}
	
	public function smartTableHeader($htmlAttr, $options, $contentCells)
	{
		$options['header'] = true;
		return $this->smartTableRow($htmlAttr, $options, $contentCells);
	}
	
	/** Ends a table with a </table> close tag, and resets tableSettings
	 *	and tableStatus.
	 */
	/* public function esmartTable($htmlAttr = array(), $options = array())
	{
		$this->tableSettings = array();
		$this->tableStatus = array();
		return $this->etable();
	} */
	
	function __call($n, $args)
	{
		if (substr($n, -3) == 'Dry' || substr($n, -3) == 'Dry')
		{
			$n = substr($n, 0, -3);
			array_unshift($args, array());
			array_unshift($args, array());
			return $this->dispatchMethod($n, $args);
		}
		
		if (method_exists($this, 's' . $n))
		{ //@todo Make a class of it
			
			$attr = $options = array();
			$content = null;
			switch (count($args))
			{
				case 0: break;
				case 1: $attr = $args[0]; break;
				case 2: list($attr, $options) = $args; break;
				case 3: list($attr, $options, $content) = $args; break;
				default:
					trigger_error('TypeBricklayerHelper::__call() - Max parameter count is 3!!!');
				break;
			}
			$standard_options = array('escape' => false, 'close_me' => false);
			$options = am($standard_options, $options);
			
			if (empty($content) && !in_array($n, self::$tags_that_need_closing_tag))
				$options['close_me'] = true;
			else
				$options['close_me'] = false;

			extract($options);
				
			$t = $this->{'s' . $n}($attr, $options);
			
			if (!$close_me)
			{
				if($escape)
					$content = h($content);
				$t .= $content . $this->{'e' . $n}();
			}
			return $t;
		}
		
		$just_name = in_array($n, self::$tags_that_begin_with_e) 
				  || in_array($n, self::$tags_that_begin_with_s);
		
		if (!$just_name && preg_match('/(^[se])([A-Za-z]\w*)/', $n, $matches))
		{
			array_unshift($args, $matches[2]);
			return $this->dispatchMethod($matches[1] . 'tag', $args);
		}
		else //@todo Add check: are these allowed tags?
		{
			array_unshift($args, $n);
			return $this->dispatchMethod('tag', $args);
		}
		//@todo Translate this!
		trigger_error('PedreiroHelper::'.$n.'(): Não existe este método.');
	}
}



?>
