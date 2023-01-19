<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
	<title>Commander</title>
	<link rel="stylesheet" href="./include/commande.css">
</head>
<?php include("./include/header.php"); 
require_once("connect.inc.php"); ?>


<body>


    <?php echo'
     <form method="POST" action="TraitCommande.php">
      <h2>Vos informations de paiement : </h2>
            <div class="inputBox">
                <input type="text" name="nom" placeholder = "Nom" required>
                
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="prenom" placeholder = "Prénom" required>
               
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="carte" placeholder = "Numéro de carte" maxlength="16" required>
                
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="date" placeholder = "Date d\'expiration (MM/AA)" maxlength="5" required>
                
                <i></i>
            </div>
            <div class="inputBox">
                <input type="text" name="ccv" placeholder = "CCV" maxlength="3" required>
                
                <i></i>
            </div>
           
            <input name="valider" type="submit" value="Valider">
            <button><a href="Panier.php?idclient='.$_SESSION['idclient'].'">Retour au panier</a></button>
        
    </form>';?>
	<div class = "infos">
	<div class = "text"><em><strong>Informations : </strong></em></div>
	<p><strong>- Le nom & prénom</strong> renseignés doivent <br>être identiques à ceux de votre compte.<br><br>
	<strong>- Le numéro de carte</strong> ne doit pas contenir <br>d'espaces.<br><br>
	<strong>- La date d'expiration </strong>est du format 'MM/AA', <br>pensez à renseigner le '/'.<br></p>
	</div>
    

</body>
<?php include("./include/footer.php");?>

</html>