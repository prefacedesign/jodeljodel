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
		$attr = $this->_mergeAttributes($attr, $new_attr); */
		
		return parent::sa($attr, $options);
	}
}



?>
