<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

/**
 * BuroCaptioner helper.
 *
 * Uses the {@link BuroBurocrataHelper} for adding captions to the JS.
 *
 * @package       jodel
 * @subpackage    jodel.burocrata.views.helpers
 */
class BuroCaptionerHelper extends AppHelper
{
/**
 * Other helpers used by OfficeBoy
 * 
 * @access public
 * @var array
 */
	public $helpers = array('Burocrata.BuroOfficeBoy');

/**
 * Adds some portion of known captions
 * 
 * @access public
 * @param string $type What portion of captions will be included
 */
	public function addCaptions($type)
	{
		if (method_exists($this, "_$type"))
		{
			$this->{"_$type"}();
		}
	}

/**
 * Adds all captions for upload input
 * 
 * @access protected
 */
	protected function _upload()
	{
		$this->BuroOfficeBoy->addCaption('upload', 'error_size',
				__d('burocrata', 'The uploaded file is too large. (filesize > upload_max_filesize or filesize > Model::$validate definitions)', true));
		$this->BuroOfficeBoy->addCaption('upload', 'error_post_max_size',
				__d('burocrata', 'The uploaded file is too large. (filesize > post_max_size)', true));
		$this->BuroOfficeBoy->addCaption('upload', 'error_location',
				__d('burocrata', 'The upload process could not be completed because the file was placed on a non-allowed directory.', true));
		$this->BuroOfficeBoy->addCaption('upload', 'error_access',
				__d('burocrata', 'The resource is blocked and the webserver can not work properly with it.', true));
		$this->BuroOfficeBoy->addCaption('upload', 'error_resource',
				__d('burocrata', 'The upload data does not define any type of resource', true));
		$this->BuroOfficeBoy->addCaption('upload', 'sending',
				__d('burocrata', 'Uploading file #{fileName}. Please, wait...', true));
		//$this->BuroOfficeBoy->addCaption('upload', 'hours_left',
		//		__d('burocrata', 'Faltando #{hours} horas', true));
		//$this->BuroOfficeBoy->addCaption('upload', 'minutes_left',
		//		__d('burocrata', 'Faltando #{minutes} minutos', true));
		//$this->BuroOfficeBoy->addCaption('upload', 'seconds_left',
		//		__d('burocrata', 'Faltando #{seconds} segundos', true));
		$this->BuroOfficeBoy->addCaption('upload', 'cancel',
				__d('burocrata', 'Cancel', true));
		$this->BuroOfficeBoy->addCaption('upload', 'try_again',
				__d('burocrata', 'Try again', true));
		$this->BuroOfficeBoy->addCaption('upload', 'remove',
				__d('burocrata', 'Remove this file', true));
		$this->BuroOfficeBoy->addCaption('upload', 'really_abort',
				__d('burocrata', 'Really abort?', true));
		$this->BuroOfficeBoy->addCaption('upload', 'really_remove',
				__d('burocrata', 'Really remove?', true));
		$this->BuroOfficeBoy->addCaption('upload', 'generic_error',
				__d('burocrata', 'Something went wrong and the file was not sent.', true));
		$this->BuroOfficeBoy->addCaption('upload', 'error_with_server_resp',
				__d('burocrata', 'Something went wrong and the file was not sent. The server returned #{error}', true));
		$this->BuroOfficeBoy->addCaption('upload', 'transfer_ok',
				__d('burocrata', 'The file #{filename} was successfully received.', true));
		$this->BuroOfficeBoy->addCaption('upload', 'get_file',
				__d('burocrata', 'Download the file', true));
	}

/**
 * Complement for image upload field
 * 
 * @access 
 */
	protected function _imageUpload()
	{
		$this->BuroOfficeBoy->addCaption('upload', 'error_validImage',
				__d('burocrata','The uploaded file is not a valid image file.',true));
		$this->BuroOfficeBoy->addCaption('upload', 'error_pixels',
				__d('burocrata','A imagem enviada é muito grande.',true));
	}
}
