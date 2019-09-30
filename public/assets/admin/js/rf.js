$(document).ready(function () {
    $("body").niceScroll();
    $(".rf-help-content").niceScroll();
    //$("<your div>").getNiceScroll().resize();
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

    $('.rf-choose').each(function(){
        var input = $(this).attr('rf-hidden');
        var inputVal = $(input).val();
        console.log(inputVal);
        $('.rf-choose[rf-id]').children('.canvas_structure_layout').css('border','none');
        $('.rf-choose[rf-id="'+inputVal+'"]').children('.canvas_structure_layout').css('border','2px solid blue');
    });

    $('.rf-search-form select').change(function(){
        $(this).closest('.rf-search-form').submit();
    });

    $('.rf-help').click(function () {

        var title = $(this).attr('rf-title');
        var contentElement = $("."+$(this).attr('rf-class'));
        $.confirm({
            theme: 'supervan',
            title: title,
            columnClass: 'large',
            content: contentElement.html(),
            buttons: {
                confirm: {
                    text: 'OK',
                    btnClass: 'btn btn-secondary',
                    keys: ['enter', 'shift'],
                    action: function(){
                    }
                }
            },
            onContentReady: function () {
                $(".rf-help-content").niceScroll();
                $(".rf-help-content").getNiceScroll().resize();
            }
        });
    });


});

function rfslugify(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}