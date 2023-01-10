<?php
	// il faut stocker le password dans la table Clients et non en dur dans le code !!!
	$hash = password_hash($_GET['mdp'], PASSWORD_DEFAULT);
	// $hash vaut $2y$10$.vGA1O9wmRjrwAVXD98HNOgsNpDczlqm3Jq7KnEd1rVAGv3Fykk1a
?>