jQuery(document).ready(function($) {
    $('#aceptar').click(function(e) {
        e.preventDefault();
        $.post(mainjs.ajaxurl, {
            'action': 'terms_accepted',
            'postid': $(this).data('postid')
        }).done(function(data) {
            console.log(data);
            location.href = mainjs.homeurl;
        });
    });
    $('#summary-tac').dialog({
        modal: true,
        buttons: [{
            text: "Cerrar",
            class:"tocclosedialog",
            icons: {
                primary: "ui-icon-close"
            },
            click: function() {
                $(this).dialog("close");
            }
        }]
    });
    $(".ui-dialog-titlebar").hide();
});