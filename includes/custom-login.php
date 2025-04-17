<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_CustomLogin {
    public function __construct() {
        add_action('login_enqueue_scripts', [$this, 'cargar_estilos_login']);
        add_filter('login_headerurl', [$this, 'custom_login_url']);
        add_filter('login_headertitle', [$this, 'custom_login_title']);
    }

    public function cargar_estilos_login() {
        wp_enqueue_style('superadmin-login-style', SUPERADMIN_URL . 'assets/css/login.css', [], '1.0');
    }

    public function custom_login_url() {
        return home_url();
    }

    public function custom_login_title() {
        return get_bloginfo('name');
    }

    public function guardar_opciones() {
        SuperAdmin_Seguridad::verificar_request('guardar_custom_login');
    
        $fields = [
            'superadmin_login_logo_url'       => 'url',
            'superadmin_login_bg_url'         => 'url',
            'superadmin_login_bg_color'       => 'color',
            'superadmin_login_bg_disposition' => 'text',
            'superadmin_login_footer_text'    => 'text',
            'superadmin_login_button_color'   => 'color',
        ];
    
        foreach ($fields as $key => $type) {
            if (isset($_POST[$key])) {
                $value = $_POST[$key];
                switch ($type) {
                    case 'url':
                        $value = esc_url_raw($value);
                        break;
                    case 'color':
                        $value = sanitize_hex_color($value);
                        break;
                    default:
                        $value = sanitize_text_field($value);
                }
                update_option($key, $value);
            }
        }
        wp_redirect(add_query_arg('message', '1', wp_get_referer()));
        exit;
    }
    
}
