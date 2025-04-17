<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Clase centralizada para operaciones API del plugin SuperAdmin.
 * Puede servir para exponer endpoints REST personalizados o para
 * encapsular el acceso a las opciones del plugin (Options API).
 */
class SuperAdmin_API {

    /**
     * Registro de endpoints personalizados.
     */
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_endpoints']);
    }

    /**
     * Ejemplo de registro de endpoint REST.
     */
    public function register_endpoints() {
        register_rest_route('superadmin/v1', '/info', [
            'methods'  => 'GET',
            'callback' => [$this, 'get_plugin_info'],
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ]);
    }

    /**
     * Callback para el endpoint /info.
     */
    public function get_plugin_info($request) {
        // Devuelve información básica del plugin.
        return [
            'plugin' => 'SuperAdmin',
            'version' => '1.0',
            'author' => 'Tu Nombre'
        ];
    }

    /**
     * Métodos utilitarios para la Options API.
     */
    public static function get_option($key, $default = '') {
        return get_option($key, $default);
    }

    public static function update_option($key, $value) {
        return update_option($key, $value);
    }

    public static function delete_option($key) {
        return delete_option($key);
    }
}
