document.addEventListener('DOMContentLoaded', function() {
    const healthStatusSelect = document.getElementById('user_plant_detail_form_HealthStatus');
    const diseasesContainer = document.getElementById('diseases-container');
    
    // Fonction pour afficher ou masquer le champ des maladies
    function toggleDiseasesField() {
        // Vérifie si l'option "Malade" est sélectionnée
        if (healthStatusSelect.value === '2') {
            diseasesContainer.classList.remove('hidden'); // Affiche le champ
        } else {
            diseasesContainer.classList.add('hidden'); // Masque le champ
        }
    }

    // Appelle la fonction au chargement de la page pour le bon état initial
    toggleDiseasesField();

    // Ajoute un écouteur d'événement pour changer la visibilité du champ en fonction de la sélection
    healthStatusSelect.addEventListener('change', toggleDiseasesField);
});