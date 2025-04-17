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

    <div class="superadmin-columns-container" style="display:flex; gap:20px;">
        <!-- Columna 1: Información de contacto -->
        <div class="superadmin-columnaUno" style="flex:1; border:1px solid #ccc; padding:15px;">
            <h2>Redes Sociales y Contacto</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_contact_info', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_contact_info">

                <p>
                    <label for="superadmin_email">Email:</label><br>
                    <input type="email" id="superadmin_email" name="superadmin_email" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_email')); ?>" class="regular-text">
                </p>

                <p>
                    <label for="superadmin_whatsapp">Whatsapp:</label><br>
                    <input type="text" id="superadmin_whatsapp" name="superadmin_whatsapp" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_whatsapp')); ?>" class="regular-text">
                </p>

                <p>
                    <label for="superadmin_titulo">Título:</label><br>
                    <input type="text" id="superadmin_titulo" name="superadmin_titulo" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_titulo')); ?>" class="regular-text">
                </p>

                <!-- Agrega más campos según tu necesidad -->

                <?php submit_button('Guardar Información'); ?>
            </form>
        </div>

        <!-- Columna 2: Custom Login -->
        <div class="superadmin-columnaDos" style="flex:1; border:1px solid #ccc; padding:15px;">
            <h2>Personalización del Login</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_custom_login', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_custom_login">

                <p>
                    <label for="superadmin_login_logo_url">URL Logo Login:</label><br>
                    <input type="url" id="superadmin_login_logo_url" name="superadmin_login_logo_url" value="<?php echo esc_attr(get_option('superadmin_login_logo_url', '')); ?>" class="regular-text">
                </p>

                <p>
                    <label for="superadmin_login_background_color">Color Fondo Login:</label><br>
                    <input type="color" id="superadmin_login_background_color" name="superadmin_login_background_color" value="<?php echo esc_attr(get_option('superadmin_login_background_color', '#ffffff')); ?>">
                </p>

                <?php submit_button('Guardar Personalización Login'); ?>
            </form>
        </div>

        <!-- Columna 3: Gestión de Menús -->
        <div class="superadmin-columnaTres" style="flex:1; border:1px solid #ccc; padding:15px;">
            <h2>Gestión de Menús por Rol</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_menu_roles', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_menu_roles">

                <?php
                global $wp_roles;
                $roles = $wp_roles->roles;
                foreach ($roles as $role_key => $role_info):
                    $menus_guardados = get_option("superadmin_menus_{$role_key}", []);
                    ?>
                    <fieldset style="margin-bottom:20px;">
                        <legend><strong><?php echo esc_html($role_info['name']); ?></strong></legend>
                        <p>Selecciona los menús visibles para este rol:</p>
                        <?php
                        // Ejemplo simple: lista de menús disponibles (puedes mejorar con menús reales)
                        $menus_disponibles = [
                            'index.php' => 'Escritorio',
                            'edit.php' => 'Entradas',
                            'upload.php' => 'Medios',
                            'edit-comments.php' => 'Comentarios',
                            'themes.php' => 'Apariencia',
                            'plugins.php' => 'Plugins',
                            'users.php' => 'Usuarios',
                            'tools.php' => 'Herramientas',
                            'options-general.php' => 'Ajustes'
                        ];
                        foreach ($menus_disponibles as $slug => $nombre): ?>
                            <label>
                                <input type="checkbox" name="menus_roles[<?php echo esc_attr($role_key); ?>][]" value="<?php echo esc_attr($slug); ?>" <?php checked(in_array($slug, $menus_guardados)); ?>>
                                <?php echo esc_html($nombre); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </fieldset>
                <?php endforeach; ?>

                <?php submit_button('Guardar Configuración de Menús'); ?>
            </form>
        </div>
    </div>
</div>
