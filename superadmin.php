<?php
/*
Plugin Name: SuperAdmin
Description: Plugin para configuraciones iniciales en WordPress.
Version: 1.0
Author: EMEGEA
*/

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes para rutas
define('SUPERADMIN_PATH', plugin_dir_path(__FILE__));
define('SUPERADMIN_URL', plugin_dir_url(__FILE__));

// Cargar clases necesarias
require_once SUPERADMIN_PATH . 'includes/class-seguridad.php';
require_once SUPERADMIN_PATH . 'includes/contact-info.php';
require_once SUPERADMIN_PATH . 'includes/custom-login.php';
require_once SUPERADMIN_PATH . 'includes/menu-manager.php';
require_once SUPERADMIN_PATH . 'includes/class-api.php';
$superadmin_api = new SuperAdmin_API();

// Inicializar clases y hooks
add_action('plugins_loaded', function () {
    // Seguridad
    $seguridad = new SuperAdmin_Seguridad();

    // Configuración Contact Info (columna 1)
    $contact_info = new SuperAdmin_ContactInfo();

    // Custom Login (columna 2)
    $custom_login = new SuperAdmin_CustomLogin();

    // Gestión de Menús (columna 3)
    $menu_manager = new SuperAdmin_MenuManager();
});

// Encolar scripts y estilos admin
function superadmin_enqueue_admin_assets($hook) {
    // Solo cargar en página del plugin (ajusta 'toplevel_page_superadmin' si cambias slug)
    if ($hook !== 'toplevel_page_superadmin') {
        return;
    }

    wp_enqueue_style('superadmin-admin-style', SUPERADMIN_URL . 'assets/css/admin.css', [], '1.0');
    wp_enqueue_script('superadmin-admin-js', SUPERADMIN_URL . 'assets/js/admin.js', ['jquery'], '1.0', true);
}
add_action('admin_enqueue_scripts', 'superadmin_enqueue_admin_assets');

// Añadir menú en admin
function superadmin_add_admin_menu() {
    add_menu_page(
        'SuperAdmin',
        'SuperAdmin',
        'manage_options',
        'superadmin',
        'superadmin_render_admin_page',
        'dashicons-admin-generic',
        2
    );
}
add_action('admin_menu', 'superadmin_add_admin_menu');

// Renderizar vista admin
function superadmin_render_admin_page() {
    include SUPERADMIN_PATH . 'admin/views/dashboard.php';
}
