//stay on the current tab on page reload
$(function(){
    var hash = window.location.hash;
    hash && $('#myTab a[href="' + hash + '"]').tab('show');
    $("#myTab a").click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
    });
});
