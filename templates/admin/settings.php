<div class="wrap">
    <h1><?php esc_html_e('Paramètres OpenDoliConnect', 'opendoliconnect'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('odc_settings');
        do_settings_sections('opendoliconnect');
        submit_button();
        ?>
    </form>
</div>
