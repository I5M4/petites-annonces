<?php

class confirm_mail_util extends _action
{

    function execute($objet)
    {

        $code = $_GET["code"];
        $id = $_GET["id"];

        $util = new $objet;
        $util->loadById($id);

        if ($util->get("code_unique") == $code) {

            $util->set("code_unique", "confirme");
            $util->update();
            $_SESSION["id"] = $util->id();
            include "template/fragment/confirm_creation_compte.php";
        } else {

            return false;
        }
    }
}
