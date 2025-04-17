<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_ContactInfo {
    private $opciones = [
        'superadmin_email' => 'email',
        'superadmin_whatsapp' => 'text',
        'superadmin_titulo' => 'text',
        'superadmin_redes_sociales' => 'text', // Podrías usar JSON o array serializado
        'superadmin_info_contacto' => 'text',
    ];

    public function __construct() {
        add_action('admin_post_guardar_contact_info', [$this, 'guardar_opciones']);
    }

    public function guardar_opciones() {
        // Verificar seguridad
        SuperAdmin_Seguridad::verificar_request('guardar_contact_info');

        foreach ($this->opciones as $key => $tipo) {
            if (isset($_POST[$key])) {
                $valor = SuperAdmin_Seguridad::sanitizar_dato($_POST[$key], $tipo);
                update_option($key, $valor);
            }
        }

        // Redirigir con mensaje de éxito
        wp_redirect(add_query_arg('message', '1', wp_get_referer()));
        exit;
    }

    /**
     * Obtener valor guardado para mostrar en formulario
     */
    public function obtener_valor($key) {
        return get_option($key, '');
    }
}
