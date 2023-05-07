<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Nouvelle annonce</h1>

    <form action="routeur.php?action=creer_annonce&class=annonce" method="post" enctype="multipart/form-data">

        <label for="titre">Titre
            <input type="text" name="titre" required>
        </label>
        <label for="img">Image
            <input type="file" name="img" >
        </label>
        <label for="description">Description
            <input type="text" name="description" required>
        </label>
        <label for="prix">Pix Minimum
            <input type="number" name="prix">
        </label>
        <input type="hidden" name="createur" value="<?= $_SESSION["id"]?>">
        <input type="hidden" name="statut" value="1">
        <input type="hidden" name="date" value="<?=date("Y-m-d H:i:s")?>">
        <input type="submit" value="Créer l'annonce">
        
    </form>
    
</body>
</html>