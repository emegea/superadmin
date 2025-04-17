<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_CustomLogin {
    public function __construct() {
        add_action('login_enqueue_scripts', [$this, 'cargar_estilos_login']);
        add_filter('login_headerurl', [$this, 'custom_login_url']);
        add_filter('login_headertitle', [$this, 'custom_login_title']);
        add_action('admin_post_guardar_custom_login', [$this, 'guardar_opciones']);
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
}
