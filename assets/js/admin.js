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
        
});