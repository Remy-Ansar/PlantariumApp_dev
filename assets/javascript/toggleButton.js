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