/**
 * Created by Administrator on 6/15/2017.
 */
$(document).ready(function() {
    $( function() {
        $( "input[type=date]" ).datepicker();
    } );

        var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;

        trigger.click(function () {
            hamburger_cross();
        });

        function hamburger_cross() {

            if (isClosed == true) {
                overlay.hide();
                trigger.removeClass('is-open');
                trigger.addClass('is-closed');

                isClosed = false;
            } else {
                overlay.show();
                trigger.removeClass('is-closed');
                trigger.addClass('is-open');

                isClosed = true;
            }
        }

        $('[data-toggle="offcanvas"]').click(function () {
            $('#wrapper').toggleClass('toggled');
        });

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

function getTotal(ctrl,id,item)
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

// Transfer Total
function setTotal(){
    var gTotal=0;
    $("#total").val(0);
    $(".qty").each(function(){
       if($(this).val()!=''){
           gTotal+=parseInt($(this).val().replace(/\,/g,""));
       }
    });
    $("#total").val(gTotal);
}
//
// function sendData(item){
//     $.ajax({
//         url: 'dispatch/create',
//         type: "post",
//         data:{ _token: "{{csrf_token()}}", it: item},
//         dataType: 'json',
//     });
// }

            // Freeezer Total
function changeFreezerTotal(ctrl,id,arr){
    if($(ctrl).val()!="")
        $("."+id+"freezerqty").val(1);
    else
    $("."+id+"freezerqty").val(0);
checkFreezerStock(ctrl,id,arr);
}

// checking stock if available stock is lesser than input then
// submit button will be disabled

function checkStock(obj,arr,id) { // arr is initalized from where the function is called (On the top of File)


    var gTotal=0,quantity=0;
    $("."+id+"item").each(function() {
        if ($(this).val() != '') {
            gTotal += parseInt($(this).val().replace(/\,/g, ""));
        }
    });
    for(i=0;i<arr.length;i++)
    {
        if(arr[i]['item_id']==id){
            quantity=arr[i]['quantity'];
        }
    }
    if(quantity<gTotal){
     alert("Given value is greater than current stock");
        $("."+obj+"qty."+id+"item").val(null);
    }

    // var totalstock=0,gTotal=0;
    // for(i=0;i<arr.length;i++){
    //     if(arr[i][0]==id){
    //         totalstock+=arr[i][1];
    //     }
    // }
    // $(".item").each(function() {
    //     if ($(this).hasClass('item') && $(this).val() != '') {
    //         gTotal += parseInt($(this).val().replace(/\,/g, ""));
    //     }
    // });
    // if(gTotal>totalstock)
    // {
    //     alert("Current value is greater than Available Stock");
    //     $("#"+id+"region").val=0;
    //     document.getElementById("submit").disabled = true;
    //
    // }
    // else{
    //     document.getElementById("submit").disabled=false;
    // }

}

// function appendCustomer(id) {
//     // alert(id);
//     var data='<datalist id="customer"> <option value="Internet Explorer"> <option value="Firefox"> <option value="Chrome"> <option value="Opera"> <option value="Safari"> </datalist>';
//              ($("#"+id)).append(data);
// }

function  checkFreezerStock(obj,id,arr) {

    var item = $("#"+id+"type").find("option:selected").val(); //getting the item id
    var region=$("select#"+id+"region").find("option:selected").val(); // getting region id

    var totalstock=0,gTotal=0;
    if(region=="" && item!=""){
        alert("Enter Location First");
        document.getElementById("submit").disabled = true;
    }
    else if(region=="" && item=="")
        document.getElementById("submit").disabled = false;
    if(region!="" && item!="") {

        var counter = 0;

        for (i = 0; i < arr.length; i++) {
            if (arr[i]['item_id'] == item && arr[i]['region_id']==region) {
                totalstock = arr[i]['quantity'];
            }
        }

        if (totalstock == 0) {
            $("."+id+"freezer").each(function () {
                $(this).val("");
            });
            alert("Current Region has zero selected item");
        }
        else {

            $(".freezer").each(function () {

                if ($(this).val() != 0 && $(this).val() != '' &&
                    ($("#" + counter + "region").val() == region && $("#" + counter + "type").val() == item)) {
                    gTotal += parseInt($(this).val().replace(/\,/g, ""));
                }
            });
        }
    }
     if(gTotal>totalstock)
     {
         $("."+id+"freezer").each(function () {
             $(this).val("");
         });
         alert("Current value is greater than available stock "+gTotal);

    }
    else{
        document.getElementById("submit").disabled=false;
    }

}

