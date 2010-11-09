<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns = "http://www.w3.org/1999/xhtml"  xml:lang = "pt-br"  lang = "pt-br">
	<head>
		<title>Jodel Jodel</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php 
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
