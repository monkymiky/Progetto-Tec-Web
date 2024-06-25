document.addEventListener('DOMContentLoaded', function () {
    // Riferimenti agli elementi
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    const breadcrumb = document.getElementById('breadcrumb'); 
    var x = window.matchMedia("(max-width: 520px)");
    const dropdownButton = document.getElementById('dropdown_button');
    
    // Controlla se gli elementi esistono prima di aggiungere event listeners
    if (menuToggle && menu && breadcrumb) {
        menuToggle.addEventListener('click', function () {
            menu.classList.toggle('active');
            breadcrumb.classList.toggle('active');
            if (menuToggle.getAttribute("aria-expanded") == "false") {
                menuToggle.setAttribute("aria-expanded", "true"); 
            } else {
                menuToggle.setAttribute("aria-expanded", "false"); 
            }
        });
    } else {
        console.error("menuToggle, menu, o breadcrumb non trovati nel DOM.");
    }

    if (dropdownButton) {
        if (x.matches) { // Se la media query corrisponde
            dropdownButton.setAttribute("aria-expanded", "true"); 
        }

        dropdownButton.addEventListener('click', function () {
            if (!x.matches) {
                if (dropdownButton.getAttribute("aria-expanded") == "false") {
                    dropdownButton.setAttribute("aria-expanded", "true"); 
                } else {
                    dropdownButton.setAttribute("aria-expanded", "false"); 
                }
            }
        });
    } else {
        console.error("dropdownButton non trovato nel DOM.");
    }
});
