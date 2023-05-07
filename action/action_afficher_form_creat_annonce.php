<?php
/*
controleur : affiche le formulaire de création d'annonce
parametre : néant
*/

class afficher_form_creat_annonce extends _action{

    function execute($class){
        if(verifConnexion()){
            include "template/form_creat_annonce.php";
        
        }else{
            header("location:routeur.php");
        }
    }
}