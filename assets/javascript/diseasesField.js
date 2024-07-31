document.addEventListener('DOMContentLoaded', function () {
    const healthStatusField = document.querySelector('[data-role="health-status"]');
    const diseasesContainer = document.getElementById('diseases-container');

    if (healthStatusField) {
        healthStatusField.addEventListener('change', function () {
            if (healthStatusField.value === 'Malade') { // Adjust this value based on your database value or form label
                diseasesContainer.style.display = 'block';
            } else {
                diseasesContainer.style.display = 'none';
            }
        });

        // Initial check to display the field if already selected
        if (healthStatusField.value === 'Malade') {
            diseasesContainer.style.display = 'block';
        }
    }
});