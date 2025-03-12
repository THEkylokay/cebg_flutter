// CEBG/js/modal.js

document.addEventListener('DOMContentLoaded', () => {
    // Création du style pour le modal
    const styleSheet = document.createElement('style');
    styleSheet.textContent = `
        .horse-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .horse-modal-content {
            background: rgba(17, 34, 64, 0.95);
            border: 1px solid rgba(100, 255, 218, 0.3);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: translateY(20px);
            transition: transform 0.3s ease-in-out;
        }

        .horse-modal.active {
            opacity: 1;
        }

        .horse-modal.active .horse-modal-content {
            transform: translateY(0);
        }

        .horse-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(100, 255, 218, 0.3);
            background: transparent;
            color: #64ffda;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .horse-modal-close:hover {
            background: rgba(100, 255, 218, 0.1);
            transform: rotate(90deg);
            border-color: #64ffda;
        }

        .horse-modal-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            border: 2px solid rgba(100, 255, 218, 0.2);
        }

        .horse-modal h2 {
            color: #64ffda;
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .horse-modal-info {
            color: #ccd6f6;
            margin: 0.5rem 0;
            font-size: 1.1rem;
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
        }

        .horse-modal-info span {
            color: #64ffda;
        }
    `;
    document.head.appendChild(styleSheet);

    function createModal(card) {
        const modal = document.createElement('div');
        modal.classList.add('horse-modal');
    
        const modalContent = document.createElement('div');
        modalContent.classList.add('horse-modal-content');
    
        // Récupération des informations
        const photos = JSON.parse(card.dataset.photos);
        const chevalName = card.querySelector('h3').textContent;
        const chevalAge = card.querySelector('.age').textContent;
        const chevalRace = card.querySelector('.race').textContent;
        
        let currentPhotoIndex = 0;
    
        // Construction du HTML du modal
        modalContent.innerHTML = `
            <button class="horse-modal-close">×</button>
            <div class="carousel">
                <div class="carousel-images">
                    ${photos.map((photo, index) => `
                        <img src="${photo}" 
                             class="carousel-image" 
                             style="display: ${index === 0 ? 'block' : 'none'}"
                             alt="${chevalName} - Photo ${index + 1}">
                    `).join('')}
                </div>
                ${photos.length > 1 ? `
                    <button class="carousel-button prev">&#10094;</button>
                    <button class="carousel-button next">&#10095;</button>
                ` : ''}
            </div>
            <h2>${chevalName}</h2>
            <div class="horse-modal-info">
                <span>Âge:</span> ${chevalAge}
            </div>
            <div class="horse-modal-info">
                <span>Race:</span> ${chevalRace.replace('Race : ', '')}
            </div>
            <div class="horse-modal-info">
                <span>Garot:</span> ${card.dataset.garot} cm
            </div>
            <div class="horse-modal-info">
                <span>Robe:</span> ${card.dataset.robe}
            </div>
        `;
    
        modal.appendChild(modalContent);
    
        // Gestion des événements après création du modal
        const closeButton = modalContent.querySelector('.horse-modal-close');
        const prevButton = modalContent.querySelector('.prev');
        const nextButton = modalContent.querySelector('.next');
        const images = modalContent.querySelectorAll('.carousel-image');
    
        // Fonction pour changer l'image
        const changeImage = (direction) => {
            images[currentPhotoIndex].style.display = 'none';
            
            if (direction === 'next') {
                currentPhotoIndex = (currentPhotoIndex + 1) % images.length;
            } else {
                currentPhotoIndex = (currentPhotoIndex - 1 + images.length) % images.length;
            }
            
            images[currentPhotoIndex].style.display = 'block';
        };
    
        // Gestionnaires d'événements
        closeButton.onclick = () => {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
        };
    
        if (prevButton && nextButton) {
            prevButton.onclick = (e) => {
                e.stopPropagation();
                changeImage('prev');
            };
    
            nextButton.onclick = (e) => {
                e.stopPropagation();
                changeImage('next');
            };
        }
    
        // Fermeture en cliquant en dehors du modal
        modal.onclick = (e) => {
            if (e.target === modal) {
                closeButton.click();
            }
        };
    
        // Fermeture avec Echap
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeButton.click();
            }
        });
    
        // Animation d'entrée
        requestAnimationFrame(() => {
            modal.classList.add('active');
        });
    
        return modal;
    }
    

    // Gestionnaire de clic pour les cartes
    const cards = document.querySelectorAll('.cheval-card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            const modal = createModal(card);
            document.body.appendChild(modal);
        });
    });
});