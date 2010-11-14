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
            $this->settings[$Model->name] = array(
                'translation_model_sufix' => 'Translation',
                'translation_model_language_field' => 'language',
                'default_language' => Configure::read('Tradutore.default_language'),
                'language' => Configure::read('Tradutore.default_language')
            );
        }
        $this->settings[$Model->name] = array_merge(
            $this->settings[$Model->name], (array)$settings
        );
    }


    function __fullFieldName($model, $fields)
    {
        if (is_array($fields)) {
            $fullFields = array();

            foreach ($fields as $field) {
                array_push($fullFields, $model . '.' . $field);
            }
            return $fullFields;

        } else {
            return $model . '.' . $fields;
        }
    }
    

    function __setupInternalSettings(&$Model)
    {
        if (!isset($this->__settings[$Model->name])) {
            $settings = $this->settings[$Model->name];

            // Get info about translatable model: name, fields and primary key.
            $translatable = $Model->name;
            $translatableFields = array_keys($Model->_schema);
            $translatablePK = $Model->primaryKey;
            
            // Get info about translation model: name, table, fields, primary, foreign key and language field.
            $translation = $translatable . $settings['translation_model_sufix'];
            //$Model->bindModel
            $translationTable = $Model->tablePrefix . Inflector::tableize($translation);
            $translationFields = array_keys($Model->$translation->_schema);
            $translationPK = $Model->$translation->primaryKey;
            $translationFK = $Model->hasMany[$translation]['foreignKey'];
            $translationLanguage = $settings['translation_model_language_field'];
            
            // All fields in translatable model are untranslatable.
            $untranslatableFields = $this->__fullFieldName($translatable, $translatableFields);
            
            // Not all fields in translation model are translatable.
            $fieldsToIgnore = array($translationPK, $translationFK, $translationLanguage);
            $translatableFields = $this->__fullFieldName($translatable, array_diff($translationFields, $fieldsToIgnore));

            // Build the join between translatable model and its translations.
            $join = array(
                'table' => $translationTable,
                'alias' => $translation,
                'foreignKey' => false,
                'type' => 'INNER',
                'conditions' => $this->__fullFieldName($translatable, $translatablePK) . ' = ' .
                                $this->__fullFieldName($translation, $translationFK)
            );

            $this->__settings[$Model->name] = array(
                'translation_model' => $translation,
                'language_field' => $this->__fullFieldName($translation, $translationLanguage),
                'untranslatable_fields' => $untranslatableFields,
                'translatable_fields' => $translatableFields,
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
        $this->settings[$Model->name]['language'] = $language;
    }


    function getLanguage(&$Model)
    {
        return $this->settings[$Model->name]['language'];
    }

    
    function beforeFind(&$Model, $query)
    {
        $translatableFields = 0;

        // TODO: Handle relative field names.
        foreach ($query['fields'] as $i => $field) {
            if (in_array($field, $this->__settings[$Model->name]['translatable_fields'])) {
                $query['fields'][$i] = str_replace($Model->name, $this->__settings[$Model->name]['translation_model'], $field);
                $translatableFields++;
            }
        }

        if ($translatableFields > 0) {
            $languageField = $this->__settings[$Model->name]['language_field'];
            array_push($query['fields'], $languageField);

            $languageCondition = array($languageField => $this->settings[$Model->name]['language']);
            $query['conditions'] = array_merge($query['conditions'], $languageCondition);

            array_push($query['joins'], $this->__settings[$Model->name]['join']);
        }
        
        return $query;
    }

    
    function afterFind(&$Model, $results, $primary)
    {
        /*
        foreach ($results as $i => $result) {
            if (isset($result[$Model->name])) {
                //$results[$i][$Model->alias]['language'] = $this->getLanguage($Model);
            }
        }
        */
        debug($results);
        //die;

        return $results;
    }


    function bindTranslationModel()
    {
    }


    function unbindTranslationModel()
    {
    }
}

?>
