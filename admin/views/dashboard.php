<?php
if (!defined('ABSPATH')) {
    exit;
}

// Instanciar clases para obtener datos
$contact_info = new SuperAdmin_ContactInfo();
?>

<div class="wrap superadmin-wrap">
    <h1>Configuraciones SuperAdmin</h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <?php
                switch ($_GET['message']) {
                    case '1':
                        echo 'Información de contacto guardada correctamente.';
                        break;
                    case '2':
                        echo 'Configuración de menús guardada correctamente.';
                        break;
                }
                ?>
            </p>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('guardar_contact_info', 'superadmin_nonce'); ?>
        <input type="hidden" name="action" value="guardar_contact_info">

        <h2>Información de Contacto</h2>
        <table class="form-table">
            <tr>
                <th><label for="superadmin_email">Email</label></th>
                <td><input type="email" id="superadmin_email" name="superadmin_email" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_email')); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="superadmin_whatsapp">Whatsapp</label></th>
                <td><input type="text" id="superadmin_whatsapp" name="superadmin_whatsapp" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_whatsapp')); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="superadmin_titulo">Título</label></th>
                <td><input type="text" id="superadmin_titulo" name="superadmin_titulo" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_titulo')); ?>" class="regular-text"></td>
            </tr>
            <!-- Agrega más campos según necesidad -->
        </table>

        <?php submit_button('Guardar Información'); ?>
    </form>

    <!-- Aquí podrías incluir formularios para login y menús -->
</div>
