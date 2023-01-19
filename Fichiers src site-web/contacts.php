<?php session_start();
if (!isset($_SESSION['access'])) {
	header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="include/contact.css">
    <link rel="shortcut icon" href="images/Logo_SubOne_png.png" />
    <title>Nous contacter</title>
    <?php include("./include/header.php");?>
</head>
<body>
<div class="titre">
    <strong>Nous contacter</strong>
</div>

 <div class="container">
    <div class="box">
       <div class="title">Notre bureau principal</div> <BR>
       <div class="content">12 Adresse du Beluga, Blagnac</div>
    </div>
    <div class="box">
        <div class="title">Adresse mail</div><BR>
        <div class="content">subone@gmail.com</div>
    </div>
    <div class="box">
        <div class="title">Numéro de téléphone</div><BR>
        <div class="content">(123) 456 7890</div>
    </div>
    <div class="box">
        <div class="title">Réseaux sociaux</div><BR>
        <div class="content">@subone (Twitter)<BR>subone (Snapchat)</div>
    </div>
 </div>


</body>
<?php include("./include/footer.php");?>
</html>