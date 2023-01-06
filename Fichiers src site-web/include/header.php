<link rel="stylesheet" href="include/header.css">
<header>
	<logo>
		<a href="index.php"><img src="include/logo.png" alt="Image logo" id="logo"></a>
   
	</logo>
 
	<bouton>
		<a href="compteClient.php" ><button type="button" class="bouton" id="bouton1">Compte client</button></a>
		<a href="contacts.php"><button type="button" class="bouton" id="bouton1">Contact</button></a>
		<a href="panier.php"><button type="button" class="bouton"><img src="include/caddie.png" width="30px" height="30px"></button></a>
		<?php
			if (!isset($_SESSION['access'])){
				session_start();
			}
			if ($_SESSION['access']!='OK'){
				echo '<a href="formulaireConnexion.php"><button type="button" class="bouton" id="bouton1">Connexion</button></a>';
			}else {
				echo '<a href="Deconnexion.php"><button type="button" class="bouton" id="bouton1">D&eacuteconnexion</button></a>';
			}
		?>
	</bouton>
</header>