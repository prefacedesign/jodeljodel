<?php
/**
 * Temp  Behavior
 *
 * @copyright Preface Design
 * @author Rodrigo Caravita, Lucas Vignoli
 * @license MIT
 * @version 0.1
 * created 20. september 2011
 *
 * This behavior is to control temp rows inserted in the tables pluggeds
 * in the dashboard, via the creatEmpty method. With this behavior we want to 
 * control if the register is temp or not, and also clean the temps rows by
 * a period configured in the config
 * 
 * Usage example :
 * 
 *
 * 
 * To set up this behavior we add this property to the both models:
 * 
 * var $actsAs = array(
 * 		'TempTemp' => array(
 *			'field' => 'is_temp',
 *			'modifiedBefore' => 1
 *		)
 * );
 *
 * // if you are using as a plugin, so you need to put de plugin name, like this:
 * var $actsAs = array(
 *		'Temp.TempTemp' => array(
 *			'field' => 'is_temp',
 *			'modifiedBefore' => 1
 *		)
 * );
 *
 * the option `field` is the name of the field in the table that controls if the row is temp or not
 * the option `modifiedBefore` controls, in days, how many time the row persists in the table
 * 
 * 
 */
 
 App::import('Config', 'Temp.tmp_config');
 App::import('Component', 'Session');

class TempTempBehavior extends ModelBehavior 
{
	var $__settings = array();
	var $__defaults = array(
		'field' => 'is_temp',
		'modifiedBefore' => '1'
	);
	
		 
	 /**
	 * Initiate behaviour for the model using settings.
	 *
	 * @param object $Model Model using the behaviour
	 * @param array  $config Settings to override for model
	 * @access public
	 * Config options:
	 *    field	 		    : field in the table that contains the temp field
	 *    modifiedBefore    : how many days the row persists in the table
	 *
	 */
	function setup(&$Model, $config = array()) 
	{
		$this->__settings[$Model->name] = am($this->__defaults, $config);
	}
	
	/**
	 * Run before a model is about to be save, save data with temp field = 1 if is the first insertion
	 * After the first insertion the temp_field is setled to 0, excepts if a force_temp field is passed
	 * in the data
	 * This fucntion also controls if is time to clean the temp rows, based in time configured in the config file
	 * and in the days configured in each Behavior use
	 *
	 * @param object $Model Model about to be found.
	 * @return boolean Alway returns true
	 * @access public
	 */
	
	function beforeSave(&$Model)
	{
		if (isset($Model->data[$Model->name]['id']))
		{
			if (isset($Model->data[$Model->name]['forceTemp']))
				$Model->data[$Model->name][$this->__settings[$Model->name]['field']] = 1;
			else
				$Model->data[$Model->name][$this->__settings[$Model->name]['field']] = 0;
		}
		else
			$Model->data[$Model->name][$this->__settings[$Model->name]['field']] = 1;
			
		$Session = new SessionComponent();
		$modifiedBefore = $this->__settings[$Model->name]['modifiedBefore'];
		$options = Configure::read('TempBehavior.options');
		
		$tempTime = $options['tempTime'];
		$nextClean = $Session->read('nextClean');

		$clean = false;
		if (empty($nextClean))
		{
			$clean = true;
			$nextClean = strtotime('+'.$tempTime. ' seconds');
			$Session->write('nextClean',$nextClean);
		}
		else
		{
			$actual = strtotime('+0 days');
			if ($actual > $nextClean)
			{
				$clean = true;
				$nextClean = strtotime('+'.$tempTime. ' seconds');
				$Session->write('nextClean',$nextClean);
			}
		}
		if ($clean)
		{
			$data = strtotime('-'.$modifiedBefore. ' days');
			$data = date('Y-m-d H:i:s', $data);
			$this->cleanTempRows($Model, $data);
		}
		
		return true;
	}
	
	
	/**
	 * Clean the temp rows based in a date passed 
	 *
	 * @param object	$Model Model about to be found.
	 * @param date		$modifiedBefore all rows before this date will be deleted
	 * @access public
	 */
	
	function cleanTempRows(&$Model, $modifiedBefore = null)
	{
		if ($modifiedBefore)
			$Model->deleteAll(array($Model->alias.'.is_temp' => true, $Model->alias.'.modified <=' => $modifiedBefore));
	}
}
?>
