<?php
// to test with default configuration of the behavior
Configure::write('StaStatusBehavior.options.disponibilidade', array('field' => 'status', 'options' => array('ativo','inativo')));
Configure::write('StaStatusBehavior.options.etapa', array('options' => array('verde','maduro','podre')));

// to work easily. in the model just use: var $actsAs = array('Stastatus.StaStatus');
Configure::write('StaStatusBehavior.options.default', array('field' => 'status', 'options' => array('rascunho','publicado'), 'active' => array('publicado')));

class StastatusAppController extends AppController 
{
	function beforeFilter()
	{
		$this->layout = 'default';
	}
}
?>