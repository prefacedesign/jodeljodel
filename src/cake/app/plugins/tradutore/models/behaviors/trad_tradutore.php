<?php

/**
 * Tradutore behavior class.
 *
 * @copyright  Copyright 2010, Preface Design
 * @link       http://www.preface.com.br/
 * @license    MIT License <http://www.opensource.org/licenses/mit-license.php> - redistributions of files must retain the copyright notice
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore
 *
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
 * @version    Jodel Jodel 0.1
 * @since      11. Nov. 2010
 */

App::import('Config','Tradutore.languages');


/**
 * Tradutore behavior.
 *
 * TODO: Improve header comment of this class.
 * TODO: Remove commented debug calls.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore
 */

class TradTradutoreBehavior extends ModelBehavior
{
    var $__settings;
    var $settings;
	var $already_done = array();
	var $contained = array();
	var $hasSetLanguage = array();
	var $deleting = array();
	
	static $currentLanguage;
	static $languageStack = array();
	

    function __setupUserSettings(&$Model, $settings)
    {
        if (!isset($this->settings[$Model->alias])) {
            // Set default user settings.
            $this->settings[$Model->alias] = array(
                'className'       => $Model->name . 'Translation',
                'foreignKey'      => Inflector::underscore($Model->name) . '_id',
                'languageField'   => 'language',
                'defaultLanguage' => Configure::read('Tradutore.mainLanguage')
            );
        }
        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);
        
        $this->already_done[$Model->alias] = array();
        $this->contained[$Model->alias] = array();
        $this->deleting[$Model->alias] = 0;
        $this->hasSetLanguage[$Model->alias] = 0;
        
        // On post setup time, the current language for model is the default language.
        //$this->settings[$Model->alias]['language'] = $this->settings[$Model->alias]['defaultLanguage'];
    }
    

    function __dotConcat($prefix, $sufix)
    {
        if (is_array($sufix)) {
            $result = array();

            foreach ($sufix as $currentSufix) {
                array_push($result, $prefix . '.' . $currentSufix);
            }
            return $result;

        } else {
            return $prefix . '.' . $sufix;
        }
    }
    

    function __setupInternalSettings(&$Model)
    {
        assert('isset($this->settings[$Model->alias])');
        
        if (!isset($this->__settings[$Model->alias])) {
            $settings = $this->settings[$Model->alias];

            // Get info about translatable model: name, fields and primary key.
            $translatable = array(
                'className'  => $Model->name,
                'fields'     => array_keys($Model->_schema),
                'primaryKey' => $Model->primaryKey
            );

            $Translation  = ClassRegistry::init($settings['className']);
            assert('!is_null($Translation)');

            // Get info about translation model: name, table, fields, primary, foreign key and language field.
            $translation = array(
                'className'    => $Translation->name,
                'table'        => $Translation->tablePrefix . $Translation->table,
                'fields'       => array_keys($Translation->_schema),
                'primaryKey'   => $Translation->primaryKey,
                'foreignKey'   => $settings['foreignKey'],
                'languageField'=> $settings['languageField']
            );

            assert('in_array($translation["foreignKey"], $translation["fields"])');
			//@todo review why this line stop the session
           // assert('in_array($translation["languageField"], $translation["fields"])');
            
            // All fields in translatable model are untranslatable.
            $untranslatableFields = $this->__dotConcat($translatable['className'], $translatable['fields']);
            
            // Not all fields in translation model are translatable.
            $fieldsToIgnore = array($translation['primaryKey'], $translation['foreignKey'], $translation['languageField'], 'publishing_status');
            $fieldsDiff     = array_diff($translation['fields'], $fieldsToIgnore);

            // Build the join between translatable model and its translations.
            $join = array(
                'table' => $translation['table'],
                'alias' => $translation['className'],
                'foreignKey' => false,
                'type' => 'INNER',
                'conditions' =>
                    $this->__dotConcat($translatable['className'], $translatable['primaryKey']) . ' = ' .
                    $this->__dotConcat($translation['className'], $translation['foreignKey'])
            );

            // Set internal settings.
            $this->__settings[$Model->alias] = array(
                'languageField' => array(
                    'translatable' => $this->__dotConcat($translatable['className'], $translation['languageField']),
                    'translation'  => $this->__dotConcat($translation['className'], $translation['languageField'])
                ),
                'untranslatableFields' => $untranslatableFields,
                'translatableFields' => array(
                    'translatable' => $this->__dotConcat($translatable['className'], $fieldsDiff),
                    'translation'  => $this->__dotConcat($translation['className'], $fieldsDiff)
                ),
                'join' => $join
            );
        }
    }
    
    
    function setup(&$Model, $settings)
    {
        $this->__setupUserSettings($Model, $settings);
        $this->__setupInternalSettings($Model);
    }

    function setLanguage(&$Model, $language)
    {
        assert('isset($this->__settings[$Model->alias])');
		TradTradutoreBehavior::setGlobalLanguage($language);
        $this->settings[$Model->alias]['language'] = $language;
    }
	
	static function setGlobalLanguage($lang = null)
	{
		if (!isset(self::$currentLanguage)) 
			self::$currentLanguage = $lang;
		array_push(self::$languageStack, self::$currentLanguage);
		self::$currentLanguage = $lang;
	}
	
	static function returnToPreviousGlobalLanguage()
	{
		self::$currentLanguage = array_pop(self::$languageStack);
	}


    function getLanguage(&$Model)
    {
        assert('isset($this->__settings[$Model->alias])');
        return $this->settings[$Model->alias]['language'];
    }
	
	function getLanguages(&$Model, $id)
    {
		extract($this->settings[$Model->alias]);
		
		$translateStatus = '';
		if (isset($Model->{$className}->Behaviors->Status->__settings[$className]['publishing_status']))
		{
			$translateStatus = $Model->{$className}->Behaviors->Status->__settings[$className]['publishing_status']['field'];
			$fields = array($languageField, $translateStatus);
		}
		else
		{
			$fields = array($languageField, 'id');
		}

        $data = $Model->{$className}->find('list', 
			array(
				'conditions' => array(
					$foreignKey => $id
				),
				'fields' => $fields
			)
		);
		return($data);
    }


    function __isLanguageField($Model, $field)
    {
        assert('isset($this->__settings[$Model->alias])');
    }

    function __isTranslatableField($Model, $field)
    {

    }
	
	function __createQuery(&$Model, $query)
	{
		if (isset($this->__settings[$Model->alias]))
		{
			$__settings = $this->__settings[$Model->alias];
			$settings   = $this->settings[$Model->alias];
		}
		
		if (isset($__settings))
		{
			$translatableFields        = $__settings['translatableFields']['translatable'];
			$translatableFieldsInQuery = array();
		

			// Search for translatable fields and language field in query.
			// If required they must be included in fields list.
			if(isset($query['fields']) && is_array($query['fields']))
			{
				foreach ($query['fields'] as $i => $queryField) 
				{
					// Search for translatable fields.
					$isTranslatableField = false;
					if (in_array($Model->name . '.' . $queryField, $translatableFields) === true) 
					{	
						// Relative translatable field name found on query.
						$queryField = $Model->name . '.' . $queryField;
						$isTranslatableField = true;
					} 
					else 
					{
						if (in_array($queryField, $translatableFields) === true) 
						{
							// Absolute translatable field name found on query.
							$isTranslatableField = true;
						}
					}

					// Replace translatable field name by translation field name.
					if ($isTranslatableField) 
					{
						$queryField          = str_replace($Model->name . '.', $settings['className'] . '.', $queryField);
						$query['fields'][$i] = $queryField;
						array_push($translatableFieldsInQuery, $queryField);
					} 
				}
			}
			
			if (count($translatableFieldsInQuery) > 0) 
			{
				// Include language field in query.
				array_push($query['fields'], $__settings['languageField']['translation']);
			}
		
			if (!empty($Model->hasOne[$settings['className']]))
			{
				$Model->hasOne[$settings['className']]['className'] = $settings['className'];
				$Model->hasOne[$settings['className']]['foreignKey'] = $settings['foreignKey'];
				$Model->hasOne[$settings['className']]['conditions'] = $__settings['languageField']['translation'] . ' = "' . self::$currentLanguage . '"';
			}
		}
		
		foreach ($Model->belongsTo as $child)
		{
			if (isset($this->already_done[$Model->alias]) && in_array($child['className'],$this->already_done[$Model->alias]) === false) 
			{
				$this->already_done[$Model->alias][] = $child['className'];
				$query = $this->__createQuery($Model->{$child['className']}, $query);
				
				if (isset($Model->Behaviors->TradTradutore->__settings[$child['className']]))
				{
					$__setts = $Model->Behaviors->TradTradutore->__settings[$child['className']];
					$setts   = $Model->Behaviors->TradTradutore->settings[$child['className']];
				}
				$c[$child['className']] = array();
				if (isset($query['fields']) && is_array($query['fields']))
				{
					foreach ($query['fields'] as $k => $field)
					{
						$f = explode('.', $field);
						$model_child = $f[0];
						if ($model_child == $child['className'])
							$c[$child['className']]['fields'][] = $field;
					}
				}
				
				if (isset($setts['className']))
				{
					if (!empty($Model->{$child['className']}->hasOne[$setts['className']]))
					{
						
						$c[$child['className']][$setts['className']] = array();
						$Model->{$child['className']}->hasOne[$setts['className']]['className'] = $setts['className'];
						$Model->{$child['className']}->hasOne[$setts['className']]['foreignKey'] = $setts['foreignKey'];
						$Model->{$child['className']}->hasOne[$setts['className']]['conditions'] = $__setts['languageField']['translation'] . ' = "' . self::$currentLanguage. '"';
						if (isset($query['fields']) && is_array($query['fields']))
						{
							foreach ($query['fields'] as $k => $field)
							{
								$f = explode('.', $field);
								$model_child = $f[0];
								if ($model_child == $Model->{$child['className']}->hasOne[$setts['className']]['className'])
									$c[$child['className']][$setts['className']]['fields'][] = $field;
							}
						}
						if (!empty($c[$child['className']][$setts['className']]))
						{
							if (isset($query['contain'] ))
							{
								$query['contain'] = array_merge_recursive($query['contain'], $c);
							}
							else
							{
								$query['contain'] = $c;
							}
						}
						else
							unset($c[$child['className']][$setts['className']]);
							
						if (!empty($c[$child['className']]))
						{
							if (isset($query['contain'] ))
							{
								$query['contain'] = array_merge_recursive($query['contain'], $c);
							}
							else
							{
								$query['contain'] = $c;
							}
						}
					}
				}
			}
		}
		
		
		
		foreach ($Model->hasOne as $child)
		{
			if (isset($this->already_done[$Model->alias]) && in_array($child['className'],$this->already_done[$Model->alias]) === false) 
			{
				$this->already_done[$Model->alias][] = $child['className'];
				$query = $this->__createQuery($Model->{$child['className']}, $query);
				
				if (isset($Model->Behaviors->TradTradutore->__settings[$child['className']]))
				{
					$__setts = $Model->Behaviors->TradTradutore->__settings[$child['className']];
					$setts   = $Model->Behaviors->TradTradutore->settings[$child['className']];
				}
				
				$c[$child['className']] = array();
				if (isset($query['fields']) && is_array($query['fields']))
				{
					foreach ($query['fields'] as $k => $field)
					{
						$f = explode('.', $field);
						$model_child = $f[0];
						if ($model_child == $child['className'])
							$c[$child['className']]['fields'][] = $field;
					}
				}

				if (isset($setts))
				{
					if (!empty($Model->{$child['className']}->hasOne[$setts['className']]))
					{
						
						$c[$child['className']][$setts['className']] = array();
						$Model->{$child['className']}->hasOne[$setts['className']]['className'] = $setts['className'];
						$Model->{$child['className']}->hasOne[$setts['className']]['foreignKey'] = $setts['foreignKey'];
						$Model->{$child['className']}->hasOne[$setts['className']]['conditions'] = $__setts['languageField']['translation'] . ' = "' . self::$currentLanguage . '"';
						if (isset($query['fields']) && is_array($query['fields']))
						{
							foreach ($query['fields'] as $k => $field)
							{
								$f = explode('.', $field);
								$model_child = $f[0];
								if ($model_child == $Model->{$child['className']}->hasOne[$setts['className']]['className'])
									$c[$child['className']][$setts['className']]['fields'][] = $field;
							}
						}
						if (!empty($c[$child['className']][$setts['className']]))
						{
							if (isset($query['contain'] ))
							{
								$query['contain'] = array_merge_recursive($query['contain'], $c);
							}
							else
							{
								$query['contain'] = $c;
							}
						}
						else
							unset($c[$child['className']][$setts['className']]);
							
						if (!empty($c[$child['className']]))
						{
							if (isset($query['contain'] ))
							{
								$query['contain'] = array_merge_recursive($query['contain'], $c);
							}
							else
							{
								$query['contain'] = $c;
							}
						}
					}	
				}
			}
		}
		return $query;
	}
	
	
	function __changeContain(&$Model, &$contain)
	{
		if (!is_array($contain))
			$contain = array($contain);
			
		if (isset($this->__settings[$Model->alias]))
		{
			$__settings = $this->__settings[$Model->alias];
			$settings   = $this->settings[$Model->alias];
			$translatableFields        = $__settings['translatableFields']['translatable'];
			$translatableFieldsInQuery = array();
		}
		else
		{
			$translatableFields = array();
			$translatableFieldsInQuery = array();
		}

        // Search for translatable fields and language field in query.
        // If required they must be included in fields list.
		if (isset($contain['fields']))
		{
			if (is_array($contain['fields']))
			{
				foreach ($contain['fields'] as $i => $queryField) 
				{
					// Search for translatable fields.
					$isTranslatableField = false;
					if (in_array($Model->name . '.' . $queryField, $translatableFields) === true) 
					{	
						// Relative translatable field name found on query.
						$queryField = $Model->name . '.' . $queryField;
						$isTranslatableField = true;
					} 
					else 
					{
						if (in_array($queryField, $translatableFields) === true) 
						{
							// Absolute translatable field name found on query.
							$isTranslatableField = true;
						}
					}

					// Replace translatable field name by translation field name.
					if ($isTranslatableField) 
					{
						$queryField          = str_replace($Model->name . '.', $settings['className'] . '.', $queryField);
						if (isset($Model->hasOne[$settings['className']]))
						{
							$contain[$settings['className']]['fields'][$i] = $queryField;
							unset($contain['fields'][$i]);
						}
						else
							$contain['fields'][$i] = $queryField;
						array_push($translatableFieldsInQuery, $queryField);
					} 
				}
			}
		}
		if (count($translatableFieldsInQuery) > 0) 
		{
            // Include language field in query.
			if (isset($Model->hasOne[$settings['className']]))
				array_push($contain[$settings['className']]['fields'], $__settings['languageField']['translation']);
			else
				array_push($contain['fields'], $__settings['languageField']['translation']);
		}
		
		if (isset($settings['className']))
		{
			if (!empty($Model->hasOne[$settings['className']]))
			{
				$Model->hasOne[$settings['className']]['className'] = $settings['className'];
				$Model->hasOne[$settings['className']]['foreignKey'] = $settings['foreignKey'];
				$Model->hasOne[$settings['className']]['conditions'] = $__settings['languageField']['translation'] . ' = "' . self::$currentLanguage . '"';
			}
		
			if (!empty($Model->{$settings['className']}->hasMany))
			{
				foreach($Model->{$settings['className']}->hasMany as $k => $m)
				{
					foreach($contain as $i => $c)
					{
						if ($k == $i)
							$contain = array($settings['className'] => array($i => $c));
					}
				}
			}
			if (!empty($Model->{$settings['className']}->hasAndBelongsToMany))
			{
				foreach($Model->{$settings['className']}->hasAndBelongsToMany as $k => $m)
				{
					foreach($contain as $i => $c)
					{
						if ($k === $i)
						{
							$contain[$settings['className']] = array($i => $c);
							unset($contain[$i]);
						}
						if ($k === $c)
						{
							$contain[$settings['className']] = array($i => $c);
							unset($contain[$i]);
						}
					}
				}
			}
		}
		
		foreach ($Model->hasMany as $child)
		{
			if (isset($this->already_done[$Model->alias]) && in_array($child['className'], $this->already_done[$Model->alias]) === false) 
			{
				$this->already_done[$Model->alias][] = $child['className'];
				if (isset($contain[$child['className']]) && is_array($contain[$child['className']]))
					$contain[$child['className']] = $this->__changeContain($Model->{$child['className']}, $contain[$child['className']]);
			}
		}
		
		foreach ($Model->belongsTo as $child)
		{
			if (isset($this->already_done[$Model->alias]) && in_array($child['className'], $this->already_done[$Model->alias]) === false) 
			{
				$this->already_done[$Model->alias][] = $child['className'];
				if (isset($contain[$child['className']]))
					$contain[$child['className']] = $this->__changeContain($Model->{$child['className']}, $contain[$child['className']]);
			}
		}
		
		foreach ($Model->hasAndBelongsToMany as $child)
		{
			if (isset($this->already_done[$Model->alias]) && in_array($child['className'], $this->already_done[$Model->alias]) === false) 
			{
				$this->already_done[$Model->alias][] = $child['className'];
				if (isset($contain[$child['className']]))
					$contain[$child['className']] = $this->__changeContain($Model->{$child['className']}, $contain[$child['className']]);
			}
		}
		
		return $contain;
	}
    
	
	function generateContain(&$Model, &$contain, &$linkedModels, $_associations, $recursive)
	{
		if ($recursive > -1) 
		{
			foreach ($_associations as $type) {
				foreach ($Model->{$type} as $assoc => $assocData) {
					$linkModel =& $Model->{$assoc};
					if (empty($linkedModels[$Model->alias . '/' . $type . '/' . $assoc])) 
					{
						if (!in_array($Model->alias . '.' . $linkModel->alias, $this->contained[$Model->alias]) && !in_array($linkModel->alias . '.' . $Model->alias , $this->contained[$Model->alias]) && !in_array($linkModel->alias, $this->contained[$Model->alias])) 
						{
							$contain[$Model->alias][$assoc] = array();
							$linkedModels[$Model->alias . '/' . $type . '/' . $assoc] = true;
							if (isset($this->settings[$Model->alias]))
								$settings   = $this->settings[$Model->alias];
							if (isset($settings['className']))
								if (!empty($Model->hasOne[$settings['className']]))
									$rec = $recursive;
								else
									$rec = $recursive - 1;
							else
								$rec = $recursive - 1;
							
							array_push($this->contained[$Model->alias], $Model->alias . '.' . $linkModel->alias  );
							$this->generateContain($linkModel, $contain[$Model->alias], $linkedModels, $linkModel->__associations, $rec);	
							
						}
					}	
				}
			}
		}
		return $contain;
	}
	
    function beforeFind(&$Model, $query)
    {
		$__settings = $this->__settings[$Model->alias];
        $settings   = $this->settings[$Model->alias];
		$this->contained[$Model->alias] = array();
		
		if (isset($query['contain']) && $query['contain'] === false)
			$query['contain'] = array();
			
		if (isset($query['fields']) && !empty($query['fields']) && empty($query['contain']))
			$query['contain'] = array();
			
		if (!isset($query['contain']))
		{
			$_associations = $Model->__associations;
			if ($Model->recursive == -1) {
				$_associations = array();
			} else if ($Model->recursive == 0) {
				unset($_associations[2], $_associations[3]);
			}

			$linkedModels = array();
			$query['contain'] = array();
			
			if (!isset($query['recursive']))
				$query['recursive'] = $Model->recursive;
				
			if (isset($query['recursive']))
			{
				if ($query['recursive'] > 1)
				{
					array_push($this->contained[$Model->alias], $Model->alias);
					$contain = $this->generateContain($Model, $query['contain'], $linkedModels, $_associations, $query['recursive'] - 1);
					$query['recursive'] += 1;
					$query['contain'] = $contain[$Model->alias];
				}
				elseif ($query['recursive'] == -1)
				{
					if (isset($settings['className']))
					{
						if (!empty($Model->hasOne[$settings['className']]))
							$query['recursive'] = 1;
					}
				}
				else
				{
					$query['recursive'] = 1;
					foreach ($_associations as $type) 
					{
						foreach ($Model->{$type} as $assoc => $assocData) 
						{
							if (isset($this->settings[$assoc]))
								$child_settings = $this->settings[$assoc];
							if (isset($child_settings['className']))
							{
								if (!empty($Model->{$assoc}->hasOne[$child_settings['className']]))
								{
									$query['recursive'] = 2;
									$query['contain'][$assoc][$child_settings['className']] = array();
								}
								else
									$query['contain'][$assoc] = array();
							}
							else
							{
								$query['contain'][$assoc] = array();
							}
						}
					}
				}
			}
		}
	
		if (isset($query['language']))
		{
			$this->setLanguage($Model, $query['language']);
			$this->hasSetLanguage[$Model->alias]++;
		}
		
#		if (!$this->deleting[$Model->alias])
#		{
#			if (is_array($query['conditions']) || !isset($query['conditions']))
#				if (!(isset($query['emptyTranslation']) && $query['emptyTranslation'] == true))
#					$query['conditions']['NOT']['language'] = 'IS NOT NULL'; 
#		}
		
		$this->already_done[$Model->alias] = array();
		$contain = $this->__changeContain($Model, $query['contain']);
		$query['contain'] = $contain;
		$this->already_done[$Model->alias] = array();
		$query = $this->__createQuery($Model, $query);
		$c = array();
		
		if (isset($settings['className']))
		{       
			if (!empty($Model->hasOne[$settings['className']]))
			{
				$c[$settings['className']] = array();
				if (isset($query['fields']) && is_array($query['fields']))
				{
					foreach ($query['fields'] as $k => $field)
					{
						list($model_child) = explode('.', $field);
						if ($model_child == $settings['className'])
							$c[$settings['className']]['fields'][] = $field;
					}
				}
			}
		}
		
		foreach($Model->hasMany as $i => $model)
		{
			
			if (isset($query['fields']) && is_array($query['fields']))
			{
				foreach ($query['fields'] as $k => $field)
				{
					$f = explode('.', $field);
					$model_child = $f[0];
					if ($model_child == $i)
					{
						if (!isset($c[$i]))
							$c[$i] = array();
						$c[$i]['fields'][] = $field;
					}
				}
			}
		}
		
		if (isset($query['fields']) && is_array($query['fields']) && !isset($query['list']))
		{
			foreach ($query['fields'] as $k => $field)
			{
				$f = explode('.', $field);
				$model_child = $f[0];
				if ($model_child == $Model->alias)
					trigger_error('The fields to the root Model will be ignorated. Ever field will be returned.', E_USER_WARNING);
			}
		}
		
		
		if (isset($query['contain'] ))
			$query['contain'] = array_merge($c, $query['contain']);
		else
			$query['contain'] = $c;
		
		if (!is_array($query['fields']))
		{
			if (substr($query['fields'], 0, 5) != 'COUNT')		
				unset($query['fields']);
		}
		else
			unset($query['fields']);
		
		
		if (isset($query['list']))
			$query['recursive'] = 1;

		
		return $query;
    }

    function afterFind(&$Model, $results, $primary)
    {
        $__settings = $this->__settings[$Model->alias];
        $settings   = $this->settings[$Model->alias];
		
		
		if (isset($this->hasSetLanguage[$Model->alias]) && $this->hasSetLanguage[$Model->alias] > 0)
		{
			$this->returnToPreviousGlobalLanguage();
			$this->hasSetLanguage[$Model->alias]--;
		}
		
		
		foreach ($results as $i => $result) 
		{
			if (isset($result[$Model->alias][0]))
			{
				foreach($result[$Model->alias] as $ix => $r)
				{
					if (isset($r[$settings['className']])) 
					{
						foreach($r[$settings['className']] as $k => $field)
						{
							if (isset($Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']))
							{
								if ($k == $Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']['field'])
									$results[$i][$Model->alias][$ix]['translate_publishing_status'] = $field;
								elseif($k == 'id')
									$results[$i][$Model->alias][$ix]['translate_id'] = $field;
								elseif($k != $settings['foreignKey'])
									$results[$i][$Model->alias][$ix][$k] = $field;
							}
							else
							{
								if($k != 'id' && $k != $settings['foreignKey'])
									$results[$i][$Model->alias][$ix][$k] = $field;	
							}	
						}
					}
					elseif(isset($r[$Model->alias][$settings['className']]))
					{
						foreach($r[$Model->alias][$settings['className']] as $k => $field)
						{
							if (isset($Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']))
							{
								if ($k == $Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']['field'])
									$results[$i][$Model->alias][$ix]['translate_publishing_status'] = $field;
								elseif($k == 'id')
									$results[$i][$Model->alias][$ix]['translate_id'] = $field;
								elseif($k != $settings['foreignKey'])
									$results[$i][$Model->alias][$ix][$k] = $field;
							}
							else
							{
								if($k != 'id' && $k != $settings['foreignKey'])
									$results[$i][$Model->alias][$ix][$k] = $field;
							}
							unset($results[$i][$Model->alias][$ix][$settings['className']][$k]);
						}
						unset($results[$i][$Model->alias][$settings['className']]);
					}
					unset($results[$i][$Model->alias][$ix][$settings['className']]);
				}
			}
			else
			{
				if (isset($result[$settings['className']])) 
				{
					foreach($result[$settings['className']] as $k => $field)
					{
						if (isset($Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']))
						{
							if ($k == $Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']['field'])
								$results[$i][$Model->alias]['translate_publishing_status'] = $field;
							elseif($k == 'id')
								$results[$i][$Model->alias]['translate_id'] = $field;
							elseif($k != $settings['foreignKey'])
								$results[$i][$Model->alias][$k] = $field;
						}
						else
						{
							if($k != 'id' && $k != $settings['foreignKey'])
								$results[$i][$Model->alias][$k] = $field;
						}
					}
				}
				elseif(isset($result[$Model->alias][$settings['className']]))
				{
					foreach($result[$Model->alias][$settings['className']] as $k => $field)
					{
						if (isset($Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']))
						{
							if ($k == $Model->{$settings['className']}->Behaviors->Status->__settings[$settings['className']]['publishing_status']['field'])
								$results[$i][$Model->alias]['translate_publishing_status'] = $field;
							elseif($k == 'id')
								$results[$i][$Model->alias]['translate_id'] = $field;
							elseif($k != $settings['foreignKey'])
								$results[$i][$Model->alias][$k] = $field;
						}
						else
						{
							if($k != 'id' && $k != $settings['foreignKey'])
								$results[$i][$Model->alias][$k] = $field;
						}
						unset($results[$i][$Model->alias][$settings['className']][$k]);
					}
					unset($results[$i][$Model->alias][$settings['className']]);
				}
				unset($results[$i][$settings['className']]);
			}
		}

        return $results;
    }
	
	
	function afterFindCascata(&$Model, $results, $primary = false)
	{
		return $this->afterFind($Model, $results, $primary);
	}
	
	
	function beforeSave(&$Model)
    {	
        $__settings = $this->__settings[$Model->alias];
        $settings   = $this->settings[$Model->alias];
		
		$translatableFields        = $__settings['translatableFields']['translatable'];
		
		if (isset($Model->data[$Model->name][0]))
		{
			foreach ($Model->data as $mod => $result) 
			{
				foreach($result as $k => $register) 
				{
					foreach($register as $field_name => $field)
					{
						if (in_array($mod.'.'.$field_name, $translatableFields) === true) {
							$Model->data[$Model->name][$k][$settings['className']][$field_name] = $field;
							unset($Model->data[$mod][$k][$field_name]);
						}
					}
					
				}
			}
		}
		else
		{
			foreach ($Model->data as $mod => $result) 
			{
				foreach($result as $field_name => $field)
				{
					if (in_array($mod.'.'.$field_name, $translatableFields) === true) 
					{
						$Model->data[$settings['className']][$field_name] = $field;
						unset($Model->data[$mod][$field_name]);
					}
				}
			}
		}

		return true;
		
    }
	
	function afterSave(&$Model, $created)
	{		
		$__settings = $this->__settings[$Model->alias];
        $settings   = $this->settings[$Model->alias];
		
		$Model->data[$settings['className']][$settings['foreignKey']] = $Model->id;

		
		$lang = explode('.', $__settings['languageField']['translation']);
		$lang = $lang[1];
		if (!isset($Model->data[$Model->name][$lang])) 
			$Model->data[$settings['className']][$lang] = self::$currentLanguage;
		else
			$Model->data[$settings['className']][$lang] = $Model->data[$Model->name][$lang];
		
		$Translate = & ClassRegistry::init($settings['className']);
		$Translate->id = false;
		
		$exists = $Translate->find('first', array('conditions' => array($settings['foreignKey'] => $Model->id, $lang => $Model->data[$settings['className']][$lang])));
		if ($exists)
			$Model->data[$settings['className']]['id'] = $exists[$settings['className']]['id'];
		if ($Translate->save($Model->data[$settings['className']]))
			return true;
		else
			return false;
	}
	
	
	function beforeDelete(&$Model)
	{		
        $settings   = $this->settings[$Model->alias];
		
		$this->deleting[$Model->alias] = 1;
		if (!empty($Model->hasOne[$settings['className']]))
			return ($Model->{$settings['className']}->deleteAll(array($settings['foreignKey'] => $Model->id)));
		
		return true;
	}
	
	function afterDelete(&$Model)
	{		
		$this->deleting[$Model->alias] = 0;
		return true;
	}
	
	function createEmptyTranslation(&$Model, $id, $language)
	{
		$__settings = $this->__settings[$Model->alias];
        $settings   = $this->settings[$Model->alias];
		
		list($className, $lang) = explode('.', $__settings['languageField']['translation']);

		$Model->data[$settings['className']][$lang] = $language;
		$Model->data[$settings['className']][$settings['foreignKey']] = $id;
		
		$Translate =& ClassRegistry::init($settings['className']);
		$Translate->create();
		return $Translate->save($Model->data, false);
	}
}

?>
