<?php
//echo 'aloha';
debug($escolas);
    foreach($escolas as $escola){
        echo $escola['AguaProfessor']['id'] . '<br>';
        echo $escola['AguaProfessor']['nome'] . '<br>';
    }
?>