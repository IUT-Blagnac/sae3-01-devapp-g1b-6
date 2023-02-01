<?php

/*$test = 0;

$id = $_SESSION['idclient'];

$req = "SELECT * FROM DETAILPANIER WHERE IDPANIER = :pID_PANIER";

$req2 = oci_parse($connect, $req);

oci_bind_by_name($req2, ":pID_PANIER", $id);

oci_execute($req2);

while(($test = oci_fetch_assoc($req2)) != false){
	
	$req3 = "SELECT * FROM ARTICLE WHERE IDARTICLE = :pID_ARTICLE";
	
	$req4 = oci_parse($connect, $req3);
	
	oci_bind_by_name($req4, ":pID_ARTICLE", $test['IDARTICLE']);
	
	oci_execute($req4);
	
	$nb = oci_fetch_assoc($req4);
		
	$nbReel = $nb['QTESTOCK'];
	
	if ($test['NBARTICLE'] > $nbReel){
		$test = $test + 1;
	}	
}

if ($test == 0){
	
	header('location: commande.php');
	exit();
}

else {
	echo '<script language="JavaScript" type="text/javascript"> 
					alert("Un des articles n\'a plus assez de stock !"); 
					location.href = "Panier.php?idclient='.$id.'";
				</script>';
}*/

?>