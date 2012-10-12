<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */

			echo $javascript->link('prototype');
			echo $javascript->link('scriptaculous');
		?>
		
	</head>

	<body>
		<div id = "container">
			<?php echo $content_for_layout;?>
			<br />
		</div>
		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>
