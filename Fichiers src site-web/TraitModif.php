<?php
	$regex[0] = "#^([a-z]+(( |')[a-z]+)*)+([-]([a-z]+(( |')[a-z]+)*)+)*$#iu"; //nom & prénom
	$regex[1] = "#^([a-z]|[0-9]|\.|-|_)+@([a-z]|[0-9]|\.|-|_)+\.([a-z]|[0-9]){2,3}$#"; //email
	$regex[2] = "#^[0][1-9]{1}[0-9]{8}$#"; //téléphone
	$regex[3] = "#^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#"; //mot de passe

	if (isset($_POST['valider']) && isset($_POST['email']) 
		&& isset($_POST['motdepasse']) && isset($_POST['nom']) //formulaire soumis
		&& isset($_POST['prenom']) && isset($_POST['telephone'])) {
		
		if(!preg_match($regex[0],$_POST['nom'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le nom n\'est pas valide !"); 
						location.href = "./formulaireModif.php?pmail='.$_GET['email'].'";
					</script>';
		}
		else if(!preg_match($regex[0],$_POST['prenom'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le prénom n\'est pas valide !"); 
						location.href = "./formulaireModif.php?pmail='.$_GET['email'].'";
					</script>';
		}
		else if(!preg_match($regex[1],$_POST['email'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le mail n\'est pas valide !"); 
						location.href = "./formulaireModif.php?pmail='.$_GET['email'].'";
					</script>';
		}
		else if (!preg_match($regex[2],$_POST['telephone'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Le téléphone n\'est pas valide ! (ne pas mettre d\'espaces)"); 
						location.href = "./formulaireModif.php?pmail='.$_GET['email'].'";
					</script>';
		}
		else if(!preg_match($regex[3],$_POST['motdepasse'])){
			echo '<script language="JavaScript" type="text/javascript">
						alert("Mot de passe non valide (8 caractères min, minimum 1 majuscule, minuscule et chiffre)"); 
						location.href = "./formulaireModif.php?pmail='.$_GET['email'].'";
					</script>';
		}else{
			require_once("connect.inc.php");
			error_reporting(0);
			$req4 = 'UPDATE Client SET nomclient=:pNom , prenomclient=:pPrenom , telclient=:ptel , emailclient=:pemail , 
      mdpclient=:pmdp WHERE emailclient=:ppemail';
			$update = oci_parse($connect , $req4);
			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];
			$tel = $_POST['telephone'];
			$email = $_POST['email'];
			$email2 = htmlentities($_GET['email']);
			$mdp = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
			oci_bind_by_name($update, ":pnom", $nom);
			oci_bind_by_name($update, ":pprenom", $prenom);
			oci_bind_by_name($update, ":ptel", $tel);
			oci_bind_by_name($update, ":pemail", $email);
			oci_bind_by_name($update, ":pmdp", $mdp);
			oci_bind_by_name($update, ":ppemail", $email2);
			$result = oci_execute($update);
			if (!$result) {
				$e = oci_error($update);  // on récupère l'exception liée au pb d'execution de la requete 
        //(violation PK par exemple)
				print htmlentities($e['message'].' pour cette requete : '.$e['sqltext']);		
			}
			oci_commit($connect);
			oci_free_statement($update);
			header('location: index.php');
		}
	}
?>