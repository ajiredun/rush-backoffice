$(document).ready(function () {
    $('.rf[rf-show]').on("click", function(){
        var toshow = $(this).attr('rf-show');
        var parent = $(this).attr('rf-parent');
        $(parent + ' ' + toshow).toggle(1000);
    });

    $('.rf-focus').focus();
    $('.rf-focus').select();

    $('.rf-choose').on("click", function(event){
        event.preventDefault();
        var input = $(this).attr('rf-hidden');
        var id = $(this).attr('rf-id');
        $(input).val(id);
        $('.rf-choose[rf-id]').children('.canvas_structure_layout').css('border','none');
        $('.rf-choose[rf-id="'+id+'"]').children('.canvas_structure_layout').css('border','2px solid blue');
    });

});