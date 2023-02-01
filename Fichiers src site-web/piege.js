var allowedKeys = {
	65: 'a',
	68: 'd',
    77: 'm',
    73: 'i',
    78: 'n'
  };
  
  var konamiCode = ['a', 'd', 'm', 'i', 'n'];
  
  var konamiCodePosition = 0;
  
  document.addEventListener('keydown', function(e) {

    var key = allowedKeys[e.keyCode];
    var requiredKey = konamiCode[konamiCodePosition];
    if (key == requiredKey) {
      konamiCodePosition++;
  
      if (konamiCodePosition == konamiCode.length) {
        activateCheats();
        konamiCodePosition = 0;
      }
    } else {
      konamiCodePosition = 0;
    }
  });
  
  function activateCheats() {
    alert("Vous allez accéder à la partie administrateur du site.");
    document.location.href = "GestionProduit.php";
   

  }
  
  
  //, 't', 'g', 'a', 'y'
  
  /*76: 'l',
    69: 'e',
    86: 'v',
    83: 's',
	84: 't',
	71: 'g',
	   89: 'y'*/