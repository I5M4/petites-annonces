<?php
/*
controleur: update le statut de l'offre en accpeter, update le statut de l'annonce en terminé et affiche les adresse mail de l'acheteur et le createur de l'annonce et envoie un mail pour prevenir l'acheteur (ici l'utilisateur courant);
paramètre : $idOffre , l'id de l'offre donnée
*/

class accepter_offre extends _action
{



    function execute()
    {

        verifConnexion();

        $idOffre = $_GET["offre"];
        $class = $_GET["class"];
        $offre = new $class;
        $offre->loadById($idOffre);
        $annonce = $offre->get("annonce");
        $offre->set("etat", 2);


        $annonce->set("statut", 2);
        $offre->update();
        $offre->envoieMailReponseOffre();
        $offre->envoieMailContact();
        $annonce->update();

        $listeOffreEnCour = $offre->getAll(["annonce" => ["", "=", $annonce->id()], "etat" => ["AND", "=", "1"]]);

        foreach ($listeOffreEnCour as $offreEnCours) {

            $offreEnCours->set("etat", "3");
            $offreEnCours->update();
            $offreEnCours->envoieMailReponseOffre();
        }
    }
}
