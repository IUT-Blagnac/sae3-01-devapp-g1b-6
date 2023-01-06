<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="include/produit.css">
    <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Nos produits</title>
    <?php include("./include/header.php");
    ?>
</head>
<body>
<div class="titre">
</div>




<div class="recherche">
  <form action="Produit.php">
    
    <div class="input">
	
      Chercher un article : 
	  
		<input type="text" name="recherche" placeholder="Exemple : Saumon">
	 
      Nos cat&eacutegories : 
      
      <button><a href = "Produit.php?recherche=Exploration">Exploration</a></button>
      <button><a href = "Produit.php?recherche=Drone">Drone</a></button>
      <button><a href = "Produit.php?recherche=Below-Zero">Below-Zero</a></button>
      <button><a href = "Produit.php?recherche=Plaisance">Plaisance</a></button>
      <button><a href = "Produit.php?recherche=Abyssale">Abyssale</a></button>
      <button><a href = "Produit.php?recherche=Sport">Sport</a></button>
    </div>
  </form>
</div>

                    
                    
 <div class="produits">
        <div class="produit_header">
        <?php $lower = strtolower($_GET['recherche']);?>
            <div class="title">R&eacutesultats pour : <?php echo $_GET['recherche']?></div>
            
        </div>

        <div class="produit_container">
            <?php
                require_once("connect.inc.php"); 
                error_reporting(0);

                switch($_GET['recherche']){
                    
                    //catégories
                    
                    case 'Tous nos produits':
                        $req = "
                            select *
                            from Article
                        ";
                        break;
                        
                    case 'Exploration':
                        $req = "
                            select *
                            from Article
                            where idCategorie = 1
                        ";
                        break;
                        
                    case 'Drone':
                            $req = "
                                select * 
                                from Article 
                                where idcategorie = 2
                            ";
                            break;
                            
                    case 'Below-Zero':
                            $req = "
                                select *
                                from Article
                                where idcategorie = 3
                            ";
                            break;
                            
                    case 'Plaisance':
                            $req = "
                                select * 
                                from Article
                                where idcategorie = 4
                            ";
                            break;
                            
                            
                    case 'Abyssale':
                            $req = "
                                select * 
                                from Article
                                where idcategorie = 5
                            ";
                            break;
                            
                            
                    case 'Sport':
                            $req = "
                                select * 
                                from Article
                                where idcategorie = 6
                            ";
                            break;
                    

                    default:
                        $req =  "
                            select *
                            from Article
                            where lower(NOMARTICLE) LIKE '%$lower%'
                        ";
                        
                }

                // préparation de la requête
                $articles = oci_parse($connect, $req);

                // exécution de la requête
                oci_execute($articles);


                //$nb = oci_fetch_all($articles, $res);
                
                // Si aucune lignes n'est trouvé
                //if ($nb==0) {	
                //    echo 'Aucun r&eacutesultat ...';
                //}
                
                

                // Affichage des produits 
                while (($article = oci_fetch_assoc($articles)) != false) {
                 //foreach ($articles as $article){ 
                    
                    echo '
                        <div class="card">
                            <div class="image">
                                <img src="./images/'.$article['NOMARTICLE'].'.png" alt="image du produit">
                            </div>
                            <div class="title">'. $article['NOMARTICLE'] .'</div>
                            
                            
                                <div class="prix">
                                    
                                    <span class="prix">'. $article['PRIXARTICLE'] . '&#8364</span>
                                </div>
                                
                            <div class="boutons">
                            
                                    <button><a href="panier.php">Ajouter au panier</a></button>
                                    <button><a href="detailArticle.php?idArticle='. $article['IDARTICLE'] . '">Informations</a></buttons>
                                
                            </div>
                            
                        </div> ';
                 
                }
                
                // libération du curseur
                oci_free_statement($articles);
            ?>
           
        </div>
        
    </div>

</body>
<?php include("./include/footer2.php");?>
</html>