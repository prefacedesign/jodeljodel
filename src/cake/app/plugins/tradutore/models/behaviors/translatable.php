<?php

/**
 * Translatable behavior class.
 *
 * ...
 *
 * Jodel Jodel
 * Copyright 2010, Preface Design
 *
 * Licensed under The MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010, Preface Design
 * @link          http://www.preface.com.br/
 * @package       jodeljodel
 * @subpackage    jodeljodel.tradutore
 * @since         Jodel Jodel 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


define('TRANSLATABLE_DEFAULT_LANGUAGE', 'en');

/**
 * Translatable behavior.
 *
 * @package       jodeljodel
 * @subpackage    jodeljodel.tradutore
 * @link ...
 */

class TranslatableBehavior extends ModelBehavior
{

    var $__settings;


    function setup(&$Model, $settings)
    {
        if (!isset($this->__settings[$Model->alias]))
        {
            $this->__settings[$Model->alias] = array(
                'defaultLanguage' => TRANSLATABLE_DEFAULT_LANGUAGE,
                'language' => TRANSLATABLE_DEFAULT_LANGUAGE
            );
        }
        $this->__settings[$Model->alias] = array_merge(
            $this->__settings[$Model->alias], (array)$settings
        );
    }


    function __setProperty(&$Model, $key, $value)
    {
        $this->__settings[$Model->alias][$key] = $value;
    }


    function __getProperty(&$Model, $key)
    {
        return $this->__settings[$Model->alias][$key];
    }


    function setDefaultLanguage(&$Model, $defaultLanguage)
    {
        $this->__setProperty($Model, 'defaultLanguage', $defaultLanguage);
    }


    function getDefaultLanguage(&$Model)
    {
        return $this->__getProperty($Model, 'defaultLanguage');
    }


    function setLanguage(&$Model, $language)
    {
        $this->__setProperty($Model, 'language', $language);
    }


    function getLanguage(&$Model)
    {
        return $this->__getProperty($Model, 'language');
    }


    function afterFind(&$Model, $results, $primary)
    {
        $alias = $Model->alias;

        foreach ($results as $i => $result)
        {
            if (isset($result[$alias]))
            {
                $results[$i][$alias]['language'] = $this->getLanguage($Model);
            }
        }
        
        return $results;
    }
}

?>
