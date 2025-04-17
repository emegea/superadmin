<?php
if (!defined('ABSPATH')) {
    exit;
}

class SuperAdmin_ContactInfo {
    private $opciones = [
        'superadmin_whatsapp' => 'text',
        'superadmin_instagram' => 'url',
        'superadmin_facebook' => 'url',
        'superadmin_youtube' => 'url',
        'superadmin_tiktok' => 'url',
    ];

    public function __construct() {
        add_action('admin_post_guardar_contact_info', [$this, 'guardar_opciones']);
    }

    public function guardar_opciones() {
        SuperAdmin_Seguridad::verificar_request('guardar_contact_info');

        // Guardar campos simples
        foreach ($this->opciones as $key => $tipo) {
            if (isset($_POST[$key])) {
                $valor = $this->sanitizar_valor($_POST[$key], $tipo);
                update_option($key, $valor);
            }
        }

        // Guardar redes sociales extra (array de arrays)
        $extra_socials = [];
        if (!empty($_POST['extra_socials']) && is_array($_POST['extra_socials'])) {
            foreach ($_POST['extra_socials'] as $social) {
                $nombre = isset($social['name']) ? sanitize_text_field($social['name']) : '';
                $url = isset($social['url']) ? esc_url_raw($social['url']) : '';
                if ($nombre && $url) {
                    $extra_socials[] = [
                        'name' => $nombre,
                        'url'  => $url
                    ];
                }
            }
        }
        update_option('superadmin_extra_socials', $extra_socials);

        wp_redirect(add_query_arg('message', '1', wp_get_referer()));
        exit;
    }

    public function obtener_valor($key) {
        return get_option($key, '');
    }

    private function sanitizar_valor($valor, $tipo) {
        switch ($tipo) {
            case 'email':
                return sanitize_email($valor);
            case 'url':
                return esc_url_raw($valor);
            case 'int':
                return intval($valor);
            default:
                return sanitize_text_field($valor);
        }
    }
}
