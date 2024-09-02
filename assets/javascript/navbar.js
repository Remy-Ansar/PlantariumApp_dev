document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner l'élément nav
    const nav = document.querySelector('nav');
  
    // Calculer la position initiale du haut de la nav par rapport au haut de la fenêtre
    const navOffsetTop = nav.offsetTop;
  
    // Fonction pour gérer le changement de couleur
    function handleNavColorChange() {
      if (window.scrollY >= navOffsetTop) {
        // Si la page est défilée plus loin que le haut de la nav
        nav.classList.add('sticky-active');
      } else {
        nav.classList.remove('sticky-active');
      }
    }
  
    // Ajouter l'événement de défilement
    window.addEventListener('scroll', handleNavColorChange);
  
    // Appeler la fonction une fois pour vérifier la position initiale
    handleNavColorChange();
  });