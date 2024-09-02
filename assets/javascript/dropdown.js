document.addEventListener('DOMContentLoaded', function() {
    let dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function(dropdown) {
        let toggleButton = dropdown.querySelector('.dropdown-toggle');
        let menu = dropdown.querySelector('.dropdown-menu');

        toggleButton.addEventListener('click', function() {
            // Masquer tous les autres menus dropdown
            document.querySelectorAll('.dropdown-menu').forEach(function(otherMenu) {
                if (otherMenu !== menu) {
                    otherMenu.style.display = 'none';
                }
            });

            // Afficher ou masquer le menu du dropdown cliqué
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        });

        // Fermer le menu si l'utilisateur clique en dehors du dropdown
        document.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    });
});