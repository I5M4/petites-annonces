<?php
/*
controleur : affiche les details d'une annonce donnée
parametre : $idAnnonce, l'id de l'annonce
*/

class afficher_details_annonce extends _action{

    function execute($class){

       if( verifConnexion()){

        $idAnnonce = $_GET["annonce"];

        $annonce = new $class;
        $annonce->loadById($idAnnonce);

        include "template/details_annonce.php";

       }else{
        
            header("location:routeur.php");
       }

    }
}