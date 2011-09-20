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
 * CsContentStream.
 *
 * Model that contains some methods for deal with finds and saves.
 *
 * @package       jodel
 * @subpackage    jodel.content_stream.models
 */
class CsContentStream extends ContentStreamAppModel
{
/**
 * Class name
 * 
 * @var string
 * @access public
 */
	public $name = 'CsContentStream';

/**
 * hasMany relationship
 * 
 * @var array
 * @access public
 */
	public $hasMany = array(
		'CsItem' => array(
			'className' => 'ContentStream.CsItem',
			'order' => 'CsItem.order'
		)
	);

/**
 * This method creates a new (and empty) Content Stream
 * 
 * @access public
 * @param $type string The type of ContentStream defined on config
 * @return mixed The result of save method
 */
	public function createEmpty($type)
	{
		$this->create(array($this->alias => compact('type')));
		return $this->save();
	}

/**
 * afterFind callback.
 * 
 * Used to retreive all content from CsItems
 * 
 * @access public
 */
	public function afterFind($results, $primary)
	{
		if($primary)
			foreach($results as &$result)
				if(isset($result['CsItem']))
					foreach($result['CsItem'] as &$item)
						$item += $this->CsItem->getContent($item);
		
		return $results;
	}
}