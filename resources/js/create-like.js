$(function() {
    $(".like_btn").click(function() {
        var post_id = $(".like_btn").attr("post_id");
        var like_exist = $(".like_btn").attr("like_exist");
        click_button = $(this);
        console.log(post_id);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/like_product",
            type: "POST",
            data: { post_id: post_id, like_exist: like_exist }
        })
            .done(function(like_exist) {
                console.log("成功");
                if (like_exist == 0) {
                    click_button.attr("like_exist", "1");
                    click_button.css({ color: "#fff", background: "#55c500" });
                    // click_button.children().attr("class", "fas fa-heart");
                }
                if (like_exist == 1) {
                    click_button.attr("like_exist", "0");
                    click_button.css({ color: "#55c500", background: "#fff" });
                }
            })
            .fail(function(data) {
                alert("いいね処理失敗");
                alert(JSON.stringify(data));
            });
    });
});
