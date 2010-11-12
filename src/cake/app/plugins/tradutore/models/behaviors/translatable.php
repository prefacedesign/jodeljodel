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


    function setup(&$Model, $settings)
    {
        if (!isset($this->__settings[$Model->alias]))
        {
            $this->__settings[$Model->alias] = array(
                'default_language' => Configure::read('Tradutore.default_language'),
                'language' => Configure::read('Tradutore.default_language')
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
        $this->__setProperty($Model, 'default_language', $defaultLanguage);
    }


    function getDefaultLanguage(&$Model)
    {
        return $this->__getProperty($Model, 'default_language');
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
        foreach ($results as $i => $result)
        {
            if (isset($result[$Model->alias]))
            {
                $results[$i][$Model->alias]['language'] = $this->getLanguage($Model);
            }
        }
        
        return $results;
    }
}

?>
