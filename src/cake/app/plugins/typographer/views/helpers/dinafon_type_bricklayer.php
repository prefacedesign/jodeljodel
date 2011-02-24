<?php

App::import('Helper', 'Typographer.TypeBricklayer');

//@todo rever todo lugar que tem tamanho/size, quando for mexer no nome da classe n??o precisa passar pro options
//@todo para resolver lugares onde ?? usado calcNomeTam - verificar o sBox e usar como modelo  - vai precisar mexer no
//styleFactory
class DinafonTypeBricklayerHelper extends TypeBricklayerHelper
{

	var $helpers = array(
		'Typographer.*TypeStyleFactory' => array(
			'name' => 'TypeStyleFactory'
		),
		'Html'
	);
	//@todo incluir o topo caixa, e quando fizer isso incluir um ediv no ecaixa
	function scaixa($attr = array(), $options = array())
	{
		//definir i -1
		//quando for transparente, chamar o sbox com transparent
		//
		$options['size'] = am($options['size'],array('g' => -1));

		$attr = $this->_mergeAttributes(array('class' => array('caixa')), $attr);

		if (isset($options['tipo']) && ($options['tipo'] == 'transparente')){
			$attr = $this->_mergeAttributes(array('class' => array('transparente')), $attr);
			unset ($options['tipo']);
		}
		

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


		return $this->div($attr,$options);
	}

	//$tamanho = array
	function espacadorVertical($attr = array(), $options = array())
	{
		$size = array('g' => 1);
		if (isset($options['size']))
			$size = am($size, $options['size']);


		$this->TypeStyleFactory->widthGenerateClasses(array(0 => $size));
		$tmp = $this->TypeStyleFactory->widthClassNames($size);
		$width = $tmp[0];

		unset($options['size']);

		return $this->div(array('class' => array('espacador_vertical',$width)),$options);
	}

	function espacadorHorizontal($attr = array(), $options = array())
	{
		$size = array('g' => 1);
		if (isset($options['size']))
		{
			$size = am($size, $options['size']);
		}

		$this->TypeStyleFactory->heightGenerateClasses(array(0 => $size));
		$tmp = $this->TypeStyleFactory->heightClassNames($size );
		$height = $tmp[0];


		unset($options['size']);


		return $this->div(array('class' => array ('espacador_horizontal',$height)),$options) . $this->floatBreak();
	}

	//$parametros = null, $atributos = null

	//@todo rever essa fun????o para ver se est?? ok em rela????o ao kulepona

	function scoluna($attr = array(), $options = array())
	{
		$width = 'larg_auto';
		if (isset ($options['size']))
		{
			$size = array('g' => -1);
			$size = am($size, $options['size']);

			$this->TypeStyleFactory->widthGenerateClasses(array(0 => $size));
			$tmp = $this->TypeStyleFactory->widthClassNames($size);
			$width = $tmp[0];
		}

		return $this->sdiv(array('class' => array('coluna','flutuante',$width)),$options);
	}

	function ecoluna()
	{
		return $this->ediv();
	}

	//@todo acertar essa fun????o (caso realmente ela n??o exista no type bricklayer)

	function simagem($attr = array(),$options = array())
	{
		if (isset($options['imgurl'])) {
			$attr = $this->_mergeAttributes(array('src' => $options['imgurl']),$attr);
			unset($options['imgurl']);
		}

		return $this->simg($attr,$options);
	}
	function eimagem()
	{
		return $this->eimg();
	}


	function scaixote($attr = array(), $options = array())
	{
		$attr = $this->_mergeAttributes(array('class' => array('caixote')), $attr);
		return $this->sbox($attr,$options);
	}

	function ecaixote()
	{
		return $this->ebox();
	}


	function h2($attr = array(), $options = array(), $content = '')
	{

		$t = parent::h2($attr,$options, $content);
		$t.= $this->barraHorizontal(array('class' => 'cinza_branco') );
		return $t;
	}

	function h3($attr = array(), $options = array(), $content = '')
	{

		$t = parent::h3($attr,$options, $content);
		$t.= $this->barraHorizontal(array('class' => 'cinza_branco') );
		return $t;
	}

}
?>
