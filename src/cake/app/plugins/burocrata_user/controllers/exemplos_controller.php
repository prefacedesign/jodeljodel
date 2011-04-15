<?php
class ExemplosController extends BurocrataUserAppController {

	var $name = 'Exemplos';
	var $uses = array('JjMedia.SfilStoredFile', 'BurocrataUser.Video', 'BurocrataUser.Galery');
	
	function index()
	{
		$this->data = $this->Galery->findById(1);
	}
	
	function teste()
	{
		
		$this->data = array(
			'PersPerson' => array(
				'adsas' => 'Podemos já vislumbrar o modo pelo qual o novo modelo estrutural aqui preconizado talvez venha a ressaltar a relatividade dos procedimentos normalmente adotados.',
				'about' => 'É importante questionar o quanto a adoção de políticas descentralizadoras é uma das consequências do sistema de participação geral.',
				'img_id' => 13,
				'file_id' => 14,
				'ssda' => 'A certificação de metodologias que nos auxiliam a lidar com o escopo das preferências de consumo representa uma abertura para a melhoria do aceite do cliente inegavelmente apropriado.'
			)
		);
	}
	
	function video()
	{
		$this->data = $this->Video->findById(1);
	}
}
?>