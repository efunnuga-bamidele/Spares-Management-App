<?php
 if ( !isset($_SESSION) ) session_start();
 
 if(empty($_SESSION['requestClass'])){
    $_SESSION['requestClass']  = 'tab one';
    }
if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :
    require_once './navigation/header.php';
    require_once './navigation/stripes.php'; 
    


$store_db = new PDO('sqlite:./schema/store.db');


?>
<style>
    /* th{
        white-space: nowrap;
      } */
    td {
        white-space: nowrap;
    }

    .badge-notify {
        background: red;
        position: relative;
        top: -20px;
        right: 10px;
    }

    .my-cart-icon-affix {
        position: fixed;
        z-index: 999;
    }

    #cart_count {
        font-size: small !important;
    }

    #cart_img {
        cursor: pointer;
        content: url('/assets/images/cart1.png');

    }

    #cart_img:hover {
        content: url('/assets/images/cart2.png');
        transform: scale(1.2);
    }
</style>

</head>

<body>
    <?php  //require_once './navigation/nav.php'; ?>
    <div class="row container-fluid" style="margin-top: 90px;">
        <!-- navigation pills -->
        <div class="col-md-2 side-nav">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"
                id="myTab" role="tablist">
                <a <?php if($_SESSION['requestClass'] == 'tab one') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                    id="home-tab" data-toggle="tab" href="#Process-Request" role="tab" aria-controls="Process-Request"
                    aria-selected="true" onclick="reloadTable_4()">Process Request</a>
                <a <?php if($_SESSION['requestClass']== 'tab two') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                    id="profile-tab" data-toggle="tab" href="#Complete-Request" role="tab"
                    aria-controls="Complete-Request" aria-selected="false" onclick="reloadTable_5()">Complete
                    Request</a>
                <a <?php if($_SESSION['requestClass']== 'tab three') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                    id="messages-tab" data-toggle="tab" href="#Restock-Spare" role="tab" aria-controls="Restock-Spare"
                    aria-selected="false" onclick="reloadTable_6()">Restock Spare</a>

            </div>
        </div>
        <!-- navigation pills end -->
        <div class="col-md-10">
            <!-- breadcrumb page -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Request</a></li>
                    <li class="breadcrumb-item active" id="activated" aria-current="page"></li>
                </ol>
            </nav>
            <!-- breadcrumb page end-->


            <!--=================================================================================================================================================================-->


            <!-- Tab panes -->
            <div class="tab-content">

                <!-- Modal form -->
                <div class="modal modal-left fade" id="left_modal_xl" tabindex="-1" role="dialog"
                    aria-labelledby="left_modal_xl">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="table-responsive ">

                                        <div class="gv">
                                            <table id="TABLE_4"
                                                class="display table table-striped table-bordered grid table-hover small"
                                                style="width:100%;">

                                                <thead>
                                                    <tr>
                                                        <th>TASK</th>
                                                        <th>ID</th>
                                                        <th>SPARE PART</th>
                                                        <th>SPARE CODE</th>
                                                        <th>PART NUMBER</th>
                                                        <th>QUANTITY LEFT</th>
                                                        <th>QUANTITY ON-HOLD</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 0; $result = $store_db->query("SELECT * FROM spares"); foreach($result as $row) : $count +=1; ?>
                                                    <tr>
                                                        <!-- add to cart button -->
                                                        <td><button
                                                                class="btn btn-warning btn-sm text-white add-to-cart"
                                                                data-id="<?php echo $row['id']; ?>"
                                                                data-name="<?php echo $row['spareName']; ?>"
                                                                name="<?php echo $row['spareName']; ?>"
                                                                data-summary="<?php echo $row['desctiption']; ?>"
                                                                data-price="0" data-quantity="1"
                                                                data-qtyRemaining="<?php echo $row['remainingStock']; ?>"
                                                                data-qtyLocked="<?php echo $row['lockedUnit']; ?>">Add</button>
                                                        </td>
                                                        <td><?php echo $count?></td>
                                                        <td><?php echo $row['spareName']; ?></td>
                                                        <td><?php echo $row['spareCode']; ?></td>
                                                        <td><?php echo $row['correspondingCode']; ?></td>
                                                        <td><?php echo $row['remainingStock']; ?></td>
                                                        <td><?php echo $row['lockedUnit']; ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>TASK</th>
                                                        <th>ID</th>
                                                        <th>SPARE PART</th>
                                                        <th>SPARE CODE</th>
                                                        <th>PART NUMBER</th>
                                                        <th>QUANTITY LEFT</th>
                                                        <th>QUANTITY ON-HOLD</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="modal-footer modal-footer-fixed" style="float: left;">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal one end -->

                <!-- Begining of process request -->
                <div <?php if($_SESSION['requestClass'] == 'tab one') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>
                    id="Process-Request" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="container-flex row">


                        <div class="col-md-12">
                            <!-- alert notification -->
                            <?php
              if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['requestClass']=== "tab one"){
                echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                  unset($_SESSION['errorMessage']);
                }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['requestClass']=== "tab one"){
                  echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                  unset($_SESSION['successMessage']);
              }
            ?>
                            <!-- alert notification -->
                            <div class="container row">
                                <div class="col-md-2">
                                    <button type="button"
                                        class="btn btn-primary btn-sm border rounded-pill shadow-sm mb-1"
                                        data-toggle="modal" data-target="#left_modal_xl"><i
                                            class="fa fa-angle-left pr-2"></i>Spare Parts</button>
                                </div>
                                <div class="col">
                                    <div class="page-header">
                                        <h3 style="text-align: center;">Process cart &#x261E;
                                            <div style="float:right;">
                                                <span class="badge badge-pill badge-primary cartItem"
                                                    id="cart_count">0</span>
                                            </div>
                                            <img src="" id="cart_img" alt="" height="50vh" width="50vh"
                                                style="float: right;" data-toggle="modal" data-target="#myCartModal">
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div id='ajaxDiv'>

                                </div>
                                <form>
                                    <div class="row" id="requestForm">

                                        <div class="form-group col-md-6">
                                            <label for="customerName">Customer Name</label>
                                            <input type="text" class="form-control" name="customerName"
                                                id="customerName" placeholder="Enter customer name" value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="processNumber">Process Number</label>
                                            <input type="text" class="form-control" name="processNumber"
                                                id="processNumber" placeholder="Generated Automatically" value=""
                                                readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="purchaseOrder">Purchase Order</label>
                                            <input type="text" class="form-control" name="purchaseOrder"
                                                id="purchaseOrder" placeholder="Enter PO number" value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="offerNumber">Offer Code</label>
                                            <input type="text" class="form-control" name="offerNumber" id="offerNumber"
                                                placeholder="Enter offer number" value="">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                placeholder="Enter customer address" value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" id="country"
                                                placeholder="Enter customer country " value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" id="state"
                                                placeholder="Enter customer state" value="">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="createdDate">Created Date</label>
                                            <input type="text" class="form-control" name="createdDate" id="createdDate"
                                                placeholder="Generated Automatically" value="" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="processesBy">Processed By</label>
                                            <input type="text" class="form-control" name="processesBy" id="processesBy"
                                                placeholder="Enter spare category"
                                                value="<?php if(ISSET($_SESSION['activeUserFull'])) echo $_SESSION['activeUserFull'] ;?>"
                                                readonly>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="memo">Comment</label>
                                            <textarea type="text" class="form-control" name="memo" id="memo"
                                                placeholder="Enter any comment on the process if available"
                                                value=""></textarea>
                                        </div>


                                        <div class=" form-group col-md-12 ">
                                            <input type='button' class="form-control-sm btn btn-outline-success"
                                                onclick='ajaxFunction()' value='Create Request' />
                                            <input type='button' class="form-control-sm btn btn-outline-warning"
                                                onclick='ClearInputField()' value='Clear' />

                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>


                <!-- Modal for cart -->
                <div class="modal fade" id="myCartModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Product Cart Items</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modelBody">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <!-- <button type="button" class="btn btn-primary">Process Request</button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal cart -->
                <!-- End process request  -->


                <!--=================================================================================================================================================================-->


                <!-- Begin Complete-Request -->
                <div <?php if($_SESSION['requestClass']== 'tab two') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>
                    id="Complete-Request" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="container-flex row">



                        <div class="col-md-12">
                            <!-- alert notification -->
                            <?php
                            if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['requestClass']=== "tab two"){
                                echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                                unset($_SESSION['errorMessage']);
                                }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['requestClass']=== "tab two"){
                                echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                                unset($_SESSION['successMessage']);
                            }
                            ?>
                            <!-- alert notification -->
                            <div class="table-responsive ">
                                <div class="gv">
                                    <table id="TABLE_5"
                                        class="diaplay table table-striped table-bordered grid table-hover small"
                                        style="width:100%;">

                                        <thead>
                                            <tr>
                                                <th>TASK</th>
                                                <th>ID</th>
                                                <th>CUSTOMER</th>
                                                <th>PROCESS NUMBER</th>
                                                <th>PO NUMBER</th>
                                                <th>OFFER NUMBER</th>
                                                <th>PROCESSED BY</th>
                                                <th>ORDER STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $pOrderCount = 0; $processed = $store_db->query("SELECT * FROM orders WHERE orderCompleted = 'Pending'"); foreach($processed as $process) : $pOrderCount +=1; ?>
                                            <tr>

                                                <td>

                                                    <button class="btn btn-sm btn-info text-white btn-requestProcess"
                                                        data-toggle="modal" data-target="#right_modal_lg"
                                                        data-name="<?php echo $process['customerName']; ?>"
                                                        data-id="<?php echo $process['id']; ?>">Process</button>
                                                </td>
                                                <td><?php echo $pOrderCount?></td>
                                                <td><?php echo $process['customerName']; ?></td>
                                                <td><?php echo $process['processNumber']; ?></td>
                                                <td><?php echo $process['poNumber']; ?></td>
                                                <td><?php echo $process['offerNumber']; ?></td>
                                                <td><?php echo $process['processedBy']; ?></td>
                                                <td><?php echo $process['orderCompleted']; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>TASK</th>
                                                <th>ID</th>
                                                <th>CUSTOMER</th>
                                                <th>PROCESS NUMBER</th>
                                                <th>PO NUMBER</th>
                                                <th>OFFER NUMBER</th>
                                                <th>PROCESSED BY</th>
                                                <th>ORDER STATUS</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-12">

                            <!-- Modal form -->
                            <div class="modal modal-right fade" id="right_modal_lg" tabindex="-1" role="dialog"
                                aria-labelledby="right_modal_lg">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Manage Processed Request</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="./tools/manage_request.php" method="POST">
                                                <div class="row" id="requestForm">
                                                    <div class="form-group col-md-6">
                                                        <label for="orderId">Order ID</label>
                                                        <input type="text" class="form-control" name="orderIdm"
                                                            id="orderIdm" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="status">Order Status</label>
                                                        <input type="text" class="form-control" name="status"
                                                            id="statusm" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="customerName">Customer Name</label>
                                                        <input type="text" class="form-control" name="customerName"
                                                            id="customerNamem" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="processNumber">Process Number</label>
                                                        <input type="text" class="form-control" name="processNumber"
                                                            id="processNumberm" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="purchaseOrder">Purchase Order</label>
                                                        <input type="text" class="form-control" name="purchaseOrder"
                                                            id="purchaseOrderm" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="offerNumber">Offer Code</label>
                                                        <input type="text" class="form-control" name="offerNumber"
                                                            id="offerNumberm" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="sparesList">Spares List</label>
                                                        <textarea type="text" class="form-control" name="sparesList"
                                                            id="sparesListm" placeholder="" value="" readonly
                                                            rows="8"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="memo">Comment</label>
                                                        <textarea type="text" class="form-control" name="memo"
                                                            id="memom" placeholder="" value="" readonly
                                                            rows="8"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="country">Country</label>
                                                        <input type="text" class="form-control" name="country"
                                                            id="countrym" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="createdDate">Created Date</label>
                                                        <input type="text" class="form-control" name="createdDate"
                                                            id="createdDatem" placeholder="" value="" readonly>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label for="processesBy">Processed By</label>
                                                        <input type="text" class="form-control" name="processesBy"
                                                            id="processesBym" placeholder="" value="" readonly>
                                                    </div>

                                                </div>


                                        </div>
                                        <div class="modal-footer">
                                            <div class=" form-group col-md-12 ">
                                                <input type='button' class="form-control-sm btn btn-outline-primary"
                                                    value='Complete Request' onclick="processFunction()" />

                                                <input type='button' class="form-control-sm btn btn-outline-secondary"
                                                    value='Cancel Request' onclick="cancelProcessFunction()" />

                                                <input type="button" value="Clear" onclick="clearMyField()"
                                                    class="form-control-sm btn btn-outline-warning">

                                                <button type="button" class="btn btn-outline-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- End Complete-Request -->
                <!--=================================================================================================================================================================-->

                <!-- Begin Restock -->
                <div <?php if($_SESSION['requestClass']== 'tab three') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>
                    id="Restock-Spare" role="tabpanel" aria-labelledby="home-tab">
                    <div class="container-flex row">
                        <div class="col-md-12 alert" >
                            <!-- alert notification -->
                            <?php
              if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['requestClass']=== "tab three"){
                echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                  unset($_SESSION['errorMessage']);
                }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['requestClass']=== "tab three"){
                  echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                  unset($_SESSION['successMessage']);
              }
            ?>
                            <!-- alert notification -->


                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive ">

                                <div class="gv">
                                    <table id="TABLE_6"
                                        class="display table table-striped table-bordered grid table-hover small display"
                                        style="width:100%;">

                                        <thead>
                                            <tr>
                                                <th>TASK</th>
                                                <th>ID</th>
                                                <th>SPARE PART</th>
                                                <th>SPARE CODE</th>
                                                <th>PART NUMBER</th>
                                                <th>LOCATION</th>
                                                <th>QTY STOCKED</th>
                                                <th>QTY SOLD</th>
                                                <th>QTY LEFT</th>
                                                <th>CREATED DATE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 0; $result = $store_db->query("SELECT * FROM spares"); foreach($result as $row) : $count +=1; ?>
                                            <tr>
                                                <td>
                                                
                                                    <button type="button" class="btn-restock btn btn-info btn-sm"
                                                        data-toggle="modal" data-target="#restock_modal_lg" data-id="<?php echo $row['id']; ?>"><i
                                                            class="fa fa-angle-left pr-2"></i>Restock</button>
                                                </td>
                                                <td><?php echo $count?></td>
                                                <td><?php echo $row['spareName']; ?></td>
                                                <td><?php echo $row['spareCode']; ?></td>
                                                <td><?php echo $row['correspondingCode']; ?></td>
                                                <td><?php echo $row['location']; ?></td>
                                                <td><?php echo $row['quantityInStock']; ?></td>
                                                <td><?php echo $row['quantitySold']; ?></td>
                                                <td><?php echo $row['remainingStock']; ?></td>
                                                <td><?php echo $row['create_date']; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>TASK</th>
                                                <th>ID</th>
                                                <th>SPARE PART</th>
                                                <th>SPARE CODE</th>
                                                <th>PART NUMBER</th>
                                                <th>LOCATION</th>
                                                <th>QTY STOCKED</th>
                                                <th>QTY SOLD</th>
                                                <th>QTY LEFT</th>
                                                <th>CREATED DATE</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>

                <!--=================================================================
                Modal  =================================================================-->


                <div class="modal modal-right fade" id="restock_modal_lg" tabindex="-1" role="dialog"
                    aria-labelledby="restock_modal_lg">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">RESTOCK SPARES</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <div class="row">
                                        <div class="form-group col-md-12" style="display: none;">
                                            <label for="spareId">Spare ID</label>
                                            <input type="text" class="form-control" name="spareId" id="spareId"
                                                value="" readonly>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="spareName">Spare Name</label>
                                            <input type="text" class="form-control" name="spareName" id="spareName" value="" readonly>
                                        
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="spareCategory">Spare Category</label>
                                            <input type="text" class="form-control" name="spareCategory" id="spareCategory" value="" readonly>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="description">Description</label>
                                            <textarea type="text" class="form-control" name="description"
                                                id="description" readonly></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="spareCode">Spare Code</label>
                                            <input type="number" class="form-control" name="spareCode" id="spareCode" value=""readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="corespondingNumber">Coresponding Code</label>
                                            <input type="number" class="form-control" name="corespondingNumber"
                                                id="corespondingNumber" value="" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="location">Location</label>
                                            <input type="text" class="form-control" name="location" id="location" value="" readonly>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="dateCreated">Date Created</label>
                                            <input type="text" class="form-control" name="dateCreated" id="dateCreated" value="" readonly>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label for="currentQuantity">Stock Quantity</label>
                                            <input type="number" class="form-control" name="currentQuantity"
                                                id="currentQuantity"
                                                value="" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="quantitySold">Quantity Sold</label>
                                            <input type="number" class="form-control" name="quantitySold"
                                                id="quantitySold"
                                                value="" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="quantityRequested">Quantity Requested</label>
                                            <input type="number" class="form-control" name="quantityRequested"
                                                id="quantityRequested"
                                                value="">
                                        </div>
                                        <div class="form-group col-md-4" hidden>
                                            <label for="totalQuantity" hidden>Quantity Requested</label>
                                            <input type="number" class="form-control" name="totalQuantity"
                                                id="totalQuantity"
                                                value="" hidden readonly>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer modal-footer-fixed">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn-addSpare btn btn-outline-primary">Add Spares</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End restock -->

            </div>


        </div>


        <!-- Footer section -->

        <div class="container">
            <?php require_once './navigation/footer.php' ?>
            <?php // require_once './navigation/special_footer.php' ?>
        </div>
    </div>



    <!-- <script type='text/javascript' src="./assets/js/bootstrap.min.js"></script> -->
    <script src="./assets/js/popper.min.js"></script>
    <script type='text/javascript' src="./assets/js/custom-cart.js"></script>
    <script>
        $("li#activated").text($('a.nav-link.active').attr('aria-controls').replace("-", " "))

        $('#v-pills-tab a').on('click', function (event) {
            event.preventDefault()
            // console.log(event.target.getAttribute("aria-controls"));

            $("li#activated").text(event.target.getAttribute("aria-controls").replace("-", " "))
        })
    </script>

</body>

</html>

<?php endif; ?>