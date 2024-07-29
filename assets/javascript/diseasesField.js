document.addEventListener('DOMContentLoaded', function () {
    var healthStatusField = document.getElementById('health-status-field');
    var diseasesField = document.getElementById('diseases-field').parentElement.parentElement; 

    function toggleDiseasesField() {
        if (healthStatusField.value === 'Malade') {
            diseasesField.style.display = 'block';
        } else {
            diseasesField.style.display = 'none';
        }
    }

    toggleDiseasesField();

    healthStatusField.addEventListener('change', toggleDiseasesField);
});