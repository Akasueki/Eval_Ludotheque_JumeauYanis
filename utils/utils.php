<?php

function formatJoueurs($min, $max){
    if($min == 1 && $max == 1){
        return 'Solo';
    }else if($min === $max){
        return $min . "joueurs";
    }else{
        return $min . "à" . $max . "joueurs";
    }
}

function categorieDuree($duree){
    if($duree <= 30){
        return "Partie rapide";
    }else if($duree <= 90){
        return "Partie moyenne";
    }else{
        return "Partie longue";
    }
}
?>