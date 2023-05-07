<?php

class offre extends _model
{

    protected $champs = ["montant", "annonce", "utilisateur", "etat"];
    protected $table = "offre";
    protected $valeur = [];
    protected $typeChamp = ["montant" => "nombre", "annonce" => "lien", "utilisateur" => "lien", "etat" => "categorie"];
    protected $valCategorie = ["etat" => [1 => "en cours", 2 => "accepté", 3 => "refusé"]];
    protected $affichageChamp = [];
    protected $nomComplet = [];
    protected $lien = ["annonce" => "annonce", "utilisateur" => "utilisateur"];
    protected $objet = [];

    protected $id = "";

    function envoieMailNewOffre()
    {
        //role: envoyer un mail au créateur de l'annonce lorsqu'une nouvelle offre est enregistré
        //parametre : néant
        //retour néant
        $annonce = new annonce;
        $annonce->loadById($this->html("annonce"));

        $sujet = "Nouvelle offre ";
        $message = "vous avez reçu une nouvelle offre pour votre annonce : " . $annonce->html("titre");
        $destMail = "ivas@mywebecom.ovh";
        $destNom = $annonce->get("createur")->html("pseudo");

        // Préparation du mail
        $messageComplet = "Bonjour $destNom, 
        $message";

        // entetes :
        $entetes = [];      // tableau vide pour les entetes

        // FROM
        $entetes["From"] = '"Annonces isma" <mywebecom@mywebecom.ovh>';       // L'adresse mail avec le @ doit être celle du serveur, ou du système de messagerie utilisé

        // REPLY TO : destinataire des réponses
        $entetes["Reply-To"] = '';

        // Mail HTML :
        // entete spécifiques
        $entetes["MIME-version"] = "1.0";
        $entetes["Content-Type"] = "text/html; charset=utf8";

        $messageHTML = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        </head>
        <body>
            <p>Bonjour ' . $destNom . ', </p>
            <p>' . nl2br(htmlentities($message)) . '</p>
            <p>on vous propose ' . $this->html("montant") . '€ <p>
            <a href="http://annonces.ivas.mywebecom.ovh/routeur.php?action=affiche_connect_util&class=utilisateur">Se connecter</a>
        </body>
        </html>
        ';

        // Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
        $destinataire = '"' . $destNom . '" ' . "<$destMail>";

        mail($destinataire, $sujet, $messageHTML, $entetes);
    }

    function envoieMailReponseOffre()
    {
        //role: envoie un mail a l'utilisateur qui a fait l'offre lorsqu'elle est accepter ou refusé
        //paramêtre : néant 
        //retour :néant 

        $annonce = new annonce;
        $annonce->loadById($this->html("annonce"));


        if ($this->get("etat") == 2) {

            $reponse = "accepté";
            $mail = "vous pouvez joindre le vendeur : " . $annonce->get("createur")->html("email");
        } else if ($this->get("etat") == 3) {

            $reponse = "refusé";
            $mail = "";
        }

        $sujet = "vous avez reçu une réponse ";
        $message = "votre offre d'un montant de " . $this->html("montant") . " €, pour l'annonce : " . $annonce->html("titre") . " à été " . $reponse;
        $destMail = "ivas@mywebecom.ovh";
        $destNom = $this->getValLiee("pseudo", "utilisateur");

        // Préparation du mail
        $messageComplet = "Bonjour $destNom, 
        $message";

        // entetes :
        $entetes = [];      // tableau vide pour les entetes

        // FROM
        $entetes["From"] = '"Annonces isma" <mywebecom@mywebecom.ovh>';       // L'adresse mail avec le @ doit être celle du serveur, ou du système de messagerie utilisé

        // REPLY TO : destinataire des réponses
        $entetes["Reply-To"] = '';

        // Mail HTML :
        // entete spécifiques
        $entetes["MIME-version"] = "1.0";
        $entetes["Content-Type"] = "text/html; charset=utf8";

        $messageHTML = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        </head>
        <body>
            <p>Bonjour ' . $destNom . ', </p>
            <p>' . nl2br(htmlentities($message)) . '</p>
            <p>' . $mail . '</p>
        </body>
        </html>
        ';

        // Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
        $destinataire = '"' . $destNom . '" ' . "<$destMail>";

        mail($destinataire, $sujet, $messageHTML, $entetes);
    }


    function envoieMailContact()
    {
        //role: envoie un mail a l'utilisateur qui a fait l'offre lorsqu'elle est accepter ou refusé
        //paramêtre : néant 
        //retour :néant 

        $annonce = new annonce;
        $annonce->loadById($this->html("annonce"));


        $mail = "vous pouvez joindre l'aquèreur pour les details de la vente : " . $this->get("utilisateur")->html("email");


        $sujet = "vous avez reçu une réponse ";
        $message = "votre avez accepté l'offre d'un montant de " . $this->html("montant") . " €, pour l'annonce " . $annonce->html("titre");
        $destMail = "ivas@mywebecom.ovh";
        $destNom = $this->getValLiee("createur", "annonce")->html("pseudo");

        // Préparation du mail
        $messageComplet = "Bonjour $destNom, 
        $message";

        // entetes :
        $entetes = [];      // tableau vide pour les entetes

        // FROM
        $entetes["From"] = '"Annonces isma" <mywebecom@mywebecom.ovh>';       // L'adresse mail avec le @ doit être celle du serveur, ou du système de messagerie utilisé

        // REPLY TO : destinataire des réponses
        $entetes["Reply-To"] = '';

        // Mail HTML :
        // entete spécifiques
        $entetes["MIME-version"] = "1.0";
        $entetes["Content-Type"] = "text/html; charset=utf8";

        $messageHTML = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        </head>
        <body>
            <p>Bonjour ' . $destNom . ', </p>
            <p>' . nl2br(htmlentities($message)) . '</p>
            <p>' . $mail . '</p>
        </body>
        </html>
        ';

        // Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
        $destinataire = '"' . $destNom . '" ' . "<$destMail>";

        mail($destinataire, $sujet, $messageHTML, $entetes);
    }
}
