<?php
 	session_start();
  require_once("connect.inc.php"); 
  error_reporting(0);
  
                
  if ($_SESSION['access'] != 'OK') {
	  header('location: formulaireConnexion.php');
    exit();
  }
  
  $idclient = htmlentities($_GET['idclient']);
  
  $reqsupprpanier = "DELETE FROM DETAILPANIER WHERE idPanier = :pID_CLIENT";

// pr�paration de la requ�te
  $supprpanier  = oci_parse($connect, $reqsupprpanier);
  
  oci_bind_by_name($supprpanier, ":pID_CLIENT", $idclient);

  // ex�cution de la requ�te
  oci_execute($supprpanier);
  
  //commit
  oci_commit($connect);
  
  //lib�ration de la m�moire
  oci_free_statement($supprpanier);
  
  //redirection vers le panier
  header("location: Panier.php?idclient=$idclient");
  exit();
  
  
  ?>
  
  