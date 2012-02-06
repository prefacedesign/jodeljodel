<?php
	echo '<h1>', $name, '</h1>';
	if (Configure::read() == 0)
		$message = sprintf(__('The requested address %s was not found on this server.', true), "<strong>'{$message}'</strong>");
	echo '<p><strong>Error:</strong> ', $message, '</p>';
