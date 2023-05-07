<?php
/*
contoleur: affiche le formulaire de connexion utilisateur
parametre : néant
*/ 


class affiche_connect_util extends _action{

    function execute($class){
        
        include "template/form_connect_util.php";
    }
}