<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="include/detailArticle.css">
    <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
    
    <title>D&eacutetail</title>
    <?php include("./include/header.php");
    ?>
</head>

<body>
<?php
require_once("connect.inc.php"); 


$req = "SELECT * FROM Article WHERE idArticle='".$_GET['idArticle']."'";

// préparation de la requête
$article = oci_parse($connect, $req);

// exécution de la requête
oci_execute($article);

$detail = oci_fetch_assoc($article);




$lesCategories = "SELECT * FROM Categorie C, Article A WHERE A.idCategorie = C.idCategorie AND A.idArticle = '".$_GET['idArticle']."'";

$cat = oci_parse($connect, $lesCategories);

oci_execute($cat);
                
$categorie = oci_fetch_assoc($cat);

echo ' <div class="card">
          <div class="image">
            <img src="./images/'.$detail['NOMARTICLE'].'.png" alt="image du produit">
          </div>
          <div class="title"><strong>Nom de l\'article : </strong>'. $detail['NOMARTICLE'] .'</div>
          
          <div class="categorie"><strong>Cat&eacutegorie : </strong>'. $categorie['NOMCATEGORIE'] .'</div>
          
          <div class="stock"><strong>Quantit&eacute en stock : </strong>'. $detail['QTESTOCK'] .'</div>
                            
          <div class="prix">
                                    
            <span class="prix"><strong>Prix : </strong>'. $detail['PRIXARTICLE'] . '&#8364 </span>
           
          </div>
          <div class="desc"><strong>Description : </strong>'. $detail['DESCRIPTIONARTICLE'] .'</div>
                                
          <div class="boutons">
                            
                <button><a href="panier.php">Ajouter au panier</a></button>
                <button><a href="Produit.php?recherche=Tous nos produits">Retour aux produits</a></button></buttons>
                                
           </div>
                            
          </div> ';
                
                
       // libération du curseur
       oci_free_statement($article);
       
?>


</body>
<?php include("./include/footer2.php");?>
</html>