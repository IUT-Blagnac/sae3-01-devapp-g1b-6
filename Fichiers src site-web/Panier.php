<?php session_start();
if ($_SESSION['access'] != 'OK') {
	header('location: formulaireConnexion.php');
}

if (htmlentities($_GET['idclient']) != $_SESSION['idclient']) {
	echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Filou, ce n\'est pas votre panier !"); 
					location.href = "index.php";
				</script>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-890">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
	<title>Votre panier</title>
	<link rel="stylesheet" href="./include/Panier.css">
</head>
<?php include("./include/header.php"); ?>

<body>
	
 <?php
 
 
 $detailpanier = "SELECT * FROM DETAILPANIER WHERE IDPANIER = '".$_GET['idclient']."'";
 
 $lepanier = oci_parse($connect, $detailpanier);
 
 oci_execute($lepanier);
 
 $totalPanier = 0;
 
 while (($panierprixtotal = oci_fetch_assoc($lepanier)) != false) {
	 
	 $totalPanier = $totalPanier + ($panierprixtotal['NBARTICLE'] * $panierprixtotal['PRIXQTEARTICLE']);
 }
 
 
//modifier le prix du panier dans la table panier

$reqmodifprixpanier = "UPDATE PANIER SET PRIXPANIER = :pPRIX_PANIER WHERE IDPANIER = '".$_GET['idclient']."'";
 
$modifprixpanier = oci_parse($connect, $reqmodifprixpanier);

oci_bind_by_name($modifprixpanier, ":pPRIX_PANIER", $totalPanier);

oci_execute($modifprixpanier);

  //commit
  oci_commit($connect);
 
 
 //------------------------------------//
 
 
 $req = "SELECT A.NOMARTICLE AS NOM, A.IDARTICLE AS ID, C.NOMCATEGORIE AS NOMCAT, D.NBARTICLE AS QTE, 
 P.PRIXPANIER AS PRIX FROM DETAILPANIER D, PANIER P , ARTICLE A, CATEGORIE C WHERE P.IDCLIENT = '".$_GET['idclient']."' 
 AND P.IDPANIER = D.IDPANIER AND D.IDARTICLE = A.IDARTICLE";
    
    $panier = oci_parse($connect, $req);

 
    // exécution de la requête
    oci_execute($panier);   
    
    
    $req2 = "SELECT A.NOMARTICLE AS NOM, A.IDARTICLE AS ID, D.NBARTICLE AS NB, P.PRIXPANIER AS PRIX 
	FROM DETAILPANIER D , ARTICLE A, PANIER P WHERE D.IDPANIER = '".$_GET['idclient']."' 
	AND D.IDARTICLE = A.IDARTICLE AND D.IDPANIER = P.IDPANIER";
    
    $panier3 = oci_parse($connect, $req2);
	
    // exécution de la requête
    oci_execute($panier3); 
	
	$req3 = "SELECT PRIXPANIER FROM PANIER WHERE IDPANIER ='".$_GET['idclient']."'";
	
	$prixpanier = oci_parse($connect, $req3);
	
	oci_execute($prixpanier);
	
	$prix = oci_fetch_assoc($prixpanier);
    
echo' <div class="produits">
  <div class="produit_header">';
  
  //si panier vide
    
    if (oci_fetch_assoc($panier) == false) {
      echo '<div class ="paniervide">  Votre panier est vide !<br>
              <button id = "vide"><a href = "Produit.php?recherche=Tous nos produits">D&eacutecouvrez nos produits !</a></button>';
  
    }
    
    else {
    
    echo'
        <div class="title">Votre panier : </div>
        <button id ="supprimer"><a href = "traitSupprPanier.php?idclient='.$_SESSION['idclient'].'">Supprimer</a></button>
        <button id ="valider"><a href = "traitValiderPanier.php">Valider</a></button>
        <button id = "retour"><a href = "Produit.php?recherche=Tous nos produits">Retour aux produits</a></button>
        <div class="title">Prix du panier : '.$totalPanier.' &#8364</div>
  </div>
  
  <div class="produit_container">'; }
 
    require_once('connect.inc.php');
 
  // Affichage des produits du panier non-vide
  
                while (($article = oci_fetch_assoc($panier3)) != false) { 
                    //$article = oci_fetch_assoc($panier);
                   
                    echo '
                        <div class="card">
                        
                            <div class="image">
                                <a href="detailArticle.php?idArticle='. $article['ID'] . '"><img src="./images/'.$article['NOM'].'.png" alt="image du produit"></a>
                            </div>
                            
                            <div class="title">Nom de l\'article : '. $article['NOM'] .'</div>              
                            
                            <div class="nombre" style="
    font-weight: 500;
    font-size: 20px;
    margin-bottom: 15px;
">Quantit&eacute command&eacutee : '. $article['NB'] . '</div>
                                
                            <div class="boutons">
                            
                                    <button id = "supprimer2"><a href="supprArticle.php?idarticle='.$article['ID'].'">Supprimer</a></button>
                            </div>
                  
                        </div> ';
                 
                }
	
	?>
 
 </div>
        
</div>

</body>
<?php include("./include/footer2.php");?>

</html>