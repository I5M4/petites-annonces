<?php

/*
controleur: affiche le formulaire de creation d'utilisateur
paramêtre : néant
*/

class afficher_form_creat_util extends _action{
    
    function execute($class){
        include "template/form_creat_util.php";
    }
}