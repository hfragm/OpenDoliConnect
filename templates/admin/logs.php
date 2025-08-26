<div class="wrap">
    <h1><?php esc_html_e('Journaux OpenDoliConnect', 'opendoliconnect'); ?></h1>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th><?php esc_html_e('Date', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Niveau', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Message', 'opendoliconnect'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($logs)) : ?>
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td><?php echo esc_html($log['created_at']); ?></td>
                        <td><?php echo esc_html($log['level']); ?></td>
                        <td><?php echo esc_html($log['message']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="3"><?php esc_html_e('Aucun log disponible', 'opendoliconnect'); ?></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
