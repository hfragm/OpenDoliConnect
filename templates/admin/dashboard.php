<div class="wrap">
    <h1><?php esc_html_e('OpenDoliConnect Dashboard', 'opendoliconnect'); ?></h1>
    <p><?php esc_html_e('Statut de la connexion avec Dolibarr et WooCommerce.', 'opendoliconnect'); ?></p>
    <ul>
        <li><?php esc_html_e('Produits', 'opendoliconnect'); ?> :
            <span class="odc-status-ok"><?php esc_html_e('Synchronisé', 'opendoliconnect'); ?></span></li>
        <li><?php esc_html_e('Clients', 'opendoliconnect'); ?> :
            <span class="odc-status-warning"><?php esc_html_e('En attente', 'opendoliconnect'); ?></span></li>
        <li><?php esc_html_e('Commandes', 'opendoliconnect'); ?> :
            <span class="odc-status-error"><?php esc_html_e('Non configuré', 'opendoliconnect'); ?></span></li>
    </ul>
</div>
