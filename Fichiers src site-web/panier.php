<?php session_start();
if ($_SESSION['access'] != 'OK') {
	header('location: formulaireConnexion.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-890">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
	<title>Panier</title>
	<link rel="stylesheet" href="./include/panier.css">
</head>
<?php include("./include/header.php"); ?>

<body>
	<?php
	require_once('connect.inc.php');
	$req = "SELECT * FROM PANIER P, ARTICLE A, CLIENT C WHERE C.emailclient = :pemailclient AND P.idclient = C.idclient AND A.idarticle = P.idarticle";
	$article = oci_parse($connect, $req);
	$email = $_SESSION["mailclient"];
	oci_bind_by_name($article, ":pemailclient", $email);
	$result = oci_execute($article);
	echo ' 
	<section>  <table class = "panier">';
			 	
	while (($unArticle = oci_fetch_assoc($article)) != false) {

		echo '
			<tr>
				<th></th>
				<th>Nom</th>
				<th>Prix</th>
				<th>Quantité</th>
				<th>Action</th>
			</tr>
			<tr>
				<th><img src="./images/' . $unArticle['NOMARTICLE'] . '.png" alt="image du produit"></th>
				<th>' . $unArticle['NOMARTICLE'] . '</th>
				<th>' . $unArticle['PRIXARTICLE'] .' €'.'</th>
				<th>' . $unArticle['QTEARTICLE'] . '</th>
				<th class="img2"><img src="./images/poubelle.png" alt="image dune poubelle"></th>
			</tr>
					
				';
	}
	echo '</table> </section>';
	
	?>
</body>
<?php include("./include/footer2.php");?>

</html>