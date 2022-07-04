const openUserSettings = () => {
    const userPicture = $("#user-avatar");

    userPicture.toggleClass("active");
};

const openAddPost = () => {
    $.ajax({
        url: "../pages/function/post/post_add_open.php",
        type: "POST",
        success: (data) => {
            const addPostModal = $("#add-post-modal");
            addPostModal.addClass("active");
            $("body").append(data);
        },
    });
};

const closeAddPost = () => {
    const addPostModal = $("#add-post-modal");

    addPostModal.remove();
};

$(document).ready(() => {
    const showPosts = () => {
        $.ajax({
            url: "../pages/function/show_posts.php",
            type: "POST",
            success: (data) => {
                $("#posts-container").html(data);
            },
        });
    };

    showPosts();

    //POST OPEN UPDATE FUNKCIONALNOST
    $(document).on("click", "#edit-post", function (e) {
        e.preventDefault();
        const postId = $(this).attr("data-id");

        $.ajax({
            url: "../pages/function/post/post_update_open.php",
            type: "POST",
            data: { id: postId },
            success: (data) => {
                $("body").append(data);
            },
        });
    });

    //POST UPDATE FUNKCIONALNOST
    $(document).on("click", "#edit-post-btn", function (e) {
        e.preventDefault();
        const postId = $("#post-edit").attr("data-id");
        const description = $("#description-edit").val();

        $.ajax({
            url: "../pages/function/post/post_update.php",
            type: "POST",
            data: { id: postId, description: description },
            success: (data) => {
                showPosts();
                $("#post-edit").remove();

                setTimeout(() => {
                    $("#notification").remove();
                }, 3000);

                $("body").append(
                    '<div class="success notification" id="notification"><h4>Post updated succesfully.</h4></div>'
                );

                setTimeout(() => {
                    $("#notification").addClass("delete");
                }, 2800);

                setTimeout(() => {
                    $("#notification").remove();
                }, [3000]);
            },
        });
    });

    //POST ADD FUNKCIONALNOST
    $(document).on("click", "#share", function (e) {
        e.preventDefault();
        const description = $("#description").val();
        const image_name = $("#post-image").prop("files")[0];

        if (image_name?.name) {
            const image = $("#post-image").prop("files")[0];
            let formData = new FormData();
            formData.append("formData", image);

            $.ajax({
                url: "../pages/function/post/add_post_pic.php",
                type: "POST",
                processData: false,
                contentType: false,
                dataType: "json",
                data: formData,
            });
        }

        $.ajax({
            url: "../pages/function/post/add_post.php",
            type: "POST",
            data: {
                image: image_name?.name,
                description: description,
            },
            success: () => {
                showPosts();
                const addPostModal = $("#add-post-modal");
                addPostModal.remove();

                setTimeout(() => {
                    $("#notification").remove();
                }, 3000);

                $("body").append(
                    '<div class="success notification" id="notification"><h4>Post added succesfully.</h4></div>'
                );

                setTimeout(() => {
                    $("#notification").addClass("delete");
                }, 2800);

                setTimeout(() => {
                    $("#notification").remove();
                }, [3000]);
            },
        });
    });

    //POST DELETE FUNKCIONALNOST
    $(document).on("click", "#delete-post", function (e) {
        e.preventDefault();

        const postID = $(this).attr("data-id");

        $.ajax({
            url: "../pages/function/post/post_delete.php",
            type: "POST",
            data: { id: postID },
            success: (data) => {
                if (data === "deleted") {
                    showPosts();

                    setTimeout(() => {
                        $("#notification").remove();
                    }, 3000);

                    $("body").append(
                        '<div class="success notification" id="notification"><h4>Post deleted.</h4></div>'
                    );

                    setTimeout(() => {
                        $("#notification").addClass("remove");

                        setTimeout(() => {
                            $("#notification").remove();
                        }, [200]);
                    }, 3000);
                } else {
                    setTimeout(() => {
                        $("#notification").remove();
                    }, 3000);

                    $("body").append(
                        '<div class="error notification" id="notification"><h4>You cant delete post that is not made by you.</h4></div>'
                    );

                    setTimeout(() => {
                        $("#notification").addClass("remove");

                        setTimeout(() => {
                            $("#notification").remove();
                        }, [200]);
                    }, 3000);
                }
            },
        });
    });

    //LIKE FUNKCIONALNOST
    $(document).on("click", "#likeBtn", function (e) {
        e.preventDefault();
        const postId = $(this).attr("data-id");

        $.ajax({
            url: "../pages/function/likes.php",
            type: "POST",
            data: { post_id: postId },
            success: (data) => {
                showPosts();
            },
        });
    });

    //DOUBLE CLICK LIKE FUNKCIONALNOST
    $(document).on("dblclick", "#post-image-main", function (e) {
        e.preventDefault();

        const postId = $(this).attr("data-id");

        $.ajax({
            url: "../pages/function/likes.php",
            type: "POST",
            data: { post_id: postId },
            success: (data) => {
                setTimeout(() => {
                    showPosts();
                }, 200);
                const data_id = e.target.getAttribute("data-id");

                document.querySelector(`[data-liked='${data_id}']`).classList.add("active");
            },
        });
    });

    //COMMENT ADD FUNKCIONALNOST
    $(document).on("click", "#post-comment", function (e) {
        e.preventDefault();

        const postId = $(this).attr("data-id");
        const commentText = $(`#comment-user${postId}`).val();

        if (commentText.length > 0) {
            $.ajax({
                url: "../pages/function/comments/addcomment.php",
                type: "POST",
                data: { post_id: postId, comment: commentText },
                success: (data) => {
                    $("#comment-section-display").append(data);
                    $(`#comment-user${postId}`).val("");

                    showPosts();

                    setTimeout(() => {
                        $("#notification").remove();
                    }, 3000);

                    $("body").append(
                        '<div class="success notification" id="notification"><h4>Comment added succesfully.</h4></div>'
                    );

                    setTimeout(() => {
                        $("#notification").addClass("remove");

                        setTimeout(() => {
                            $("#notification").remove();
                        }, [200]);
                    }, 3000);
                },
            });
        } else {
            alert("You have to type characters to post a comment.");
        }
    });

    //COMMENT REMOVE FUNKCIONALNOST
    $(document).on("click", "#remove-comment", function (e) {
        e.preventDefault();

        const commentId = $(this).attr("data-id");

        $.ajax({
            url: "../pages/function/comments/deletecomment.php",
            type: "POST",
            data: { id: commentId },
            success: (data) => {
                showPosts();

                $("body").append(
                    '<div class="success notification" id="notification"><h4>Comment removed succesfully.</h4></div>'
                );

                setTimeout(() => {
                    $("#notification").addClass("remove");

                    setTimeout(() => {
                        $("#notification").remove();
                    }, [200]);
                }, 3000);
            },
        });
    });

    //PREGLED USER LIKEOVA FUNKCIONALNOST
    $(document).on("click", "#user-likes", function (e) {
        e.preventDefault();

        const postID = $(this).attr("data-id");

        $.ajax({
            url: "../pages/function/show_liked_users.php",
            type: "POST",
            data: { id: postID },
            success: (data) => {
                $("#user-likes-container").append(data);
            },
        });
    });
});
