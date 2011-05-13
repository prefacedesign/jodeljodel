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

/**
 * Basic configuration of JjMedia plugin:
 * 
 * {{{Configure::write('Media.filter_plus.NAME_OF_CONFIGURATION', array( // NAME_OF_CONFIGURATION is a name that has significance
 * 	'fields' => array(),				// List of Model.file_id that this config will be applyed
 * 	'image' => array(					// What type of media transformation (image, sound, video....)
 * 		'filter' => array(				// Name of the version (will be used in future to get this version)
 * 			'fit' => array(120,120)		// One filter
 * 			'convert' => 'image/jpeg'	// Other filter
 * 		)
 * 	)
 * ));}}} 
 */
 
Configure::write('Media.filter_plus.textile', array(
	'fields' => array('Textile.image_id'),
	'image' => array(
		'filter' => array(
			'fit' => array(
				$dinafonTools['hg']->size(array('M' => 6), false),
				$dinafonTools['vg']->size(array('M' => 6), false)
			),
			'convert' => 'image/jpeg'
		)
	)
)); 
Configure::write('Media.filter_plus.picture', array(
	'fields' => array('Picture.file_upload_id'),
	'image' => array(
		'backstage_preview' => array(
			'fitCrop' => array(
				$backstageTools['hg']->size(array('M' => 4, 'g' => -1), false),
				$backstageTools['vg']->size(array('M' => 4, 'g' => -1), false)
			)
		),
		'preview' => array(
			'fitCrop' => array(
				$backstageTools['hg']->size(array('M' => 3, 'g' => -1), false),
				$backstageTools['vg']->size(array('M' => 3, 'g' => -1), false)
			)
		),
		'mini_preview' => array(
			'fitCrop' => array(
				$backstageTools['hg']->size(array('M' => 1, 'g' => -1), false),
				$backstageTools['vg']->size(array('M' => 1, 'g' => -1), false)
			)
		),
		'backstage_list' => array(
			'fitCrop' => array(
				$backstageTools['hg']->size(array('M' => 7, 'g' => -1), false),
				$backstageTools['vg']->size(array('M' => 2, 'g' => -1), false)
			)
		)
	)
));