<?php session_start();
if (!isset($_SESSION['access'])) {
	header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="include/formulaire.css">
    <title>Formulaire de connexion</title>
	<link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
</head>
<?php include("./include/header.php");?>

<body>

    <div class="box">
      
        <form class="form" method="POST" action="TraitConnexion.php">  
        
            <h2>Veuillez vous <p>connecter </p> </h2>
            <div class="inputBox">
                <input type="text" name="login" required
				<?php
					if(isset($_COOKIE['cookIdent'])){
						echo "value='".$_COOKIE['cookIdent']."'";
					}
				?>
				>
                <span>Adresse e-mail</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="password" required>
                <span>Mot de passe</span>
                <i></i>
            </div>
             
	          	<div class = "cookie">
		              Se souvenir de moi  <input type = "checkbox" name = "cookie">	
	          	</div>
	          	
                              
            <div class="link">
                <a href="formulaireInscription.php"> Vous n'avez pas de compte ? Inscrivez-vous.</a>
            </div>
            <input type="submit" value="Se connecter" name="connexion">
            
        </form>
    </div>

</body>
<?php include("./include/footer3.php");?>
</html>