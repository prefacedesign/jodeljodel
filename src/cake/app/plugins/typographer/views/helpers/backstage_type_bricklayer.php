<?php

App::import('Helper','Typographer.TypeBricklayer');

class BackstageTypeBricklayerHelper extends TypeBricklayerHelper
{
	/* Handles the Backstage links.
	 *
	 * @access public
	 * @param $attr The HTML attributes.
	 * @param $options Extra element related options. Here, we are treating the 'text' superclass: array('superclass' => 'text');
	 * @return 
	 */
	function sa($attr = array(), $options = array())
	{
		/*$new_attr = array('class' => 'text');
		
		if (isset($options['superclass']))
		{
			if (in_array('image', $options['superclass']))
				unset($new_attr['class']);
		}
		$attr = $this->_mergeAttributes($attr, $new_attr);
		*/
		return parent::sa($attr, $options);
	}
	
	function sh1($attr = array(), $options = array(), $content = array())
	{
		$standard_options = array(
			'escape' => true
		);
		
		$options = am($standard_options, $options);
		extract($options);
	
		$divAttr = array('class' => 'h1div');
	
		if (isset($contentDivAttr))
		{
			$divAttr = $this->_mergeAttributes($divAttr, $contentDivAttr);
		}
	
		$r  = $this->sdiv($divAttr);
		if (isset($additionalText))
		{
			$r .= $this->span(array(), array('escape' => $escape), $additionalText);
		}	
		$r .= parent::sh1($attr, $options);
		
		return $r;
	}
	
	function eh1()
	{
		return parent::eh1() . $this->ediv();
	}
	
	function sbigInfoBox($attr = array(), $options = array())
	{
		$attr = $this->_mergeAttributes(array('class' => array('big_info_box')), $attr);
		
		return $this->sdiv($attr, $options) . $this->sdiv();
	}
	
	function ebigInfoBox()
	{
		return $this->ediv().$this->ediv();
	}
	
	function scontrolBox($attr = array(), $options = array())
	{
		$attr = $this->_mergeAttributes(array('class' => array('control_box')), $attr);
		
		return $this->sdiv($attr, $options) . $this->sdiv();
	}
	
	function econtrolBox()
	{
		return $this->ediv().$this->ediv();
	}

	function sinfoBox($attr = array(), $options = array())
	{
		$attr = $this->_mergeAttributes(array('class' => array('info_box')), $attr);

		return $this->sdiv($attr, $options);
	}

	function einfoBox()
	{
		return $this->ediv();
	}


}



?>
