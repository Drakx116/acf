jQuery(document).ready(() => {
    const url = window.location.origin + '/wp-admin/admin-ajax.php';

    const form = jQuery('#form-contact')

    form.submit(e => {
        e.preventDefault();

        jQuery.post({
            url: url,
            data: {
                'action': 'send_contact_form',
                'form': form.serializeArray()
            }})
        .done(response => {
            jQuery('#contact-response').text((!response.success) ? response.data.error : response.data.message );
        })
    });
})


