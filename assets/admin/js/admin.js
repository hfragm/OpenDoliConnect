// OpenDoliConnect - Admin JS
document.addEventListener('DOMContentLoaded', () => {
    console.log('OpenDoliConnect admin script loaded');

    // Bouton de test de connexion (si présent sur la page)
    const buttons = document.querySelectorAll('.odc-test-connection');
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            alert('Test de connexion à Dolibarr lancé (simulation).');
        });
    });
});
