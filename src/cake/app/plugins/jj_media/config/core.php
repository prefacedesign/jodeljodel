<?php

/**
 * Filters and versions
 *
 * For each media type a set of filters keyed by version name is configured.
 * A filter is a set of instructions which are processed by the Media_Process class.
 *
 * For more information on available methods see the classes
 * located in `libs/mm/src/Media/Process`.
 * 
 * Avaible processes:
 * - fit/fitInside: Resizes media proportionally keeping both sides within given dimensions.
 * - fitOutside:Resizes media proportionally keeping _smaller_ side within corresponding dimensions.
 * - crop: Crops media to provided dimensions.
 * - zoom/zoomFit: Enlarges media proportionally by factor 2.
 * - zoomCrop: 
 * - fitCrop: First resizes media so that it fills out the given dimensions, then cuts off overlapping parts.
 * - compress:Selects level of compression than compresses the media according to provided value.
 * - strip: Strips unwanted data from an image.
 * - colorProfile:
 * - colorDepth: Changes the color depths (of the channels).
 * - interlace: Enables or disables interlacing. Formats like PNG, GIF and JPEG support interlacing.
 * - convert: Converts the media to given MIME type.
 * 
 * 
 * @see GeneratorBehavior
 */

Configure::write('Media.filter_plus.textile', array(
	'fields' => array('Textile.image_id'),
	'image' => array(
		'view' => array(
			'fit' => array(
				$dinafonTools['hg']->size(array('M' => 2), false),
				$dinafonTools['vg']->size(array('M' => 2), false)
			),
			'convert' => 'image/jpeg'
		),
		'backstage_preview' => array(
			'fitCrop' => array(
				$dinafonTools['hg']->size(array('M' => 4, 'g' => -1), false),
				$dinafonTools['vg']->size(array('M' => 4, 'g' => -1), false)
			)
		)
	)
));
Configure::write('Media.filter_plus.people', array(
	'fields' => array('PersPerson.img_id'),
	'image' => array(
		'preview'  => array('fit' => array(600, 440)),
		'event_page' => array(
			'fit' => array(
				$dinafonTools['hg']->size(array('M' => 2), false),
				$dinafonTools['vg']->size(array('M' => 2), false)
			),
			'convert' => 'image/jpeg'
		),
		'backstage_preview' => array(
			'fitCrop' => array(
				$dinafonTools['hg']->size(array('M' => 4, 'g' => -1), false),
				$dinafonTools['vg']->size(array('M' => 4, 'g' => -1), false)
			)
		),
		'backstage_list' => array('fitCrop' => array(150, 50))
	)
));


Configure::write('Media.filter_plus.new_news', array(
	'fields' => array('NewNew.sfil_storage_file_id', 'NewNew.audio_cast_id'),
	'audio' => array(
		'convert' => array('audio/ogg')
	),
	'image' => array(
		'preview' => array('fit' => array(200, 250)),
		'view'    => array('fit' => array(400, 400)),
		'lista'   => array('fit' => array(100, 100))
	)
));



Configure::write('Media.filter_plus.pap_papers', array(
	'fields' => array('PapPaper.file_id'),
));