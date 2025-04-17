<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_Seguridad {
    public function __construct() {
        // Aquí podrías añadir hooks relacionados con seguridad si quieres
    }

    /**
     * Verificar nonce y capacidad del usuario
     */
    public static function verificar_request($nonce_action, $nonce_field = 'superadmin_nonce') {
        if (
            !isset($_POST[$nonce_field]) ||
            !wp_verify_nonce($_POST[$nonce_field], $nonce_action) ||
            !current_user_can('manage_options')
        ) {
            wp_die(__('No tienes permisos para realizar esta acción.', 'superadmin'));
        }
    }

    /**
     * Función para sanitizar datos antes de guardar
     */
    public static function sanitizar_dato($dato, $tipo = 'text') {
        switch ($tipo) {
            case 'email':
                return sanitize_email($dato);
            case 'url':
                return esc_url_raw($dato);
            case 'int':
                return intval($dato);
            default:
                return sanitize_text_field($dato);
        }
    }
}
