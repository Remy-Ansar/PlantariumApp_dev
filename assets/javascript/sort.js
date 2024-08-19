document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const plantList = document.getElementById('plant-list');
    const paginationLinks = document.querySelectorAll('#pagination a');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            fetch(link.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                plantList.innerHTML = new DOMParser()
                    .parseFromString(html, 'text/html')
                    .querySelector('#plant-list').innerHTML;
                document.getElementById('pagination').innerHTML = new DOMParser()
                    .parseFromString(html, 'text/html')
                    .querySelector('#pagination').innerHTML;
            });
        });
    });
});