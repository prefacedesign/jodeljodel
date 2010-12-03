<?php
echo $bl->sdiv(array('id' => 'main_column'));

	echo $bl->sdiv(array('id' => 'header'));
		echo $bl->sbox(array(),array('size' => array('M' => 5, 'g' => -1)));
			echo $bl->p(array(), array('escape' => false),
				$bl->emDry(preg_replace('/\/$/','', Router::url('/',true))) . ' / ' . __('Content management area', true)
			);
		echo $bl->ebox();		
		echo $bl->sdiv(array('id' => 'user_area'));
			echo $bl->pDry($user_name);
			echo $bl->a(array('href' => array('/')), array(), __('Logout', true));
		echo $bl->ediv();
	echo $bl->ediv();
	
	echo $bl->sdiv(array('id' => 'content'));
		echo $content_for_layout;
		echo $bl->floatBreak();
	echo $bl->ediv();
	
	echo $bl->sdiv(array('id' => 'footer'));
		echo $bl->sbox(array(),array('size' => array('M' => 4, 'g' => -1)));
			echo $bl->pDry(__('Powered by Jodel Jodel',true));
		echo $bl->ebox();
		echo $bl->sbox(array(),array('size' => array('M' => 8, 'g' => -1)));
			echo $bl->p(array('id' => 'credits'), array('escape'=> false), __('This site, alongside its public version, was developed by ',true)
					. $bl->a(array('href'=>'http://preface.com.br'),array(), 'Preface Design')
				);
		echo $bl->ebox();
	echo $bl->ediv(); 

echo $bl->ediv();
?>
