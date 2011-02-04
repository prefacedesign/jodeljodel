<?php

/**
 * Translatable behavior class.
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

Configure::load('Tradutore.config');


/**
 * Translatable behavior.
 *
 * TODO: Improve header comment of this class.
 * TODO: Remove commented debug calls.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore
 */

class TranslatableBehavior extends ModelBehavior
{
    var $__settings;
    

    function __setupUserSettings(&$Model, $settings)
    {
        if (!isset($this->settings[$Model->name])) {
            // Set default user settings.
            $this->settings[$Model->name] = array(
                'className'       => $Model->name . 'Translation',
                'foreignKey'      => Inflector::underscore($Model->name) . '_id',
                'languageField'   => 'language',
                'defaultLanguage' => Configure::read('Tradutore.defaultLanguage')
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
    

    function setLanguage(&$Model, $language)
    {
        assert('isset($this->__settings[$Model->name])');
        $this->settings[$Model->name]['language'] = $language;
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
    
	function __createContain(&$Model, $query, $language)
	{
		$__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		
		$translatableFields        = $__settings['translatableFields']['translatable'];
        $translatableFieldsInQuery = array();

        // Search for translatable fields and language field in query.
        // If required they must be included in fields list.
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
		
		if (count($translatableFieldsInQuery) > 0) 
		{
            // Include language field in query.
            array_push($query['fields'], $__settings['languageField']['translation']);
		}
		
		if (!empty($Model->hasOne))
		{
			$Model->hasOne[$settings['className']]['className'] = $settings['className'];
			$Model->hasOne[$settings['className']]['foreignKey'] = $settings['foreignKey'];
			$Model->hasOne[$settings['className']]['conditions'] = $__settings['languageField']['translation'] . ' = "' . $language . '"';
		}
		
		foreach ($Model->belongsTo as $child)
		{
			$query = $this->__createContain($Model->{$child['className']}, $query, $language);
			
			$__setts = $Model->Behaviors->Translatable->__settings[$child['className']];
			$setts   = $Model->Behaviors->Translatable->settings[$child['className']];
			
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
				$Model->{$child['className']}->hasOne[$setts['className']]['conditions'] = $__setts['languageField']['translation'] . ' = "' . $language . '"';
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
						$query['contain'] = array_merge($c, $query['contain']);
					else
						$query['contain'] = $c;
				}
				else
					unset($c[$child['className']][$setts['className']]);
					
				if (!empty($c[$child['className']]))
				{
					if (isset($query['contain'] ))
						$query['contain'] = array_merge($c, $query['contain']);
					else
						$query['contain'] = $c;
				}
			}
			
		}
			
		return $query;
	}
    
    function beforeFind(&$Model, $query)
    {
		$__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		$language = $settings['language']; 
		$query = $this->__createContain($Model, $query, $language);
		
		if (!empty($Model->hasOne[$settings['className']]))
		{
			$c[$settings['className']] = array();
			foreach ($query['fields'] as $k => $field)
			{
				$f = explode('.', $field);
				$model_child = $f[0];
				if ($model_child == $settings['className'])
					$c[$settings['className']]['fields'][] = $field;
			}
		}
		foreach ($query['fields'] as $k => $field)
		{
			$f = explode('.', $field);
			$model_child = $f[0];
			if ($model_child == $Model->alias)
				trigger_error('The fields to the root Model will be ignorated. Ever field will be returned.', E_USER_WARNING);
		}
		
		
		if (isset($query['contain'] ))
			$query['contain'] = array_merge($c, $query['contain']);
		else
			$query['contain'] = $c;
			
		unset($query['fields']);
		debug($query);
		
		return $query;
    }

    function afterFind(&$Model, $results, $primary)
    {
		//debug('after find do model:'.$Model->alias);
        $__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
		//debug($results);
		//debug($settings);
		//debug($__settings);
        foreach ($results as $i => $result) {
			//debug($settings->className);
			//debug($settings);
			//debug($__settings);
			//debug($Model->alias);
			//debug($result);
            if (isset($result[$settings['className']])) {
				//debug('legal');
				//debug($result[$settings['className']]);
				foreach($result[$settings['className']] as $k => $field)
				{
					//debug($field);
					//debug($k);
					$results[$i][$Model->alias][$k] = $field;
				}
            }
			elseif(isset($result[$Model->alias][$settings['className']]))
			{
				debug('legal 2');
				debug($i);
				foreach($result[$Model->alias][$settings['className']] as $k => $field)
				{
					debug($field);
					debug($k);
					if($k != 'id')
						$results[$i][$Model->alias][$k] = $field;
					unset($results[$i][$Model->alias][$settings['className']][$k]);
				}
				unset($results[$i][$Model->alias][$settings['className']]);
			}
			unset($results[$i][$settings['className']]);
			
        }
        
        // debug($results);
        //die;

        return $results;
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
			$Model->data[$settings['className']][$lang] = $settings['language'];
		else
			$Model->data[$settings['className']][$lang] = $Model->data[$Model->name][$lang];
		
		
		
		$this->Translate = & ClassRegistry::init($settings['className']);
		$this->Translate->id = false;
		if ($this->Translate->save($Model->data[$settings['className']]))
			return true;
		else
			return false;
	}
}

?>
