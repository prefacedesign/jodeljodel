<?php
/**
 * StatusBehavior
 *
 * @copyright Preface Design
 * @author Rodrigo Caravita, Lucas Vignoli
 * @license MIT
 * @version 0.1
 * created 29. october 2010
 *
 * This behavior lets you control registers with multiple status,
 * like published, or drafts. You can set a status with this behavior and
 * also define a list of status that are active, then in a search,
 * only the registers with this status set previously will be returned.
 * 
 * 
 * Usage example :
 * 
 * Lets say you have Category with Products, and a field status, with the
 * options published and drafs in both tables. So you have these models:
 * 
 * Category hasMany Product
 * Product belongsTo Category
 * 
 * The Product model has fields : 
 * id
 * name
 * category_id 
 * status => enum(published, draft)
 *
 * The Category model has fields:
 * id
 * name
 * status => enum('published', 'draft')
 * 
 * To set up this behavior we add this property to the both models:
 * 
 * var $actsAs = array(
 * 		'Status' => array(
 * 			'status' => array(
 *				'field' => 'whatever_the_name',
 *				'options' => array('published', 'draft'),
 *				'active' => array('published')
 *			)
 *		)
 * );
 *
 * // if you are using as a plugin, so you need to put de plugin name, like this:
 * var $actsAs = array(
 *		'Status.Status' => array(
 * 			'status' => array(
 *				'field' => 'whatever_the_name',
 *				'options' => array('published', 'draft'),
 *				'active' => array('published')
 *			)
 *		)
 * );
 *
 * // with two fields of status behavior
 * var $actsAs = array(
 *		'Status.Status' => array(
 * 			'status' => array(
 *				'field' => 'whatever_the_name',
 *				'options' => array('published', 'draft'),
 *				'active' => array('published')
 *			),
 *      	'maturarion' => array(
 *				'options' => array('unseasoned', 'mature', 'rotten')
 *			)
 *		)
 * );
 * // note that if the name of the field is the same that the name 
 * // of the index you don`t need to specify the name of the field
 *
 * // the active option controls the registers that are found in a seek
 * // if no option is passed, all the registers will be returned
 *
 * there are another ways to configure the behavior in the model,
 * if you define a default config
 *
 * in your app_controller you can define:
 * Configure::write('StatusBehavior.options.availability', array('field' => 'status', 'options' => array('active','inactive'), 'active' => array('active')));
 * Configure::write('StatusBehavior.options.maturation', array('options' => array('unseasoned', 'mature', 'rotten')));
 *
 * and in you model:
 * var $actsAs = array(
 *		'Status.Status' => array('availability', 'maturation')
 *	);
 *
 *
 * or, in a fast way:
 * Configure::write('StatusBehavior.options.default', array('field' => 'status', 'options' => array('draft','published')));
 *
 * in the model:
 * var $actsAs = array('Status.Status');
 *
 *
 * To set a status...
 * 
 * // in controller action
 * $this->Category->setStatus($id, array('status' => 'draft'));
 * // the name that`s import isn`t the name of the field, but the name set uped
 * // in the configuration (in this case, status)
 *
 * // if you have two fields configured
 * $this->Category->setStatus($id, array('status' => 'draft', 'maturarion' => 'mature'));
 * 
 * to set statuses as active...
 *
 * // in a controller action:
 * $this->Category->setActiveStatuses(array('status' => array('published')));
 * 
 * // or other way in controller action (in this case the active statuses are only set uped for this search)
 * $this->Category->find('all',array('conditions' => array('id' => 5),'active_statuses' => array('status' => array('published'))));
 *
 * 
 */
 App::import('Config', 'Status.sta_config');
 
//@todo: change the name of the behavior to StaStatus behavior
 
class StatusBehavior extends ModelBehavior 
{


	var $__settings = array();
	var $__defaults = array(
		'field' => 'status'
	);
	
	private static $activeStatus;
		 
	 /**
	 * Initiate behaviour for the model using settings.
	 *
	 * @param object $Model Model using the behaviour
	 * @param array  $config Settings to override for model
	 * @access public
	 * Config options:
	 *    field	 		    : field in the table that contains the status
	 *    options   		: array with the options of statuses
	 * 	  active    		: array with the list of statuses pre configured as active
	 *
	 */
	function setup(&$Model, $config = array()) 
	{
		if (empty($config))
		{
			$default_config = Configure::read('StatusBehavior.options.default');
			if (!isset($default_config))
				trigger_error('StatusBehavior::setup could´n be initialized. There is not a default config set aproperly. See the behavior documentation to more details.');
			else
			{
				$this->__defaults['field'] = $default_config['field'];
				if (!isset($default_config['active']))
					$default_config['active'] = $default_config['options'];
				$this->__settings[$Model->alias][$default_config['field']] = array_merge($this->__defaults, $default_config);
				if (isset($default_config['default']))
					$this->__settings[$Model->alias]['default'] = $default_config['default'];
			}
		}
		foreach($config as $index => $data)
		{

			$default_config = Configure::read('StatusBehavior.options');
			if (!is_array($data))
			{
				if (!isset($default_config[$data]))
					trigger_error('StatusBehavior::setup could´n be initialized. There is not a default config set aproperly to find the name os this configuration: '.$data.'. See the behavior documentation to more details.');
				else
				{
					$this->__defaults['field'] = $data;
					if (!isset($default_config[$data]['active']))
						$default_config[$data]['active'] = $default_config[$data]['options'];
					$this->__settings[$Model->alias][$data] = array_merge($this->__defaults, $default_config[$data]);
					if (isset($default_config[$data]['default']))
						$this->__settings[$Model->alias][$data]['default'] = $default_config[$data]['default'];
				}
			}
			else
			{
				if (isset($default_config[$index]))
				{
					$this->__defaults['field'] = $index;
					if (!isset($default_config[$index]['active']))
						$default_config[$index]['active'] = $default_config[$index]['options'];
					$this->__settings[$Model->alias][$index] = array_merge($this->__defaults, $default_config[$index]);
				}
				
				if (!empty($this->__settings))
					if (is_array($this->__settings[$Model->alias][$index]))
						$this->__defaults = $this->__settings[$Model->alias][$index];
				$this->__defaults['field'] = $index;
				if (!isset($data['active']) && isset($data['options']))
					$data['active'] = $data['options'];
				$this->__settings[$Model->alias][$index] = array_merge($this->__defaults, $data);
			}

		}
	}
	
	
	/**
	 * Run to set a status in a table
	 *
	 * @param object   $Model Model using the behaviour
	 * @param int 	   $id the id of the register that should be found
	 * @param array    $fields The name of the set of status that will be settled
	 * @return boolean Returns true if can save the data or false if not
	 * @access public
	 */
	function setStatus(&$Model, $id, $fields = array())
	{
		foreach ($fields as $index => $option)
		{
			$data = array();
			$data[$Model->alias]['id'] = $id;
			$data[$Model->alias][$this->__settings[$Model->alias][$index]['field']] = $option;
			if (!$Model->save($data, array('validate' => false)))
				return false;
		}
		return true;
	}
	
	
	/**
	 * Run to set statuses as active, and the registers with these status will be found in a seek
	 *
	 * @param object   $Model Model using the behaviour
	 * @param array    $options The set of status active, i.e. array('status' => array('published'))
	 * @param boolean  $ignore if true the function will ignore any global settings of active statuses
	 * @return array   Return an array with the settings, i.e. 
	 * 		array('Category' => array(
	 *			'status' => array(
	 *				'field' => 'status',
	 *				'options' => array('draft', 'published'),
	 *				'active' => array('published')
	 *			)
	 *		));
	 * @access public
	 */

	function setActiveStatuses(&$Model, $options = array(), $ignore = false)
	{
		foreach ($options as $index => $option)
		{
			if ($index != '0')
			{
				$default_config = Configure::read('StatusBehavior.options');
				if (isset($default_config[$index]))
				{
					if (isset($default_config[$index]['active']) && isset($option))
					{
						if (isset($default_config[$index]['overwrite']) && $default_config[$index]['overwrite'])
						{
							if ($option !== $default_config[$index]['active'] && !$ignore)
								trigger_error('StatusBehavior::setActiveStatuses error. The global settings of active statuses is different of the local settings, and it is marked to overwrite, then there are a conflict to be resolved.');
						}
					}
				}
				$this->__settings[$Model->alias][$index]['active'] = $option;
			}
			elseif (count($this->__settings[$Model->alias]) == 1)
			{
				foreach ($this->__settings[$Model->alias] as $idx => $whatever)
				{
					$this->__settings[$Model->alias][$idx]['active'] = $options;
					break 2;
				}
			}
			else
			{
				$default_config = Configure::read('StatusBehavior.options.default');
				if (!isset($default_config))
					trigger_error('StatusBehavior::setActiveStatuses error. There is not a default config set aproperly. See the behavior documentation to more details.');
				else
					$this->__settings[$Model->alias][$default_config['field']]['active'] = $options;
				break ;
			}
		}
		return $this->__settings;
	}
	
	
	/**
	 * Run to clean active statuses settled with the funcion setActiveStatuses
	 *
	 * @param object   $Model Model using the behaviour
	 * @param array    $options An array with the name of the status type that will be cleaned
	 * @return array   Return an array with the settings, i.e. 
	 * 		array('Category' => array(
	 *			'status' => array(
	 *				'field' => 'status',
	 *				'options' => array('draft', 'published'),
	 *				'active' => array('published')
	 *			)
	 *		));
	 * @access public
	 */
	function cleanActiveStatuses(&$Model, $options = array())
	{
		foreach ($options as $option)
		{
			if (!isset($this->__settings[$Model->alias][$option]))
				trigger_error('StatusBehavior::cleanActiveStatuses error. There is not a type defined to this model with the name: '.$option);
			elseif (isset($this->__settings[$Model->alias][$option]['active']))
				unset($this->__settings[$Model->alias][$option]['active']);
		}
		return $this->__settings;
	}
	
	
	/**
	 * Run to set active statuses in a global scope 
	 * (
	 *	 it´s necessaty to have the type preconfigured with, for example:
	 *	 Configure::write('StatusBehavior.options.maturation', array('options' => array('unseasoned', 'mature', 'rotten')));
	 * )
	 *
	 * @param array    $options An array with the name of the status type that will be settled
	 * options:
	 *    active 		    : array with the list of statuses pre configured as active
	 *    overwrite   		: boolean, true if should overwrite local scope that are defined by the setActiveStatuses
	 *
	 * @return array   Return an array with the settings, i.e. 
	 * 		array(
	 *			'maturation' => array(
	 *				'field' => 'maturation',
	 *				'options' => array('unseasoned', 'mature', 'rotten'),
	 *				'active' => array('mature').
	 *				'overwrite' => true
	 *			)
	 *		);
	 * @access public
	 */
	function setGlobalActiveStatuses($options = array())
	{	
		$defaultSingleOptions = array(
			'overwrite' => false,
			'mergeWithCurrentActiveStatuses' => false
		);
	
		//@todo Allow for a pile of configurations. FIFO. For one to be able to set it and return to previous configuration.
		$default_config = Configure::read('StatusBehavior.options');
		foreach($options as $index => $data)
		{
			$data = am($defaultSingleOptions, $data);
		
			if (!isset($default_config[$index]))
				trigger_error('StatusBehavior::setGlobalActiveStatuses error. The name set of the index isnt a valid name, verify if exists a config type set with this name.');
			else
			{
				if ($data['mergeWithCurrentActiveStatuses'])
				{
					$currentConfig = self::$activeStatus[$index];
					$data['active'] = am($currentConfig['active'], $data['active']);
				}
				self::$activeStatus[$index]['active'] = $data['active'];
				self::$activeStatus[$index]['overwrite'] = $data['overwrite'];
			}
		}
		return self::$activeStatus;
	}
	
	
	/**
	 * Run before a model is about to be find, found the records using the statuses defined as active
	 * or, if a status field is passed in the conditions then it will be used
	 *
	 * @param object $Model Model about to be found.
	 * @param array  $queryData Data used to execute this query, i.e. conditions, order, etc.
	 * @return array Return an array with data used to execute query
	 * @access public
	 */
	
	function beforeFind(&$Model, $queryData)
	{
		$priority_status = false;
		if (isset($queryData['active_statuses']))
		{
			$oldSettings = $this->__settings;
			$this->setActiveStatuses($Model, $queryData['active_statuses'], true);
			$priority_status = true;
		}
		$sql_conditions = '';
		if (empty($queryData['conditions']))
			$queryData['conditions'] = array();
		if (is_string($queryData['conditions']))
		{
			$sql_conditions = $queryData['conditions'];
			$queryData['conditions'] = array();
		}
		$currentActiveStatus = self::$activeStatus;
		foreach ($this->__settings[$Model->alias] as $idx => $options)
		{
			if (isset($options['field']))
			{
				$overwrite = false;
				if (isset($currentActiveStatus[$idx]))
				{
					if (isset($currentActiveStatus[$idx]['overwrite']))
						if ($currentActiveStatus[$idx]['overwrite'] && !$priority_status)
							$overwrite = true;
					
					if (!$overwrite)
					{
						if (!isset($queryData['conditions'][$Model->alias.'.'.$options['field']]))
							if (isset($options['active']))
								$queryData['conditions'][$Model->alias.'.'.$options['field']] = $options['active'];
							elseif (isset($currentActiveStatus[$idx]['active']))
								$queryData['conditions'][$Model->alias.'.'.$options['field']] = $currentActiveStatus[$idx]['active'];
					}
					else
					{
						$queryData['conditions'][$Model->alias.'.'.$options['field']] = $currentActiveStatus[$idx]['active'];
					}
				}
				else
					$queryData['conditions'][$Model->alias.'.'.$options['field']] = $options['active'];
			}
		}
		
		if (isset($Model->Behaviors->TempTemp->__settings))
		{	
			if (isset($this->__settings[$Model->alias]['publishing_status']))
			{
				if ($queryData['conditions'][$Model->alias.'.publishing_status'] != $this->__settings[$Model->alias]['publishing_status']['options'])
				{
					if (!isset($queryData['conditions'][$Model->alias.'.'.$Model->Behaviors->TempTemp->__settings[$Model->alias]['field']]))
						$queryData['conditions'][$Model->alias.'.'.$Model->Behaviors->TempTemp->__settings[$Model->alias]['field']] = 0;
				}
			}
			else
			{
				if (!isset($queryData['conditions'][$Model->alias.'.'.$Model->Behaviors->TempTemp->__settings[$Model->alias]['field']]))
					$queryData['conditions'][$Model->alias.'.'.$Model->Behaviors->TempTemp->__settings[$Model->alias]['field']] = 0;
			}
		}
		
		if (!empty($sql_conditions))
			$queryData['conditions'][] = $sql_conditions;
		if (isset($oldSettings))
			$this->__settings = $oldSettings;
			
		if (isset($Model->Behaviors->TradTradutore))
		{
			if (isset($Model->Behaviors->TradTradutore->settings[$Model->alias]))
			{
				if (isset($this->__settings[$Model->Behaviors->TradTradutore->settings[$Model->alias]['className']]))
				{
					foreach($this->__settings[$Model->Behaviors->TradTradutore->settings[$Model->alias]['className']] as $index => $translatableStatus)
					{
						$active = Configure::read('StatusBehavior.options.'.$index);
						$condition = array($Model->Behaviors->TradTradutore->settings[$Model->alias]['className'].'.'.$active['field'] => $active['active']);
						$conditions = array($Model->hasOne[$Model->Behaviors->TradTradutore->settings[$Model->alias]['className']]['conditions'], $condition);
						$Model->hasOne[$Model->Behaviors->TradTradutore->settings[$Model->alias]['className']]['conditions'] = $conditions;
						$Model->hasOne[$Model->Behaviors->TradTradutore->settings[$Model->alias]['className']]['type'] = 'LEFT';
					}
				}
			}	
		}
		return $queryData;
	}
	
	
	
	/**
	 * Run before a model is about to be save, put default status in new registers if no status is passed
	 *
	 * @param object $Model Model about to be found.
	 * @param array  $queryData Data used to execute this query, i.e. conditions, order, etc.
	 * @return array Return an array with data used to execute query
	 * @access public
	 */
	function beforeSave(&$Model)
    {	
		if (!isset($Model->data[$Model->name]['id']))
		{
			foreach($this->__settings[$Model->name] as $settings)
				if (!isset($Model->data[$Model->name][$settings['field']]) && isset($settings['default']))
					$Model->data[$Model->name][$settings['field']] = $settings['default'];
		}
		return true;
    }
	
	function afterFindCascata(&$Model, $results, $primary = false)
	{
		return $this->afterFind($Model, $results, $primary);
	}
	
}
?>
