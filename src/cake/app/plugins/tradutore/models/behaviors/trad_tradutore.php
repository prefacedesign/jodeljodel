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
	
	static $currentLanguage;
	static $languageStack = array();
	
	var $hasSetLanguage = 0;

    function __setupUserSettings(&$Model, $settings)
    {
        if (!isset($this->settings[$Model->name])) {
            // Set default user settings.
            $this->settings[$Model->name] = array(
                'className'       => $Model->name . 'Translation',
                'foreignKey'      => Inflector::underscore($Model->name) . '_id',
                'languageField'   => 'language',
                'defaultLanguage' => Configure::read('Tradutore.mainLanguage')
            );
        }
        $this->settings[$Model->name] = array_merge($this->settings[$Model->name], (array)$settings);

        // On post setup time, the current language for model is the default language.
        $this->settings[$Model->name]['language'] = $this->settings[$Model->name]['defaultLanguage'];
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
        assert('isset($this->settings[$Model->name])');
        
        if (!isset($this->__settings[$Model->name])) {
            $settings = $this->settings[$Model->name];

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
            assert('in_array($translation["languageField"], $translation["fields"])');
            
            // All fields in translatable model are untranslatable.
            $untranslatableFields = $this->__dotConcat($translatable['className'], $translatable['fields']);
            
            // Not all fields in translation model are translatable.
            $fieldsToIgnore = array($translation['primaryKey'], $translation['foreignKey'], $translation['languageField']);
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
            $this->__settings[$Model->name] = array(
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
        //debug($this->settings);
        $this->__setupInternalSettings($Model);
        //debug($this->__settings);
    }


	/*
    function setDefaultLanguage(&$Model, $defaultLanguage)
    {
        assert('isset($this->__settings[$Model->name])');
        $this->settings[$Model->name]['defaultLanguage'] = $defaultLanguage;
    }


    function getDefaultLanguage(&$Model)
    {
        assert('isset($this->__settings[$Model->name])');
        return $this->settings[$Model->name]['defaultLanguage'];
    }
    
	*/
	
    function setLanguage(&$Model, $language)
    {
        assert('isset($this->__settings[$Model->name])');
		//debug($language);
		TradTradutoreBehavior::setGlobalLanguage($language);
        $this->settings[$Model->name]['language'] = $language;
    }
	
	static function setGlobalLanguage($lang = null)
	{
		if (!isset(self::$currentLanguage)) 
			self::$currentLanguage = $lang;
		//debug(self::$languageStack);
		array_push(self::$languageStack, self::$currentLanguage);
		self::$currentLanguage = $lang;
		//debug(self::$currentLanguage);
	}
	
	static function returnToPreviousGlobalLanguage()
	{
		self::$currentLanguage = array_pop(self::$languageStack);
	}


    function getLanguage(&$Model)
    {
        assert('isset($this->__settings[$Model->name])');
        return $this->settings[$Model->name]['language'];
    }


    function __isLanguageField($Model, $field)
    {
        assert('isset($this->__settings[$Model->name])');

       // if ($this->__dotConcat($Model->name, $field) == )
    }

    function __isTranslatableField($Model, $field)
    {

    }
	
	
	/*
	function __recursiveArraySearch($haystack, $needle, $index = null)
	{
		$aIt     = new RecursiveArrayIterator($haystack);
		$it    = new RecursiveIteratorIterator($aIt);
	   
		while($it->valid())
		{       
			if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) {
				return $aIt->key();
			}
		   
			$it->next();
		}
	   
		return false;
	} 
	
	function __arraySearchKey( $needle_key, $array ) 
	{
		foreach($array AS $key=>$value){
			if($key == $needle_key) return $value;
			if(is_array($value)){
				if( ($result = $this->__arraySearchKey($needle_key,$value)) !== false)
				return $result;
			}
		}
		return false;
	} 
	*/
	
    
	function __createQuery(&$Model, $query)
	{
		if (isset($this->__settings[$Model->name]))
		{
			$__settings = $this->__settings[$Model->name];
			$settings   = $this->settings[$Model->name];
		}
		
		if (isset($__settings))
		{
			$translatableFields        = $__settings['translatableFields']['translatable'];
			$translatableFieldsInQuery = array();
		

			// Search for translatable fields and language field in query.
			// If required they must be included in fields list.
			if(isset($query['fields']))
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
		
		
			//debug($settings['className']);
			//debug($Model->hasOne);
			if (!empty($Model->hasOne[$settings['className']]))
			{
				$Model->hasOne[$settings['className']]['className'] = $settings['className'];
				$Model->hasOne[$settings['className']]['foreignKey'] = $settings['foreignKey'];
				$Model->hasOne[$settings['className']]['conditions'] = $__settings['languageField']['translation'] . ' = "' . self::$currentLanguage . '"';
			}
		}
		
		foreach ($Model->belongsTo as $child)
		{
			if (in_array($child['className'], $this->already_done) === false) 
			{
				$this->already_done[] = $child['className'];
				$query = $this->__createQuery($Model->{$child['className']}, $query, self::$currentLanguage);
				
				$__setts = $Model->Behaviors->TradTradutore->__settings[$child['className']];
				$setts   = $Model->Behaviors->TradTradutore->settings[$child['className']];
				
				$c[$child['className']] = array();
				foreach ($query['fields'] as $k => $field)
				{
					$f = explode('.', $field);
					$model_child = $f[0];
					if ($model_child == $child['className'])
						$c[$child['className']]['fields'][] = $field;
				}

				if (!empty($Model->{$child['className']}->hasOne[$setts['className']]))
				{
					
					$c[$child['className']][$setts['className']] = array();
					$Model->{$child['className']}->hasOne[$setts['className']]['className'] = $setts['className'];
					$Model->{$child['className']}->hasOne[$setts['className']]['foreignKey'] = $setts['foreignKey'];
					$Model->{$child['className']}->hasOne[$setts['className']]['conditions'] = $__setts['languageField']['translation'] . ' = "' . self::$currentLanguage. '"';
					foreach ($query['fields'] as $k => $field)
					{
						$f = explode('.', $field);
						$model_child = $f[0];
						if ($model_child == $Model->{$child['className']}->hasOne[$setts['className']]['className'])
							$c[$child['className']][$setts['className']]['fields'][] = $field;
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
		
		
		
		foreach ($Model->hasOne as $child)
		{
			if (in_array($child['className'], $this->already_done) === false) 
			{
				$this->already_done[] = $child['className'];
				$query = $this->__createQuery($Model->{$child['className']}, $query);
				
				if (isset($Model->Behaviors->TradTradutore->__settings[$child['className']]))
				{
					$__setts = $Model->Behaviors->TradTradutore->__settings[$child['className']];
					$setts   = $Model->Behaviors->TradTradutore->settings[$child['className']];
				}
				
				$c[$child['className']] = array();
				if (isset($query['fields']))
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
						foreach ($query['fields'] as $k => $field)
						{
							$f = explode('.', $field);
							$model_child = $f[0];
							if ($model_child == $Model->{$child['className']}->hasOne[$setts['className']]['className'])
								$c[$child['className']][$setts['className']]['fields'][] = $field;
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
		if (isset($this->__settings[$Model->name]))
		{
			$__settings = $this->__settings[$Model->name];
			$settings   = $this->settings[$Model->name];
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
				//debug($contain);
				
				foreach($Model->{$settings['className']}->hasMany as $k => $m)
				{
					//debug($k);
					foreach($contain as $i => $c)
					{
						//debug($i);
						//debug($contain);
						if ($k == $i)
							$contain = array($settings['className'] => array($i => $c));
						//debug($contain);
					}
				}
			}
		}
		
			
		foreach ($Model->hasMany as $child)
		{
			if (in_array($child['className'], $this->already_done) === false) 
			{
				$this->already_done[] = $child['className'];
				if (isset($contain[$child['className']]))
					$contain[$child['className']] = $this->__changeContain($Model->{$child['className']}, $contain[$child['className']]);
			}
		}
		
		foreach ($Model->belongsTo as $child)
		{
			if (in_array($child['className'], $this->already_done) === false) 
			{
				$this->already_done[] = $child['className'];
				if (isset($contain[$child['className']]))
					$contain[$child['className']] = $this->__changeContain($Model->{$child['className']}, $contain[$child['className']]);
			}
		}
		
		foreach ($Model->hasAndBelongsToMany as $child)
		{
			if (in_array($child['className'], $this->already_done) === false) 
			{
				$this->already_done[] = $child['className'];
				if (isset($contain[$child['className']]))
					$contain[$child['className']] = $this->__changeContain($Model->{$child['className']}, $contain[$child['className']]);
			}
		}
		
		return $contain;
	}
    
    function beforeFind(&$Model, $query)
    {
		$__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		//debug($query);
		if (isset($query['language']))
		{
			$this->setLanguage($Model, $settings['language']);
			$this->hasSetLanguage++;
		}
		
		if (!(isset($query['emptyTranslation']) && $query['emptyTranslation'] == true))
		{
			$query['conditions']['NOT']['language'] = 'IS NOT NULL'; 
		}
		
		
		//debug($query['contain']);
		$this->already_done = array();
		$contain = $this->__changeContain($Model, $query['contain']);
		$query['contain'] = $contain;
		//debug($query['contain']);
		//die;
		$this->already_done = array();
		$query = $this->__createQuery($Model, $query);
		//debug($query);
		//die;
		
		if (isset($settings['className']))
		{
			if (!empty($Model->hasOne[$settings['className']]))
			{
				$c[$settings['className']] = array();
				if (isset($query['fields']))
				{
					foreach ($query['fields'] as $k => $field)
					{
						$f = explode('.', $field);
						$model_child = $f[0];
						if ($model_child == $settings['className'])
							$c[$settings['className']]['fields'][] = $field;
					}
				}
			}
		}
		//debug($Model->hasMany);
		
		
		foreach($Model->hasMany as $i => $model)
		{
			//debug($k);
			//debug($model);
			
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
		
		if (isset($query['fields']))
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
			
		unset($query['fields']);
		//debug($query);
		//die;
		
		return $query;
    }

    function afterFind(&$Model, $results, $primary)
    {
		//debug('after find do model:'.$Model->alias);
        $__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		
		if ($this->hasSetLanguage > 0)
		{
			$this->returnToPreviousGlobalLanguage();
			$this->hasSetLanguage--;
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
							if($k != 'id')
								$results[$i][$Model->alias][$ix][$k] = $field;	
						}
					}
					elseif(isset($r[$Model->alias][$settings['className']]))
					{
						foreach($r[$Model->alias][$settings['className']] as $k => $field)
						{
							if($k != 'id')
								$results[$i][$Model->alias][$ix][$k] = $field;
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
						if($k != 'id')
							$results[$i][$Model->alias][$k] = $field;
					}
				}
				elseif(isset($result[$Model->alias][$settings['className']]))
				{
					foreach($result[$Model->alias][$settings['className']] as $k => $field)
					{
						if($k != 'id')
							$results[$i][$Model->alias][$k] = $field;
						unset($results[$i][$Model->alias][$settings['className']][$k]);
					}
					unset($results[$i][$Model->alias][$settings['className']]);
				}
				unset($results[$i][$settings['className']]);
			}
		}

		//debug($results);
        return $results;
    }
	
	
	function afterFindCascata(&$Model, $results, $primary = false)
	{
		return $this->afterFind($Model, $results, $primary);
	}
	
	
	function beforeSave(&$Model)
    {	
        $__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		
		$translatableFields        = $__settings['translatableFields']['translatable'];
		
		if (isset($Model->data[$Model->name][0]))
		{
			foreach ($Model->data as $mod => $result) 
			{
				//debug($mod);
				//debug($result);
				foreach($result as $k => $register) 
				{
					foreach($register as $field_name => $field)
					{
						if (in_array($mod.'.'.$field_name, $translatableFields) === true) {
							$Model->data[$Model->name][$k][$settings['className']][$field_name] = $field;
							unset($Model->data[$mod][$k][$field_name]);
						}
						//debug($field_name);
					}
					
				}
			}
		}
		else
		{
			foreach ($Model->data as $mod => $result) {
				//debug(count($result));
				//debug($settings['className']);
				//debug($result);
				//debug($mod);
				//die;
				foreach($result as $field_name => $field)
				{
					if (in_array($mod.'.'.$field_name, $translatableFields) === true) {
						$Model->data[$settings['className']][$field_name] = $field;
						unset($Model->data[$mod][$field_name]);
					}
					//debug($field_name);
				}
			}
		}

		//debug($Model->data);
		return true;
		
    }
	
	function afterSave(&$Model, $created)
	{		
		$__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		
		//debug($Model->data);
		
		$Model->data[$settings['className']][$settings['foreignKey']] = $Model->id;

		
		$lang = explode('.', $__settings['languageField']['translation']);
		$lang = $lang[1];
		
		if (!isset($Model->data[$Model->name][$lang])) 
			$Model->data[$settings['className']][$lang] = self::$currentLanguage;
		else
			$Model->data[$settings['className']][$lang] = $Model->data[$Model->name][$lang];
		
		
		
		$this->Translate = & ClassRegistry::init($settings['className']);
		$this->Translate->id = false;
		
		//debug($Model->data[$settings['className']]);
		//debug($Model->id);
		//debug($settings['foreignKey']);
		$exists = $this->Translate->find('first', array('conditions' => array($settings['foreignKey'] => $Model->id, $lang => $Model->data[$settings['className']][$lang])));
		if ($exists)
			$Model->data[$settings['className']]['id'] = $exists[$settings['className']]['id'];
		//debug($settings['className']);
		//debug($Model->data[$settings['className']]);
		if ($this->Translate->save($Model->data[$settings['className']]))
			return true;
		else
			return false;
	}
}

?>
