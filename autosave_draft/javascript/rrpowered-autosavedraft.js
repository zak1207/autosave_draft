$(function () {
    $.post("php/rrpowered-autosave.php", function (data) {
        $("[name='title']").val(data.title);
        $("[name='body']").val(data.body);
    }, "json");
    setInterval(function () {
        $.post("php/rrpowered-autosave.php", $("form").serialize());
    }, 2000);
});
