<?php

/*
controleur : insert une ligne dans la table offre dans la bdd
paramètre : $idAnnonce
            : $prixOffre, le prix saisie par l'utilisateur
*/

class enregistre_offre extends _action
{

    function execute($class)
    {

        if (verifConnexion()) {

            $annonce = new annonce;
            $annonce->loadById($_POST["annonce"]);

            if ($annonce->get("etat") != 1) {
                var_dump($_POST);
                $offre = new $class;
                $offre->loadByArray($_POST);
                $idOffre = $offre->insert();
                $offre->envoieMailNewOffre();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
