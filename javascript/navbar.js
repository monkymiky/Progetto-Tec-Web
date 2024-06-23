document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    const breadcrumb = document.getElementById('breadcrumb'); 
    var x = window.matchMedia("(max-width: 520px)");
    const dropdownButton = document.getElementById('dropdown_button');
    
    menuToggle.addEventListener('click', function () {
        menu.classList.toggle('active');
        breadcrumb.classList.toggle('active');
        if(menuToggle.getAttribute("aria-expanded") == "false") menuToggle.setAttribute("aria-expanded", "true"); 
            else menuToggle.setAttribute("aria-expanded", "false"); 
    });

    
    if (x.matches) { // If media query matches
        dropdownButton.setAttribute("aria-expanded", "true"); 
    }

    dropdownButton.addEventListener('click', function () {
        if (!x.matches){
            if(dropdownButton.getAttribute("aria-expanded") == "false") dropdownButton.setAttribute("aria-expanded", "true"); 
            else dropdownButton.setAttribute("aria-expanded", "false"); 
          }
        
    });
    
        
});