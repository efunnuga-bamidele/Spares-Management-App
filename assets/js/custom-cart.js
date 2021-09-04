const cartItemList = new Map();

let divId = 0
let countedItems = 0
// get Cart Item Details
$('.add-to-cart').bind('click', function(e){
    e.preventDefault();
    // check if item does not exist
    if(cartItemList.has($(this).data("name")) == false){
        // check if item remaining is not less than item in cart.
        if(($(this).attr('data-qtyRemaining') - $(this).attr('data-qtyLocked')) > 0){
        cartItemList.set($(this).data("name"),$(this).data("quantity"));
    }else{
        alert($(this).data("name") + " is Out of Stock! / Locked for Delivery!");
    }

    }else{
        // alert(cartItemList.get($(this).data("name")))
    if(($(this).attr('data-qtyRemaining') - $(this).attr('data-qtyLocked')) > cartItemList.get($(this).data("name"))){
    cartItemList.set($(this).data("name"), (cartItemList.get($(this).data("name")) + 1))
    }else{
            alert($(this).data("name") + "is Out of Stock! / Locked for Delivery!");
        }
    }
    // count the values
    let itemIndex = 0;
    for (let x of cartItemList.values()) {
        itemIndex += x;
    }
    // console.log(itemIndex)
    $('.cartItem').text(itemIndex);
    countedItems = itemIndex;
})

function countItems(){
        // count the values
        let cartItemCount = 0;
        for (let x of cartItemList.values()) {
            cartItemCount += x;
        }
        // console.log("New Item Count :"+cartItemCount)
        $('.cartItem').text(cartItemCount);
}


// Modal response
$('#myCartModal').on('show.bs.modal', function (event) {
    myelement();

    $('#myCartModal').on('shown.bs.modal', function (event) {

        $("#myCartModal .modal-body").on( 'click change',function(){
            changeQty();
        }) 
        $( "#myCartModal .modal-body button" ).click(function() {
        //    Delete item function
            divId ="#"+$(this).parent().parent().attr('id');
            $(divId).hide();
            cartItemList.delete($(this).parent().parent().attr('data-name'));
            countItems();
           
            if(cartItemList.size >= 1){
                let count = 1;
                $(":input[data-name=My]:visible").each(function(){
                     $(this).val(count++);
                    // console.log(this.value);
                })
            }else{
                $(".modal-body").html("");
                $('.modal-body').append(`
                <div class="alert alert-danger text-center text-capitalize" role="alert">
                    No Item in Cart!
                </div>
                `);
            }
        }); 

    })   
})


// function increase item quantity
function changeQty(){
    $(".modal-body :input[data-index]").bind('keyup mouseup click', function () {
        itemIndex = cartItemList.get($(this).attr('data-index'));
        // Add 1 to existing count of the array
        cartItemList.set($(this).attr('data-index'), parseInt($(this).val()))
        countItems();
        $(".modal-body :input[data-index]").unbind('keyup mouseup click', function (){});
    });
  
}

// Create Element
function myelement(){
    $(".modal-body").html("");
    // for (let x of cartItemList.values()) {
    if(cartItemList.size >= 1){
        let count = 0
        cartItemList.forEach (function(value, key) {
            count += 1 
                $('#myCartModal .modal-body').append(`
                    <div class="form-row " id = "${key.replace(/[.,-\s]/g, '')}" data-name="${key}" >
                        <div class="col-1 form-group">
                            <input type="text" id = "${key.replace(/[.,-\s]/g, '')}" data-name="My" class="form-control" value="${count}"readonly></div>
                        <div class="col-8 form-group">
                            <input type="text" class="form-control" value="${key}" readonly>
                        </div>
                        <div class="col form-group">
                            <input type="number" class="form-control" value="${value}" data-index = "${key}">
                        </div>
                        <div class="col form-group">
                            <button data-Id="${key}" class="btn btn-danger btn-sm deleteItem" data-class="deleteItem">X</button>
                        </div>
                    </div>
                
                `)
        })
      
    
    }else{
        $('.modal-body').append(`
        <div class="alert alert-danger text-center text-capitalize" role="alert">
            No Item in Cart!
        </div>
        `)
    }
}

$(function clearFunction(){

})


//process order history

      //Browser Support Code
      function ajaxFunction(e){
    
        var r = confirm("Do you really want to proceed with this request! Now that your cart has "+countedItems+" Item(s) in the cart!");
        if (r == true) {
        
        //   e.preventDefault();
          console.log("Clicked Ajax function")
        
        var ajaxRequest;  // The variable that makes Ajax possible!
        
        try {
           // Opera 8.0+, Firefox, Safari
           ajaxRequest = new XMLHttpRequest();
        }catch (e) {
           // Internet Explorer Browsers
           try {
              ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
           }catch (e) {
              try{
                 ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
              }catch (e){
                 // Something went wrong
                 alert("Your browser broke!");
                 return false;
              }
           }
        }

        var customerName = document.getElementById('customerName').value;
        var purchaseOrder = document.getElementById('purchaseOrder').value;
        var offerNumber = document.getElementById('offerNumber').value;
        var address = document.getElementById('address').value;
        var country = document.getElementById('country').value;
        var state = document.getElementById('state').value;
        var processesBy = document.getElementById('processesBy').value;
        var memo = document.getElementById('memo').value;

      
        var rand = Math.floor(Math.random() * 9999)
        var txt1 = processesBy
        var txt3 = customerName.toUpperCase().slice(0,2)
        txt1 =  txt1.toUpperCase();
        var txt2 =  txt1.slice(-2);
        txt1 = txt1.replace(' ','')
        txt1 = txt1.slice(0, 2)
        // console.log(txt1.concat('-',rand,'-',txt2,txt3))
        document.getElementById('processNumber').value = txt1.concat('-',rand,'-',txt2,txt3)
        var processNumber = document.getElementById('processNumber').value;
        var queryString = "?processNumber=" + processNumber ;

        let jsonText = strMapToJson(cartItemList)


        ajaxRequest.onreadystatechange = function(){
           if(ajaxRequest.readyState == 4 ){
              var ajaxDisplay = document.getElementById('ajaxDiv');
              var result ='<div class="alert alert-success">'+processNumber+' Request Created Successful</div>';
              
              if(ajaxRequest.responseText.localeCompare(result) > 0){
            //   console.log('CORRECT');
              ajaxDisplay.innerHTML = ajaxRequest.responseText;
              ClearInputField();
             


            } else {
            //   console.log('INCORRECT');
              ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
    
           }
        }
        // console.log(jsonText)

        queryString +=  "&customerName=" + customerName + "&purchaseOrder=" + purchaseOrder  + "&offerNumber=" + offerNumber  + "&address=" + address  + "&country=" + country  + "&state=" + state  + "&memo=" + memo  + "&processesBy=" + processesBy + "&cartItemList=" + jsonText;

        ajaxRequest.open("GET", "./tools/create_request.php" + queryString, true);
        ajaxRequest.send(null); 
       
       // ajaxRequest.send();

       setTimeout(function() {
       
        $('.alert').fadeOut().empty();     
        sessionStorage.removeItem('successMessage'); 
       
        sessionStorage.removeItem('errorMessage'); 
        }, 5000);

    } else {}
     }


    //  End of ajax


    function ClearInputField() {
      document.getElementById('customerName').value = "";
      document.getElementById('processNumber').value = '';
      document.getElementById('purchaseOrder').value = '';
      document.getElementById('offerNumber').value = '';
      document.getElementById('address').value = '';
      document.getElementById('country').value = '';
      document.getElementById('state').value = '';
      document.getElementById('memo').value = '';
      cartItemList.clear();
      countItems();
      window.location.href = "./request.php";
    //   document.getElementsByClassName('cartItem').value = "";
  }
   

      function strMapToObj(strMap) {
        let obj = Object.create(null);
        for (let [k,v] of strMap) {
          // We don’t escape the key '__proto__'
          // which can cause problems on older engines
          obj[k] = v;
        }
        return obj;
      }

      
     function strMapToJson(strMap) {
        return JSON.stringify(strMapToObj(strMap));
      }
      

    // 
$(".btn-requestProcess").on("click", function(){
        console.log($(this).attr("data-name"))
        console.log($(this).data("id"))
  
    let rowId = $(this).data("id");
         $.ajax({ url: './tools/manage_request.php?',
         data: {editOrder: rowId},
         type: 'POST',
         dataType: 'json',
            success: function(output) {
                        // alert(output.id);
                 
                        $('#right_modal_lg').on('shown.bs.modal', function (e) {
                            $('#orderIdm').val(output.value.id);
                            $('#statusm').val(output.value.orderCompleted);
                            $('#customerNamem').val(output.value.customerName);
                            $('#processNumberm').val(output.value.processNumber);
                            $('#purchaseOrderm').val(output.value.poNumber);
                            $('#offerNumberm').val(output.value.offerNumber);
                            $('#sparesListm').val(JSON.stringify(output.parts, null, "\t"));
                            $('#memom').val(output.value.memo);
                            $('#countrym').val(output.value.country);
                            $('#createdDatem').val(output.value.createDate);
                            $('#processesBym').val(output.value.processedBy);
                          })
                    }
});

})

$(".btn-viewProcess").on("click", function(){
    console.log($(this).attr("data-id"))
    console.log($(this).data("id"))

let rowId = $(this).attr("data-id");
     $.ajax({ url: './tools/manage_request.php?',
     data: {editOrder: rowId},
     type: 'POST',
     dataType: 'json',
        success: function(output) {
            // alert(JSON.parse(output.parts));
                    // alert(output.id);
                    $('#right_modal_xl').on('shown.bs.modal', function (e) {
                        // do something...
                

                        $('#orderId-v').val(output.value.id);
                        $('#status-v').val(output.value.orderCompleted);
                        $('#customerName-v').val(output.value.customerName);
                        $('#processNumber-v').val(output.value.processNumber);
                        $('#purchaseOrder-v').val(output.value.poNumber);
                        $('#offerNumber-v').val(output.value.offerNumber);
                        // $('#sparesList-v').val(JSON.stringify(output.parts,null,2));
                        $('#sparesList-v').val(JSON.stringify(output.parts));
                  
                        
                        // alert(`<?php echo json_encode($_SESSION['sparesList']); ?>`);
                        $('#memo-v').val(output.value.memo);
                        $('#country-v').val(output.value.country);
                        $('#createdDate-v').val(output.value.createDate);
                        $('#processesBy-v').val(output.value.processedBy);
                        $('#state-v').val(output.value.state);
                        $('#completedDate-v').val(output.value.completedDate);
                        $('#completedBy-v').val(output.value.completedBy);
                        $("div#preload h1").html($('#customerName-v').val()+" : "+$('#processNumber-v').val())
                      })
                }
});

})

var remainingQty =''
$(".btn-restock").on("click", function(e){
    // alert();
    let $rowId = $(this).attr("data-id");

    $.ajax({
        url:"./tools/create_spares.php?",
        data:{restockSpares:$rowId},
        type:"POST",
        dataType:"json",
        success:function(output){
            // alert(output.spareName);

            $("#spareId").val(output.id);
            $("#spareName").val(output.spareName);
            $("#spareCategory").val(output.category);
            $("#description").val(output.description);
            $("#spareCode").val(output.spareCode);
            $("#corespondingNumber").val(output.correspondingCode);
            $("#location").val(output.location);
            $("#dateCreated").val(output.create_date);
            $("#currentQuantity").val(output.remainingStock);
            remainingQty = output.remainingStock;
            $("#quantitySold").val(output.quantitySold);
            $("#totalQuantity").val(output.quantityInStock);
        }
    })
})

// {"qtyRequest":$requestQty, "spareId":$spareRow, "totalStocked":$currentQty, "remaining":$remainingQty},
$(".btn-addSpare").on("click", function(e){
    var spareRow = $('#spareId').val();
    var requestQty = $("#quantityRequested").val();
    var currentQty = $("#totalQuantity").val();
//    remainingQty = remainingQty;
//    $("currentQuantity").val();
    // alert( spareRow + requestQty + currentQty + remainingQty);
    $.ajax({
        type: "POST",
        cache: false,
        url:"./tools/create_spares.php?",
        data:{qtyRequest:requestQty,
            spareId:spareRow,
            totalStocked:currentQty,
            remaining:remainingQty,
            location:$("#location").val(),
            spareName:$("#spareName").val(),
            
        },
    
    })
    .done(function( msg ) {
        $("#restock_modal_lg").modal('hide');
        window.location = "./request.php"
        
      });
})

