<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_CustomLogin {
    public function __construct() {
        add_action('login_enqueue_scripts', [$this, 'cargar_estilos_login']);
        add_filter('login_headerurl', [$this, 'custom_login_url']);
        add_filter('login_headertitle', [$this, 'custom_login_title']);
        add_action('login_footer', [$this, 'imprimir_texto_inferior']);
        add_action('admin_post_guardar_custom_login', [$this, 'guardar_opciones']);
    }

    public function cargar_estilos_login() {
        // Encolar CSS básico si tienes archivo
        wp_enqueue_style('superadmin-login-style', SUPERADMIN_URL . 'assets/css/login.css', [], '1.0');
        
        // Inyectar CSS dinámico con opciones guardadas
        add_action('login_head', [$this, 'imprimir_css_personalizado']);
    }

    public function custom_login_url() {
        return home_url();
    }

    public function custom_login_title() {
        return get_bloginfo('name');
    }

    public function guardar_opciones() {
        if (!isset($_POST['superadmin_nonce']) || !wp_verify_nonce($_POST['superadmin_nonce'], 'guardar_custom_login')) {
            wp_die('¡Seguridad fallida! Nonce inválido.');
        }

        $login_logo_url = isset($_POST['superadmin_login_logo_url']) ? esc_url_raw($_POST['superadmin_login_logo_url']) : '';
        $login_bg_url = isset($_POST['superadmin_login_bg_url']) ? esc_url_raw($_POST['superadmin_login_bg_url']) : '';
        $login_bg_color = isset($_POST['superadmin_login_bg_color']) ? sanitize_hex_color($_POST['superadmin_login_bg_color']) : '#ffffff';
        $login_bg_disposition = isset($_POST['superadmin_login_bg_disposition']) ? sanitize_text_field($_POST['superadmin_login_bg_disposition']) : 'cover';
        $login_footer_text = isset($_POST['superadmin_login_footer_text']) ? sanitize_text_field($_POST['superadmin_login_footer_text']) : '';
        $login_button_color = isset($_POST['superadmin_login_button_color']) ? sanitize_hex_color($_POST['superadmin_login_button_color']) : '#2271b1';

        update_option('superadmin_login_logo_url', $login_logo_url);
        update_option('superadmin_login_bg_url', $login_bg_url);
        update_option('superadmin_login_bg_color', $login_bg_color);
        update_option('superadmin_login_bg_disposition', $login_bg_disposition);
        update_option('superadmin_login_footer_text', $login_footer_text);
        update_option('superadmin_login_button_color', $login_button_color);

        wp_redirect(admin_url('admin.php?page=superadmin&status=success'));
        exit;
    }

    public function imprimir_css_personalizado() {
        $logo_url = get_option('superadmin_login_logo_url', '');
        $bg_url = get_option('superadmin_login_bg_url', '');
        $bg_color = get_option('superadmin_login_bg_color', '#fff');
        $bg_disposition = get_option('superadmin_login_bg_disposition', 'cover');
        $button_color = get_option('superadmin_login_button_color', '#2271b1');
        ?>
        <style type="text/css">
            body.login {
                background-color: <?php echo esc_attr($bg_color); ?>;
                <?php if ($bg_url): ?>
                background-image: url('<?php echo esc_url($bg_url); ?>');
                background-size: <?php echo esc_attr($bg_disposition); ?>;
                background-repeat: no-repeat;
                background-position: center;
                <?php endif; ?>
            }
            body.login #login h1 a {
                background-image: url('<?php echo esc_url($logo_url); ?>');
                background-size: contain;
                width: 320px;
                height: 65px;
            }
            body.login #login form .button.wp-core-ui {
                background-color: <?php echo esc_attr($button_color); ?>;
                border-color: <?php echo esc_attr($button_color); ?>;
                box-shadow: none;
                text-shadow: none;
            }
            /* Puedes agregar más estilos personalizados aquí */
        </style>
        <?php
    }    
    public function imprimir_texto_inferior() {
        $texto = get_option('superadmin_login_footer_text', '');
        if ($texto) {
            echo '<p class="textoFooter">' . esc_html($texto) . '</p>';
        }
    }
    
}
