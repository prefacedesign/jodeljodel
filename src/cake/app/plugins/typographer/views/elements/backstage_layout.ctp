<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

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
			echo $bl->sbox(array('id' => 'logo'),array('size' => array('M' => 8, 'g' => -1)));
				echo $bl->p(array(), array('escape' => false),
					$bl->emDry(preg_replace('/\/$/','', Router::url('/',true))) . ' / ' . __('Content management area', true)
				);
			echo $bl->ebox();
			echo $bl->sbox(array('id' => 'user_area'), array('size' => array('M' => 4)));
				echo $bl->pDry($userData['full_name']);
				echo $bl->anchor(array(), 
					array(
						'url' => array('plugin' => 'jj_users', 'controller' => 'user_users', 'action' => 'logout')
					), 
					__('Logout', true)
				);
			echo $bl->ebox();
			echo $this->Bl->floatBreak();
			echo $bl->menu(array(), array('menuLevel' => 1));
			if (isset($ourLocation[2]) && ($ourLocation[2] == 'user_users' || $ourLocation[2] == 'user_profiles' || $ourLocation[2] == 'user_permissions'))
				echo $bl->menu(array(), array('menuLevel' => 2));
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
