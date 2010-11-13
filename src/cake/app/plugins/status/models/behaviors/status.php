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
 * The behavior also controls status in cascade. For example, if a status
 * in a table Category is changed and you have a table Products, that is
 * associated with Category (and dependent, and with the same field with 
 * the same options) than a status will be changed for the Products 
 * that category,
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
 * 		'StaStatus' => array(
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
 *		'StaStatus.StaStatus' => array(
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
 *		'StaStatus.StaStatus' => array(
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
 * // the active controls the registers that are found in a seek
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
 *		'Stastatus.StaStatus' => array('availability', 'maturation')
 *	);
 *
 *
 * or, in a fast way:
 * Configure::write('StatusBehavior.options.default', array('field' => 'status', 'options' => array('draft','published')));
 *
 * in the model:
 * var $actsAs = array('Stastatus.StaStatus');
 *
 *
 * To set a status...
 * 
 * // in controller action
 * $this->Category->setStatus($id, array('status' => 'draft'), true);
 * // the name that`s import isn`t the name of the field, but the name set uped
 * // in the configuration (in this case, status)
 *
 * // if you have two fields configured
 * $this->Category->setStatus($id, array('status' => 'draft', 'maturarion' => 'mature'), true);
 * // the true in the third parameter will change the status for
 * // the products associateds. 
 * 
 * to set statuses as active...
 *
 * // in a controller action (status in parameter is the field in the table):
 * $this->Category->setActiveStatuses(array('status' => array('published')));
 * 
 * // or other way in controller action
 * $this->Category->find('all',array('conditions' => array('id' => 5),'active_statuses' => array('status' => array('published'))));
 *
 * 
 */
 
 App::import('Config', 'Status.config');
 
class StatusBehavior extends ModelBehavior 
{

	public $settings = array();
	public $defaults = array(
		'field' => 'status'
	);
	
	
	function setup(&$Model, $config) 
	{
		if (empty($config))
		{
			$default_config = Configure::read('StatusBehavior.options.default');
			if (!isset($default_config))
				die('Error. There is not a default config set aproperly. See the behavior documentation to more details.');
			else
			{
				$this->defaults['field'] = $default_config['field'];
				if (!isset($default_config['active']))
					$default_config['active'] = $default_config['options'];
				$this->settings[$Model->alias][$default_config['field']] = array_merge($this->defaults, $default_config);
			}
		}
		foreach($config as $index => $data)
		{

			$default_config = Configure::read('StatusBehavior.options');
			if (!is_array($data))
			{
				if (!isset($default_config[$data]))
					die('Error. There is not a default config set aproperly to find the name os this configuration: '.$data.'. See the behavior documentation to more details.');
				else
				{
					$this->defaults['field'] = $data;
					if (!isset($default_config[$data]['active']))
						$default_config[$data]['active'] = $default_config[$data]['options'];
					$this->settings[$Model->alias][$data] = array_merge($this->defaults, $default_config[$data]);
				}
			}
			else
			{
				if (isset($default_config[$index]))
				{
					$this->defaults['field'] = $index;
					if (!isset($default_config[$index]['active']))
						$default_config[$index]['active'] = $default_config[$index]['options'];
					$this->settings[$Model->alias][$index] = array_merge($this->defaults, $default_config[$index]);
				}
				
				if (is_array($this->settings[$Model->alias][$index]))
					$this->defaults = $this->settings[$Model->alias][$index];
				$this->defaults['field'] = $index;
				if (!isset($data['active']) && isset($data['options']))
					$data['active'] = $data['options'];
				$this->settings[$Model->alias][$index] = array_merge($this->defaults, $data);
			}

		}

       
	}
	
	
	//precisa documentar
	function setStatus(&$Model, $id, $fields = array(), $cascade = false)
	{
		$error = false;
		foreach ($fields as $index => $option)
		{
			$data = array();
			$data[$Model->alias]['id'] = $id;
			$data[$Model->alias][$this->settings[$Model->alias][$index]['field']] = $option;
			//if ($Model->updateAll(array($this->settings[$Model->alias][$index]['field'] => '"'.$option.'"'), array('id' => $id)))
			if ($Model->save($data))
				$error = false;
			else
			{
				$error = true;
				return !$error;
			}
		}
		return !$error;
	}
	
	
	/**
	 * Run to set statuses as active, and the registers with these status will be found in a seek
	 *
	 * @param object $Model Model about to be found.
	 * @param array $options The set of status active, i.e. array('status' => array('published'))
	 * @return array Return an array with the settings, i.e. 
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
			//debug($index);
			//debug($option);
			if ($index != '0')
			{
				$default_config = Configure::read('StatusBehavior.options');
				if (isset($default_config[$index]))
				{
					if (isset($default_config[$index]['active']) && isset($option))
					{
						if ($default_config[$index]['overwrite'])
						{
							if ($option !== $default_config[$index]['active'] && !$ignore)
								die('Error. The global settings of active statuses is different of the local settings, and it is marked to overwrite, then there are a conflict to be resolved.');
						}
					}
				}
				$this->settings[$Model->alias][$index]['active'] = $option;
			}
			elseif (count($this->settings[$Model->alias]) == 1)
			{
				//debug('aqui');
				foreach ($this->settings[$Model->alias] as $idx => $whatever)
				{
					$this->settings[$Model->alias][$idx]['active'] = $options;
					break 2;
				}
			}
			else
			{
				$default_config = Configure::read('StatusBehavior.options.default');
				if (!isset($default_config))
					die('Error. There is not a default config set aproperly. See the behavior documentation to more details.');
				else
					$this->settings[$Model->alias][$default_config['field']]['active'] = $options;
				break ;
			}
		}
		//debug($this->settings);
		return $this->settings;
	}
	
	
	function cleanActiveStatuses(&$Model, $options = array())
	{
		foreach ($options as $option)
		{
			if (!isset($this->settings[$Model->alias][$option]))
				die('Error. There is not a type defined to this model with the name: '.$option);
			elseif (isset($this->settings[$Model->alias][$option]['active']))
				unset($this->settings[$Model->alias][$option]['active']);
		}
		return $this->settings;
	}
	
	
	function setGlobalActiveStatuses($options = array(), $overwrite = false)
	{
		$default_config = Configure::read('StatusBehavior.options');
		foreach($options as $index => $data)
		{
			if (!isset($default_config[$index]))
				die('Error. The name set of the index isnt a valid name, verify if exists a config type set with this name.');
			else
			{
				//debug($default_config[$index]);
				$default_config[$index]['active'] = $data['active'];
				$default_config[$index]['overwrite'] = $data['overwrite'];
				//debug($default_config[$index]);
				Configure::write('StatusBehavior.options.'.$index, $default_config[$index]);
			}
			//debug($data);
		}
		return $default_config;
		
	}

	
	
	
	/**
	 * Run before a model is about to be find, found the records using the statuses defined as active
	 * or, if a status field is passed in the conditions then it will be used
	 *
	 * @param object $Model Model about to be found.
	 * @param array $queryData Data used to execute this query, i.e. conditions, order, etc.
	 * @return mixed Set to false to abort find operation, or return an array with data used to execute query
	 * @access public
	 */
	
	function beforeFind(&$Model, $queryData)
	{
		$priority_status = false;
		if (isset($queryData['active_statuses']))
		{
			$oldSettings = $this->settings;
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
		foreach ($this->settings[$Model->alias] as $idx => $options)
		{
			//debug($options);
			$default_config = Configure::read('StatusBehavior.options');
			if (isset($options['field']))
			{
				$overwrite = false;
				if (isset($default_config[$idx]))
				{
					if (isset($default_config[$idx]['overwrite']))
						if ($default_config[$idx]['overwrite'] && !$priority_status)
							$overwrite = true;
					
					if (!$overwrite)
					{
						//debug($options['active']);
						if (!isset($queryData['conditions'][$Model->alias.'.'.$options['field']]))
							if (isset($options['active']))
								$queryData['conditions'][$Model->alias.'.'.$options['field']] = $options['active'];
							elseif (isset($default_config[$idx]['active']))
								$queryData['conditions'][$Model->alias.'.'.$options['field']] = $default_config[$idx]['active'];
					}
					else
					{
						$queryData['conditions'][$Model->alias.'.'.$options['field']] = $default_config[$idx]['active'];
					}
				}
				else
					$queryData['conditions'][$Model->alias.'.'.$options['field']] = $options['active'];
			}
		}
		
		if (!empty($sql_conditions))
			$queryData['conditions'][] = $sql_conditions;
		//debug($queryData);
		if (isset($oldSettings))
			$this->settings = $oldSettings;
		return $queryData;
		
	}
	
}
?>
