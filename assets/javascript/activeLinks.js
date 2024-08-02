document.addEventListener('DOMContentLoaded', function() {
    const hypertext = document.querySelectorAll('.link');
  
    let setActiveLink = function() {

      let currentPath = window.location.pathname;
      

      for (let i = 0; i < hypertext.length; i++) {

        let linkPath = hypertext[i].getAttribute('href');
        

        if (currentPath === linkPath) {
          hypertext[i].classList.add('active');
        } else {
          hypertext[i].classList.remove('active');
        }
      }
    };
  

    setActiveLink();
  

    for (let i = 0; i < hypertext.length; i++) {
      hypertext[i].addEventListener('click', function(event) {

        for (let j = 0; j < hypertext.length; j++) {
          hypertext[j].classList.remove('active');
        }

        event.currentTarget.classList.add('active');
      });
    }
  });