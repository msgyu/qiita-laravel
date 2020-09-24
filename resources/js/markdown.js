import marked from "marked";

$(function() {
    marked.setOptions({
        langPrefix: "",
        breaks: true,
        sanitize: true
    });

    $("#markdown_editor_textarea").keyup(function() {
        var html = marked(getHtml($(this).val()));
        $("#markdown_preview").html(html);
    });

    function getHtml(html) {
        html = html.replace(/&lt;/g, "<");
        html = html.replace(/&gt;/g, ">");
        html = html.replace(/&amp;/g, "&");
        return html;
    }
});
