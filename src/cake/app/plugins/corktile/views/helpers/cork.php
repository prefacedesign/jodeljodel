<?php

class CorkHelper extends AppHelper 
{
	public $helpers = array('Html', 'Form', 'Ajax', 'Js' => 'prototype', 'Burocrata.BuroOfficeBoy',
		'Typographer.*TypeBricklayer' => array(
			'name' => 'Bl'
		)
	);

	/** tile
	 *
	 *  This method inserts a Cork Tile in the spot, given the specified key.
	 *  If there's already content with this key, it will be used. Otherwise
	 *  a new one will be created. The Cork content will be enclosed by a special
	 *  div with the class 'cork'.
	 * 
	 *  @see Model CorkCortile->getData
	 *
	 *  @param array $htmlAttributes The htmlAttributes that will be used in the div
	 *                               that contains the data.
     *  @param array $options The settings of this special tile:
	 *                         - 'key' -> string with the key of this tile (required).
	 *                         - 'type' -> what type of cork we're using? (required).
	 *                                     More data will be retrieved through the config
	 *                                     key: 'jj.modules'.
	 *                         - 'title' -> The title of the Cork - in few words what's
	 *                                     the content about?
	 *                         - 'editorsRecommendations' -> A free text recomending
	 *                                     on how to fill the content. The administrators
	 *                                     will see this code above the form.
	 *                         - 'replaceOptions' -> Defaults to true. If set to false
	 *                                      the options saved on DB will be used,
	 *                                      otherwise if true, the options will be
	 *                                      overwritten. If 'Corktile.overwrite' is set
	 *                                      to true this will be assumed always true.
	 *                         - 'defaultContent' -> An array with the default data
	 *                                      that should be used, when it does not exist.
	 *                         - 'options' -> These options will be passed on to the
	 *                                      the content Model.
	 *  @todo Handle caching.
	 *  @todo Corktile shell: script that goes through all files resetting every
	 *        piece of Cork.
	 */
	function tile ($htmlAttributes = array(), $options = array())
	{
		if (!isset($options['key']) && !isset($options['type']))
			trigger_error("CorkHelper::tile One must at least specify 'key' and 'type'"); 

		$htmlAttributes = $this->Bl->_mergeAttributes(array('class' => array('cork')), $htmlAttributes);
		
		//@todo: Probably cache should emcompass all this: till the bottom todo

		$CorkCorktile = & ClassRegistry::init('Corktile.CorkCorktile');
		$corkData = $CorkCorktile->getData($options); //This one handles all data logic.

		$typeConfig = Configure::read('jj.modules.' . $options['type']);
		
		$View =& ClassRegistry::getObject("View");

		$t = $this->Bl->sdiv($htmlAttributes);
		$t .=  $View->element(Inflector::underscore($typeConfig['model']), array(
				'plugin' => Inflector::underscore($typeConfig['plugin']),
				'type' => array('cork'),
				'options' => isset($options['options']) ? $options['options'] : array(),
				'data' => $corkData
			)
		);
		$t .= $this->Bl->ediv();
		
		//@todo: Probably cache should emcompass all this. till here

		return $t;
	}
}


?>
