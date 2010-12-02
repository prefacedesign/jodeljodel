<?php
echo $this->Bl->sdiv(array('id' => 'main_column'));

	echo $this->Bl->sdiv(array('id' => 'header'));
		echo $this->Bl->sbox(array(),array('size' => array('M' => 5, 'g' => -1)));
			echo $this->Bl->p(array(), array('escape' => false),
				$this->Bl->emDry(preg_replace('/\/$/','', Router::url('/',true))) . ' / ' . __('Content management area', true)
			);
		echo $this->Bl->ebox();		
		echo $this->Bl->sdiv(array('id' => 'user_area'));
			echo $this->Bl->pDry($user_name);
			echo $this->Bl->a(array('href' => array('/')), array(), __('Logout', true));
		echo $this->Bl->ediv();
	echo $this->Bl->ediv();
	
	echo $this->Bl->sdiv(array('id' => 'content'));
		echo $content_for_layout;
		echo $this->Bl->floatBreak();
	echo $this->Bl->ediv();
	
	echo $this->Bl->sdiv(array('id' => 'footer'));
		echo $this->Bl->sbox(array(),array('size' => array('M' => 4, 'g' => -1)));
			echo $this->Bl->pDry(__('Powered by Jodel Jodel',true));
		echo $this->Bl->ebox();
		echo $this->Bl->sbox(array(),array('size' => array('M' => 8, 'g' => -1)));
			echo $this->Bl->p(array('id' => 'credits'), array('escape'=> false), __('This site, alongside its public version, was developed by ',true)
					. $this->Bl->a(array('href'=>'http://preface.com.br'),array(), 'Preface Design')
				);
		echo $this->Bl->ebox();
	echo $this->Bl->ediv(); 

echo $this->Bl->ediv();
?>
