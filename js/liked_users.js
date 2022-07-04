$(document).ready(() => {
    $(document).on('click', '#close-user-likes', (e) => {
        e.preventDefault();

        $('#user-likes-container').html('');
    });
});
