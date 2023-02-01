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
					alert(" Diantre, arr�tez de modifier cet URl !"); 
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

  // ex�cution de la requ�te
  oci_execute($panier2);
               
// si le client n'a pas de panier, on lui en cr�� un 
  if (($panier3 = oci_fetch_assoc($panier2)) == false){
	  
    $createpanier = "INSERT INTO PANIER VALUES (:pID_PANIER, :pID_CLIENT, 0)";

    // pr�paration de la requ�te
    $createpanier2  = oci_parse($connect, $createpanier);
  
    oci_bind_by_name($createpanier2, ":pID_PANIER", $idclient);
  
    oci_bind_by_name($createpanier2, ":pID_CLIENT", $idclient);

    // ex�cution de la requ�te
    oci_execute($createpanier2);
  
    //commit
    oci_commit($connect);

  }
  
  // requ�te v�rifiant si l'article ajout� est d�j� dans le panier
  $reqdejapanier = "SELECT * FROM DETAILPANIER WHERE idPanier = :pID_PANIER AND idArticle = :pID_ARTICLE";
  
  $dejapanier = oci_parse($connect, $reqdejapanier);
    
    oci_bind_by_name($dejapanier, ":pID_PANIER", $idclient);
  
    oci_bind_by_name($dejapanier, ":pID_ARTICLE", $idarticle);
  
  // ex�cution de la requ�te
  oci_execute($dejapanier);
  
  // si l'article ajout� est d�j� dans le panier, on modifie sa quantit�
  if (($test = oci_fetch_assoc($dejapanier)) != false){
  
		if (($test['NBARTICLE'] + $nbarticle) > $qteenstock) {
			echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Pas assez de stock ! (cette quantit\u00e9 plus celle d\u00e9j\u00e0 dans votre panier d\u00e9passe le stock actuel pour cet article) "); 
					location.href = "detailArticle.php?idArticle='.$idarticle.'";
				</script>';
			exit();
		}
    //modification de la quantit�
    $reqmodifpanier = "UPDATE DETAILPANIER SET NBARTICLE = NBARTICLE + :pNB_ARTICLE WHERE idPanier = :pID_PANIER AND idArticle = :pID_ARTICLE";
    
  
    // pr�paration de la requ�te
    $modifpanier = oci_parse($connect, $reqmodifpanier);
    
    
    oci_bind_by_name($modifpanier, ":pNB_ARTICLE", $nbarticle);
    
    oci_bind_by_name($modifpanier, ":pID_ARTICLE", $idarticle);
  
    oci_bind_by_name($modifpanier, ":pID_PANIER", $idclient);

  // ex�cution de la requ�te
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
  
  //on ajoute l'article d�sir� au panier du client
  $req = "INSERT INTO DETAILPANIER VALUES (:pID_PANIER, :pID_ARTICLE, :pNB_ARTICLE, :pPRIX_QTE_ARTICLE)";
  
  // pr�paration de la requ�te
  $panier = oci_parse($connect, $req);
  
  oci_bind_by_name($panier, ":pID_PANIER", $idclient);
  
  oci_bind_by_name($panier, ":pID_ARTICLE", $idarticle);
  
  oci_bind_by_name($panier, ":pNB_ARTICLE", $nbarticle);
  
  oci_bind_by_name($panier, ":pPRIX_QTE_ARTICLE", $prixunitaire);

  // ex�cution de la requ�te
  oci_execute($panier);
  
  //commit
  oci_commit($connect);
  
  //lib�ration de la m�moire
  oci_free_statement($panier);
  
  //redirection vers le panier
 
  header("location: Panier.php?idclient=$idclient");
  exit();
  
}
  
?>


