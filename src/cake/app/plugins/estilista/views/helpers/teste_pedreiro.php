<?php

App::import('Helper','Estilista.Pedreiro');

class TestePedreiroHelper extends PedreiroHelper
{	
	var $num_audio_player = 1;

	function imagemRedimensionada($atributos = array(), $opcoes = array())
	{
		$url_original = '/arquivos/' . $opcoes['arquivo'];
		
		list($w, $h, $type) = getimagesize(WWW_ROOT . $url_original);
		
		$w_orig = $w;
		$h_orig = $h;
		
		$proporcao = $w/$h;
		
		if (isset($opcoes['max_w']))
		{		
			$max_w = $this->gh->calcTam($opcoes['max_w']);
			if ($w > $max_w)
			{
				$escala = $max_w/$w;
				$w *= $escala;
				$h *= $escala;
			}
		}
		
		if (isset($opcoes['max_h']))
		{
			$max_h = $this->gv->calcTam($opcoes['max_h']);
			if ($h > $max_h)
			{
				$escala = $max_h/$h;
				$w *= $escala;
				$h *= $escala;
			}
		}
		
		$w = round($w);
		$h = round($h);
		
		preg_match('/(\w*)[.](\w*)/', $opcoes['arquivo'], $encontrados);		
		$nome_sem_extensao = $encontrados[1];
		$extensao = $encontrados[2];
		
		$url = $this->ig->url(
			array(
				'w' => $w,
				'h' => $h,
				'wi' => $w_orig,
				'hi' => $h_orig,
				'extensao' => $encontrados[2],
				'nome_base' => $nome_sem_extensao,
				'camadas' => array(
					array(
						'tipo' =>	'imagem',
						'caminho' => $url_original
					)
				)
			)
		);
		
		return $this->img(array('src' => $url));
	}
	
	function player($atributos = array(), $opcoes = array())
	{
		/*$url = 'http://localhost:8086/' . 'arquivos/'. $opcoes['arquivo'];
	
		$t = $this->p(array('id' => 'audioplayer_' . $this->num_audio_player), array(), 'Não conseguiu carregar o arquivo de música');
		$t .= $this->script(
			array('type' => 'text/javascript'), 
			array('escape' => true),
			'AudioPlayer.embed("audioplayer_' . $this->num_audio_player. '", {soundFile: "' . $url . '"});'
		);
		
		$this->num_audio_player++; */
		
		$url = $this->webroot . 'arquivos/'. $opcoes['arquivo'];		
		$url_player = $this->webroot . 'swf/player.swf';
		$id = 'audioplayer_' . $this->num_audio_player;
		
		$t = $this->iDiv(array('class' => 'audio'));
		
		$t .= $this->iObject(
			array(
				'type'   => 'application/x-shockwave-flash',
				'data'   => $url_player,
				'id'     => 'audioplayer_' . $this->num_audio_player,
				'height' => round($this->entrelinha * 1.5),
				'width'  => round($this->gh->calcTam(array('qM' => 5, 'qi' => -1), false))
			)
		);
		
		$t .= $this->param(array('name' => 'movie', 'value' => $url_player))
			. $this->param(array('name' => 'FlashVars', 'value' => 'playerID=' . $id . '&soundFile=' . $url))
			. $this->param(array('name' => 'quality', 'value' => 'high'))
			. $this->param(array('name' => 'wmode', 'value' => 'transparent'));
		
		$t .= $this->fObject()
		   .  $this->fDiv();
		/*
		<object type="application/x-shockwave-flash" data="/flash/audio_player.swf" id="<?php echo $id;?>" height="24" width="<?php echo $largura;?>">
<param name="movie" value="/flash/audio_player.swf" />
<param name="FlashVars" value="playerID=<?php echo $id;?>&soundFile=/files/<?php echo $data['Arquivo']['file_name']?>"/>
<param name="quality" value="high" />
<param name="menu" value="false" />
<param name="wmode" value="transparent" />
</object> */
		
		$this->num_audio_player++;
		
		return $t;
	}
}



?>
