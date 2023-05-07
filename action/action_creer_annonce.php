<?php


class creer_annonce extends _action{

    function execute($class){

        if( verifConnexion()){
        
            $annonce = new $class;
        
            $_FILES["img"]["tmp_name"];
            move_uploaded_file($_FILES["img"]["tmp_name"], "img_uploaded/".$_FILES["img"]["name"]);
            $annonce ->set("img", htmlentities("img_uploaded/".$_FILES["img"]["name"]));
        
            $annonce->loadByArray($_POST);
            $annonce->insert();
            
            
        }
        header("location:routeur.php");
    }
}