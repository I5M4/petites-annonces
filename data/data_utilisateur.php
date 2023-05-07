<?php

class utilisateur extends _model {

    protected $champs = ["pseudo", "email", "mdp", "code_unique"];
    protected $table = "utilisateur";
    protected $valeur = [];
    protected $typeChamp = ["pseudo"=>"texte", "email"=>"texte", "mdp"=>"texte", "code_unique"=>"texte"];
    protected $affichageChamp = [];
    protected $nomComplet = [];
    protected $lien = [];
    protected $objet =[];

    protected $id = "";


   function envoieMailCreation($id){
    //role: envoyer un mail pour confirmer le mail de l'utilisateur créé
    //paramêtre: id, l'id de l'utilisateur qu'on vient d'entré dans la bdd

        $sujet = "confirmez votre adresse mail";
        $message = "Pour confirmer votre inscription";
        $destMail = "ivas@mywebecom.ovh";
        $destNom = $this->html("pseudo");
        $lien = "http://annonces.ivas.mywebecom.ovh/routeur.php?code=".$this->get('code_unique')."&action=confirm_mail_util&class=utilisateur&id=".$id;
        var_dump($lien);
        // Préparation du mail
        $messageComplet = "Bonjour $destNom, 
        $message
        ";

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
            <p>Bonjour '.$destNom.', </p>
            <p>' . nl2br(htmlentities($message)) . '</p>
            <a href='.$lien.'>cliquez ici</a>
        </body>
        </html>
        ';





        // Destinataire : "nom visible" <adresse>, "nom visible 2" <adresse2>
        $destinataire = '"' . $destNom . '" ' . "<$destMail>";

        mail($destinataire, $sujet, $messageHTML, $entetes);
   }
}