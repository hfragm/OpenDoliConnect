<?php
/**
 * Définition des capacités OpenDoliConnect
 */

return [
    'manage_opendoliconnect' => [
        'label' => 'Gérer OpenDoliConnect',
        'roles' => ['administrator']
    ],
    'view_opendoliconnect_logs' => [
        'label' => 'Voir les journaux OpenDoliConnect',
        'roles' => ['administrator']
    ],
    'sync_opendoliconnect' => [
        'label' => 'Lancer une synchronisation',
        'roles' => ['administrator', 'shop_manager']
    ]
];
