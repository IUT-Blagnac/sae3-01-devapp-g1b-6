<?php

session_start();

require_once('connect.inc.php');

error_reporting(0);

if ($_SESSION['access'] != 'OK') {
	  header('location: formulaireConnexion.php');
      exit();
  }

$id = $_SESSION['idclient'];

if ($id != $_SESSION['idclient']) {
	echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Filou, ce n\'est pas votre compte !"); 
					location.href = "compteClient.php";
				</script>';
}


//on supprime le compte du client, ainsi que son panier et son contenu

$reqSupprContenuPanier = "DELETE FROM DETAILPANIER WHERE IDPANIER = :pID_CLIENT";

$supprContenuPanier = oci_parse($connect, $reqSupprContenuPanier);

oci_bind_by_name($supprContenuPanier, ":pID_CLIENT", $id);

oci_execute($supprContenuPanier);

oci_commit($connect);

$reqSupprPanier = "DELETE FROM PANIER WHERE IDPANIER = :pID_CLIENT";

$supprPanier = oci_parse($connect, $reqSupprPanier);

oci_bind_by_name($supprPanier, ":pID_CLIENT", $id);

oci_execute($supprPanier);

oci_commit($connect);

$reqSupprClient = "DELETE FROM CLIENT WHERE IDCLIENT = :pID_CLIENT";

$supprClient = oci_parse($connect, $reqSupprClient);

oci_bind_by_name($supprClient, ":pID_CLIENT", $id);

oci_execute($supprClient);

oci_commit($connect);

$_SESSION['access']='NOT OK';

/*header("location: index.php");
exit();*/

echo '<script language="JavaScript" type="text/javascript"> 
						alert("Compte supprim\u00e9 !"); 
						location.href = "./index.php";
					</script>';


?>
				