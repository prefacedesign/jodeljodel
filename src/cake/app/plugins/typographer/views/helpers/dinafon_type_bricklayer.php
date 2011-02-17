<?php

App::import('Helper', 'Typographer.TypeBricklayer');

//@todo rever todo lugar que tem tamanho/size, quando for mexer no nome da classe não precisa passar pro options
//@todo para resolver lugares onde é usado calcNomeTam - verificar o sBox e usar como modelo  - vai precisar mexer no
//styleFactory
class DinafonTypeBricklayerHelper extends TypeBricklayerHelper
{

	//@todo incluir o topo caixa, e quando fizer isso incluir um ediv no ecaixa
	function scaixa($attr = array(), $options = array())
	{
		//definir i -1
		//quando for transparente, chamar o sbox com transparent
		//
		$options = am(array('size' => array('g' => -1)), $options);

		if (isset($options['tipo']) && ($options['tipo'] == 'transparente'))
			$attr = $this->_mergeAttributes(array('class' => array('transparente')), $attr);
		return $this->sbox($attr,$options);  //'<div class="topo_caixa '. $classe_largura . ' ' . _classe_estilo_topo_caixa($tamanho['qM']) . '"></div>';
		
	}

	function ecaixa()
	{
		return $this->ebox();
	}
	//$tipo, $parametros = null, $atributos = null
	function barraHorizontal($attr = array(),$options = array())
	{
		if (isset($options['tipo'])){
			$class = array('barra_h', $options['tipo']);
			unset($options['tipo']);
		}
		else
			$class = array('barra_h');

		$attr = $this->_mergeAttributes(array('class' => $class), $attr);


		return $this->sdiv($attr,$options);
	}

	//$tamanho = array
	function espacadorVertical($attr = array(), $options = array())
	{
		$size = array('g' => 1);
		$size = am($size, $options['size']);
		unset($options['size']);

		$largura = 'larg' . $this->calcNomeTam($size);

		return $this->div(array('class' => array('espacador_vertical',$largura)));
	}

	function espacadorHorizontal($attr = array(), $options = array())
	{
		$size = array('g' => 1);
		$size = am($size, $options['size']);
		unset($options['size']);

		$altura = 'alt' . $this->calcNomeTam($size);

		return $this->div(array('class' => array ('espacador_horizontal',$altura))) . $this->floatBreak();
		//return '<div class="espacador_horizontal ' . $altura .'"></div>' . $this->limpador();

	}

	//$parametros = null, $atributos = null

	//@todo rever essa função para ver se está ok em relação ao kulepona
	function scoluna($attr = array(), $options = array())
	{
		$largura = 'larg_auto';
		if (isset ($options['size']))
		{
			$size = array('g' => -1);
			$size = am($size, $options[size]);

			$largura = 'flutuante larg' . $this->calcNomeTam($size);
		}

		return $this->sdiv(array('class' => array('coluna',$largura)));
	}

	function ecoluna()
	{
		return $this->ediv();
	}



}
?>
