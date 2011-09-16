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
		'JjUtils.Ordered' => array(
			'field' => 'order',
			'foreign_key' => 'cs_content_straem_id'
		)
	);

/**
 * 
 * 
 * @access public
 */
	function getContent()
	{
	}
}