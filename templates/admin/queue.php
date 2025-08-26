<div class="wrap">
    <h1><?php esc_html_e("File d'attente OpenDoliConnect', 'opendoliconnect"); ?></h1>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th><?php esc_html_e('ID', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Type', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Statut', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Tentatives', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Disponible le', 'opendoliconnect'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($jobs)) : ?>
                <?php foreach ($jobs as $job) : ?>
                    <tr>
                        <td><?php echo esc_html($job['id']); ?></td>
                        <td><?php echo esc_html($job['type']); ?></td>
                        <td><?php echo esc_html($job['status']); ?></td>
                        <td><?php echo esc_html($job['attempts']); ?>/<?php echo esc_html($job['max_attempts']); ?></td>
                        <td><?php echo esc_html($job['available_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="5"><?php esc_html_e("Aucun job en file d'attente', 'opendoliconnect"); ?></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
