<link rel="stylesheet" href="include/header.css">
<header>
	<logo>
		<a href="index.php"><img src="include/logo.png" alt="Image logo" id="logo"></a>
   
	</logo>
<?php require_once('connect.inc.php');?>
	<bouton>

		<?php
   
   if (!isset($_SESSION['access'])){
				session_start();
				
			}
      
			if ($_SESSION['access']!='OK'){
				echo '<a href="formulaireConnexion.php"><button type="button" class="bouton" id="bouton1">Connexion</button></a>
        <a href="Panier.php"><button type="button" class="bouton"><img src="include/caddie.png" width="30px" height="30px"></button></a>';
			}else {
        
				echo '<a href="Deconnexion.php"><button type="button" class="bouton" id="bouton1">D&eacuteconnexion</button></a>
        <a href="Panier.php?idclient='.$_SESSION['idclient'].'"><button type="button" class="bouton"><img src="include/caddie.png" width="30px" height="30px"></button></a>';
			}
    	
    
    
    echo'
		<a href="compteClient.php"><button type="button" class="bouton" id="bouton1">Compte client</button></a>
		<a href="contacts.php"><button type="button" class="bouton" id="bouton1">Contact</button></a> ';
   
   
		?>
		
	</bouton>
</header>