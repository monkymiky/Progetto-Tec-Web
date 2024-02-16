document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');
    const bradcrumb = document.getElementById('breadcrumb');

    menuToggle.addEventListener('click', function () {
        menu.classList.toggle('active');
        bradcrumb.classList.toggle('active');
        const element = document.getElementById('prestazioni');
        if(element.getAttribute("aria-expanded") == "false") element.setAttribute("aria-expanded", "true"); 
        else element.setAttribute("aria-expanded", "false"); 
    });
    
});