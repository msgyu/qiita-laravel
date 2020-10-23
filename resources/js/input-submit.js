$(function() {
    $(".search-input").keydown(function(e) {
        if (e.keyCode == 13) {
            $(this)
                .parents("form")
                .submit();
        }
    });

    $(".delete-button").click(function() {
        if (confirm("本当に削除しますか？")) {
        } else {
            return false;
        }
    });
});
