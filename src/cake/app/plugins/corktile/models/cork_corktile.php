<?php

class CorkCorktile extends CorktileAppModel
{
	var $name = 'CorkCorktile';
	
	
	/** getData
	 *
	 *  This method retrieves the data of a corktile. The arguments in the $options
	 *  array are the same as the tile() function in the CorkHelper. It will get the
	 *  data if existant, or create and retrieve if not.
	 * 
	 *  @see Helper CorkHelper->tile
	 *
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
	function getData($options)
	{
		$defaultOptions = array(
			'type' => 'text_cork',
			'defaultContent' => array(),
			'replaceOptions' => true,
			'options' => array()
		);
		
		$options = am($defaultOptions, $options);
	
		$typeConfig = Configure::read('jj.modules.' . $options['type']);
		$pluginCamelName =  Inflector::camelize($typeConfig['plugin']);
		$modelName = $typeConfig['model'];
		
		$Model =& ClassRegistry::init($pluginCamelName . '.' . $modelName);
		
		$corktileData = $this->find('first',array('conditions' => array('id' => $options['key'], 'type' => $options['type'])));
		
		if (empty($corktileData))
		{
			$defaultContent = isset($options['defaultContent']) ? $options['defaultContent'] : array();
			$contentId = $Model->saveCorkContent($defaultContent, $options, false);
		
			if($contentId === false)
			{
				trigger_error(__('CorkCorktile Model: Could not save the CorkContent',true));
				return false;
			}
		
			$data = array('CorkCorktile' => array(
				'id' => $options['key'],
				'type' => $options['type'],
				'content_id' => $contentId,
				'title' => isset($options['title']) ? $options['title'] : Inflector::humanize($options['key']),
				'instructions' => isset($options['editorsRecommendations']) ? $options['editorsRecommendations'] : '',
				'location' => json_encode(isset($options['location']) ? $options['location'] : ''),
				'options' => json_encode(isset($options['options']) ? $options['options'] : '') //@todo Make this a behavior
			));
			
			if ($this->save($data) === false)
			{
				trigger_error(__('CorkCorktile Model: Could not save the Cork meta data',true));
				return false;
			}
			$corktileData['CorkCorktile']['content_id'] = $contentId;
		}
		
		if ($options['replaceOptions'])
		{
			//@todo Check if something changed, and do something about it.
			
			$data = array('CorkCorktile' => array(
				'id' => $options['key'],
				'type' => $options['type'],
				'title' => isset($options['title']) ? $options['title'] : Inflector::humanize($options['key']),
				'location' => json_encode(isset($options['location']) ? $options['location'] : ''),
				'options' => json_encode(isset($options['options']) ? $options['options'] : '') //@todo Make this a behavior
			));
			
			if ($this->save($data) === false)
			{
				trigger_error(__('CorkCorktile Model: Could not update the Cork meta data',true));
				return false;
			}
		}
		
		return $Model->getCorkContent($corktileData['CorkCorktile']['content_id']); //Must always retrieve because the Model may have proccessed the data;
	}
}

?>
