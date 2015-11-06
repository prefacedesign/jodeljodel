<?php

/**
 * When defined to a valid location (a mirror), the Media plugin will attempt to find a copy on the mirror
 * to use it as original and create the filtered option
 *
 * $type string|false
 */
$config['JjMedia']['mirror'] = '';

/**
 * When set to false, the JjMedia will create the filtered images right after the original is saved.
 * If set to true, the filtered image will be created only when requested.
 *
 * @type boolean
 */
$config['JjMedia']['asyncGeneration'] = true;
