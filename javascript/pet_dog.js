// Creo un event listener al pulsante con id pet-button per gestire il click
document.getElementById('pet-button').addEventListener('click', function() {
    // Ottengo l'elemento dell'immagine del cane con l'id dog-image
    const dogImage = document.getElementById('dog-image');
    // Aggiungo la classe petting all'immagine del cane per iniziare l'animazione
    dogImage.classList.add('petting');
    
    // Rimuovo la classe di animazione dopo che l'animazione è terminata
    dogImage.addEventListener('animationend', function() {
        dogImage.classList.remove('petting');
    }, { once: true }); // L'evento listener viene eseguito solo una volta
});
