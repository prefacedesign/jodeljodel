<?php
    //view relativo a agua_escola
    foreach($escolas as $escola){
        foreach($escola['AguaProfessor'] as $professor){
            echo $professor['id'] . '<br>';
            echo $professor['nome'] . '<br>';
        }
    }
?>