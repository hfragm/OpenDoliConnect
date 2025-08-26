# Migrations OpenDoliConnect

Ces scripts créent et mettent à jour les tables nécessaires au plugin.

## Tables
- `wp_odc_jobs` : file d'attente des tâches (queue)
- `wp_odc_logs` : journaux structurés
- `wp_odc_maps` : correspondances WP ↔ Dolibarr
- `wp_odc_schedules` : miroir de lecture des échéanciers (optionnel)

## Utilisation
Exécuter `dbDelta()` avec le contenu de chaque migration (incluses à l'activation du plugin).
