document.addEventListener('DOMContentLoaded', function() { /* recuperation la marque selectionné */ 
  var selectMarque = document.getElementById('filtre-marque');
  var cartes       = document.querySelectorAll('.vu');

  function filtrer() { /* affiche les modeles et leurs donnees de la marque selectionné */
    var choix = selectMarque.value;
    cartes.forEach(function(c) {
      var marque = c.getAttribute('data-marque');
      c.style.display = (choix === 'Toutes' || marque === choix) ? '' : 'none';
    });
  }

  filtrer(); 
  selectMarque.addEventListener('change', filtrer); 
});
