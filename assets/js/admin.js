jQuery(document).ready(function ($) {
    const SuperAdmin = {
        init: function () {
            this.initContactForm();
            this.initMenuEditor();
        },

        initContactForm: function () {
            $('#superadmin-contact-form').on('submit', function () {
                // Validaciones simples si quieres
                return true;
            });
        },

        initMenuEditor: function () {
            // Aquí podrías agregar lógica para arrastrar/soltar menús, etc.
        }
    };

    SuperAdmin.init();

    // Media Uploader para el logo del login
    $('#upload-login-logo').on('click', function(e){
        e.preventDefault();
        var mediaUploader = wp.media({
            title: 'Seleccionar logo',
            button: { text: 'Usar esta imagen' },
            multiple: false
        });
        mediaUploader.on('select', function(){
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#superadmin_login_logo_url').val(attachment.url);
            $('#login-logo-preview').attr('src', attachment.url);
        });
        mediaUploader.open();
    });

    // Media Uploader para la imagen de fondo
    $('#upload-login-bg').on('click', function(e){
        e.preventDefault();
        var bgUploader = wp.media({
            title: 'Seleccionar imagen de fondo',
            button: { text: 'Usar esta imagen' },
            multiple: false
        });
        bgUploader.on('select', function(){
            var attachment = bgUploader.state().get('selection').first().toJSON();
            $('#superadmin_login_bg_url').val(attachment.url);
            $('#login-bg-preview').attr('src', attachment.url);
        });
        bgUploader.open();
    });

    
    // Tabs para roles
        // Mostrar el primer tab al cargar
        $('.role-tab-content').first().addClass('active');
    
        // Manejar clicks en los tabs
        $('.role-tab-link').on('click', function(e) {
            e.preventDefault();
            const role = $(this).data('role');
            
            // Remover clase 'active' de todos los tabs y contenidos
            $('.role-tab-link, .role-tab-content').removeClass('active');
            
            // Agregar clase 'active' al tab y contenido clickeado
            $(this).addClass('active');
            $('#role-tab-' + role).addClass('active');
        });

        // Para que los submenús se desplieguen al hacer clic en el ítem padre (sin botón extra):
        $('.parent-menu-item.has-children .menu-parent-label').on('click', function() {
            $(this).closest('.parent-menu-item').find('.superadmin-submenu-list').slideToggle();
            $(this).find('.toggle-icon').text(function(_, text) {
                return text === '▶' ? '▼' : '▶';
            });
        });


});


