$(document).ready(function () {
    $('.rf[rf-show]').on("click", function(){
        var toshow = $(this).attr('rf-show');
        var parent = $(this).attr('rf-parent');
        $(parent + ' ' + toshow).toggle(1000);
    });
});