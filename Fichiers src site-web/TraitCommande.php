<?php
session_start();

$regex[0] = "#^[0-9]{16}$#"; //numéro de la CB

$regex[1] = "#^(0[1-9]|1[0-2])[/](2[3-9])$#"; //date d'expiration de la CB  

$regex[2] = "#^[0-9]{3}$#"; //cryptogramme de la CB

$idclient = $_SESSION['idclient']; //l'id du client et également l'id du panier

$nom = $_SESSION['nom'];

$prenom = $_SESSION['prenom'];

// Le formulaire a été soumis
	if (isset($_POST['valider']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['carte']) && isset($_POST['date']) && isset($_POST['ccv'])) {
		require_once("connect.inc.php");
		error_reporting(0);
		
		if ($nom != $_POST['nom']){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le nom n\'est pas similaire \u00e0 celui de votre compte !"); 
						location.href = "./commande.php";
					</script>';
		}
		
		else if ($prenom != $_POST['prenom']){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le pr\u00e9nom n\'est pas similaire \u00e0 celui de votre compte !"); 
						location.href = "./commande.php";
					</script>';
		}
		
		else if(!preg_match($regex[0],$_POST['carte'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le num\u00e9ro de carte n\'est pas valide !"); 
						location.href = "./commande.php";
					</script>';
		}
		
		else if(!preg_match($regex[1],$_POST['date'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("La date d\'expiration n\'est pas valide !"); 
						location.href = "./commande.php";
					</script>';
		}
		
		else if(!preg_match($regex[2],$_POST['ccv'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le CCV n\'est pas valide !"); 
						location.href = "./commande.php";
					</script>';
		}
		
		else {
		
		// on récupère le prix du panier
		
		$reqPrix = "SELECT * FROM PANIER WHERE idPanier = :pID_CLIENT";
		
		$prix = oci_parse($connect, $reqPrix);
		
		oci_bind_by_name($prix, ":pID_CLIENT", $idclient);
		
		oci_execute($prix);
		
		$panierprixtotal = oci_fetch_assoc($prix);
		
		$prixPanier = $panierprixtotal['PRIXPANIER'];
		
	
//----------------------------------------------------------//
		
		//on ajoute une ligne dans la table commande
		
		$req = "INSERT INTO COMMANDE VALUES (SEQIDCOMMANDE.NEXTVAL, :pID_CLIENT, :pPRIX)";
		
		$req2 = oci_parse($connect, $req);
		
		oci_bind_by_name($req2, ":pID_CLIENT", $idclient);
		oci_bind_by_name($req2, ":pPRIX", $prixPanier);
		/*oci_bind_by_name($req2, ":pCARTE", $_POST['carte']);
		oci_bind_by_name($req2, ":pCCV", $_POST['ccv']);
		oci_bind_by_name($req2, ":pDATE", $_POST['date']);*/
		
		oci_execute($req2);
		
		oci_commit($connect);
		
//-----------------------------------------------------------------//

		//on ajoute le contenu de detailPanier dans detailCommande
		
		//on sélectionne en premier l'idCommande qui vient d'être ajouté
		
		$reqId = "SELECT MAX(IDCOMMANDE) AS IDCOMMANDE FROM COMMANDE WHERE IDCLIENT = :pID_CLIENT";
		
		$id = oci_parse($connect, $reqId);
		
		oci_bind_by_name($id, ":pID_CLIENT", $idclient);
		/*oci_bind_by_name($id, ":pPRIX", $prixPanier);
		oci_bind_by_name($id, ":pCARTE", $_POST['carte']);
		oci_bind_by_name($id, ":pCCV", $_POST['ccv']);
		oci_bind_by_name($id, ":pDATE", $_POST['date']);*/
		
		oci_execute($id);
		
		$idComm = oci_fetch_assoc($id);
   
    $idCommande = $idComm['IDCOMMANDE']; //variable stockant l'id de la commande actuelle
   
   echo '<script language="JavaScript" type="text/javascript">
						alert("'.$idCommande.'"); 
						location.href = "./index.php";
					</script>';
                     
   
		
		//$idCommande = $idComm['IDCOMMANDE']; //variable stockant l'id de la commande actuelle
		
		//on prend ensuite tous les articles du panier du client
		
		$req3 = "SELECT * FROM DETAILPANIER WHERE IDPANIER = :pID_CLIENT";
		
		$req4 = oci_parse($connect, $req3);
		
		oci_bind_by_name($req4, ":pID_CLIENT", $idclient);
		
		oci_execute($req4);
		
		//on ajoute enfin les articles du panier dans detailComande
		
		while (($articles = oci_fetch_assoc($req4)) != false) { 
			
			$reqInsert = "INSERT INTO DETAILCOMMANDE VALUES (:pID_COMMANDE, :pID_ARTICLE, :pNB_ARTICLE)";	
			
			$insert = oci_parse($connect, $reqInsert);
			
			oci_bind_by_name($insert, ":pID_COMMANDE", $idCommande); //$idCommande
			oci_bind_by_name($insert, ":pID_ARTICLE", $articles['IDARTICLE']);
			oci_bind_by_name($insert, ":pNB_ARTICLE", $articles['NBARTICLE']);
			
			oci_execute($insert);
			
			oci_commit($connect);
			
			//on met à jour le stock de chaque article
			$reqUpdate = "UPDATE ARTICLE SET QTESTOCK = QTESTOCK  - :pNB_ARTICLE WHERE IDARTICLE = :pID_ARTICLE";
			
			$update = oci_parse($connect, $reqUpdate);
			
			oci_bind_by_name($update, ":pNB_ARTICLE", $articles['NBARTICLE']);
			oci_bind_by_name($update, ":pID_ARTICLE", $articles['IDARTICLE']);
			
			oci_execute($update);
			
			oci_commit($connect);
				
		}
	
//-----------------------------------------------------------------//
	
		//on supprime le contenu du panier du client
		
		$req5 = "DELETE FROM DETAILPANIER WHERE IDPANIER = :pID_CLIENT";
		
		$req6 = oci_parse($connect, $req5);
		
		oci_bind_by_name($req6, ":pID_CLIENT", $idclient);
		
		oci_execute($req6);
		
		oci_commit($connect);
		
//-----------------------------------------------------------------//
		
		//après avoir commandé, si un des articles n'a plus de stock, on le supprime du panier de toutes les personnes l'ayant ajouté 
		
		$reqPanierSuppr = "SELECT * FROM ARTICLE WHERE QTESTOCK = 0";
		
		$panierSuppr = oci_parse($connect, $reqPanierSuppr);
		
		oci_execute($panierSuppr);
		
		while (($testSuppr = oci_fetch_assoc($panierSuppr)) != false){
			
			$reqSupprimer = "DELETE FROM DETAILPANIER WHERE IDARTICLE = :pID_ARTICLE";
			
			$supprimer = oci_parse($connect, $reqSupprimer);
			
			oci_bind_by_name($supprimer, ":pID_ARTICLE", $testSuppr['IDARTICLE']);
		
			oci_execute($supprimer);
		
			oci_commit($connect);
		}
		
		
		
//------------------------------------------------------------------------------

		//enfin, on supprime le panier du client, puis retour à l'accueil
		
		$req7 = "DELETE FROM PANIER WHERE IDPANIER = :pID_CLIENT";
		
		$req8 = oci_parse($connect, $req7);
		
		oci_bind_by_name($req8, ":pID_CLIENT", $idclient);
		
		oci_execute($req8);
		
		oci_commit($connect);
		
//-----------------------------------------------------------------//
		
		//retour à l'accueil avec pop-up informatif
		echo '<script language="JavaScript" type="text/javascript">
						alert("Commande effectu\u00e9e !"); 
						location.href = "./index.php";
					</script>';

		}
	}
	
	else { //si le filou tente de modifier l'url pour arriver direct sur cette page
		echo '<script language="JavaScript" type="text/javascript">
						alert("Non non non !"); 
						location.href = "./index.php";
					</script>';
	}


?>