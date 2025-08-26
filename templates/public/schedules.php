<div class="odc-schedules">
    <h2><?php esc_html_e('Échéancier de paiement', 'opendoliconnect'); ?></h2>
    <table>
        <thead>
            <tr>
                <th><?php esc_html_e('Date', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Montant', 'opendoliconnect'); ?></th>
                <th><?php esc_html_e('Statut', 'opendoliconnect'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($schedules)) : ?>
                <?php foreach ($schedules as $s) : ?>
                    <tr>
                        <td><?php echo esc_html($s['due_date']); ?></td>
                        <td><?php echo esc_html(number_format($s['amount'], 2)); ?> €</td>
                        <td><?php echo esc_html($s['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="3"><?php esc_html_e('Aucune échéance disponible', 'opendoliconnect'); ?></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
