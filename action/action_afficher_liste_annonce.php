<?php
/*
controleur: affiche la liste des annonces

parametre: (les critères de tri optionnel)
            : $recherche, (tri par texte)
            : $prixMin
            :$prixMax
            :$anciennete (date min)
            
*/


class afficher_liste_annonce extends _action
{


    function execute($class)
    {

        $annonce = new $class;

        if (isset($_GET["cible"])) {

            if ($_GET["cible"] == "annonce") {

                $listeAnnonce = $annonce->getAll(["createur" => [" ", "=", $_SESSION["id"]]]);
                include "template/fragment/liste_annonce.php";
            } elseif ($_GET["cible"] == "offre") {


                $offre = new $_GET["cible"];
                $listeOffre = $offre->getAll(["utilisateur" => [" ", "=", $_SESSION["id"]]]);
                include "template/fragment/mes_offres.php";
            }
        } else if (empty($_POST) and empty($_GET["cible"])) {


            $listeAnnonce = $annonce->getAll(["statut" => ["", "=", "1"]]);

            include "template/accueil.php";
        } else if (!empty($_POST)) {

            isset($_POST["recherche"]) ? $recherche = $_POST["recherche"] : $recherche = NULL;
            isset($_POST["prixMin"]) ? $prixMin = $_POST["prixMin"] : $prixMin = NULL;
            isset($_POST["prixMax"]) ? $prixMax = $_POST["prixMax"] : $prixMax = NULL;
            isset($_POST["date"]) ? $date = $_POST["date"] : $date = NULL;

            if ($_POST["prixMax"] != NULL and $_POST["prixMin"] == Null) {
                $prixMin = "0";
            }


            $tri = ["titre" => [" ", "LIKE", "%" . $recherche . "%"], "description" => ["OR", "LIKE", "%" . $_POST["recherche"] . "%"], "prix" => ["AND", "BETWEEN", $prixMin, "AND", $prixMax], "date" => ["AND", ">=", $date], "statut" => ["AND", "=", "1"]];

            $listeAnnonce = $annonce->getAll($tri);

            include "template/fragment/liste_annonce.php";
        }
    }
}
