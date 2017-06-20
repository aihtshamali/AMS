/**
 * Created by Administrator on 6/15/2017.
 */


$(function(){
    $(':input').on('input',function(){
        if ($('input[id=' + $(this).attr('id') + ']').val()) {
            $('input[id=' + $(this).attr('id') + ']').prop('required', true);
            $('input[id=total' + $(this).attr('id')+']').val('0');
        }
        else {

            $('input[id=total' + $(this).attr('id') + ']').val('');
        }
    });
    $('.greenqty , .yellowqty').on('input',function(){

        if ($('.greenqty , .yellowqty').val()) {
           var total=0;
            total=parseInt($('input[id=' + $(this).attr('id') + '][class="greenqty"]').val())+ $('input[id=total' + $(this).attr('id')+']').val();
           total= $('input[id=total' + $(this).attr('id')+']').val()+ parseInt($('input[id=' + $(this).attr('id') + ']  input[class=".yellowqty"]').val())
           alert(total);
           $('input[id=total' + $(this).attr('id') + ']').val(total);
        }
        else {
            $('input[id=total' + $(this).attr('id') + ']').val('0');
        }
    });
});