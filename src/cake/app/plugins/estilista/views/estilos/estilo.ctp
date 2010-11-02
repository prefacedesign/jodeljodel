<?php
	
	echo $this->element($modelo_de_layout . '_css', array('plugin' => 'estilista'));	
	
	$pintor->compacto = true;
	foreach($classes_automaticas_usadas as $tipo => $params) //produz todas as regras automáticas
	{
		$fabriquinha->{'geraClasses' . Inflector::camelize($tipo)}($params);
	}
	Configure::write('debug', 0);
?>
