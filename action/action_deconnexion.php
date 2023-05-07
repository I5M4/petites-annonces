<?php

class deconnexion extends _action {

    
    
    function execute($class){
    
        $_SESSION["id"] = NULL;

       header("location:routeur.php");
    }
}

