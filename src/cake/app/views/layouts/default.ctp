<?php
echo $this->Html->doctype(),"\n",
'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">',

	'<head>',
		$this->Html->charset(),
		'<title>',$title_for_layout,'</title>',
		
		$scripts_for_layout,
	'</head>',
	'<body style="padding-top: 110px">',
		'<div style="width: 960px; margin: 0 auto; ">',
		$content_for_layout,
		'</div>',
	'</body>',
'</html>';
