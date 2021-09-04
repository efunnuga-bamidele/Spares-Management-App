
// Delete and fadeout session in javascript
setTimeout(function() {
    $(".alert").fadeOut().empty();
    // console.log( sessionStorage.getItem("successMessage"))    
    sessionStorage.removeItem('itemName'); 
}, 5000);

// To remove all sessions 
// sessionStorage.clear();  

// Example starter JavaScript for disabling form submissions if there are invalid fields


(function () {
    'use strict'
  
    window.addEventListener('load', function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation')
  
      // Loop over them and prevent submission
      Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
          }
  
          form.classList.add('was-validated')
        }, false)
      })
    }, false)
  })()

//   $(document).ready(function () {
// //   // $("#TABLE_4").dataTable().ajax.reload();
//   // $('#TABLE_4').DataTable().clear().destroy();
// //     $("#TABLE_4").dataTable({
  
// //     })
// });




$(document).ready(function () {
 
  $("table[id^='TABLE']").DataTable( {
    retrieve: true,
    dom: 'lfBtirpRS',
    buttons: [
    
      'colvis', 'copy', 'excel', 'pdf', 'print','colvisRestore',
    ],
    scrollY:'50vh',
   scrollX: true,
   searching: true,
   paging: true,
   ordering:  true,
   select: true,
   scrollCollapse: true,
   processing: true,
   info: true,
   lengthChange: true,
   search: {
     smart: true
   }
  });
  

});

function clearMyField(e) {
  var r = confirm("Do you really want to clear field!");
  if (r == true) {
      // postComment();
      window.location.href = "./tools/manage_request.php?clearRequest";
  } else {

  }
}

function processFunction(e) {
  var r = confirm("Do you really want to complete this request!");
  if (r == true) {
      let id = document.getElementById('orderIdm').value;
      window.location.href = "./tools/manage_request.php?completeRequest="+id;
  } else {}
}

function cancelProcessFunction(e) {
  var r = confirm("Do you really want to cancel this request!");
  if (r == true) {
      let id = document.getElementById('orderIdm').value;
      window.location.href = "./tools/manage_request.php?cancelRequest="+id;
  } else {}
}

function reloadTable_1(){
  window.location.href = "./tools/create_spares.php?clearSpares";
}
function reloadTable_2(){
  window.location.href = "./tools/create_location.php?clearLocation";
}
function reloadTable_3(){
  window.location.href = "./tools/create_category.php?clearCategory";
}
function reloadTable_4(){
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
  window.location.href = "./tools/create_request.php?clearProcess";
}
function reloadTable_5(){
  window.location.href = "./tools/manage_request.php?clearRequest";
}
function reloadTable_6(){
  window.location.href = "./tools/create_spares.php?clearRestock";
}
function reloadTable_7(){
  window.location.href = "./history.php?reloadOne";
}

function reloadTable_8(){
  window.location.href = "./history.php?reloadTwo";
  }

function reloadTable_9(){
      window.location.href = "./history.php?reloadThree";    
}
function reloadTable_10(){
  window.location.href = "./preference.php?reloadOne";    
}
function reloadTable_11(){
  // alert("Two")
  window.location.href = "./preference.php?reloadTwo";    
}
function reloadTable_12(){
  window.location.href = "./preference.php?reloadThree";    
}
function reloadTable_13(){
  window.location.href = "./preference.php?reloadFour";    
}
function reloadTable_14(){
  window.location.href = "./preference.php?reloadFive";    
}
