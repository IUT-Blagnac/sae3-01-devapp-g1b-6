<?php
	session_start();
	$_SESSION['access']='NOT OK';
  echo '<script language="JavaScript" type="text/javascript"> 
						alert("D\u00e9connexion effectu\u00e9e !"); 
						location.href = "./index.php";
					</script>';
	
?>