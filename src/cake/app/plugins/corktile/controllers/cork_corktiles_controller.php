<?php
class CorkCorktilesController extends CorktileAppController {

	var $name = 'CorkCorktiles';
	var $helpers = array('Corktile.CorkCork');
	//var $scaffold;

	function edit($key)
	{

		$this->CorkCorktile->$key = $key;
		if (empty($this->data)) {
			$this->data = $this->CorkCorktile->read();
		} else {
			if ($this->CorkCorktile->save($this->data)) {
				$message = __('Your data are save');
				$this->Session->setFlash($message);
				$this->redirect(array('action' => 'index'));
			}
	}


		
	}

	function view()
	{
		
	}

}
?>