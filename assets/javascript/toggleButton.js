document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-plant').forEach(function(button) {
        button.addEventListener('click', function() {
            var plantId = this.getAttribute('data-id');
            var url = this.getAttribute('data-url');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Met à jour le texte du bouton en fonction du nouvel état
                    this.textContent = data.enabled ? 'Désactiver' : 'Activer';
                } else {
                    alert('Une erreur s\'est produite lors de la mise à jour de la visibilité.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur s\'est produite lors de la communication avec le serveur.');
            });
        });
    });
});
