$(function() {
    function add_tag(text) {
        var $tag_li = `<li class="tag-content">
                    <span class="tag-label">
                      ${text}
                    </span>
                    <a class="text-icon">
                      ×
                    </a>
                    <input class="tag-hidden-field" name="tags[]" value="${text}" type="hidden">
                  </li>`;
        return $tag_li;
    }

    $tags = [];

    $("#tag-input").on("keydown", function(e) {
        if (e.keyCode == 13) {
            var $text = this.value;
            if ($text.length > 0 && $tags.indexOf($text) == -1) {
                $("#tag-input").before(add_tag($text));
                $tags.push($text);
                this.value = "";
            }
            return false;
        }

        if (e.keyCode == 8) {
            var $text = this.value;
            if ($text.length == 0) {
                var $tag = $(".tag-content:last");
                var tag_value = $tag.find(".tag-hidden-field").val();
                var index = $tags.indexOf(tag_value);
                if (index > -1) {
                    $tags.splice(index, 1);
                }
                $tag.remove();
            }
        }
    });

    $(".tag-wrapper").on("click", ".text-icon", function() {
        var $tag = $(this).parents(".tag-content");
        var tag_value = $tag.find(".tag-hidden-field").val();
        var index = $tags.indexOf(tag_value);
        if (index > -1) {
            $tags.splice(index, 1);
        }
        $tag.remove();
    });
});
