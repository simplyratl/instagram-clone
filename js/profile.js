//POST OPEN UPDATE FUNKCIONALNOST
$(document).on('click', '#change-profile', function (e) {
    e.preventDefault();
    const id = $(this).attr('data-id');

    $.ajax({
        url: '../pages/function/profile/open_edit_profile.php',
        type: 'POST',
        data: { id: id },
        success: (data) => {
            $('body').append(data);
        },
    });
});

$(document).on('click', '#close', function (e) {
    e.preventDefault();

    $('#profile-edit').remove();
});

$(document).on('click', '#edit-post-btn', function (e) {
    e.preventDefault();
    const id = $('#id').val();
    const oldUsername = window.location.search.split('username=')[1];
    const username = $('#username').val();
    const email = $('#email').val();
    const name = $('#name').val();
    const image_name = $('#image').prop('files')[0];

    const password = $('#password').val();

    if (image_name?.name) {
        const image = $('#image').prop('files')[0];
        let formData = new FormData();
        formData.append('formData', image);

        $.ajax({
            url: '../pages/function/profile/update_profile_pic.php',
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            success: function (data) {
                alert(data);
            },
        });
    }

    $.ajax({
        url: '../pages/function/profile/edit_profile.php',
        type: 'POST',
        data: {
            id: id,
            username: username,
            email: email,
            name: name,
            image: image_name?.name,
            password: password,
            originalUsername: oldUsername,
        },
        success: (data) => {
            $('#profile-edit').remove();

            setTimeout(() => {
                $('#notification').remove();
            }, 3000);

            $('body').append(
                '<div class="success notification" id="notification"><h4>Post updated succesfully.</h4></div>'
            );

            setTimeout(() => {
                $('#notification').addClass('delete');
            }, 2800);

            setTimeout(() => {
                $('#notification').remove();
            }, [3000]);

            window.location.assign(`/instagram/pages/profile.php?username=${username}`);
        },
    });
});
