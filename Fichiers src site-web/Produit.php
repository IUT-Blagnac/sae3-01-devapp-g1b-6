<?php session_start();
if (!isset($_SESSION['access'])) {
	header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
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
<body style = "margin : 0">
<div class="titre">
</div>




<div class="recherche">
  <form action="Produit.php" method = "get">
 
    
    <div class="input">
		<div class = "input2">
      <strong style="
    font-size: 25px;
">Chercher un article : </strong>
	  <div class = "loupe">
		<i class="fa-sharp fa-solid fa-magnifying-glass"></i>
		<input type="text" name="recherche" placeholder="Exemple : Saumon" required>
		
	  </div>
		
    <input type ="submit" name = "valider" value = "Rechercher">
	 
     <strong style="
    font-size: 25px;
"> 
</div> 
<div class = "input3">Nos cat&eacutegories : </strong>
      
      <button><a href = "Produit.php?recherche=Exploration">Exploration</a></button>
      <button><a href = "Produit.php?recherche=Drone">Drone</a></button>
      <button><a href = "Produit.php?recherche=Below-Zero">Below-Zero</a></button>
      <button><a href = "Produit.php?recherche=Plaisance">Plaisance</a></button>
      <button><a href = "Produit.php?recherche=Abyssale">Abyssale</a></button>
      <button><a href = "Produit.php?recherche=Sport">Sport</a></button>
    </div>
  </form>
  </div> 
</div>

                    
                    
 <div class="produits">
        <div class="produit_header">
        <?php $lower = strtolower(htmlentities($_GET['recherche']));
				?>
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
                            from Article A, Categorie C WHERE A.idCategorie = C.idCategorie
                        ";
                        break;
                        
                    case 'Exploration':
                        $req = "
                            select *
                            from Article A, Categorie C
                            where A.idCategorie = 1 AND A.idCategorie = C.idCategorie
                        ";
                        break;
                        
                    case 'Drone':
                            $req = "
                                select * 
                                from Article A, Categorie C
                                where A.idcategorie = 2 AND A.idCategorie = C.idCategorie
                            ";
                            break;
                            
                    case 'Below-Zero':
                            $req = "
                                select *
                                from Article A, Categorie C
                                where A.idcategorie = 3 AND A.idCategorie = C.idCategorie
                            ";
                            break;
                            
                    case 'Plaisance':
                            $req = "
                                select * 
                                from Article A, Categorie C
                                where A.idcategorie = 4 AND A.idCategorie = C.idCategorie
                            ";
                            break;
                            
                            
                    case 'Abyssale':
                            $req = "
                                select * 
                                from Article A, Categorie C
                                where A.idcategorie = 5 AND A.idCategorie = C.idCategorie
                            ";
                            break;
                            
                            
                    case 'Sport':
                            $req = "
                                select * 
                                from Article A, Categorie C
                                where A.idcategorie = 6 AND A.idCategorie = C.idCategorie
                            ";
                            break;
                    

                    default:
                        $req =  "
                            select *
                            from Article A, Categorie C
                            where LOWER(A.NOMARTICLE) LIKE '%' || :p_ARTICLE || '%' AND A.idCategorie = C.idCategorie ";
                        
                }

                // préparation de la requête
                $articles = oci_parse($connect, $req);

				oci_bind_by_name($articles, ":p_ARTICLE", $lower);
				
				
                // exécution de la requête
                oci_execute($articles);
					
				oci_fetch_all($articles, $res);
                // si aucun résultat (aucune lignes n'est trouvé)
                /*if ((oci_fetch_assoc($articles)) == false) {
                  echo'<div class ="aucunresultat">  Aucun r&eacutesultat ...</div>';
                }*/
				
				
				
				if (empty($res['IDARTICLE'])) {
                  echo'<div class ="aucunresultat">  Aucun r&eacutesultat ...</div>';
                }
				
				else{
                // Affichage des produits
				//$article = oci_fetch_assoc($articles);
					//while (($article = oci_fetch_assoc($articles)) != false) { 
					for($i = 0; $i < count($res['IDARTICLE']); $i++){
					//foreach ($article as $article2) { //= oci_fetch_assoc($articles){
						echo '
							<div class="card">
							
								<div class="image">
									<a href="detailArticle.php?idArticle='. $res['IDARTICLE'][$i] . '"><img src="./images/'.$res['NOMARTICLE'][$i].'.png" alt="image du produit"></a>
								</div>
								<div class="title">'. $res['NOMARTICLE'][$i] .'</div>
                            
								<div class="categorie">Cat&eacutegorie : '. $res['NOMCATEGORIE'][$i] .'</div>
                            
                            
									<div class="prix">
                                    
										<span class="prix">'. $res['PRIXARTICLE'][$i] . '&#8364</span>
									</div>
                                
								<div class="boutons">
                                    
										<button id ="infos"><a href="detailArticle.php?idArticle='. $res['IDARTICLE'][$i] . '">Informations</a></buttons>
                                
								</div>
                            
							</div> ';
                 
					}
				  }
				
                
                // libération du curseur
                oci_free_statement($articles);
            ?>
           
        </div>
        
    </div>

</body>
<?php include("./include/footer2.php");?>
</html>