$(function() {
    $(".like_btn").click(function() {
        var post_id = $(".like_btn").data("post_id");
        $.ajax({
            url: "/likes",
            type: "POST",
            dataType: "json",
            data: { id: post_id }
        })
            .done(function(comments) {})
            .fail(function() {
                alert("通信に失敗しました");
            });
    });
});
