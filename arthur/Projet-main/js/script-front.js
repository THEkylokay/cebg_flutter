// Gestion du bouton scroll-to-top
document.addEventListener('DOMContentLoaded', function() {
    const scrollToTopButton = document.getElementById('scroll-to-top');
    if (!scrollToTopButton) return; // Protection si le bouton n'existe pas

    // Afficher ou masquer le bouton en fonction du défilement
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollToTopButton.style.display = 'flex';
        } else {
            scrollToTopButton.style.display = 'none';
        }
    });

    // Faire défiler vers le haut lorsque le bouton est cliqué
    scrollToTopButton.addEventListener('click', function() {
        // Ajouter l'animation d'explosion et de folie
        scrollToTopButton.classList.add('explode');
        
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        // Retirer l'animation après qu'elle soit terminée
        setTimeout(() => {
            scrollToTopButton.classList.remove('explode');
        }, 1500);
    });
});
