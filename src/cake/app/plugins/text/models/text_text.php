<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TextText extends TextAppModel
{
	function insertCorkContent($content = array(), $options = array(), $from_form = false)
	// o from_form, indica se o conteúdo foi gerado a partir do formulário dele ou pelo
	// usuário, caso o formato seja ligeiramente diferente...
	{
		// Esta função deve inserir o conteúdo passado como content
		// seguindo as orientações especiais das options. Em geral,
		// o content terá o formato de um save, mas em alguns casos
		// especiais o Model é livre para estabelecer outro formato.
		//
		// Se vier vazio o $content ele preencherá com o conteúdo padrão
		//
		// Esta função deve retornar a chave do conteúdo inserido, ou
		// false se não conseguir inserir.
		$this->save($content);
		
	}

	function getCorkContent($id, $options = array())
	{
		// provavelmente um find com o contain certo que devolve o conteúdo do Cork.
		return $this->find('first',array(
				'conditions' => array(
					'id' => $id
				),
				'fields' => arrau(
					'text_content'
				)
			)
		);
		
	}

	/*
	 * Função para inserção default, quando não se passa um conteúdo para o insertCorkContent
	 */
	function insertCorkDefault()
	{

	}

}

?>
