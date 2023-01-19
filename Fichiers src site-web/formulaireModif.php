<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="include/formulaire3.css">
    <title>Modification compte</title>
	<link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
</head>
<?php include("./include/header.php");?>
<body>
	<?php
		
		require_once("connect.inc.php");
		error_reporting(0);
		
		if (htmlentities($_GET['pmail']) != $_SESSION['mailclient']) {
			echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Filou, ce n\'est pas votre compte !"); 
					location.href = "index.php";
				</script>';
		}


		$req3 = "SELECT * FROM Client WHERE emailclient = :pEmail";
		$compte = oci_parse($connect , $req3);
		$email = $_GET['pmail'];
		oci_bind_by_name($compte, ":pEmail", $email);
		$result = oci_execute($compte);
		$info = oci_fetch_assoc($compte);
	
	
	
	echo '
		<div class="box">
		
			<form class="form" method="POST" action="TraitModif.php?email='.$info['EMAILCLIENT'].'">   
			
				<h2>Modification</h2>
				<div class="inputBox">
					<input type="text" name="nom" value="'.$info['NOMCLIENT'].'" required>
					<span>Nom </span>
					<i></i>
				</div>
				<div class="inputBox">
					<input type="text" name="prenom" value="'.$info['PRENOMCLIENT'].'" required>
					<span>Prénom</span>
					<i></i>
				</div>
				<div class="inputBox">
					<input type="text" name="email" value="'.$info['EMAILCLIENT'].'" required>
					<span>Adresse mail</span>
					<i></i>
				</div>
				<div class="inputBox">
					<input type="text" name="telephone" value="'.$info['TELCLIENT'].'" required>
					<span>Téléphone</span>
					<i></i>
				</div>
				<div class="inputBox">
					<input type="password" name="motdepasse" required>
					<span>Mot de passe</span>
					<i></i>
				</div>
			   
				<input name="valider" type="submit" value="Valider">
			</form>
		</div> ';
	?>
</body>
<?php include("./include/footer3.php");?>
</html>