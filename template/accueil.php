<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <?= isset($_SESSION["id"]) ? "<button class='mes-annonces'>Mes annonces</button>" : "" ?><?= isset($_SESSION["id"]) ? "<button class='mes-offres'>Mes offres</button>" : ""  ?>
        <?php empty($_SESSION["id"]) ? include "template/fragment/btn_creat_connect.php" : include "template/fragment/btn_deconnexion.php" ?>
    </div>

    <?php include "template/fragment/form_filtrage.php" ?>

    <div class="listeAnnonces">
        <?php include "template/fragment/liste_annonce.php"; ?>
    </div>

    <?= isset($_SESSION["id"]) ? '<a href="routeur.php?action=afficher_form_creat_annonce&class=annonce"><button>Créer une annonce</button></a>' : ""; ?>

    <script src="js/fonction.js"></script>
    <script src="js/jquery.js"></script>
</body>

</html>