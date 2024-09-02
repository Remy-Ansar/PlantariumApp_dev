document.addEventListener('DOMContentLoaded', function () {
    // Sélectionne tous les boutons avec la classe 'toggle-plant'
    const toggleButtons = document.querySelectorAll('.toggle-plant');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Empêche le comportement par défaut du bouton

            const plantId = button.getAttribute('data-id');
            const url = button.getAttribute('data-url');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ id: plantId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Change l'image en fonction du nouvel état
                    const img = button.querySelector('img');
                    if (data.enabled) {
                        img.src = '/images/components/commutateur_on.png'; // Image pour 'enabled'
                        img.alt = 'Désactiver';
                    } else {
                        img.src = '/images/components/commutateur_off.png'; // Image pour 'disabled'
                        img.alt = 'Activer';
                    }
                } else {
                    console.error('Erreur: ', data.error);
                }
            })
            .catch(error => {
                console.error('Erreur réseau: ', error);
            });
        });
    });
});
// Sélection des éléments
const toggleButton = document.getElementById('toggle-header-button');
const header = document.getElementById('main-header');

// État initial
let isHeaderVisible = true;

// Fonction pour toggler le header
function toggleHeader() {
    isHeaderVisible = !isHeaderVisible;
    if (isHeaderVisible) {
        header.classList.remove('header-hidden');
        toggleButton.setAttribute('aria-expanded', 'true');
    } else {
        header.classList.add('header-hidden');
        toggleButton.setAttribute('aria-expanded', 'false');
    }
}

// Écouteur d'événement sur le bouton
toggleButton.addEventListener('click', toggleHeader);