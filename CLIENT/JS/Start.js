$(document).ready(function () {
// load w3css
    $.ajax({
        url: "/Html/Header.html",
        cache: false,
        success: function (data) {
            $("head").append(data);
        }
    });
});

