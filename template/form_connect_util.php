<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="routeur.php?action=connecter_utilisateur&class=utilisateur" method="post">

        <label for="">Pseudo
            <input type="text" name="pseudo" required>
        </label>
        <label for="">Mot de passe
            <input type="password" name="mdp" required>
        </label>
        <input type="submit" value="Se connecter">
        
    </form>
    
</body>
</html>