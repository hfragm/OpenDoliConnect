// OpenDoliConnect - Public JS
document.addEventListener('DOMContentLoaded', () => {
    console.log('OpenDoliConnect public script loaded');

    // Exemple : mise en surbrillance automatique des échéances en retard
    const rows = document.querySelectorAll('.odc-schedules tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('td:last-child');
        if (statusCell && statusCell.textContent.toLowerCase().includes('retard')) {
            row.style.backgroundColor = '#ffe5e5'; // léger fond rouge
        }
    });
});
