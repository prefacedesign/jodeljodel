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
    
    
    function beforeFind(&$Model, $query)
    {
        $__settings = $this->__settings[$Model->name];
        $settings   = $this->settings[$Model->name];
        
        $translatableFields        = $__settings['translatableFields']['translatable'];
        $translatableFieldsInQuery = array();

        // Search for translatable fields and language field in query.
        // If required they must be included in fields list.
        foreach ($query['fields'] as $i => $queryField) {
            // Search for translatable fields.
            $isTranslatableField = false;

            if (in_array($Model->name . '.' . $queryField, $translatableFields) === true) {
                // Relative translatable field name found on query.
                $queryField = $Model->name . '.' . $queryField;
                $isTranslatableField = true;
            } else {
                if (in_array($queryField, $translatableFields) === true) {
                    // Absolute translatable field name found on query.
                    $isTranslatableField = true;
                }
            }

            // Replace translatable field name by translation field name.
            if ($isTranslatableField) {
                $queryField          = str_replace($Model->name . '.', $settings['className'] . '.', $queryField);
                $query['fields'][$i] = $queryField;
                array_push($translatableFieldsInQuery, $queryField);
            } else {

                // Search for language field.
                if ($Model->name . '.' . $queryField == $__settings['languageField']['translatable']) {

                }
            }
        }
        debug($query);

        // Translatable fields are required.
        if (count($translatableFieldsInQuery) > 0) {
            // Include language field in query.
            array_push($query['fields'], $__settings['languageField']);

            // Include language condition.
            // Get translations for default language and current language selected.
            if (!isset($query['conditions'][$__settings['languageField']])) {
                $query['conditions'][$__settings['languageField']] = array($settings['language']);
            }
            array_push($query['conditions'][$__settings['languageField']], $settings['defaultLanguage']);
            debug($query);
            die;
        }
        
        /*debug($Model);*/

        return $query;
    }

    
    function afterFind(&$Model, $results, $primary)
    {
        /*
        foreach ($results as $i => $result) {
            if (isset($result[$Model->name])) {
                $results[$i][$Model->alias]['...'] = ...
            }
        }
        */
        debug($results);
        die;

        return $results;
    }
}

?>
