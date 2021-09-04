const cartItemList = [];
const cartQtyList = [];
let cartItemCount = 0
let divId = 0
let itemIndex = ''
// get Cart Item Details
$('.add-to-cart').bind('click', function(e){
    e.preventDefault();
    let checkArray = cartItemList.includes($(this).data("name"))
    if(!checkArray){
        cartItemList.push($(this).data("name"));
        cartQtyList.push($(this).data("quantity"));   
    }else{
        // get Index of array
        let itemIndex = cartItemList.indexOf($(this).data("name"));
        // Add 1 to existing count of the array
        cartQtyList[itemIndex] = cartQtyList[itemIndex] + 1;
    }
     countItems();
        // console.log('Unit : '+cartItemList+' Qty: '+cartQtyList)
        $('.add-to-cart').unbind('click', function(e){})
    
})

function countItems(){
    cartItemCount = cartQtyList.reduce(getSum, 0);
    function getSum(total, num) {
        return total + Math.round(num);
        }
        $('.cartItem').text(cartItemCount);
}

$("#cart_img").click(function(e){
    $(".modal-body").html("");
    loadElements();
})

$('#myCartModal').on('shown.bs.modal', function (event) {

    $(".modal-body").on( 'click change',function(){
        changeQty();
   
    }) 
    $( "#myCartModal .modal-body button" ).click(function() {
        console.log("Initial "+cartItemList)
        divId ='#'+$(this).parent().parent().attr('id');
        deleteElement()
        console.log("After : "+cartItemList)
    }); 

})   

// function increase item quantity
function changeQty(){
    $(".modal-body :input[data-index]").bind('keyup mouseup click', function () {
        itemIndex = cartItemList.indexOf($(this).attr('data-index'));
        // Add 1 to existing count of the array
        cartQtyList[itemIndex] =$(this).val();
        countItems();
        $(".modal-body :input[data-index]").unbind('keyup mouseup click', function (){})
    })
}

// function to get list element id
function elementListId(){
    $(".modal-body .form-row" ).bind('click',function(){ 
        // divId =$(".modal-body .form-row").attr("id")
        divId ='#'+$(this).attr("id")
        console.log(divId)
        // $(".modal-body .form-row" ).unbind('click',function(){})
    });

}

// delete item from modal
function deleteElement(){
    let count
    $(divId).css("display", "none")
 
    cartItemList.pop(divId);
    cartQtyList.pop(divId); 
    $(divId).html("");
    // myelement();


    countItems();
}
function myelement(){
    $(".modal-body").html("");
    cartItemList.forEach(function (item, index) {
        console.log(item, index);
      });
    if(cartItemList.length >= 1){
        for(let i = 0; i < cartItemList.length; i++){
            let itemIndex = cartItemList.indexOf(cartItemList[i]);
            count = i+1; 
                console.log("Element: "+count+ "Index :" +itemIndex)
                $('.modal-body').append(`
                    <div class="form-row" id = "${count}">
                        <div class="col-1 form-group">
                            <input type="text" class="form-control" value="${count}"readonly></div>
                        <div class="col-8 form-group">
                            <input type="text" class="form-control" value="${cartItemList[i]}" readonly>
                        </div>
                        <div class="col form-group">
                            <input type="number" class="form-control" value="${cartQtyList[i]}" data-index = "${cartItemList[i]}">
                        </div>
                        <div class="col form-group">
                            <button data-Id="${itemIndex}" class="btn btn-danger btn-sm deleteItem" data-class="deleteItem">X</button>
                        </div>
                    </div>
                
                `)
                console.log("end Loop")
        }
    }else{
        $('.modal-body').append(`
        <div class="alert alert-danger text-center text-capitalize" role="alert">
            No Item in Cart!
        </div>
        `)
    }
}
// load Element
function loadElements(){
    let count
    if(cartItemList.length >= 1){
        for(let i = 0; i < cartItemList.length; i++){
            let itemIndex = cartItemList.indexOf(cartItemList[i]);
            count = i+1; 
                console.log("Element: "+count)
                $('.modal-body').append(`
                    <div class="form-row" id = "${count}">
                        <div class="col-1 form-group">
                            <input type="text" class="form-control" value="${count}"readonly></div>
                        <div class="col-8 form-group">
                            <input type="text" class="form-control" value="${cartItemList[i]}" readonly>
                        </div>
                        <div class="col form-group">
                            <input type="number" class="form-control" value="${cartQtyList[i]}" data-index = "${cartItemList[i]}">
                        </div>
                        <div class="col form-group">
                            <button data-Id="${itemIndex}" class="btn btn-danger btn-sm deleteItem" data-class="deleteItem">X</button>
                        </div>
                    </div>
                
                `)
        }
    }else{
        $('.modal-body').append(`
        <div class="alert alert-danger text-center text-capitalize" role="alert">
            No Item in Cart!
        </div>
        `)
    }
}
