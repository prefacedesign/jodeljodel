<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'principal', 'action' => 'index'));


	Router::connect(
		'/media/filter/:filter/:type/:basename',
		array('plugin' => 'jj_media', 'controller' => 'jj_media', 'action' => 'deliver_filter')
	);

/**
 * Adding `language` to the parsed named parameters
 *
 * Without this, URLs with `language:something` will fail at reverse routing!
 * The deafult option setted to true is necessary so it doesnt override the defaults named args.
 */
	//Router::connectNamed(array('language'), array('default' => true));

/**
 * Connecting the two responsible plugins for admin actions
 */
	Router::connect('/admin/:language', array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'), array('language' => '[a-t]{3}'));
	Router::connect('/admin/:language/cork/:action/*', array('plugin' => 'corktile', 'controller' => 'cork_corktiles'), array('language' => '[a-t]{3}'));
	Router::connect('/admin/:language/user/:action/*', array('plugin' => 'jj_users', 'controller' => 'user_users', 'action' => 'logout'), array('language' => '[a-t]{3}'));
	Router::connect('/admin/:language/:action/*', array('plugin' => 'backstage', 'controller' => 'back_contents'), array('language' => '[a-t]{3}'));
	
	Router::connect('/admin', array('plugin' => 'dashboard', 'controller' => 'dash_dashboard', 'action' => 'index'));
	Router::connect('/admin/cork/:action/*', array('plugin' => 'corktile', 'controller' => 'cork_corktiles'));
	Router::connect('/admin/user/:action/*', array('plugin' => 'jj_users', 'controller' => 'user_users', 'action' => 'logout'));
	Router::connect('/admin/:action/*', array('plugin' => 'backstage', 'controller' => 'back_contents'));


/**
 * Connecting '/dl' for forcing download of upload files and '/vw' for just viewing
 */
	Router::connect('/dl/*', array('plugin' => 'jj_media', 'controller' => 'jj_media', 'action' => 'index', '1'));
	Router::connect('/vw/*', array('plugin' => 'jj_media', 'controller' => 'jj_media', 'action' => 'index', '0'));

/**
 * Here, we are connecting '/css/sheet-layout_scheme.css' to a action called
 * 'sheet' in the 'estilos' controller. This allows us to create dynamic CSS,
 * according to the layout framework, called now "Estilista".
 *
 * @todo change plugin name
 * @todo check wether reverse routing will work in this case, it may be the case to change
 *	  routing in order to address this issue.
 * 
 */
	Router::connect('/css/:scheme-:action.css/*',
		array('plugin' => 'typographer', 'controller' => 'type_stylesheet'),
		array(
			'pass' => array('scheme'),
			'scheme' => '[a-z0-9_]+',
		)
	);

	Router::connect('/css/:scheme-:type-:action.css/*',
		array('plugin' => 'typographer', 'controller' => 'type_stylesheet'),
		array(
			'pass' => array('scheme', 'type'),
			'scheme' => '[a-z0-9_]+',
			'type' => '[a-z0-9_]+'
		)
	);
	
	//Router::connect('/teste/:controller/:action/*', array('plugin' => 'tradutore'));	
	
//	Router::connect('/:language/:plugin/:controller/:action/*',
//		array(),
//		array('language' => '[a-z]{3}')
//	);
//
//	Router::connect('/:language/:controller/:action/*',
//		array(),
//		array('language' => '[a-z]{3}')
//	);


	//@todo change this for the previous code (and find a way to resolve the route of plugin new)
	Router::connect('/:language/:plugin/:controller/:action/*',
		array(),
		array('language' => '[a-t]{3}')
	);

	Router::connect('/:language/:controller/:action/*',
		array(),
		array('language' => '[a-t]{3}')
	);

	//ou
	
	/*
	Router::connect('/:language/:controller/:action/*',
		array('plugin' => 'tradutore'),
		array('language' => '[a-z]{2}')
	);
	
	*/
	
