import marked from "marked";

$(function() {
    marked.setOptions({
        langPrefix: "",
        breaks: true,
        sanitize: true
    });
    var html = marked(getHtml($("#markdown_editor_textarea").val()));
    $("#markdown_preview").html(html);

    $("#markdown_editor_textarea").keyup(function() {
        var html = marked(getHtml($(this).val()));
        $("#markdown_preview").html(html);
    });

    var target = $(".post-body");
    var html = marked(getHtml(target.html()));
    $(".post-body").html(html);

    function getHtml(html) {
        html = html.replace(/&lt;/g, "<");
        html = html.replace(/&gt;/g, ">");
        html = html.replace(/&amp;/g, "&");
        return html;
    }
});
