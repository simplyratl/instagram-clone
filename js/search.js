$(document).ready(() => {
    $("#search").bind("input", (e) => {
        const search = e.target.value;
        if (search.length >= 3) {
            $("#search-load").addClass("active");

            $.ajax({
                url: "../pages/function/search.php",
                type: "POST",
                data: { search: search },
                success: (data) => {
                    setTimeout(() => {
                        $("#suggestion-list").html(data);
                        $("#suggestions").addClass("active");
                        $("#search-load").removeClass("active");
                    }, 400);
                },
            });
        } else {
            $("#suggestions").removeClass("active");
            $("#suggestion-list").html(null);
        }
    });
});
