<?php session_start();
if (!isset($_SESSION['access'])) {
	header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./include/gestionpro.css">
    <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gestion du stock</title>
    

</head>
<?php include("./include/header.php");?>    

<body>

<div class = "boutons" style = "display:flex;
	gap : 30px;" >
<button id = "b1"><a href="formulaireGestion1.php">Ajouter du stock</a></button>

<button id = "b2"><a href="formulaireGestion2.php">Retirer du stock</a></button>
</div>

</body>
<?php include("./include/footer3.php");?>
</html>