<?php

class annonce extends _model {

    protected $champs = ["titre", "description","img", "prix","createur","statut", "date"];
    protected $table = "annonce";
    protected $valeur = [];
    protected $typeChamp = ["titre" => "texte", "description"=>"texte", "img"=>"texte", "prix"=>"nombre", "createur"=>"lien","statut"=>"categorie", "date"=>"date"];
    protected $valCategorie = ["statut" => [1 => "en cours", 2 => "termine"]];
    protected $affichageChamp = [];
    protected $nomComplet = [];
    protected $lien = ["createur" => "utilisateur"];
    protected $objet =[];

    protected $id = 0;

    function afficherMail(){
        //role: faire les verificaation et si ok afficher les mail
        //parametre : néant
        //retour : true si ok , false sinon

        $offre = new offre;
        $tabOffre = $offre->getAll(["annonce"=>["","=", $this->id()], "etat"=>["AND", "=", 2]]);
        if(!empty($tabOffre)){$offre = $tabOffre[0];}else{ return false;};
        $client = $offre->get("utilisateur");
        $vendeur = $this->get("createur");

        if($_SESSION["id"] == $this->html("createur") or $client->id()== $_SESSION["id"] and $this->get("statut")==2 and $offre->get("etat")==2){
            
            include "template/fragment/mail.php";
            return true;

        }else{
            return false;
        }

    }
}