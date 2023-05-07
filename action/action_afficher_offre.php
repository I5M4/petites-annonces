<?php
/*
controleur : affiche la liste des offre pour une annonce donnée
parametre : $idAnnonce, id de l'annonce
*/

class afficher_offre extends _action{

    function execute(){
        
        if( verifConnexion()){

            $idAnnonce = $_GET["annonce"];
            $class = $_GET["class"];
            $annonce = new annonce;
            $annonce->loadById($idAnnonce);
            

            if($_SESSION["id"] == $annonce->html("createur")){

                $offre = new $class;
                $tri = ["annonce" => ["", "=", $idAnnonce]];
                $listeOffre = $offre->getAll($tri);
            
                // var_dump($listeOffre);
                include "template/fragment/liste_offre.php";
                
            }else{

                $offre = new $class;
                $tri = ["annonce" => ["", "=", $idAnnonce], "utilisateur" => ["AND", "=", $_SESSION["id"]]];
                $listeOffre = $offre->getAll($tri);
                $listeOffreUtil = listeOffreUtil($listeOffre);

                include "template/fragment/liste_mes_offre_annonce.php"; 
            }
        }else {
            header("location:routeur.php");
        }
    }
}