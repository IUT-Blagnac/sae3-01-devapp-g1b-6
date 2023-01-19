<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="include/detailCommande.css">
    <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
    
    <title>D&eacutetail</title>
    <?php include("./include/header.php");
    ?>
</head>

<body style = "margin:0">

<div class = "produit">
		<div class = "container">
		
<?php
require_once("connect.inc.php"); 

$detailCommande = $_GET['idcommande'];

$idClient = $_SESSION['idclient'];


//--- Test pour vérifier que le client n'accède pas au détail de commande d'une commande qui n'est pas la sienne ! ------/
$req = "SELECT * FROM COMMANDE WHERE IDCLIENT = :pID_CLIENT";

$req2 = oci_parse($connect, $req);

oci_bind_by_name($req2, ":pID_CLIENT", $idClient);

oci_execute($req2);

$test = 0;

while (($furet = oci_fetch_assoc($req2)) != false) {
	if($furet['IDCOMMANDE'] == $detailCommande){
	$test = $test + 1;
	}
}

if ($test == 0){
	echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Sacrebleu, ce n\'est pas votre commande !"); 
					location.href = "consultCommandes.php";
				</script>';
}

//--------on affiche le détail de la commande en question ----------------//

$reqDetail = "SELECT * FROM DETAILCOMMANDE WHERE IDCOMMANDE = :pID_COMMANDE";

$detail = oci_parse($connect, $reqDetail);

oci_bind_by_name($detail, ":pID_COMMANDE", $detailCommande);

oci_execute($detail);

while (($article = oci_fetch_assoc($detail)) != false) { 

	$idArticleEnfin = $article['IDARTICLE'];
	
	$reqAll = "SELECT * FROM ARTICLE WHERE IDARTICLE = '".$idArticleEnfin."'";
	
	$all = oci_parse($connect, $reqAll);
	
	//oci_bind_by_name($connect, ":pID_ARTICLE", $idArticleEnfin);
	
	oci_execute($all);
	
	$article2 = oci_fetch_assoc($all);
		
	$prix = $article2['PRIXARTICLE'];
	
	$prixTotal = $prix * $article['NBARTICLE'];

	echo '<div class="card"> 
                <div class="title"> Article num&eacutero '.$article['IDARTICLE'].'</div>
			
				<div class="image">
					<img src="./images/'.$article2['NOMARTICLE'].'.png" alt="image de l\'article">
                </div>
				
			         
                <div class="prix" style="font-weight: 500;font-size: 20px;margin-bottom: 15px;">Prix unitaire : '.$prix.' € 
				</div>
				
				<div class = "nombre" style="font-weight: 500;font-size: 20px;margin-bottom: 15px;" > Nombre de fois commandé : '.$article['NBARTICLE'].' </div>
                 <div class="prixTotal" style="font-weight: 500;font-size: 20px;margin-bottom: 15px;"> Prix total : '.$prixTotal.' € </div>
                
                  
            </div>';

}


?>

</div>
			<button id ="retour"><a href="consultCommandes.php">Retour à vos commandes</a>
	</div>
	

</body>
<?php include("./include/footer2.php");?>


</html>