$.cookie.json = true;
function priceArr(){
    ret = [];
    $('#items .price').each(function() {
        ret.push({
            cat: $(this).find('.cat').text(),
            name: $(this).find('.namei').text(),
            price: $(this).find('.cost').text(),
            times: $(this).find('.times').val(),
            description: $(this).find('.description').text(),
        });
    });
    return ret;
}
function saveForm(){
    data = {
        id:             $("#taskform").data('id'),
        name:           $('#name').val(),
        description:    $('#description').val(),
        state:          $('input[name="state"]:checked').val(),
        date:           $('#date').val(),
        end:            $('#end').val(),
        brand:          $('input[name="brand"]:checked').val(),
        items:          priceArr()
    }
    $('#save').addClass('progress').attr('disabled', 'disabled');
    $.post('/tasks/save', data, function(data){
        $("#taskform").data('id', data);
        $('#save').removeClass('progress').removeAttr('disabled');
        $('#year').trigger('change');
    });
}
function setFilter(year, month){
    data = {
        month: year + '-' + month
    };
    $.post('/tasks/list', data, function(data){
        $('#tasksi').html(data);
        $('#tasks .id a').click(function(){
            $('#modaltask .uk-modal-body').html('...');
            $.post($(this).data('href') + '?view=ajax', '', function(data){
                $('#modaltask .uk-modal-body').html(data);
            });
        }).each(function(){
            $(this).attr('href', '#modaltask');
        });
    });
}
$(function() {
    $('aside').css('html', $(document).height());
    $("aside .price").draggable({
        helper: "clone",
        appendTo: "main"
    });
    $("#taskform").droppable({
        accept: ".price",
        drop: function( event, ui ) {
            $id = $('#items .price[data-id="' + $('.price.ui-draggable-dragging').data('id') + '"]');
            if ( $id.size() ){
                $id.find('.plusminus:last').trigger('click');
            } else {
                $('.price.ui-draggable-dragging').clone().attr('class', 'price').attr('style', '').appendTo('#items');
            }
            saveForm();
        }
    });
    $('#items').on('click', '.remove', function(){
        $removeprice = $(this).parents('.price');
        UIkit.modal.confirm('Remove cell?', function(){
            $removeprice.remove();
        });
    }).on('click', '.plusminus', function(){
        $input = $(this).parents('.price').find('.times');
        val = parseInt($input.val(), 10) + $(this).data('sign');
        if ( val > 0 ) $input.val( val );
    });

    $('#taskform').submit(function(e){
        e.preventDefault();
        saveForm();
    });

    $('#year, #month').change(function(){
        $.cookie('periodform', {'year':$('#year').val(),'month':$('#month').val()});
        setFilter($('#year').val(), $('#month').val());
    });
    periodfilter = $.cookie('periodform');
    if (typeof periodfilter != "undefined") {
        $('#year').val(periodfilter.year);
        $('#month').val(periodfilter.month);
    }
    setFilter($('#year').val(), $('#month').val());
});