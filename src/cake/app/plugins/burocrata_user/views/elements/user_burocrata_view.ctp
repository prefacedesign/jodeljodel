<?php
	echo $this->Bl->b(array(), array(), 'Nome: ');
	echo $this->Bl->p(array(), array(), $data['User']['name']);
	
	echo $this->Bl->b(array(), array(), 'Age: ');
	echo $this->Bl->p(array(), array(), $data['User']['age']);
	
	echo $this->Bl->b(array(), array(), 'Gender: ');
	echo $this->Bl->p(array(), array(), $data['User']['gender']);
	
	echo '<br />';