<?php
	session_start();
	if($_SESSION['access']!='OK'){
		header('location: formulaireConnexion.php');
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Compte client</title>
        <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
        <link rel="stylesheet" href="include/compteClient.css">
    </head>
	<?php include("./include/header.php");?>
	<body>
		<?php
			require_once("connect.inc.php");
			error_reporting(0);
			$req3 = "SELECT * FROM Client WHERE emailclient = :pEmail";
			$compte = oci_parse($connect , $req3);
			$email = $_SESSION['mailclient'];
			oci_bind_by_name($compte, ":pEmail", $email);
			$result = oci_execute($compte);
			$info = oci_fetch_assoc($compte);
			echo '<content>
					<label id="titre">VOS INFORMATIONS</label>
					<label class="info"><strong>Nom :</strong> '.$info['NOMCLIENT'].'</label>
					<label class="info"><strong>Prénom :</strong> '.$info['PRENOMCLIENT'].'</label>
					<label class="info"><strong>Tél :</strong> '.$info['TELCLIENT'].'</label>
					<label class="info"><strong>Email :</strong> '.$info['EMAILCLIENT'].'</label>
					<a id="lien" href="formulaireModif.php?pmail='.$info['EMAILCLIENT'].'"><button id="bouton">Modifier</button></a>
					
					 <a id ="lien" onclick = "return confirm(\'Voulez-vous vraiment supprimer votre compte ?\')" 
						href="SupprCompte.php"> <button id="bouton2">Supprimer</button> </a>
						
				  </content>';
				  
				 
		?>
		
	</body>
	<?php include("./include/footer.php");?>
</html>
