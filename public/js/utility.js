/**
 * Created by Administrator on 6/15/2017.
 */
$(document).ready(function() {

    // $(function () {
        // $(':input').on('input',function(){
        //
        //     $('input[id=' + parseInt($(this).attr('id')) + 'customer]').prop('required', true);
        //     $('input[id=' + parseInt($(this).attr('id')) + 'sales]').prop('required', true);
        //     $('input[id=' + parseInt($(this).attr('id')) + 'total]').prop('required', true);
        //
        //
        // });
    //     $('.greenqty , .yellowqty').on('input', function () {
    //         var total = 0;
    //         var t1 = 0, t2 = 0;
    //         var id = parseInt($(this).attr('id'));
    //
    //         if ($('input[id=' + id + 'greenqty]').val()) {
    //             t2 = parseInt($('input[id=' + id + 'greenqty][class="greenqty"]').val());
    //         }
    //         if ($('input[id=' + id + 'yellowqty]').val()) {
    //             t1 = parseInt($('input[id=' + id + 'yellowqty][class="yellowqty"]').val());
    //         }
    //         total = t1 + t2;
    //         $('input[id=' + id + 'total]').val(total);
    //
    //     });
    // });

    $('select.freezerlocation').on('change',
        function(){
            $('input[class="freezerqty"]').val(1);
            if (!$('select.freezerlocation').val()){
                $('input[class="freezerqty"]').val();
            }
        });

    $("input#itemName").on({
        keydown: function(e) {
            if (e.which === 32)
                return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });




    });

            // Dispatch Total

function getTotal(ctrl,id)
{
    var gTotal=0;
    $("#"+id+"qtytotal").val(0);
    $("."+id+"qty").each(function() {
        if($(this).hasClass(id+'qty') && $(this).val()!=''){
            gTotal+=parseInt( $(this).val().replace(/\,/g,""));
        }
    });
    $("#"+id+"qtytotal").val(gTotal);
}

            // Freeezer Total
function changeFreezerTotal(ctrl,id){
    if($(ctrl).val()!="")
        $("."+id+"freezerqty").val(1);
    else
    $("."+id+"freezerqty").val(0);
}

