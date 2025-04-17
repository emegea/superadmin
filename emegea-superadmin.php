<?php
/*
Plugin Name: SUPERADMIN
Description: Panel personalizado para administrar accesos y opciones específicas del sitio.
Version: 1.0
Author: EMEGEA
*/

if (!defined('ABSPATH')) exit;

// Agrega el panel al admin
add_action('admin_menu', function () {
    add_menu_page('SUPERADMIN', 'SUPERADMIN', 'manage_options', 'emegea-superadmin', 'emegea_superadmin_page');
});

// Carga scripts y estilos solo en la página del plugin
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'toplevel_page_emegea-superadmin') {
        wp_enqueue_media();
        wp_enqueue_script('emegea-admin', plugin_dir_url(__FILE__) . 'assets/js/admin.js', ['jquery'], '1.0', true);
        wp_enqueue_style('emegea-admin-style', plugin_dir_url(__FILE__) . 'assets/css/admin-style.css');
        wp_enqueue_style('emegea-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
    }
});

// Render de la vista del plugin
function emegea_superadmin_page() {
    include plugin_dir_path(__FILE__) . 'admin/view-superadmin.php';
}

// Guarda opciones desde el formulario
add_action('admin_init', 'emegea_superadmin_save_settings');

// Función unificada para guardar TODO
function emegea_superadmin_save_settings() {
    if (isset($_POST['emegea_superadmin_settings_nonce']) && 
        wp_verify_nonce($_POST['emegea_superadmin_settings_nonce'], 'emegea_superadmin_save_settings')) {

        // Guardar customLogin
        update_option('emegea_logo', esc_url_raw($_POST['emegea_logo'] ?? ''));
        update_option('emegea_login_bg_img', esc_url_raw($_POST['emegea_login_bg_img'] ?? ''));
        update_option('emegea_login_bg', sanitize_hex_color($_POST['emegea_login_bg'] ?? ''));
        update_option('emegea_login_bg_style', esc_url_raw($_POST['emegea_login_bg_style'] ?? ''));
        update_option('emegea_login_btn', sanitize_hex_color($_POST['emegea_login_btn'] ?? ''));
        update_option('emegea_login_footer', sanitize_text_field($_POST['emegea_login_footer'] ?? ''));

        // Guardar ítems visibles del menú
        $visible_items = isset($_POST['emegea_visible_menu_items']) ? 
            array_map('sanitize_text_field', $_POST['emegea_visible_menu_items']) : [];
        update_option('emegea_visible_menu_items', $visible_items);

        wp_redirect(admin_url('admin.php?page=emegea-superadmin&status=success'));
        exit;
    }
}

// Shortcode para redes sociales
add_shortcode('emegea_socials', function () {
    $output = '<div class="emegea-socials">';
    $socials = ['whatsapp', 'instagram', 'facebook', 'youtube', 'tiktok'];
    foreach ($socials as $s) {
        $url = esc_url(get_option("emegea_{$s}", ''));
        if ($url) {
            $output .= "<a href='{$url}' target='_blank'><i class='fab fa-{$s}'></i></a> ";
        }
    }
    $output .= '</div>';
    return $output;
});

// Shortcode para logo
add_shortcode('emegea_logo', function () {
    $logo = get_option('emegea_logo');
    return $logo ? "<img src='{$logo}' alt='Logo' class='emegea-logo' />" : '';
});
// Shortcode para imagen de fondo
add_shortcode('emegea_login_bg_img', function () {
    $bg_img = get_option('emegea_login_bg_img');
    return $bg_img ? "'{$bg_img}'" : '';
});
// Shortcode para texto personalizado
add_shortcode('emegea_login_footer', function ($atts) {
    $atts = shortcode_atts(['id' => ''], $atts);
    $val = get_option('emegea_' . sanitize_key($atts['id']), '');
    return esc_html($val);
});
// Shortcode para texto personalizado
add_shortcode('emegea_custom_text', function ($atts) {
    $atts = shortcode_atts(['id' => ''], $atts);
    $val = get_option('emegea_' . sanitize_key($atts['id']), '');
    return esc_html($val);
});


// Personaliza login
add_action('login_enqueue_scripts', function () {
    $bg_color = get_option('emegea_login_bg', '#ffffff');
    $btn_color = get_option('emegea_login_btn', '#1a1a1a');
    $footer = get_option('emegea_login_footer', '');
    $logo = get_option('emegea_logo', '');
    $bg_image = get_option('emegea_login_bg_img', '');
    $bg_style = get_option('emegea_login_bg_style', 'cover');

    echo "<style>
    body.login {
        background-color: {$bg_color} !important;" .
        ($bg_image ? "background-image: url('{$bg_image}');
        background-size: {$bg_style};
        background-repeat: " . ($bg_style === 'repeat' ? 'repeat' : 'no-repeat') . ";
        background-position: center;" : '') .
    "}
    .login #loginform input[type=submit] { background-color: {$btn_color} !important; border: none; }
    .login #login h1 a {
        background-image: url('{$logo}');
        background-size: contain;
        background-position: center;
        width: 100%;
        height: 100px;
    }
    .login #backtoblog, .login #nav { display: none; }
    </style>";

    if ($footer) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            let f = document.createElement('div');
            f.innerHTML = `" . addslashes($footer) . "`;
            f.style.textAlign = 'center';
            f.style.marginTop = '20px';
            document.body.appendChild(f);
        });
        </script>";
    }
});

add_action('admin_menu', 'emegea_ocultar_items_seleccionados', 999);
function emegea_ocultar_items_seleccionados() {
    if (current_user_can('administrator')) return;

    global $menu, $submenu;

    $permitidos = get_option('emegea_visible_menu_items', []);
    if (!is_array($permitidos)) $permitidos = [];

    // Ocultamos menús principales
    foreach ($menu as $item) {
        $slug = $item[2];
        if (!in_array($slug, $permitidos)) {
            remove_menu_page($slug);
        }
    }

    // Ocultamos submenús
    foreach ($submenu as $parent_slug => $subitems) {
        foreach ($subitems as $subitem) {
            $sub_slug = $subitem[2];
            if (!in_array($sub_slug, $permitidos)) {
                remove_submenu_page($parent_slug, $sub_slug);
            }
        }
    }
}