<?php
 	session_start();
  require_once("connect.inc.php"); 
  error_reporting(0);
  
                
  if ($_SESSION['access'] != 'OK') {
	  header('location: formulaireConnexion.php');
    exit();
  }
  
  if(!isset($_POST['Valider'])){
	echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Diantre, arrêtez de modifier cet URl !"); 
					location.href = "index.php";
				</script>';
			exit();	
  
  }

//variables

    $nbarticle = $_POST['nbarticle']; 
  
    $idclient = $_SESSION['idclient'];
  
    $idarticle = htmlentities($_GET['idarticle']);  
	
	$qteenstock = htmlentities($_GET['qtestock']);
	
	$prixunitaire = htmlentities($_GET['prix']);
	
	
	if($nbarticle > $qteenstock){
		echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Pas assez de stock !"); 
					location.href = "detailArticle.php?idArticle='.$idarticle.'";
				</script>';
		exit();
		
	}
  
  $idpanier = "SELECT idPanier FROM PANIER WHERE idClient = :pID_CLIENT";
  
  $panier2 = oci_parse($connect, $idpanier);
  
   oci_bind_by_name($panier2, ":pID_CLIENT", $idclient);

  // exécution de la requête
  oci_execute($panier2);
               
// si le client n'a pas de panier, on lui en créé un 
  if (($panier3 = oci_fetch_assoc($panier2)) == false){
	  
    $createpanier = "INSERT INTO PANIER VALUES (:pID_PANIER, :pID_CLIENT, 0)";

    // préparation de la requête
    $createpanier2  = oci_parse($connect, $createpanier);
  
    oci_bind_by_name($createpanier2, ":pID_PANIER", $idclient);
  
    oci_bind_by_name($createpanier2, ":pID_CLIENT", $idclient);

    // exécution de la requête
    oci_execute($createpanier2);
  
    //commit
    oci_commit($connect);

  }
  
  // requête vérifiant si l'article ajouté est déjà dans le panier
  $reqdejapanier = "SELECT * FROM DETAILPANIER WHERE idPanier = :pID_PANIER AND idArticle = :pID_ARTICLE";
  
  $dejapanier = oci_parse($connect, $reqdejapanier);
    
    oci_bind_by_name($dejapanier, ":pID_PANIER", $idclient);
  
    oci_bind_by_name($dejapanier, ":pID_ARTICLE", $idarticle);
  
  // exécution de la requête
  oci_execute($dejapanier);
  
  // si l'article ajouté est déjà dans le panier, on modifie sa quantité
  if (($test = oci_fetch_assoc($dejapanier)) != false){
  
		if (($test['NBARTICLE'] + $nbarticle) > $qteenstock) {
			echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Pas assez de stock ! (cette quantit\u00e9 plus celle d\u00e9j\u00e0 dans votre panier d\u00e9passe le stock actuel pour cet article) "); 
					location.href = "detailArticle.php?idArticle='.$idarticle.'";
				</script>';
			exit();
		}
    //modification de la quantité
    $reqmodifpanier = "UPDATE DETAILPANIER SET NBARTICLE = NBARTICLE + :pNB_ARTICLE WHERE idPanier = :pID_PANIER AND idArticle = :pID_ARTICLE";
    
  
    // préparation de la requête
    $modifpanier = oci_parse($connect, $reqmodifpanier);
    
    
    oci_bind_by_name($modifpanier, ":pNB_ARTICLE", $nbarticle);
    
    oci_bind_by_name($modifpanier, ":pID_ARTICLE", $idarticle);
  
    oci_bind_by_name($modifpanier, ":pID_PANIER", $idclient);

  // exécution de la requête
  oci_execute($modifpanier);
  
  //commit
  oci_commit($connect);
  
  //redirection vers le panier
  
  header("location: Panier.php?idclient=$idclient");
  exit();
  
  }
  
  else {
 
  // sinon on ajoute l'article au panier
  
  $article = oci_fetch_assoc($panier2);   
  
  $idPanier = $article['IDPANIER'];      
  
  //on ajoute l'article désiré au panier du client
  $req = "INSERT INTO DETAILPANIER VALUES (:pID_PANIER, :pID_ARTICLE, :pNB_ARTICLE, :pPRIX_QTE_ARTICLE)";
  
  // préparation de la requête
  $panier = oci_parse($connect, $req);
  
  oci_bind_by_name($panier, ":pID_PANIER", $idclient);
  
  oci_bind_by_name($panier, ":pID_ARTICLE", $idarticle);
  
  oci_bind_by_name($panier, ":pNB_ARTICLE", $nbarticle);
  
  oci_bind_by_name($panier, ":pPRIX_QTE_ARTICLE", $prixunitaire);

  // exécution de la requête
  oci_execute($panier);
  
  //commit
  oci_commit($connect);
  
  //libération de la mémoire
  oci_free_statement($panier);
  
  //redirection vers le panier
 
  header("location: Panier.php?idclient=$idclient");
  exit();
  
}
  
?>


