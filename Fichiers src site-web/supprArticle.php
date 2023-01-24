 <?php
 	session_start();
    require_once("connect.inc.php"); 
    error_reporting(0);
	
	if ($_SESSION['access'] != 'OK') {
	  header('location: formulaireConnexion.php');
      exit();
  }
  
    $idclient = $_SESSION['idclient'];
 
    $idarticle = htmlentities($_GET['idarticle']);
    
    $nbarticle = $_POST['nbarticle'];
    
    $req = "SELECT * FROM DETAILPANIER WHERE IDPANIER = :pID_PANIER AND IDARTICLE = :pID_ARTICLE";
    
    $verif = oci_parse($connect, $req);
    
    oci_bind_by_name($verif, ":pID_PANIER", $idclient);
  
    oci_bind_by_name($verif, ":pID_ARTICLE", $idarticle);
    
    // exécution de la requête
    oci_execute($verif);
    
    $stock = oci_fetch_assoc($verif);
    
    $stockTable = $stock['NBARTICLE'];
    
    if ($stockTable != $nbarticle){ //on met à jour la quantité de l'article dans detailPanier
    
      $nombre = $stockTable - $nbarticle;
    
      $reqUpdate = "UPDATE DETAILPANIER SET NBARTICLE = :pNB_ARTICLE WHERE IDPANIER = :pID_PANIER AND IDARTICLE = :pID_ARTICLE";
      
	    //préparation de la requête
	    $UpdateArticle = oci_parse($connect, $reqUpdate);
	
  	  oci_bind_by_name($UpdateArticle, ":pID_PANIER", $idclient);
  
      oci_bind_by_name($UpdateArticle, ":pID_ARTICLE", $idarticle);
      
      oci_bind_by_name($UpdateArticle, ":pNB_ARTICLE", $nombre);

      // exécution de la requête
      oci_execute($UpdateArticle);
         
      //commit
      oci_commit($connect);
	
	    //libération de la mémoire
      oci_free_statement($UpdateArticle);
  
      //redirection vers le panier
      header("location: Panier.php?idclient=$idclient");
      exit();
      
    }
    
    else { //on supprimer l'article du panier

	    $reqDelete = "DELETE FROM DETAILPANIER WHERE IDPANIER = :pID_PANIER AND IDARTICLE = :pID_ARTICLE";
	
	    //préparation de la requête
	    $deleteArticle = oci_parse($connect, $reqDelete);
	
  	  oci_bind_by_name($deleteArticle, ":pID_PANIER", $idclient);
  
      oci_bind_by_name($deleteArticle, ":pID_ARTICLE", $idarticle);

      // exécution de la requête
      oci_execute($deleteArticle);
  
      //commit
      oci_commit($connect);
	
	    //libération de la mémoire
      oci_free_statement($deleteArticle);
  
      //redirection vers le panier
      header("location: Panier.php?idclient=$idclient");
      exit();
    }
  
?>
