<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="include/contact.css">
    <title>Nous contacter</title>
    <?php include("./include/header.php");?>
</head>
<body>
    <div class="titre">
        <strong>Produit</strong>
    </div>
    
    <div style="padding: 20px">
		<div class="dropdown">
			<button onclick="myFunction()" class="dropbtn"></button>
			<div id="myDropdown" class="dropdown-content">
			  <a href="#">Link 1</a>
			  <a href="#">Link 2</a>
			  <a href="#">Link 3</a>
			</div>
		</div>
    </div>
	<script>
		/* When the user clicks on the button,
		toggle between hiding and showing the dropdown content */
		function myFunction() {
		document.getElementById("myDropdown").classList.toggle("show");
		}

		// Close the dropdown menu if the user clicks outside of it
		window.onclick = function(event) {
		if (!event.target.matches('.dropbtn')) {
			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for (i = 0; i < dropdowns.length; i++) {
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
			}
		}
		}
	</script>
</body>
<?php include("./include/footer.php");?>
</html>
