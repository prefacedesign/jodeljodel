<?php

define('JODEL_TRANSLATABLE_DEFAULT_LANGUAGE', 'en');

class JodelTranslatableBehavior extends ModelBehavior {

    var $__settings;

    function setup(&$Model, $settings) {
        if (!isset($this->__settings[$Model->alias])) {
            $this->__settings[$Model->alias] = array(
                'defaultLanguage' => JODEL_TRANSLATABLE_DEFAULT_LANGUAGE,
                'language' => JODEL_TRANSLATABLE_DEFAULT_LANGUAGE
            );
        }
        $this->__settings[$Model->alias] = array_merge(
            $this->__settings[$Model->alias], (array)$settings
        );
    }

    function __setProperty(&$Model, $key, $value) {
        $this->__settings[$Model->alias][$key] = $value;
    }

    function __getProperty(&$Model, $key) {
        return $this->__settings[$Model->alias][$key];
    }

    function setDefaultLanguage(&$Model, $defaultLanguage) {
        $this->__setProperty($Model, 'defaultLanguage', $defaultLanguage);
    }

    function getDefaultLanguage(&$Model) {
        return $this->__getProperty($Model, 'defaultLanguage');
    }

    function setLanguage(&$Model, $language) {
        $this->__setProperty($Model, 'language', $language);
    }

    function getLanguage(&$Model) {
        return $this->__getProperty($Model, 'language');
    }

}

?>
