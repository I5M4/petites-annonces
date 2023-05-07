<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="routeur.php?action=creer_utilisateur&class=utilisateur" method="post">

        <label for="pseudo">Pseudo  
            <input type="text" name="pseudo" required>
        </label>
        <label for="email">Email
            <input type="email" name="email" required>
        </label>
    
        <label for="mdp">Mot de passe
            <input type="password" name="mdp" required>
        </label>
        <label for="">Confirmer le mot de passe 
            <input type="password" name="confirm-mdp" required>
        </label>
        
            <input type="submit" value="Créer le compte">
    </form>
    
</body>
</html>