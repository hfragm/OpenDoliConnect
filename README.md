OpenDoliConnect

🔗 Connecteur gratuit & open source entre WordPress (WooCommerce) et Dolibarr ERP/CRM

Développé par Asgard Hosting et Helptech Informatique

🌍 Présentation

OpenDoliConnect est un plugin WordPress permettant de synchroniser facilement WooCommerce et Dolibarr.
L’objectif est de centraliser la gestion des produits, commandes, clients, factures et expéditions tout en gardant une cohérence entre la boutique en ligne et l’ERP.

OpenDoliConnect vise à offrir une solution gratuite, open source et communautaire, alternative aux connecteurs payants, pour aider TPE/PME à automatiser leurs flux sans surcoût.

⚙️ Fonctionnalités principales (MVP)

🔄 Synchronisation Produits : catalogue, prix, stock, images.

👥 Synchronisation Clients : création & mise à jour automatiques.

🛒 Commandes WooCommerce → Dolibarr : lignes produits, remises, frais de port, taxes.

🧾 Factures : génération dans Dolibarr avec retour numéro & PDF vers WooCommerce.

📦 Expéditions & Tracking : gestion des BL et suivi transporteur.

📊 Stocks : décrémentation côté Dolibarr et mise à jour automatique dans WooCommerce.

🔐 Sécurité : authentification par token API Dolibarr, capacités WP dédiées.

🛠️ Logs & files d’attente pour fiabilité et reprise sur erreur.

📌 Fonctionnalités avancées prévues

📅 Module optionnel OpenDoliSchedule pour la gestion des échéanciers de paiement.

💶 Multi-tarifs et listes de prix (Dolibarr ↔ rôles WooCommerce).

🧩 Compatibilité avec produits variables et bundles.

📍 Multi-entrepôts et lots/numéros de série.

📈 Dashboard de suivi (ventes, stocks, impayés).

🔔 Webhooks & notifications temps réel.

🛠️ Stack technique

WordPress 6.5+ / WooCommerce 8+

Dolibarr 17+ (via API REST)

PHP 8.1+

Architecture orientée services, mapping bi-directionnel configurable.

🤝 Contribution

Ce projet est open source sous licence GPLv3.
Toutes les contributions (issues, pull requests, idées) sont les bienvenues pour enrichir et fiabiliser le connecteur.

📄 Roadmap initiale

🎬 Setup plugin & client API Dolibarr.

📦 Sync Produits & Stocks.

👥 Sync Clients.

🛒 Commandes & Factures.

📦 Expéditions & Tracking.

🧾 Échéancier (OpenDoliSchedule).

👉 Avec OpenDoliConnect, votre boutique WooCommerce et votre ERP Dolibarr fonctionnent enfin main dans la main, sans coût supplémentaire.