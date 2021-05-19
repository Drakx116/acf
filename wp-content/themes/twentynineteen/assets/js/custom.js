jQuery(document).ready(() => {
    const url = window.location.origin + '/wp-admin/admin-ajax.php';

    sendEmail(url);
    updateList(url);
});

const sendEmail = url => {
    // CONTACT EMAIL
    const form = jQuery('#form-contact');

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
        });
    });
}

const updateList = url => {
    const currentList = jQuery('#main');

    jQuery('body').on('click', '.main-courses-btn', e => {
        e.preventDefault(); // Prevent link propagation
        const button = e.target;
        let page = jQuery(jQuery('#main-courses-list-container')[0]).data('page');

        page += (jQuery(button).hasClass('btn-next')) ? 1 : -1;
        currentList.empty();

        jQuery.post({
            url: url,
            data: {
                'action': 'main_course_update_list',
                'page': page
            }
        })
        .done(response => {
            currentList.html(response);
        });
    })
};

