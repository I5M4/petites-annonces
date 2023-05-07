<?php
/*
controleur : update le statut de l'offre en refus
paramètre: $idOffre: id de l'offre donnée
*/

class refuser_offre extends _action{

    function execute(){
        
        if(verifConnexion()){
        
            $idOffre = $_GET["offre"];
            $class = $_GET["class"];
            $offre = new $class;
            $offre->loadById($idOffre);
            
            $offre->set("etat","3");
            $offre->update();
            $offre->envoieMailReponseOffre();
        }
    }
}
