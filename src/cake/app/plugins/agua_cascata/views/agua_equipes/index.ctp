<?php
    //arquivo que gera visualização para equipes

    foreach($equipes as $equipe){
        echo $equipe['AguaProfessor']['id'] . '<br>';
        echo $equipe['AguaProfessor']['nome'] . '<br>';
    }
?>