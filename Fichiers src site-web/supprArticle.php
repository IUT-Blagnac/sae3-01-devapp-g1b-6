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
  
?>
