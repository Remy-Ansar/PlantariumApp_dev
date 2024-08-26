document.addEventListener('DOMContentLoaded', function () {
    // Prevent form submission when fields change
    const form = document.querySelector('form');
    const modifyButton = document.querySelector('.modifyButton');

    form.addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent default form submission
    });

    // Allow form submission only when the modify button is clicked
    modifyButton.addEventListener('click', function(event) {
        event.preventDefault();  // Prevent default action
        form.submit();  // Manually submit the form
    });
});