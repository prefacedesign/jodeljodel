<?php
	
	if (in_array('cork',$type))
	{

		if (in_array('form',$type))
		{
		//here goes de code from form
		} else
		{
			echo 'Conteúdo do Text ';
			echo '<BR>';
			echo $data['TextText']['text_content'];
		}
	}
?>
