<?php
	session_start();
	$_SESSION['access']='NOT OK';
  echo '<script language="JavaScript" type="text/javascript"> 
						alert("D&eacuteconnexion effectu&eacutee !"); 
						location.href = "./index.php";
					</script>';
	
?>