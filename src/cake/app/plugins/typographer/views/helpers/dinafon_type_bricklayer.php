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
	
	
	var $diferentes_topos_caixas = array(
		 array(0,5), array(0,4), array(0,3), 
		 array(1,5), array(1,4), array(1,3),  
		 array(2,5), array(2,4), array(2,3), 
		 array(3,5), array(3,4), array(3,2), array(3,1), array(3,0), 
		 array(4,3), array(4,2), array(4,1), array(4,0), 
		 array(5,3), array(5,2), array(5,1), array(5,0)
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
			$colocaTopo = false;
		}
		else
			$colocaTopo = true;
		
		$t = $this->sbox($attr,$options);
		
		if ($colocaTopo)
		{
			$aleatorio = rand(0,21);
			$topoCaixaParams = array(
				'width' => $options['size'], 
				'h1' => $this->diferentes_topos_caixas[$aleatorio][0], 
				'h2' => $this->diferentes_topos_caixas[$aleatorio][1]
			);
			
			$this->TypeStyleFactory->topoCaixaGenerateClasses(array(0 => $topoCaixaParams));
			
			$attrTopo = array(
				'class' => array('topo_caixa')
			);
			$attrTopo['class'] = am($attrTopo['class'], $this->TypeStyleFactory->topoCaixaClassNames($topoCaixaParams));
			$attrTopo['class'] = am($attrTopo['class'], $this->TypeStyleFactory->widthClassNames($options['size']));

			$t .= $this->div($attrTopo);
		}

		return $t;

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
			$attr = $this->_mergeAttributes(array('class' => array($tmp[0],'flutuante')), $attr);
		}
		
		$attr = $this->_mergeAttributes(array('class' => array('coluna')), $attr);

		return $this->sdiv($attr,$options);
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
		$t.= $this->barraHorizontal(array('class' => 'cinza_branco'));
		return $t;
	}

	function h3($attr = array(), $options = array(), $content = '')
	{

		$t = parent::h3($attr,$options, $content);
		$t.= $this->barraHorizontal(array('class' => 'cinza_branco') );
		return $t;
	}

	function espacoM ()
	{
		return '&emsp;';
	}

	function espacoN ()
	{
		return '&ensp;';
	}

	function  textile($attr = array(), $options = array(), $content = null) {
		$text = parent::textile($attr, $options, $content);
		//@todo Hardcoded Dinafon only
		$text = preg_replace('/<h([1-6])>/', '</div><h$1>', $text);
		$text = preg_replace('/<\/h([1-6])>/', '</h$1><div class="para">', $text);
		$text= preg_replace('/<\/h([2-3])>/', '</h$1><div class="barra_h cinza_branco"></div>', $text);

		return ('<div class="para">' . $text . '</div>');
	}

}
?>
