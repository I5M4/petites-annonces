<?php

class _model
{

    protected $champs = [];
    protected $table = "";
    protected $valeur = [];
    protected $typeChamp = [];
    protected $affichageChamp = [];
    protected $nomComplet = [];
    protected $valCategorie = [];
    protected $lien = [];
    protected $objet = [];

    protected $id = "";




    ////////////////////// GETER


    function get($champ)
    {
        //role: recupérer la valeur a l'attribut visé
        //parametre: $attribut, l'attribut dont on veut la valeur
        //retour: si le type de champ est un texte ou un nombre, retourne la valeur du champ,
        //                : si le type de champ est un lien return l'objet
        //                : si le type de champ est une date return une date

        if (in_array($champ, $this->champs)) {


            if ($this->typeChamp[$champ] == "texte" or $this->typeChamp[$champ] == "nombre" or $this->typeChamp[$champ] == "categorie") {

                if (isset($this->valeur[$champ])) {

                    return $this->valeur[$champ];
                }
            } else if ($this->typeChamp[$champ] == "date") {

                if (isset($this->valeur[$champ])) {

                    return date($this->valeur[$champ]);
                }
            } else if ($this->typeChamp[$champ] == "lien") {


                if (in_array($this->lien[$champ], $this->objet)) {

                    return  $this->objet[$champ];
                } else {

                    $objet = new $this->lien[$champ];
                    $objet->loadById($this->valeur[$champ]);
                    $this->objet[$champ] = $objet;
                    return $this->objet[$champ];
                }
            }
        }
    }


    function getChampLiee($champ)
    {
        // rôle: retourn la valeur d'un champ qui appartient à un objet liée (sur un ou plusieurs niveaux) a celui qu'on traite
        //parametre:
        //          : $champ, le champs que l'on recherche
        $tabClass = $this->searchChamp($champ);
        $class = key($tabClass);
        $objet = new $class;

        if (empty($objet->get($champ))) {


            $objet = $this->searchLienTable($class);
        }

        return $objet->get($champ);
    }


    function html($nomChamp)
    {
        //Role: récupérer le contenu du champ en format html (pour les liens, c'est l'id)
        //retour : texte formaté html
        // paramêtre : $nomchamp

        if (!empty($this->valeur[$nomChamp])) {

            if ($this->typeChamp[$nomChamp] == "categorie") {

                return nl2br(htmlentities($this->valCategorie[$nomChamp][$this->get("$nomChamp")]));
            } else if ($this->typeChamp[$nomChamp] == "date") {

                return nl2br(htmlentities(date($this->valeur[$nomChamp])));
            } else {

                return nl2br(htmlentities($this->valeur[$nomChamp]));
                //var_dump($this->valeur[$nomChamp]);
            }
        } else {

            return "";
        }
    }


    function getNomComplet()
    {
        //rôle : affiche un nombre minimum de valeur en lien avec l'objet pour l'html
        //parametre : néant
        //return : chaine de caractères
        $nomComplet = [];

        foreach ($this->nomComplet as $champ) {

            if (gettype($this->get($champ)) == "object") {

                $nomComplet[] = $this->get($champ)->getNomComplet();
            } else {

                $nomComplet[] = $this->get($champ);
            }
        }

        return implode("  ", $nomComplet);
    }


    function id()
    {
        return $this->id;
    }


    function Lien()
    {
        //role : retour le tableau de lien de l'objet
        //parmetre : néant
        //retout $tabLien
        return $this->lien;
    }

    function table()
    {
        return $this->table;
    }


    function champs()
    {
        // rôle: return le tableau des champs de cet objet
        return $this->champs;
    }


    ///////////////////////  SETER


    function set($champ, $val)
    {
        //role : attribuer la valeur au champ visé
        //paramêtre : $attribut, l'attribut visé
        //          : $val, la valeur que l'on veut attribuer à cet attribut
        //retour : true si ok , false sinon

        if (in_array($champ, $this->champs)) {

            $this->valeur[$champ] = $val;
            return true;
        }
    }
    /*
            bout de code que je garde sous le coude

    else if(!empty($this->searchChamp($champ))) {

            $tabClass =  $this->searchChamp($champ);
            $class = $tabClass[0];
            $objet = new $class;
            $id = $this->valeur[$class];
            $objet->set($champ, $val, $id);
            
        }
    */

    function loadByArray($tab)
    {
        //role: charger un objet depuis un tableau
        //parametre : $tab, le tableau avec lequel on veut charger l'objet
        //retour : néant

        foreach ($tab as $index => $val) {

            if (in_array($index, $this->champs)) {

                $this->set($index, $val);
            }
            if ($index == "id") {

                $this->id = $val;
            }
        }
    }


    //////////////////////// FONCTIONS LIEE A LA BDD


    function loadById($id)
    {
        //role : charger un objet depuis la bdd 
        //parametre : 
        // $id : celui de la ligne visé dans la bdd
        //retour: néant

        //on prepare la requête sql
        $champs = $this->champsToSelectSql();
        $sql = "SELECT `id` , $champs FROM `$this->table` WHERE `id`= :id";
        $param = ["id" => $id];
        //var_dump($sql);
        // var_dump($param);
        // on prepare/execute la req
        $tab = reqSelect($sql, $param);

        if (empty($tab)) {

            return false;
        }
        //on charge d'ans l'objet
        $this->loadByArray($tab[0]);

        return true;
    }


    function getAll($tri = [])
    {
        //role : recupérer toutes les lignes (avec ou sans filtre ) 
        //param: (optionnel):
        //     :    (optionnel) : $tri , tableau de type ["id" => $_GET["id"]]
        //      :    (optionnel) : $condition, un tableau avec les conditions de tri   ("LIKE", "=" ...)   
        //retour: $tab, tableau d'objet 
        $champ = $this->champsToSelectSql();
        $joinTable = $this->makeTablesJoin();

        if (!empty($this->selectJoinTable())) {
            $joinChamp = "," . $this->selectJoinTable();
        } else {
            $joinChamp = "";
        }


        $sql = "SELECT `$this->table`.`id`, $champ $joinChamp FROM `$this->table` $joinTable ";

        if (!empty($tri)) {

            $reqCondition = $this->tabtoTriSql($tri);
            $param = $this->tabToParam($tri);
            $sql .= "WHERE" . $reqCondition;
            $tab = reqSelect($sql, $param);
            //var_dump($sql);
            //print_r($param);

        } else {

            $tab = reqSelect($sql);
        }

        $tabObj = $this->tabToTabObj($tab);

        return $tabObj;
    }



    function update()
    {

        //rôle : met a joue la table de la bdd avec les données de l'objet courant
        //paramêtre: néant
        //retour: true si la requête a été exécuté , flase sinon

        $champs = $this->champsToUpdate();
        $sql = "UPDATE `$this->table` SET $champs WHERE `id` = :id  ";
        $param = $this->makeParamUpdate();
        $reponse = reqUpdateDelete($sql, $param);
        return $reponse;
    }


    function insert()
    {
        //role : insérer une ligne dans la bdd
        //param: $sql, la requete sql "insert
        //     : $param , les parametres de la requête sql
        //retour : $id de la ligne insérer
        $champs = $this->champsToUpdate();
        $param = $this->makeParamUpdate();

        $sql = "INSERT INTO `$this->table` SET $champs";

        $id = reqInsert($sql, $param);

        return $id;
    }

    function delete()
    {
        //role : supprimer une la ligne de la table correspond a l'ide de l'objet
        //parametre : néant
        //retour: néant

        $sql = "DELETE FROM `$this->table` WHERE `id` = :id";
        $param = [":id" => $this->id()];

        reqUpdateDelete($sql, $param);
    }




    //////////////// OUTILS DIVERS


    function getValLiee($champ, $lien)
    {
        //role : retourn la valeur du champ $champ dans un objet lie donné
        //paramêtre: 
        //          :$champ, le champ demander
        //           :$lien, le cahmp du lien dont on cherche la valeur
        //retour: la valeur du champ de l'objet liée

        $objet = $this->get($lien);

        return $objet->get($champ);
    }



    function searchChamp($champ, $tab = [])
    {

        //role : determiner si un champ existe dans les differents objets lié
        //parametre : $champ , le champ a vérifier
        //retour: tableau indéxer avec la class dans lequel se trouve se champ si il est trouvé, sinon tableau vide

        $resultat = $tab;

        if (in_array($champ, $this->champs)) {

            $class = get_class($this);
            $resultat[$class] = $champ;
        }
        foreach ($this->lien as $key => $class) {

            $objet = new $class;

            if (in_array($champ, $objet->champs())) {

                $resultat[$class] = $champ;
            } else {

                $resultat = $objet->searchChamp($champ, $resultat);
            }
        }

        return $resultat;
    }

    function searchLienTable($class)
    {
        //role : retourne la valeur du champ par lequel il est lié, (donc son id aussi)
        //param : $class : la table dont on veut connaitre la table liée (a sa gauche)
        //retour: la valeur du champ par lequel il est lié, (donc son id aussi)

        if (in_array($class, $this->lien)) {

            return $this->get($class);
        } else {

            foreach ($this->lien as $lien) {

                $objet = new $lien;
                $objet->loadById($this->valeur[$lien]);

                if (in_array($class, $objet->lien)) {

                    return  $objet->get($class);
                } else {

                    $objet->searchLienTable($lien);
                }
            }
        }
    }


    function tabToTabObj($tab)
    {
        //role: convertir un tableau en tableau d'objet 
        //parametre: $tab
        //retour: $tabobj 

        $tabObj = [];

        foreach ($tab as $val) {

            $class = get_class($this);
            $objet = new $class;
            $objet->loadByArray($val);
            $tabObj[] = $objet;
        }

        return $tabObj;
    }


    function champsToSelectSql()
    {
        // role: preparer les champ de l'objet pour la requete sql
        //parametre: néant
        //retour : chaine de caratére
        $resultat = [];

        foreach ($this->champs as $index => $champ) {

            $resultat[] = "`$this->table`.`$champ`";
        }

        return implode(" , ", $resultat);
    }


    function selectJoinTable()
    {
        //role : preparer le bout de ligne select pour les table liée pour requete sql 
        //param: néant
        //retour : chaine de caractère
        $tab = [];

        if ($tab == null) {

            foreach ($this->lien as $class) {

                include_once("data/data_" . $class . ".php");

                $objet = new $class;

                foreach ($objet->champs as $champ) {

                    $tab[] = "`$class`.`$champ`";
                }
            }
        }

        $ligne = implode(" , ", $tab);
        return $ligne;
    }

    function makeTablesJoin()
    {
        //role : return la ligne "LEFT JOIN" pour les requête sql
        //param : néant
        //retour: $ligne, chaine de charactère, la lign LEFT JOIN pour la requête

        $tabLiens = [];
        $indextab = "";

        foreach ($this->lien as $id => $nomTable) {
            //si il y a deux lien vers la même table on garde que le premier
            //if(!$nomTable == $indextab){

            $indextab = $nomTable;
            $tabLiens[$nomTable] = "LEFT JOIN `$nomTable` ON `$this->table`.`$id` = `$nomTable`.id";
            //}
        }

        //var_dump($tabLiens);
        $ligne = implode(" ", $tabLiens);
        //var_dump($ligne);
        return $ligne;
    }


    function champsToUpdate()
    {
        //rôle : prépare la ligne des champs pour les requête sql update avec les parametre
        //parametre : néant
        //retour: chaine de ccharactère : la ligne des champs pour les requête sql update avec les parametre

        $tab = [];

        foreach ($this->champs as $champ) {

            $tab[] = "`$champ` = :$champ";
        }

        return implode(" , ", $tab);
    }


    function makeParamUpdate()
    {
        //rôle : prepare le tableau des parametre pour les requête sql
        //parametre : néant
        //retour: $tab , le tableau de parametres 

        $tab = [];

        foreach ($this->champs as $champ) {

            if ($this->typeChamp[$champ] == "categorie") {

                $tab[":$champ"] = $this->get($champ);
            } else {

                $tab[":$champ"] = $this->html($champ);
            }
        }
        if (!$this->id() == null or !empty($this->id)) {
            $tab[":id"] = $this->id();
        }

        return $tab;
    }


    function tabToParam($tab)
    {
        //Role :  creer des paramêtre depuis un tableau
        //paramêtre : 
        //          : $tab, le tableau 
        //retour : tableau de parametre sql
        $param = [];
        //var_dump($tab);
        foreach ($tab as $index => $donnee) {

            if ($donnee[2] != NULL) {

                if ($donnee[1] == "BETWEEN") {

                    $param[":" . $index . "Min"] = $donnee[2];
                    $param[":" . $index . "Max"] = $donnee[4];
                } else {

                    $param[":" . $index] = $donnee[2];
                }
            }
        }

        return $param;
    }


    function tabtoTriSql($tab)
    {
        //role : creer le bout de condition de requête sql (aprés le WHERE)
        //parametre : 
        //          : $tab, tableau de parametre
        //retour : bout de requête sql (depuis Where)
        $resultat = [];
        $i = 0;

        foreach ($tab as $index => $donnee) {
            //print_r($tab);
            if ($donnee[2] != NULL) {

                if ($donnee[0] == "OR") {
                    //var_dump($i);
                    $resultat[$i - 1] = "(" . $resultat[$i - 1];
                    $close = ")";
                } else {
                    $close = "";
                }
                if ($donnee[1] == "BETWEEN") {

                    if ($donnee[2] != "%%") {

                        $resultat[$i] = " " . $donnee[0] . " `$this->table`.`" . $index . "` " . $donnee[1] . " :" . $index . "Min " . $donnee[3] . " :" . $index . "Max ";
                    }
                } else if ($donnee[1] != "BETWEEN") {

                    //var_dump($donnee[2]);
                    $resultat[$i] = " " . $donnee[0] . "  `$this->table`.`" . $index . "` " . $donnee[1] . " :" . $index . $close;
                }

                $i += 1;
            }
        }
        //var_dump($resultat);
        return implode("", $resultat);
    }
}
