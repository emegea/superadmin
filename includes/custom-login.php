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
}
