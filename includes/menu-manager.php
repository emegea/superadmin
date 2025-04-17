<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_MenuManager {
    public function __construct() {
        add_action('admin_menu', [$this, 'filtrar_menus_por_rol'], 999);
        add_action('admin_post_guardar_menu_roles', [$this, 'guardar_configuracion']);
    }

    /**
     * Filtra los menús visibles según el rol del usuario
     */
    public function filtrar_menus_por_rol() {
        if (current_user_can('administrator')) {
            return; // Administradores ven todo
        }

        $user = wp_get_current_user();
        $rol = $user->roles[0] ?? '';

        if (!$rol) {
            return;
        }

        $menus_permitidos = get_option("superadmin_menus_{$rol}", []);

        global $menu;
        foreach ($menu as $index => $item) {
            if (!in_array($item[2], $menus_permitidos)) {
                unset($menu[$index]);
            }
        }
    }

    /**
     * Guardar configuración de menús para roles
     */
    public function guardar_configuracion() {
        SuperAdmin_Seguridad::verificar_request('guardar_menu_roles');

        if (!isset($_POST['menus_roles']) || !is_array($_POST['menus_roles'])) {
            wp_die('Datos inválidos');
        }

        foreach ($_POST['menus_roles'] as $rol => $menus) {
            $menus_sanitizados = array_map('sanitize_text_field', $menus);
            update_option("superadmin_menus_{$rol}", $menus_sanitizados);
        }

        wp_redirect(add_query_arg('message', '2', wp_get_referer()));
        exit;
    }
}
