<div class="emegea-wrap">
    <div id="logo">
        <img src="https://www.emegea.ar/iso-blanco.svg" alt="EMEGEA">            
        <h1>emegea Superadmin</h1>
    </div>
    <?php if (isset($_GET['status'])): ?>
    <div class="notice notice-success is-dismissible">
        <p>¡Ajustes guardados correctamente!</p>
    </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" id="main">
        <input type="hidden" name="action" value="emegea_save_menu_options">
        <?php wp_nonce_field('emegea_superadmin_save_settings', 'emegea_superadmin_settings_nonce'); ?>
        <div class="contenido">
            <div class="columnaUno">
                <div id="redesSociales">
                    <h2>+ Redes Sociales</h2>
                    <?php
                    $socials = [
                        'whatsapp' => 'WhatsApp',
                        'instagram' => 'Instagram',
                        'facebook' => 'Facebook',
                        'youtube' => 'YouTube',
                        'tiktok' => 'TikTok',
                    ];
                    foreach ($socials as $key => $label) {
                        $val = get_option("emegea_{$key}", '');
                        echo "<p><label>{$label}: <input type='text' name='emegea_{$key}' value='{$val}' /></label></p>";
                    }
                    ?>
                </div>
            </div>
            <div class="columnaDos">
                <div id="login">
                    <h2>+ Personalización del Login</h2>
                    <div>
                        <p>Logo del login:</p>
                        <input
                            type="text"
                            id="emegea_logo_input"
                            name="emegea_logo"
                            value="<?php echo esc_url(get_option('emegea_logo')); ?>"
                        />
                        <button id="emegea-select-logo" class="button">Seleccionar imagen</button>
                        <?php if (get_option('emegea_logo')): ?>
                            <img id="emegea_logo_preview" src="<?php echo esc_url(get_option('emegea_logo')); ?>" style="max-width: 200px; display: block;" />
                        <?php else: ?>
                            <img id="emegea_logo_preview" src="" style="max-width: 200px; display: none;" />
                        <?php endif; ?>
                    </div>
                    <div>
                        <p><label>Color de fondo: <input type="color" name="emegea_login_bg" value="<?php echo get_option('emegea_login_bg', '#ffffff'); ?>" /></label></p>
                    </div>
                    <div>
                        <p>Imagen de fondo:</p>
                        <input
                            type="text"
                            id="emegea_login_bg_img_input"
                            name="emegea_login_bg_img"
                            value="<?php echo esc_url(get_option('emegea_login_bg_img')); ?>"
                        />
                        <button id="emegea-select_login_bg_img" class="button">Seleccionar imagen</button>
                        <?php if (get_option('emegea_login_bg_img')): ?>
                            <img id="emegea_bg_preview" src="<?php echo esc_url(get_option('emegea_login_bg_img')); ?>" style="max-width: 200px; display: block;" />
                        <?php else: ?>
                            <img id="emegea_bg_preview" src="" style="max-width: 200px; display: none;" />
                        <?php endif; ?>
                    </div>
                    <div>
                        <p id="disposicion"><label for="emegea_login_bg_style">Disposición del fondo:</label>
                        <select name="emegea_login_bg_style" id="emegea_login_bg_style">
                            <?php
                            $options = ['cover', 'contain', 'repeat', 'no-repeat', 'repeat-x', 'repeat-y'];
                            $selected = get_option('emegea_login_bg_style', 'cover');
                            foreach ($options as $opt) {
                                echo "<option value='{$opt}' " . selected($opt, $selected, false) . ">{$opt}</option>";
                            }
                            ?>
                        </select>
                        </p>
                    </div>
                    <div>
                        <p><label>Color del botón: <input type="color" name="emegea_login_btn" value="<?php echo get_option('emegea_login_btn', '#1a1a1a'); ?>" /></label></p>
                        <p><label>Texto inferior: <input type="text" name="emegea_login_footer" value="<?php echo get_option('emegea_login_footer', ''); ?>" /></label></p>
                    </div>
                </div>
            </div><!-- .columnaDos -->
                    
            <div class="columnaTres">
                <div id="itemsMenu">
                    <?php
                        global $menu, $submenu;

                        $visible_items = get_option('emegea_visible_menu_items', []);
                        if (!is_array($visible_items)) $visible_items = [];
                    ?>
                    <h2>+ Menú de WordPress
                        <br>
                        <p>(Tildar opciones que se van a mostrar)</p>
                    </h2>

                    <ul class="emegea-menu-list">
                        <?php foreach ($menu as $menu_item):
                            $slug = $menu_item[2];
                            $label = strip_tags($menu_item[0]);
                            $checked = in_array($slug, $visible_items);
                        ?>
                        <li>
                            <div class="emegea-menu-item">
                                <label>
                                    <input 
                                        type="checkbox" 
                                        name="emegea_visible_menu_items[]" 
                                        value="<?= esc_attr($slug); ?>" 
                                        <?= $checked ? 'checked' : ''; ?>
                                    >
                                    <?= esc_html($label); ?>
                                </label>
                            </div>
                            <?php if (isset($submenu[$slug])): ?>
                                <ul class="emegea-submenu">
                                    <?php foreach ($submenu[$slug] as $sub): ?>
                                        <li>
                                            <label>
                                                <input 
                                                    type="checkbox" 
                                                    name="emegea_visible_menu_items[]" 
                                                    value="<?= esc_attr($sub[2]); ?>" 
                                                    <?= in_array($sub[2], $visible_items) ? 'checked' : ''; ?>
                                                >
                                                <?= esc_html(strip_tags($sub[0])); ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- itemsMenu -->
            </div><!-- columnaTres -->
        </div><!-- .contenido -->
        <?php submit_button('Guardar cambios'); ?>
    </form>
</div>
