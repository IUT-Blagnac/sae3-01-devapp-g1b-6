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

// préparation de la requête
  $supprpanier  = oci_parse($connect, $reqsupprpanier);
  
  oci_bind_by_name($supprpanier, ":pID_CLIENT", $idclient);

  // exécution de la requête
  oci_execute($supprpanier);
  
  //commit
  oci_commit($connect);
  
  //libération de la mémoire
  oci_free_statement($supprpanier);
  
  //redirection vers le panier
  header("location: Panier.php?idclient=$idclient");
  exit();
  
  
  ?>
  
  