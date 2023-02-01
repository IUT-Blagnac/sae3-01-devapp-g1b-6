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
	<title>Vos commandes</title>
	<link rel="stylesheet" href="./include/consultCommandes.css">
</head>
<?php include("./include/header.php"); ?>

<body style = "margin:0">
   

<div class = "produit">
<?php 

	$idclient = $_SESSION['idclient'];
	
	$req = "SELECT * FROM COMMANDE WHERE IDCLIENT = :pID_CLIENT ORDER BY IDCOMMANDE ASC";
    
    $lesCommandes = oci_parse($connect, $req);
	
	oci_bind_by_name($lesCommandes, ":pID_CLIENT", $idclient);

	oci_execute($lesCommandes);
	
	oci_fetch_all($lesCommandes, $res);
		
	//si pas de commandes
	if (empty($res['IDCOMMANDE'])) {
		echo '<div class ="paniervide"> Vous n\'avez aucune commandes !<br>
              <button id = "vide"><a href = "Produit.php?recherche=Tous nos produits">D&eacutecouvrez nos produits !</a></button></div>';
    }
	
	else {
	
		echo'<div class = "container">'; 
		
		//while (($commande = oci_fetch_assoc($lesCommandes)) != false) { 
		for($i = 0; $i < count($res['IDCOMMANDE']); $i++){
		
			$reqNbArticle = "SELECT SUM(NBARTICLE) AS NOMBRE FROM DETAILCOMMANDE WHERE IDCOMMANDE = :pID_COMMANDE ";
		
			$nbArticle = oci_parse($connect, $reqNbArticle);
		
			oci_bind_by_name($nbArticle, ":pID_COMMANDE", $res['IDCOMMANDE'][$i]);

			oci_execute($nbArticle);
	
			$nbArticleTotal = oci_fetch_assoc($nbArticle);
		
			$nb = $nbArticleTotal['NOMBRE'];
		
			echo '<div class="card"> 
		<div class="title"> Commande num&eacutero '.$res['IDCOMMANDE'][$i].'</div>';
					if ($res['IDCOMMANDE'][$i]%2 == 0) {
						echo'
					<div class="image">
						<img src="./images/leo.jpg" alt="image satanique">
					</div>';
					}else{
						echo'<div class="image">
						<img src="./images/v.jpg" alt="image satanique">
					</div>';
					}
				
					echo'
                            
					<div class="prix" style="font-weight: 500;font-size: 20px;margin-bottom: 15px;">Prix de la commande : '.$res['PRIXTOTAL'][$i].' € 
					</div>
				
					<div class = "nombre" style="font-weight: 500;font-size: 20px;margin-bottom: 15px;" > Nombre d\'articles : '.$nb.' </div>
                                
					<div class="boutons">
						<button id = "detail"><a href="detailCommande.php?idcommande='.$res['IDCOMMANDE'][$i].'">Voir le détail</a></button>
					</div>
                  
				</div>';
		}
	}


?>

		</div>
	</div>

</body>
<?php include("./include/footer2.php");?>

</html>