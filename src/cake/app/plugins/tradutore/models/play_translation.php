<?php

/**
 * Mock object to test Translatable behavior.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class PlayTranslation extends AppModel
{
    var $name = 'PlayTranslation';

    var $hasOne = 'Play';
}

?>
