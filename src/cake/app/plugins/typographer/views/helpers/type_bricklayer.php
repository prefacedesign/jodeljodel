<?php

class TypeBricklayerHelper extends AppHelper
{
	static $automatic_tags = array(
		'html','head','title','link','body',
		'h1','h2','h3','h4','div','br','span','hr','img',
		'form', 'input','textarea','p', 'em','a','script', 'small',
		'hr','script', 'object', 'param'
	);
	
	static $tags_without_space_after = array(
		'i', 'em', 'span', 'a'
	);
	
	static $tags_that_need_closing_tag = array(
		'div'
	);
	
	static $tags_that_begin_with_e = array(
		'em'
	);
	
	static $tags_that_begin_with_s = array(
		'span'
	);
	
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
	
	//@todo Find better placement for this funcion.
	public function _mergeAttributes($atr1, $atr2)
	{
		if ($atr1 == null)
			$atr1 = array();
		
		if ($atr2 == null)
			$atr2 = array();
			
		return array_merge_recursive($atr1, $atr2);
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
		//para onde passamos os atributos e opcoes passados? -- posso aceitar opcoes individuais, e opcoes generalizadas
		$t = $this->spara($attr, $options);
		
		foreach($paras as $para)
		{
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
		return '</'.$tag.'>' . (in_array($tag, TypeBricklayerHelper::$tags_without_space_after) ? '' : "\n");
	}
	
	function tag($tag, $attr = null, $options = null, $content = null)
	{
		$standard_options = array();
		$standard_options['escape'] = false;
		$standard_options['close_me'] = empty($content);
		
		$options = am($standard_options, $options);
		extract($options);
		unset($options['escape']);
		
		if ($close_me && in_array($tag, TypeBricklayerHelper::$tags_that_need_closing_tag))
			$close_me = $options['close_me'] = false;
		
		$t = $this->sTag($tag, $attr, $options);
		
		if (!$close_me)
		{
			if (isset($options['escape']) && $options['escape'])
				$content = h($content);
			$t .= $content . $this->eTag($tag);
		}
		
		return $t;
	}
	
	
	function anchor($attr = array(), $options = array(), $name = '')
	{
		if (isset($options['url']))
			$attr['href'] = Router::url($options['url']);
		
		return $this->a($attr, $options, $name);
	}
	
	/**
	 * Make consecutive calls to anchor method.
	 * All anchors are enclosed within a span tag.
	 * 
	 * @see TypeBricklayerHelper->anchor
	 * 
	 * @author Mazzoti, Fedel, Lucas
	 * @since  02 Dez. 2010
	 * @access public
	 * 
	 * @param array $attr    HTML attributes of the enclosing span.
	 * @param array $options One mandatory argument must be passed in $options array: $linkList.
     *                       It is an array of arrays, each one containing the parameters of anchor method.	 
	 *                       Two optional arguments can be supplied in $options array: $separator and $lastSeparator.
     *                       $separator is the connector string between items i - 1 and i, with i < n.
	 *                       $lastSeparator is the connector string between item n - 1 and n.
	 *                       If not supplied both separators defaults to ', '.
	 * @param       $content Ignored by this method, the content is created based on $options.
 	 * @todo Update this help text to the new array structure.
	 * @return String of HTML tags representing the anchor list.
	 */
	function anchorList($attr = array(), $options = array(), $content = null)
	{
		$standardOptions = array(
			'lastSeparator' => ', ',
			'separator' => ', '
		);
		
		$options = am($standardOptions, $options);
		extract($options);
	
		$r = $this->sspan($attr, $options);
		
		foreach($linkList as $key => $link)
		{
			$curAttr = array();
			if (isset($link['attr']))
				$curAttr = $link['attr'];
			
			$curOptions = array();
			if (isset($link['options']))
				$curOptions = $link['options'];
				
			$curOptions['url'] = $link['url'];
			
			$r .= $this->anchor($curAttr, $curOptions, $link['name']);
			
			if ($key == count($linkList) - 2) 
				$r .= $lastSeparator;
			elseif ($key != count($linkList) - 1) 
				$r .= $separator;			
		}
		return $r . $this->espan();
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
	 * @var array $tableSettings Stored table settings for smartTable funcions.
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
	 * @var array $tableStatus Stored table creation status for smartTable funcions.
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
			@list($attr, $options, $content) = $args;
			$standard_options = array('escape' => false, 'close_me' => false);
			$options = am($standard_options, $options);
			extract($options);
			
			if ($close_me || empty($content))
			{
				$close_me = true;
				$options['close_me'] = true;
			}
			else
				$close_me = false;
				
			$t = $this->{'s' . $n}($attr, $options);
			
			if (!$close_me)
			{
				if($escape)
					$content = h($content);
				$t .= $content . $this->{'e' . $n}($attr, $options);
			}
			return $t;
		}
		
		$just_name = in_array($n, TypeBricklayerHelper::$tags_that_begin_with_e) 
				  || in_array($n, TypeBricklayerHelper::$tags_that_begin_with_s);
		
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
