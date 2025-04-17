jQuery(document).ready(function($) {
    let frame;
    $('#emegea-select-logo').on('click', function(e) {
        e.preventDefault();

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media({
            title: 'Seleccionar logo',
            button: {
                text: 'Usar esta imagen'
            },
            multiple: false
        });

        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            $('#emegea_logo_input').val(attachment.url);
            $('#emegea_logo_preview').attr('src', attachment.url).show();
        });

        frame.open();
    });

    $('#emegea-select-bg').on('click', function(e) {
        e.preventDefault();
    
        if (frame) {
            frame.open();
            return;
        }
    
        frame = wp.media({
            title: 'Seleccionar fondo de login',
            button: { text: 'Usar esta imagen' },
            multiple: false
        });
    
        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            $('#emegea_bg_input').val(attachment.url);
        });
    
        frame.open();
    });


    
});
// Función para desplegar/ocultar submenús
document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.emegea-menu-item');

    menuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            if (e.target.tagName.toLowerCase() === 'input') return;

            const parentLi = this.closest('li');
            const submenu = parentLi.querySelector('.emegea-submenu');

            if (submenu) {
                submenu.classList.toggle('visible');
            }
        });
    });
});
