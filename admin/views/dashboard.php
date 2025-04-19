<?php
if (!defined('ABSPATH')) {
    exit;
}

$contact_info = new SuperAdmin_ContactInfo();
?>

<div id="logo">
    <img src="https://www.emegea.ar/iso-blanco.svg" alt="EMEGEA">
    <h1>emegea Superadmin</h1>
</div>


<div class="wrap superadmin-wrap">
    <?php if (isset($_GET['status'])): ?>
        <div class="notice notice-success is-dismissible">
            <p>¡Ajustes guardados correctamente!</p>
        </div>
    <?php endif; ?>
    <div class="superadmin-columns-container" style="display:flex; gap:20px;">

        <!-- Columna 1 -->
        <div class="superadmin-columnaUno" style="flex:1; border:1px solid #ccc; padding:15px;">
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
                            ?>
                            <div class="extra-social">
                                <input type="text" name="extra_socials[<?php echo $i; ?>][name]" placeholder="Nombre" value="<?php echo esc_attr($social['name']); ?>">
                                <input type="url" name="extra_socials[<?php echo $i; ?>][url]" placeholder="URL" value="<?php echo esc_attr($social['url']); ?>">
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-social-btn" class="button">+ Agregar red social</button>
                <?php submit_button('Guardar Información'); ?>
            </form>
        </div>

        <!-- Columna 2 -->
        <div class="superadmin-columnaDos" style="flex:1; border:1px solid #ccc; padding:15px;">
            <h2>Personalización del Login</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('guardar_custom_login', 'superadmin_nonce'); ?>
                <input type="hidden" name="action" value="guardar_custom_login">
                <!-- Logo del login -->
                <p>
                    <label>Logo del login:</label><br>
                    <img id="login-logo-preview" src="<?php echo esc_url(get_option('superadmin_login_logo_url', '')); ?>" style="max-width:100px;">
                    <input type="hidden" id="superadmin_login_logo_url" name="superadmin_login_logo_url" value="<?php echo esc_attr(get_option('superadmin_login_logo_url', '')); ?>">
                    <button type="button" class="button" id="upload-login-logo">Seleccionar logo</button>
                </p>

                <!-- Imagen de fondo -->
                <p>
                    <label>Imagen de fondo:</label><br>
                    <img id="login-bg-preview" src="<?php echo esc_url(get_option('superadmin_login_bg_url', '')); ?>" style="max-width:100px;">
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
                        foreach ($options as $val => $label) {
                            echo '<option value="'.esc_attr($val).'" '.selected($current, $val, false).'>'.esc_html($label).'</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="superadmin_login_footer_text">Texto inferior:</label><br>
                    <input type="text" id="superadmin_login_footer_text" name="superadmin_login_footer_text" value="<?php echo esc_attr(get_option('superadmin_login_footer_text', '')); ?>" class="regular-text">
                </p>
                <p>
                    <label for="superadmin_login_button_color">Color del botón de login:</label><br>
                    <input type="color" id="superadmin_login_button_color" name="superadmin_login_button_color" value="<?php echo esc_attr(get_option('superadmin_login_button_color', '#2271b1')); ?>">
                </p>
                <?php submit_button('Guardar Personalización Login'); ?>
            </form>
        </div>

        <!-- Columna 3 -->
        <div class="superadmin-columnaTres" style="flex:1; border:1px solid #ccc; padding:15px;">
            <h2>Gestión de Menús por Rol</h2>
            <div class="superadmin-roles-tabs">
                <!-- Pestañas de roles -->
                <ul class="roles-tabs-nav">
                    <?php foreach ($roles as $role_key => $role_info): ?>
                        <li>
                            <a href="#" 
                            class="role-tab-link <?php echo ($role_key === array_key_first($roles)) ? 'active' : ''; ?>" 
                            data-role="<?php echo esc_attr($role_key); ?>">
                                <?php echo esc_html($role_info['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Contenido de cada pestaña -->
                <?php foreach ($roles as $role_key => $role_info): ?>
                    <div class="role-tab-content <?php echo ($role_key === array_key_first($roles)) ? 'active' : ''; ?>" 
                        id="role-tab-<?php echo esc_attr($role_key); ?>">
                        <!-- ... mantén el contenido actual ... -->
                    </div>
                <?php endforeach; ?>
            </div>
        </div><!-- Columna 3 -->

    </div>
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