<?php

class creer_utilisateur extends _action
{

    function execute($class)
    {

        $util = new $class;

        $tri = ["pseudo" => ["", "LIKE", $_POST["pseudo"]]];
        $samePseudo = $util->getAll($tri);

        if (!empty($samePseudo)) {

            echo "pseudo deja utilisé";
            return false;
        } else {

            if ($_POST["mdp"] != $_POST["confirm-mdp"]) {

                echo "les mot de passe ne correspondent pas";
                return false;
            }

            $util->loadByArray($_POST);
            $code = uniqid("", true);
            $util->set("code_unique", $code);
            $hash = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
            $util->set("mdp", $hash);
            $id = $util->insert();


            $util->envoieMailCreation($id);
            $_SESSION["id"] = $id;
            include "template/fragment/message_envoie_mail_confirm.php";
            // header("location: routeur.php");
        }
    }
}
