<?php
	session_start();
	if($_SESSION['access']!='OK'){
		header('location: formulaireConnexion.php');
	}
	



?>
