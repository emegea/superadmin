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
        <div class="superadmin-columnaUno">
            <h2>Redes Sociales y Contacto</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_contact_info', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_contact_info">

                <p>
                    <label for="superadmin_whatsapp">Whatsapp:</label><br>
                    <input type="text" id="superadmin_whatsapp" name="superadmin_whatsapp" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_whatsapp')); ?>" class="regular-text">
                </p>
                <p>
                    <label for="superadmin_instagram">Instagram:</label><br>
                    <input type="url" id="superadmin_instagram" name="superadmin_instagram" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_instagram')); ?>" class="regular-text">
                </p>
                <p>
                    <label for="superadmin_facebook">Facebook:</label><br>
                    <input type="url" id="superadmin_facebook" name="superadmin_facebook" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_facebook')); ?>" class="regular-text">
                </p>
                <p>
                    <label for="superadmin_youtube">YouTube:</label><br>
                    <input type="url" id="superadmin_youtube" name="superadmin_youtube" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_youtube')); ?>" class="regular-text">
                </p>
                <p>
                    <label for="superadmin_tiktok">TikTok:</label><br>
                    <input type="url" id="superadmin_tiktok" name="superadmin_tiktok" value="<?php echo esc_attr($contact_info->obtener_valor('superadmin_tiktok')); ?>" class="regular-text">
                </p>

                <div id="superadmin-extra-socials">
                    <?php
                    $extra_socials = get_option('superadmin_extra_socials', []);
                    if (is_array($extra_socials)) {
                        foreach ($extra_socials as $i => $social) {
                            echo '<div class="extra-social">';
                            echo '<input type="text" name="extra_socials['.$i.'][name]" placeholder="Nombre" value="'.esc_attr($social['name']).'">';
                            echo '<input type="url" name="extra_socials['.$i.'][url]" placeholder="URL" value="'.esc_attr($social['url']).'">';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-social-btn" class="button">+ Agregar red social</button>

                <?php submit_button('Guardar Información'); ?>
            </form>
        </div>
        <script>
        jQuery(document).ready(function($){
            $('#add-social-btn').on('click', function(e){
                e.preventDefault();
                var idx = $('#superadmin-extra-socials .extra-social').length;
                $('#superadmin-extra-socials').append(
                    '<div class="extra-social">'+
                    '<input type="text" name="extra_socials['+idx+'][name]" placeholder="Nombre">'+
                    '<input type="url" name="extra_socials['+idx+'][url]" placeholder="URL">'+
                    '</div>'
                );
            });
        });
        </script>


        <!-- Columna 2: Custom Login -->
        <div class="superadmin-columnaDos">
            <h2>Personalización del Login</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_custom_login', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_custom_login">

                <p>
                    <label>Logo del login:</label><br>
                    <img id="login-logo-preview" src="<?php echo esc_url(get_option('superadmin_login_logo_url', '')); ?>" style="max-width:100px; display:block; margin-bottom:10px;">
                    <input type="hidden" id="superadmin_login_logo_url" name="superadmin_login_logo_url" value="<?php echo esc_attr(get_option('superadmin_login_logo_url', '')); ?>">
                    <button type="button" class="button" id="upload-login-logo">Seleccionar logo</button>
                </p>
                <p>
                    <label>Imagen de fondo:</label><br>
                    <img id="login-bg-preview" src="<?php echo esc_url(get_option('superadmin_login_bg_url', '')); ?>" style="max-width:100px; display:block; margin-bottom:10px;">
                    <input type="hidden" id="superadmin_login_bg_url" name="superadmin_login_bg_url" value="<?php echo esc_attr(get_option('superadmin_login_bg_url', '')); ?>">
                    <button type="button" class="button" id="upload-login-bg">Seleccionar imagen de fondo</button>
                </p>
                <p>
                    <label for="superadmin_login_bg_color">Color de fondo:</label><br>
                    <input type="color" id="superadmin_login_bg_color" name="superadmin_login_bg_color" value="<?php echo esc_attr(get_option('superadmin_login_bg_color', '#ffffff')); ?>">
                </p>
                <p>
                    <label for="superadmin_login_bg_disposition">Disposición de fondo:</label><br>
                    <select id="superadmin_login_bg_disposition" name="superadmin_login_bg_disposition">
                        <?php
                        $options = ['cover' => 'Cover', 'contain' => 'Contain', 'repeat' => 'Repeat', 'no-repeat' => 'No Repeat', 'center' => 'Center'];
                        $current = get_option('superadmin_login_bg_disposition', 'cover');
                        foreach($options as $val => $label) {
                            echo '<option value="'.esc_attr($val).'" '.selected($current, $val, false).'>'.esc_html($label).'</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="superadmin_login_footer_text">Texto inferior:</label><br>
                    <input type="text" id="superadmin_login_footer_text" name="superadmin_login_footer_text" value="<?php echo esc_attr(get_option('superadmin_login_footer_text', '')); ?>" class="regular-text">
                </p>

                <?php submit_button('Guardar Personalización Login'); ?>
            </form>
        </div>
        <script>
        jQuery(document).ready(function($){
            var mediaUploader;
            $('#upload-login-logo').on('click', function(e){
                e.preventDefault();
                if (mediaUploader) { mediaUploader.open(); return; }
                mediaUploader = wp.media({
                    title: 'Seleccionar logo',
                    button: { text: 'Usar esta imagen' },
                    multiple: false
                });
                mediaUploader.on('select', function(){
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#superadmin_login_logo_url').val(attachment.url);
                    $('#login-logo-preview').attr('src', attachment.url);
                });
                mediaUploader.open();
            });
            $('#upload-login-bg').on('click', function(e){
                e.preventDefault();
                var bgUploader = wp.media({
                    title: 'Seleccionar imagen de fondo',
                    button: { text: 'Usar esta imagen' },
                    multiple: false
                });
                bgUploader.on('select', function(){
                    var attachment = bgUploader.state().get('selection').first().toJSON();
                    $('#superadmin_login_bg_url').val(attachment.url);
                    $('#login-bg-preview').attr('src', attachment.url);
                });
                bgUploader.open();
            });
        });
        </script>

        <!-- Columna 3: Gestión de Menús -->
        <div class="superadmin-columnaTres">
            <h2>Gestión de Menús por Rol</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_menu_roles', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_menu_roles">

                <?php
                global $wp_roles, $menu, $submenu;
                $roles = $wp_roles->roles;
                foreach ($roles as $role_key => $role_info):
                    $menus_guardados = get_option("superadmin_menus_{$role_key}", []);
                    ?>
                    <fieldset style="margin-bottom:20px;">
                        <legend><strong><?php echo esc_html($role_info['name']); ?></strong></legend>
                        <ul class="superadmin-menu-list">
                            <?php
                            foreach ($menu as $item) {
                                $slug = $item[2];
                                $name = strip_tags($item[0]);
                                if ($slug === 'index.php') continue; // Opcional: omitir escritorio
                                ?>
                                <li>
                                    <label>
                                        <input type="checkbox" name="menus_roles[<?php echo esc_attr($role_key); ?>][]" value="<?php echo esc_attr($slug); ?>" <?php checked(in_array($slug, $menus_guardados)); ?>>
                                        <?php echo esc_html($name); ?>
                                    </label>
                                    <?php
                                    if (!empty($submenu[$slug])) {
                                        echo '<ul class="superadmin-submenu-list" style="display:none;">';
                                        foreach ($submenu[$slug] as $subitem) {
                                            $subslug = $subitem[2];
                                            $subname = strip_tags($subitem[0]);
                                            ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox" name="menus_roles[<?php echo esc_attr($role_key); ?>][]" value="<?php echo esc_attr($subslug); ?>" <?php checked(in_array($subslug, $menus_guardados)); ?>>
                                                    <?php echo esc_html($subname); ?>
                                                </label>
                                            </li>
                                            <?php
                                        }
                                        echo '</ul>';
                                        echo '<button type="button" class="toggle-submenu button-link">Mostrar/Ocultar submenú</button>';
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </fieldset>
                <?php endforeach; ?>

                <?php submit_button('Guardar Configuración de Menús'); ?>
            </form>
        </div>
        <script>
        jQuery(document).ready(function($){
            $('.toggle-submenu').on('click', function(e){
                e.preventDefault();
                $(this).prev('.superadmin-submenu-list').slideToggle();
            });
        });
        </script>

    </div>
</div>
