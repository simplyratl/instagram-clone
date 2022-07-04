$(document).on('click', '#edit-btn', (e) => {
    e.preventDefault();
    const data_id = e.target.getAttribute('data-id');

    if (document.querySelector(`[data-post-settings='${data_id}']`).classList.contains('active')) {
        document.querySelector(`[data-post-settings='${data_id}']`).classList.remove('active');
        return;
    }

    $('#post-actions.active').removeClass('active');
    document.querySelector(`[data-post-settings='${data_id}']`).classList.toggle('active');
});

$(document).on('click', '#close-edit', (e) => {
    e.preventDefault();

    $('#post-edit').remove();
});
