<?php

class connecter_utilisateur extends _action{

    function execute($class){

        $util = new $class;
        $recupUtil = $util->getAll(["pseudo"=>["","LIKE", $_POST["pseudo"]]]);

        if(empty($recupUtil)){
            echo "pseudo inconnue de la bdd";
            return false;
        }
        if (password_verify($recupUtil[0]->get("mdp"), $_POST["mdp"])){
            
            echo "le mot de passe est incorrecte";
            return false;
        }
        
        $_SESSION["id"] = $recupUtil[0]->id();
        header("location:routeur.php");
    }
}