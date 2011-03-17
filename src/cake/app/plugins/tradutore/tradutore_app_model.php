<?php

class TradutoreAppModel extends AppModel {

	function deleteAll($conditions, $cascade = true, $callbacks = true)
	{
		parent::deleteAll($conditions, $cascade, $callbacks);
	}
    
}

?>