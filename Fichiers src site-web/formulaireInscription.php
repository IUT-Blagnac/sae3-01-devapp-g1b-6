<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="include/formulaire2.css">
    <title>Formulaire d'inscription</title>
	<link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
</head>
<?php include("./include/header.php");?>
<body>

    <div class="box">
    
        <form class="form" method="POST" action="TraitInscription.php">   
        
            <h2>S'inscrire</h2>
            <div class="inputBox">
                <input type="text" name="nom" required>
                <span>Nom </span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="prenom" required>
                <span>Prénom</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="email" required>
                <span>Adresse mail</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="telephone" required>
                <span>Téléphone</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="motdepasse" required>
                <span>Mot de passe</span>
                <i></i>
            </div>
           
            <input name="valider" type="submit" value="Créez votre compte">
        </form>
    </div>

</body>
<?php include("./include/footer.php");?>
</html>