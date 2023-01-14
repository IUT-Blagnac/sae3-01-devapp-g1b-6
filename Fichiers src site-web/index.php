<?php
	session_start();
	if (!isset($_SESSION['access'])){
		$_SESSION['access']='NOT OK';
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>SubOne Accueil</title>
        <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
        <link rel="stylesheet" href="include/index.css">
		<script src="piege.js"></script>
    </head>
	<?php include("./include/header.php");?>
    <body>
    
    <?php
      if ($_SESSION['access']=='OK'){
        
	      echo '<div class ="bonjour"> Bonjour, '. $_SESSION['prenom']. ' ! </div>';
      }
      
    ?>
   
  
		<div id="divtitre">
			<label1>
				<label class="text">SUBONE</label><br>
				<label class="text">VIVEZ L'OCEAN</label>
			</label1>
			<bouton2>
				<a href="Produit.php?recherche=Tous nos produits" id="boutonProd"><button type="button" class="bouton2" id="bouton2">Nos produits </button></a>
			</bouton2>
		</div>
		
    </body>
	<?php include("./include/footer.php");?>
</html>
