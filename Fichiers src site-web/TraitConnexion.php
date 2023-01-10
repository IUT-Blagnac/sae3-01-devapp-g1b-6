<?php
	session_start();
	// Le formulaire a été soumis
	if (isset($_POST['connexion']) && isset($_POST['login']) && isset($_POST['password'])) {
		require_once("connect.inc.php");
		error_reporting(0);
		
		$req1 = "SELECT * FROM Client WHERE emailclient = :pEmail";
		$compte = oci_parse($connect , $req1);
		$email = $_POST['login'];
		oci_bind_by_name($compte, ":pEmail", $email);
		$result = oci_execute($compte);
		$mdp = oci_fetch_assoc($compte);
		
		if($mdp!=''){
			if (password_verify($_POST['password'], $mdp['MDPCLIENT'])!=1){
				$_SESSION['access'] = 'NOT OK';
				echo '<script language="JavaScript" type="text/javascript"> 
						alert("Mot de passe incorrect !"); 
						location.href = "./formulaireConnexion.php";
					</script>';
			}else{
				$_SESSION['access']='OK';
        $_SESSION['prenom']=$mdp['PRENOMCLIENT'];
				$_SESSION['mailclient']= $mdp['EMAILCLIENT'];
				if (isset($_POST['cookie'])) {
					$valCookie=$_POST['login'];
                                     
					// on met 60 sec de vie pour ce cookie afin de tester sa disparation
					setcookie('cookIdent', $valCookie, time()+60);
				}
				header('location: index.php');
				exit();
			}
		}else{
			echo '<script language="JavaScript" type="text/javascript"> 
					alert(" Ce compte n\'existe pas !"); 
					location.href = "./formulaireConnexion.php";
				</script>';
		}
		oci_free_statement($compte);
	}
?>
