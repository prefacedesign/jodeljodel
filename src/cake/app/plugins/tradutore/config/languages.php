<?php

Configure::write('Tradutore.mainLanguage', 'por');
Configure::write('Tradutore.languages', array('por', 'eng'));

Configure::write('Tradutore.guessingMethod', 'http'); // 'http', 'ip', false
Configure::write('Tradutore.guessingFallback', 'por'); // Some language to be used when was not possible to guess (false is acceptable)

?>
