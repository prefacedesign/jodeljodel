<?php
/**
 * Model for content_stream plugin.
 *
 * PHP versions 5
 *
 * @package       jodel
 * @subpackage    jodel.content_stream.models
 */

/**
 * CsItem.
 *
 * Model that contains some methods for deal with finds and saves.
 *
 * @package       jodel
 * @subpackage    jodel.content_stream.models
 */
class CsItem extends ContentStreamAppModel
{
/**
 * Class name
 * 
 * @var string
 * @access public
 */
	var $name = 'CsItem';

/**
 * belongsTo relationship
 * 
 * @var array
 * @access public
 */
	var $belongsTo = array('ContentStream.CsContentStream');

/**
 * Attached behaviors
 * 
 * @var array
 * @access public
 */
	var $actsAs = array(
		'Containable',
		'JjUtils.Ordered' => array(
			'field' => 'order',
			'foreign_key' => 'cs_content_stream_id'
		)
	);

/**
 * afterFind callback.
 * 
 * Used to retreive all content from CsItems
 * 
 * @access public
 * @param array $results
 * @param boolean $primary
 * @return array The complete results
 */
	function afterFind($results, $primary)
	{
		if (isset($results[0]))
			foreach ($results as &$result)
				$result['CsItem'] += $this->getContent($result['CsItem']);
		
		return $results;
	}

/**
 * Method called by the BuroBurocrataController
 * 
 * This method receive the data from the ContentStream input and creates/updates
 * an CsItem.
 * 
 * @access public
 * @param array $data
 * @return boolean True if succefully saved. False otherwise.
 */
	function saveBurocrata($data)
	{
		$contentType = false;
		$this->data = $data;
		
		// If CsItem is already created, get its type
		if (!empty($this->data['CsItem']['id']))
		{
			$this->id = $this->data['CsItem']['id'];
			$contentType = $this->field('type');
		}
		// Else, need to get the type from the passed data
		else if (!empty($this->data[$this->alias]['type']))
		{
			$contentType = $this->data[$this->alias]['type'];
		}
		
		if (!$contentType)
			return false;
		
		$this->data[$this->alias]['type'] = $contentType;
		
		// Start the transaction
		$dbo = $this->getDataSource();
		$dbo->begin($this);
		
		// Loads the config
		App::import('Lib', 'ContentStream.CsConfigurator');
		$config = CsConfigurator::getConfig();
		
		$stream_config = $config['streams'][$contentType];
		$Model = ClassRegistry::init($stream_config['model']);
		
		$Model->create($this->data);
		if ($Model->save())
		{
			$this->data[$this->alias]['foreign_key'] = $Model->id;
			$this->create($this->data);
			if ($this->save())
			{
				$dbo->commit($this);
				return true;
			}
		}
		
		$dbo->rollback($this);
		return false;
	}

/**
 * Logic of duplicating an CsItem (and its content)
 * 
 * @access public
 * @param string $item_id
 * @return boolean True if succefully duplicated. False otherwise.
 */
	function duplicate($item_id)
	{
		$this->contain();
		$item = $this->findById($item_id);
		
		if (empty($item))
			return false;
		
		App::import('Lib', 'ContentStream.CsConfigurator');
		$config = CsConfigurator::getConfig();
		$Model = ClassRegistry::init($config['streams'][$item[$this->alias]['type']]['model']);
		
		
		$item[$Model->alias] = $item[$this->alias][$Model->alias];
		unset($item[$this->alias][$Model->alias]);
		if (method_exists($Model, 'duplicate'))
		{
			if (!$Model->duplicate($item[$Model->alias][$Model->primaryKey]))
				return false;
			
			$item[$Model->alias][$Model->primaryKey] = $Model->id;
		}
		else
		{
			unset($item[$Model->alias][$Model->primaryKey]);
		}
		unset($item[$this->alias][$this->primaryKey]);
		unset($item[$this->alias]['foreign_key']);
		
		return $this->saveBurocrata($item);
	}

/**
 * Method that completes the content of an CsItem record.
 * 
 * @access public
 * @param array The CsItem data
 * @return array
 */
	function getContent($item)
	{
		App::import('Lib', 'ContentStream.CsConfigurator');
		$config = CsConfigurator::getConfig();
		
		if (empty($item['type']) || empty($item['foreign_key']))
			return array();
		
		if (!isset($config['streams'][$item['type']])) {
			trigger_error('CsItem::getContent() - Found a item of an unknown type `'.$item['type'].'`.');
			return $item;
		}
		
		$stream_config = $config['streams'][$item['type']];
		$Model = ClassRegistry::init($stream_config['model']);
		$item['__title'] = $stream_config['title'];
		
		if (!$Model) {
			trigger_error('CsItem::getContent() - Model `'.$stream_config['model'].'` could´n be initialized.');
			return $item;
		}
		
		$data = array();
		if (method_exists($Model, 'findContentStream'))
		{
			$data = $Model->findContentStream($item['foreign_key']);
		}
		else
		{
			$Model->recursive = -1;
			$data = $Model->findById($item['foreign_key']);
		}

		if (empty($data) || !is_array($data))
			return $item;

		return $item+$data;
	}

/**
 * Calls delete for each Content.
 *
 * @access public
 * @param boolean $cascade 
 * @return boolean Returns true, if the delation was ok and false, otherwise.
 */
	function beforeDelete($cascade)
	{
		$this->contain();
		$item = $this->read();
		
		App::import('Lib', 'ContentStream.CsConfigurator');
		$config = CsConfigurator::getConfig();
		
		$stream_config = $config['streams'][$item[$this->alias]['type']];
		$Model = ClassRegistry::init($stream_config['model']);
		return $Model->delete($item[$this->alias]['foreign_key']);
	}
}