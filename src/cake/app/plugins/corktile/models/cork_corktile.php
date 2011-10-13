<?php

class CorkCorktile extends CorktileAppModel
{
/**
 * Model name
 * 
 * @var string
 * @access public
 */
	var $name = 'CorkCorktile';

/**
 * Behaviors
 * 
 * @var array
 * @access public
 */
	var $actsAs = array(
		'JjUtils.Encodable' => array('fields' => array('location' => 'serialize', 'options' => 'serialize')),
		'Dashboard.DashDashboardable' => array()
	);

/**
 * This method retrieves the data of a corktile.
 * 
 * The arguments in the $options array are the same as the 
 * CorkHelper::tile() method. It will get the data if existant, 
 * or create it if not.
 * 
 * @see CorkHelper::tile()
 * @access public
 * @param array $options The settings of this special tile:
 *                        - 'key' -> string with the key of this tile (required).
 *                        - 'type' -> what type of cork we're using? (required).
 *                                    More data will be retrieved through the config
 *                                    key: 'jj.modules'.
 *                        - 'title' -> The title of the Cork - in few words what's
 *                                    the content about?
 *                        - 'editorsRecommendations' -> A free text recomending
 *                                    on how to fill the content. The administrators
 *                                    will see this code above the form.
 *                        - 'replaceOptions' -> Defaults to true. If set to false
 *                                     the options saved on DB will be used,
 *                                     otherwise if true, the options will be
 *                                     overwritten. If 'Corktile.overwrite' is set
 *                                     to true this will be assumed always true.
 *                        - 'defaultContent' -> An array with the default data
 *                                     that should be used, when it does not exist.
 *                        - 'options' -> These options will be passed on to the
 *                                     the content Model.
 * @todo Handle caching.
 * @todo Corktile shell: script that goes through all files resetting every
 *       piece of Cork.
 */
	function getData($options)
	{
		$options += array(
			'type' => 'text_cork',
			'defaultContent' => array(),
			'replaceOptions' => true,
			'options' => array()
		);
	
		if (empty($options['type']))
		{
			trigger_error('CorkCorktile::getData - "type" not defined.');
			return array();
		}
		
		$typeConfig = Configure::read('jj.modules.' . $options['type']);
		if (empty($typeConfig))
		{
			trigger_error('CorkCorktile::getData - Module (jj.modules) configuration for "' . $options['type'] . '" not found.');
			return array();
		}
		
		$Model =& ClassRegistry::init($typeConfig['model']);
		$corktileData = $this->find('first', array('conditions' => array('id' => $options['key'], 'type' => $options['type'])));
		if (empty($corktileData))
		{
			$defaultContent = isset($options['defaultContent']) ? $options['defaultContent'] : array();
			
			$Model->create();
			if(!$Model->saveCorkContent($defaultContent, $options, false))
			{
				trigger_error(__('CorkCorktile Model: Could not save the CorkContent',true));
				return false;
			}
		
			$data = array('CorkCorktile' => array(
				'id' => $options['key'],
				'type' => $options['type'],
				'content_id' => $Model->id,
				'title' => isset($options['title']) ? $options['title'] : Inflector::humanize($options['key']),
				'instructions' => isset($options['editorsRecommendations']) ? $options['editorsRecommendations'] : '',
				'location' => isset($options['location']) ? $options['location'] : '',
				'options' => $options['options']
			));
			
			if ($this->save($data) === false)
			{
				trigger_error(__('CorkCorktile Model: Could not save the Cork meta data',true));
				return false;
			}
		}
		elseif ($options['replaceOptions'])
		{
			//@todo Check if something changed, and do something about it.
			
			$data = array('CorkCorktile' => array(
				'id' => $options['key'],
				'type' => $options['type'],
				'content_id' => $corktileData['CorkCorktile']['content_id'],
				'title' => isset($options['title']) ? $options['title'] : Inflector::humanize($options['key']),
				'location' => isset($options['location']) ? $options['location'] : '',
				'options' => $options['options'] //@todo Make this a behavior
			));
			
			if (!$this->save($data))
			{
				trigger_error(__('CorkCorktile Model: Could not update the Cork meta data',true));
				return false;
			}
		}
		
		$corktileData = $this->read();
		//Must always retrieve because the Model may have proccessed the data;
		$contentData = $Model->getCorkContent($corktileData[$this->alias]['content_id']);
		return $corktileData+$contentData;
	}

/** 
 *  Retrieves the whole data associated with a Cork tile.
 *
 * It's meta data, the model's data and info about the module
 * retrieved from the general configuration of modules.
 * 
 * @access public
 * @param $key The key to the cork Model.
 * @return Array with meta data ['CorkCorktile'], model's data and the model and plugin info.
 */
	function getFullData($key)
	{
		$metaData = $this->findById($key);
		
		if (empty($metaData))
			return false;
		
		$typeConfig = Configure::read('jj.modules.' . $metaData['CorkCorktile']['type']);
		
		$Model =& ClassRegistry::init($typeConfig['model']);
		$corkContent = $Model->getCorkContent($metaData['CorkCorktile']['content_id']);
		
		list($typeConfig['plugin'],$typeConfig['model']) = pluginSplit($typeConfig['model']);
		return am($metaData, $corkContent, array('ModuleInfo' => $typeConfig));
	}
	
/**
 * Find suited for the burocrata form. Part of the Burocrata/Backstage contract.
 *
 * @access public
 * @param string $id
 * @return Same as Model::findById();
 */
	function findBurocrata($id)
	{
		return $this->findById($id);
	}

/**
 * The data that must be saved into the dashboard. Part of the Dashboard contract.
 * 
 * @access public
 * @param string $key Also know as $id
 * @return array
 */
	function getDashboardInfo($key)
	{
		$data = $this->getFullData($key);
		
		//@todo Make this take only the main language.
		
		$typeConfig = Configure::read('jj.modules.' . $data['CorkCorktile']['type']);
		$Model =& ClassRegistry::init($typeConfig['model']);
		
		if ($data == null)
			return null;
		
		$info = '';
		if (isset($data['CorkCorktile']['location'][0]))
			$info = 'Location: ' . substr($data['CorkCorktile']['location'][0], 0, 20) . '...';
		
		$dashdata = array(
			'dashable_id'    => $data['CorkCorktile']['id'],
			'dashable_model' => $this->name,
			'type'           => 'corktile',
			'status'         => 'published',
			'created'        => $data['CorkCorktile']['created'],
			'modified'       => $data['CorkCorktile']['modified'], 
			'name'           => $data['CorkCorktile']['title'],
			'info'           => $info,
			'idiom'          => isset($data[$Model->alias]['languages'])? $data[$Model->alias]['languages'] : array()
		);
		
		return $dashdata;
	}

/**
 * When data is deleted from the Dashboard. Part of the Dashboard contract.
 *
 * For now data from CorkCorktile won't be deletable through the Dashboard.
 *
 * @access public
 * @param string $id
 * @return false Always returns false
 * @todo Maybe we should study how to do it from Backstage contract.
 */
	function dashDelete($id)
	{
		return false;
	}
	
/**
 * Updates the modified field, given only the cork's id and its type. 
 *
 * Used by the CorkAttachable in order to update the container row. It implies 
 * that Dashboard will be updated also.
 *
 * @access public
 * @param string $content_id
 * @param string $type
 * @param string $modified
 * @return boolean True - success. False - failure.
 */
	function updateModifiedDate($content_id, $type, $modified)
	{
		$data = $this->find('first', array('conditions' => compact('content_id','type')));
		if (empty($data))
			return false;
			
		$result = $this->save(array('CorkCorktile' => array('modified' => $modified, 'id' => $data['CorkCorktile']['id'])));

		return $result !== false;
	}

/**
 * If the corktile needs to be deleted, it deletes the related content, before.
 * 
 * @access public
 * @param string $id
 * @return boolean
 */
	function delete($id)
	{
		$this->id = $id;
		$this->read();
		return $this->deleteRelatedContent() && parent::delete();
	}

/**
 * Deletes the related content
 * 
 * @access protected
 * @return boolean
 */
	protected function deleteRelatedContent()
	{
		$typeConfig = Configure::read('jj.modules.' . $this->data[$this->alias]['type']);
		$Model =& ClassRegistry::init($typeConfig['model']);
		return $Model->delete($this->data[$this->alias]['content_id']);
	}
}