document.getElementById('pet-button').addEventListener('click', function() {
    const dogImage = document.getElementById('dog-image');
    dogImage.classList.add('petting');
    
    dogImage.addEventListener('animationend', function() {
        dogImage.classList.remove('petting');
    }, { once: true });
});
