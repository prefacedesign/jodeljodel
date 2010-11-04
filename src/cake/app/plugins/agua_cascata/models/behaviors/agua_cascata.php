<?php
/**
 * Behavior que vai garantir o cascateamento de afterFind e beforeFind
 */
class AguaCascataBehavior extends ModelBehavior {

    function afterFind(&$Model,$results, $primary)
    {
    }

    function beforeFind(&$Model,$query)
    {
    }
    
}


?>
