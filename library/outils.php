<?php

    function reqSelect($sql, $param=[]){
        //role : preparer et executer une requete sql 
        //parametre: $sql, $param
        //retour : tableau 
        global $bdd;
        $req = $bdd -> prepare($sql);

        if($req == false){
            return  "probleme $sql ";
        }
       //var_dump($sql);
       //print_r($param);
       
        if($req -> execute($param) == false){
            return "probleme sql";
        }
        

        $tab = $req->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($tab);
        return $tab;
    }

    function reqUpdateDelete($sql, $param){
    //role : prepare et execute une requete sql d'update ou delete
    //parametre : 
                //$sql : la requete
                //$param : les parametres de la requête
    ///retour : néant

        global $bdd;
        $req = $bdd -> prepare($sql);
        //var_dump($req);
        if($req == false){
            return  false;
        }
        //var_dump($param);
        if($req -> execute($param) == false){
            return false;
        }
        return true;
    }

    function reqInsert($sql, $param){
        //role : prepare et execute une requête insert dans la table de la bdd
        //paramêtre :
                   // : $sql 
                   // : $param

        //retour : lastinsertid = id de la ligne qui vient d'être créer
        global $bdd;
        $req = $bdd -> prepare($sql);

        if($req == false){
            return  "probleme $sql ";
        }
            //var_dump($sql);
           // var_dump($param);
        if($req -> execute($param) == false){
            return "probleme sql";
        }

        return $bdd->lastInsertId();
        
    }


    function listeAnnonce($listeAnnonce){
        //role: mettre en form une liste d'annonce
        //paramètre: $listAnnonce, tab objet d'annonce
        //return néant

        foreach($listeAnnonce as $annonce){

            include "template/fragment/ligne_liste_annonce.php";
        }
    }

    function offresToAnnonce($listeOffre){
        //role: recupérer une liste d'annonnce a partir d'une liste d'offre
        //parametre: liste d'offre
        //retour: liste d'objet annonce
        
            foreach($listeOffre as $objOffre){
            
                include "template/fragment/mon_offe.php";
            }

            
    }

    function listeOffre($listeOffre){
        //role: recuperer une liste d'offre a afficher
        //paramètre: $listeOffre
        //retour: néant

        foreach($listeOffre as $offre){
            
            include "template/fragment/ligne_liste_offre.php";
        }
    }

    function autoload1($classe){

        $fichier = "data/data_$classe.php";
        if(file_exists($fichier)){
            include $fichier;
        }
    }
    //injecter la fonction dans le loader
    spl_autoload_register("autoload1");

    function verifConnexion(){
        // role verifier que la session n'est pas vide
        //paramêtre : néant
        //retour : néant

        if( empty($_SESSION["id"])){

            return false;

        }else{
            
            $util = new utilisateur;
            $util->loadById($_SESSION["id"]);

            if($util->get("code_unique") != "confirme"){
                echo "veuillez confirmer votre adresse mail";
                return false;
            }else{
                return true;
            }
            
        }
    
    }

    function listeOffreUtil($listeOffre){
        //role: creer la liste des offre de l'utilisateur courant
        //paramêtre : liste d'offre
        //retour : liste d'objet offre

        
        $listeOffreUtil = [];

        foreach($listeOffre as $offre){
            
            if($offre->html("utilisateur") == $_SESSION["id"]){
                
                $listeOffreUtil[] = $offre; 
            }
        }
        return $listeOffreUtil;
    }

    function listeMesOffreAnnonce($listeOffreUtil){
        //role: afficher les offre enrengistré par l'utilisateur courant pour une annnonce
        //parametre: la liste des offre pour cette annonce , creer par l'utilisateur courant
        //retour : néant

        foreach($listeOffreUtil as $monOffre){
            
            include "template/fragment/ligne_liste_mes_offre_annonce.php";
        }
    }