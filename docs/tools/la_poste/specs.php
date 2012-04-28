<?php

$config['LaPoste.postSpaces'] = array(
	'Olimpiada',
	'Museu',
	'Sistema de inscrições'
);

$config['LaPoste.postSpaces'] = array(
	'Olimpiada',
	'Museu',
	'Sistema de inscrições'
);

$config['LaPoste.postSpaces.Olimpiada'] = array(
	'defaultAddresses' =>  array(
		'to' => array('user', 'draga'),
		'from' => array('olimpiada_system_team'),
	)
);

$config['LaPoste.postSpaces.Olimpiada.templates'] = array(
	'defaultAddresses' => array(
	)
);


class LpCourrierComponent extends Object
{
	/*
	 * $options = array(
	 * 		'composeNow' => true,
	 *		'priority' => true,
	 *		'addresses' => (
	 *		),
	 *		'sendTime' => 'now' // '2011-10-1',
	 *		'element' =>
	 *		'mailTemplate' => 
	 *		'additionalIdentification' => 
	 * );
	 */
	function registerLetter($space, $type, $subject, $data, $options);
	
	$id = $LpCourrier->registerLetter('6gd.sui', 'confirmacao_inscricao', $data);
	
	
	/*
	 * array(
		'lucas@preface.com.br' => array('equipe_id' => 35, 'person_id' => 12)
		);
	 */
	function addAddresses($id, $addresses);
	
	function postLetter($space, $type, $subject, $data, $options);
	
	function dispatchLetter($id);
	
	function dispatchManyLetters($timeLimit = 40, $limit = 5, $letterId = false);
	
	function _composeLetter();
	
	
	
	Olá, :nome:,
	
	:equipes:{
		:nome_equipe: - :cod_equipe: - 
	}
	
	Olá, :Nome da pessoa:
	
	
	
	array(
		'nome' => 'Lucas',
		'equipes' => array(
			'nome_equipe
		)
	
	
	
	
	
}