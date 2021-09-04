<?php
 if ( !isset($_SESSION) ) session_start();

 if(empty($_SESSION['historyClass'])){
  $_SESSION['historyClass']  = 'tab one';
  }

if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :
  require_once './navigation/header.php';
  require_once './navigation/stripes.php'; 

  $store_db = new PDO('sqlite:./schema/store.db');

  if(isset($_GET["reloadOne"])){
    $_SESSION['historyClass']  = 'tab one';
  }else if(isset($_GET["reloadTwo"])){
    $_SESSION['historyClass']  = 'tab two';
  }else if(isset($_GET["reloadThree"])){
    $_SESSION['historyClass']  = 'tab three';
  }
 ?>
   <style type="text/css">
@media screen {
    #printSection {
        display: none;
    }
}
@media print {
    @page {
        size: A4 portrait;
        max-height:100%; 
        max-width:100%;
        margin-top: 0;
    }
    body * {
        visibility:hidden;
    }
    #printSection, #printSection * {
        visibility:visible;
    }
    #printSection {
        width:100%;
        height:100%;
        margin: 0; 
        padding: 0;
        position:absolute;
        left:0;
        top:0;
    }
}

</style>


</head>
      <body>
      <?php // require_once './navigation/nav.php'; ?>

    <div class="row container-fluid" style="margin-top: 90px;">
      <!-- navigation pills -->
      <div class="col-md-2 side-nav">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"
            id="myTab" role="tablist">

            <a <?php if($_SESSION['historyClass'] == 'tab one') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                id="requestHistory-tab" data-toggle="tab" href="#Request-History" role="tab" aria-controls="Request-History"
                aria-selected="true" onclick="reloadTable_7()">Request History</a>

            <a <?php if($_SESSION['historyClass']== 'tab two') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                id="sparesHistory-tab" data-toggle="tab" href="#Spares-History" role="tab"
                aria-controls="Spares-History" aria-selected="false" onclick="reloadTable_8()">Spares History</a>

            <a <?php if($_SESSION['historyClass']== 'tab three') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
            id="restockHistory-tab" data-toggle="tab" href="#Restock-History" role="tab"
            aria-controls="Restock-History" aria-selected="false" onclick="reloadTable_9()">Restock History</a>
        
        </div>
    </div>
    <!-- navigation pills end -->
    <div class="col-md-10">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">History</a></li>
          <li class="breadcrumb-item active" id="activated" aria-current="page"></li>
        </ol>
    </nav>
    <div class="tab-content">
        <div <?php if($_SESSION['historyClass']== 'tab one') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>  id="Request-History" role="tabpanel" aria-labelledby="requestHistory-tab">

                    <!-- Table -->
            <div class="table-responsive ">

            <div class="gv">
            <table id="TABLE_7"
            class="display table table-striped table-bordered grid table-hover small text-nowrap "
            style="width:100%;">
                <thead>
                    <tr>
                        <th>Function</th>
                        <th>ID</th>
                        <th>CUSTOMER</th>
                        <th>PROCESS NO</th>
                        <th>PO NUMBER</th>
                        <th>OFFER NO</th>
                        <th>ADDRESS</th>
                        <th>COUNTRY</th>
                        <th>STATE</th>
                        <th>CREATED DATE</th>
                        <th>CREATED BY</th>
                        <th>SPARE LIST</th>
                        <th>REQUEST STATUS</th>
                        <th>COMMENT</th>
                    </tr>
                </thead>
                <tbody>
                <?php $count = 0; $result = $store_db->query("SELECT * FROM orders"); foreach($result as $row) : $count +=1; ?>
                    <tr>
                    <!-- <button class="btn btn-sm btn-info text-white btn-requestProcess"
                                                        data-toggle="modal" data-target="#right_modal_lg"
                                                        data-name="<?php echo $process['customerName']; ?>"
                                                        data-id="<?php echo $process['id']; ?>">Process</button> -->
                              <td><button class="btn btn-warning btn-sm text-white btn-viewProcess" data-toggle="modal" data-target="#right_modal_xl"
                              data-id="<?php echo $row['id']; ?>"
                              data-name="<?php echo $row['processNumber']; ?>"
                              name="<?php echo $row['processNumber']; ?>">VIEW</button>
                      </td>
                      <td><?php echo $count?></td>
                      <td><?php echo $row['customerName']; ?></td>
                      <td><?php echo $row['processNumber']; ?></td>
                      <td><?php echo $row['poNumber']; ?></td>
                      <td><?php echo $row['offerNumber']; ?></td>
                      <td><?php echo $row['customerLocation']; ?></td>
                      <td><?php echo $row['country']; ?></td>
                      <td><?php echo $row['state']; ?></td>
                      <td><?php echo $row['createDate']; ?></td>
                      <td><?php echo $row['processedBy']; ?></td>
                      <td class="text-nowrap"><?php print_r (unserialize($row['sparesList'])); ?></td>
                      <td><?php echo $row['orderCompleted']; ?></td>
                      <td><?php echo $row['memo']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                   </tbody>
                    <tfoot>
                        <tr>
                        <th>Function</th>
                        <th>CUSTOMER</th>
                        <th>PROCESS NO</th>
                        <th>PO NUMBER</th>
                        <th>OFFER NO</th>
                        <th>ADDRESS</th>
                        <th>COUNTRY</th>
                        <th>STATE</th>
                        <th>CREATED DATE</th>
                        <th>CREATED BY</th>
                        <th>SPARE LIST</th>
                        <th>REQUEST STATUS</th>
                        <th>COMMENT</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
              </div>

              <!-- Table  and tab one-->
        </div>
         <!-- Modal 1 form -->
         <div class="modal modal-right fade" id="right_modal_xl" tabindex="-1" role="dialog" aria-labelledby="right_modal_xl">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header-fluid">
                                          <div class="row col">
                                          <div class="col-md-4">
                                          <h5 class="modal-title">View Processed Request</h5>
                                          </div>
                                          <div class="col-md4">
                                          <input type='button' class="form-control-sm btn btn-outline-primary printRequest-btn"
                                                    value='Print' id="printRequest"/>
                                          </div>
                                          <div class="col-md-4">
                                          <button type="button" class="btn btn-outline-danger"
                                                    data-dismiss="modal">Close</button>
                                          </div>
                                           </div>
                                           <hr>
                                        </div>
                                   
                                        <div id="printThis" class="modal-body">
                                        <div class="row" id="preload">
                                        <img class="mb-6" src="./assets/images/Bosch-logo.png" alt="" width="10%" height="10%">
                                        <div class="col text-right">
                                        <h1 class="h3 mb-6 font-weight-normal" id="header-text">...</h1>
                                        </div>
                                            </div>
                                            <hr style="border: solid gray;">
                                            <form action="#">
                                                <div class="row" id="requestForm">
                                                    <div class="form-group col-md-4">
                                                        <label for="orderId">Order ID</label>
                                                        <input type="text" class="form-control" name="orderId-v"
                                                            id="orderId-v" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="status">Order Status</label>
                                                        <input type="text" class="form-control" name="statu-v"
                                                            id="status-v" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="customerName">Customer Name</label>
                                                        <input type="text" class="form-control" name="customerName-v"
                                                            id="customerName-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="processNumber">Process Number</label>
                                                        <input type="text" class="form-control" name="processNumber-v"
                                                            id="processNumber-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="purchaseOrder">Purchase Order</label>
                                                        <input type="text" class="form-control" name="purchaseOrder-v"
                                                            id="purchaseOrder-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="offerNumber">Offer Code</label>
                                                        <input type="text" class="form-control" name="offerNumber-v"
                                                            id="offerNumber-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label for="sparesList">Spares List</label>
                                                        <textarea type="text" class="form-control" name="sparesList-v"
                                                            id="sparesList-v" placeholder="" value="" readonly
                                                            rows="7"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="memo">Comment</label>
                                                        <textarea type="text" class="form-control" name="memo-v"
                                                            id="memo-v" placeholder="" value="" readonly
                                                            rows="7"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="country">Country</label>
                                                        <input type="text" class="form-control" name="country-v"
                                                            id="country-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="createdDate">Created Date</label>
                                                        <input type="text" class="form-control" name="createdDate-v"
                                                            id="createdDate-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="processesBy">Processed By</label>
                                                        <input type="text" class="form-control" name="processesBy-v"
                                                            id="processesBy-v" placeholder="" value="" readonly>
                                                    </div>
<!-- 
                                                    <div class="form-group col-md-3">
                                                        <label for="status">State</label>
                                                        <input type="text" class="form-control" name="state-v"
                                                            id="state-v" placeholder="" value="" readonly>
                                                    </div> -->
                                                    <div class="form-group col-md-6">
                                                        <label for="completedDate">Completed Date</label>
                                                        <input type="text" class="form-control" name="completedDate-v"
                                                            id="completedDate-v" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="completedBy">Completed By</label>
                                                        <input type="text" class="form-control" name="completedBy-v"
                                                            id="completedBy-v" placeholder="" value="" readonly>
                                                    </div>

                                                </div>

                                                </form>   
                                        </div>
                                        <div class="modal-footer">
                                                                                  
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal one end -->
                            <!-- Spares-History -->
    <div <?php if($_SESSION['historyClass']== 'tab two') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Spares-History" role="tabpanel" aria-labelledby="sparesHistory-tab">
            <!-- Table -->
            <div class="table-responsive ">

            <div class="gv">
            <table id="TABLE_8"
            class="display table table-striped table-bordered grid table-hover small text-nowrap "
            style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PROCESS NUMBER</th>
                        <th>CUSTOMER</th>
                        <th>SPARE NAME</th>
                        <th>QUANTITY TAKEN</th>
                        <th>CREATED BY</th>
                        <th>COMPLETED BY</th>
                        <th>DATE COMPLETED</th>
                    </tr>
                </thead>
                <tbody>
                <?php $count = 0; $result = $store_db->query("SELECT * FROM orderHistory"); foreach($result as $row) : $count +=1; ?>
                    <tr>
             
                      <td><?php echo $count?></td>
                      <td><?php echo $row['processNumber']; ?></td>
                      <td><?php echo $row['customer']; ?></td>
                      <td><?php echo $row['spareName']; ?></td>
                      <td><?php echo $row['quantity']; ?></td>
                      <td><?php echo $row['createdBy']; ?></td>
                      <td><?php echo $row['completedBy']; ?></td>
                      <td><?php echo $row['dateCompleted']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                   </tbody>
                    <tfoot>
                        <tr>
                        <th>ID</th>
                        <th>PROCESS NUMBER</th>
                        <th>CUSTOMER</th>
                        <th>SPARE NAME</th>
                        <th>QUANTITY TAKEN</th>
                        <th>CREATED BY</th>
                        <th>COMPLETED BY</th>
                        <th>DATE COMPLETED</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
              </div>

        
        </div>
      <!-- Table Tab three -->
                                  <!-- Spares-History -->
    <div <?php if($_SESSION['historyClass']== 'tab three') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Restock-History" role="tabpanel" aria-labelledby="restockHistory-tab">
            <!-- Table -->
            <div class="table-responsive ">

            <div class="gv">
            <table id="TABLE_9"
            class="display table table-striped table-bordered grid table-hover small text-nowrap "
            style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>SPARE NAME</th>
                        <th>LOCATION</th>
                        <th>INITIAL STOCK</th>
                        <th>REQUESTED STOCK</th>
                        <th>TOTAL STOCK</th>
                        <th>PROCESSED DATE</th>
                        <th>PROCESSED BY</th>
                    </tr>
                </thead>
                <tbody>
                <?php $count = 0; $result = $store_db->query("SELECT * FROM restockig"); foreach($result as $row) : $count +=1; ?>
                    <tr>
             
                      <td><?php echo $count?></td>
                      <td><?php echo $row['spareName']; ?></td>
                      <td><?php echo $row['location']; ?></td>
                      <td><?php echo $row['initialStock']; ?></td>
                      <td><?php echo $row['newQuantity']; ?></td>
                      <td><?php echo $row['currentStock']; ?></td>
                      <td><?php echo $row['currentDate']; ?></td>
                      <td><?php echo $row['processedBy']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                   </tbody>
                    <tfoot>
                        <tr>
                        <th>ID</th>
                        <th>SPARE NAME</th>
                        <th>LOCATION</th>
                        <th>INITIAL STOCK</th>
                        <th>REQUESTED STOCK</th>
                        <th>TOTAL STOCK</th>
                        <th>PROCESSED DATE</th>
                        <th>PROCESSED BY</th>
                        </tr>
                    </tfoot>
                </table>
                </div>
              </div>

        
        </div>
      <!-- Table Tab three -->

                
    </div>
     
      </div>

   </div>
    <!-- Footer section -->
    
        <div class="container">
        <?php require_once './navigation/footer.php' ?>
        </div>
    </div>
<script type='text/javascript' src="./assets/js/custom-cart.js"></script>  
<script>
       $("li#activated").text($('a.nav-link.active').attr('aria-controls').replace("-", " "))

$('#v-pills-tab a').on('click', function(event) {
    event.preventDefault()
    // console.log(event.target.getAttribute("aria-controls"));

    $("li#activated").text(event.target.getAttribute("aria-controls").replace("-", " "))
})
  $('#right_modal_xl').on('shown.bs.modal', function (e) {
document.getElementById("printRequest").onclick = function () {
  printElement(document.getElementById("printThis"));
};
});
function printElement(elem) {
  var domClone = elem.cloneNode(true);

  var $printSection = document.getElementById("printSection");

  if (!$printSection) {
      var $printSection = document.createElement("div");
      $printSection.id = "printSection";
      document.body.appendChild($printSection);
  }

  $printSection.innerHTML = "";
  $printSection.appendChild(domClone);
  window.print();
}
</script>
</body>
</html>
<?php endif; ?>