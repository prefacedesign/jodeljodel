<?php
    debug($todos);
    foreach($todos as $prof){
        echo $prof['AguaProfessor']['id'] . '<br>';
        echo $prof['AguaProfessor']['nome'] . '<br>';
    }
?>