<?php
//@todo Make something to backstage be able to access multiple layouts
if (isset($typeLayout) && $typeLayout == 'login')
{
	echo $bl->sdiv(array('id' => 'login_box'));
		echo $bl->sdiv(array('id' => 'login_box_contained'));
			echo $content_for_layout;
		echo $bl->ediv();
	echo $bl->ediv();
}
else
{
	echo $bl->sdiv(array('id' => 'main_column'));

		echo $bl->sdiv(array('id' => 'header'));
			echo $bl->sbox(array(),array('size' => array('M' => 5, 'g' => -1)));
				echo $bl->p(array(), array('escape' => false),
					$bl->emDry(preg_replace('/\/$/','', Router::url('/',true))) . ' / ' . __('Content management area', true)
				);
			echo $bl->ebox();		
			echo $bl->sdiv(array('id' => 'user_area'));
				echo $bl->pDry($userData['name']);
				echo $bl->anchor(array(), 
					array(
						'url' => array(
							'plugin' => 'jj_users', 
							'controller' => 'user_users', 
							'action' => 'logout'
						)
					), 
					__('Logout', true)
				);
			echo $bl->ediv();
			echo $bl->menu(array(), array('menuLevel' => 1));
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
}
?>
