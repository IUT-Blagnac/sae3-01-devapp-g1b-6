var allowedKeys = {
	76: 'l',
    69: 'e',
    86: 'v',
    83: 's',
	84: 't',
	71: 'g',
    65: 'a',
    89: 'y'
  };
  
  var konamiCode = ['l', 'e', 'v', 'e', 's', 't', 'g', 'a', 'y'];
  
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
    alert("Toi aussi tu trouves que le V est gay ?!");
    document.location.href = "backrooms.html";
    

    var audio = new Audio('images/leV.mp3');
    audio.play();

  }