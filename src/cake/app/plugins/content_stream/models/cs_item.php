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
		
		if (!isset($config['streams'][$item['type']])) {
			trigger_error('CsItem::getContent() - Found a item of an unknown type `'.$item['type'].'`.');
			return $item;
		}
		
		$stream_config = $config['streams'][$item['type']];
		$Model = ClassRegistry::init($stream_config['model']);
		$item['title'] = $stream_config['title'];
		
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
		{
			trigger_error('CsItem::getContent() - I found an CsItem without content ('.$item['id'].'), but it was not meant to happen.');
			return $item;
		}

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
		
		$stream_config = $config['streams'][$item['type']];
		$Model = ClassRegistry::init($stream_config['model']);
		return $Model->delete($item[$this->alias]['foreign_key']);
	}
}