document.addEventListener('DOMContentLoaded', function () {
    const filterButton = document.querySelector('.filterButton');
    const filters = document.querySelector('.filters');
  
    filterButton.addEventListener('click', function () {
      if (filters.classList.contains('visible')) {
        filters.classList.remove('visible');
        filterButton.textContent = 'Tri avancés :'; // Texte du bouton lorsqu'il est fermé
      } else {
        filters.classList.add('visible');
        filterButton.textContent = 'Masquer les filtres'; // Texte du bouton lorsqu'il est ouvert
      }
    });
  });