document.addEventListener('DOMContentLoaded', function() {
  // Sélectionne tous les liens à l'intérieur des éléments menuItem
  const hypertext = document.querySelectorAll('nav .menu .menuItem a');

  const setActiveLink = () => {
    const currentPath = window.location.pathname;

    hypertext.forEach(link => {
      const linkPath = link.getAttribute('href'); // Obtenir l'attribut href directement de <a>
      link.classList.toggle('active', currentPath === linkPath); // Comparer currentPath avec linkPath
    });
  };

  setActiveLink();

  hypertext.forEach(link => {
    link.addEventListener('click', function(event) {
      // Supprimer la classe 'active' de tous les liens
      hypertext.forEach(link => link.classList.remove('active'));
      // Ajouter la classe 'active' à l'élément cliqué
      event.currentTarget.classList.add('active');
    });
  });
});