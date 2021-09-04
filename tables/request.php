<?php
// session_start();
require_once './navigation/header.php';
require_once './navigation/stripes.php'; 
if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :

if(empty($_SESSION['requestClass'])){
  $_SESSION['requestClass']  = 'tab one';
}

$store_db = new PDO('sqlite:./schema/store.db');


?>
    <style>
       /* th{
            white-space: nowrap;
          } */
      td{
            white-space: nowrap;
          }
          .badge-notify{
              background:red;
              position:relative;
              top: -20px;
              right: 10px;
            }
            .my-cart-icon-affix {
              position: fixed;
              z-index: 999;
            }
    </style>

</head>

      <body>
      <?php  require_once './navigation/nav.php'; ?>

      <div class="row container-fluid" style="margin-top: 90px;">
      <!-- navigation pills -->
      <div class="col-md-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"  aria-orientation="vertical"  id="myTab" role="tablist" >
              <a <?php if($_SESSION['requestClass'] == 'tab one') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?> id="home-tab" data-toggle="tab" href="#Process-Request" role="tab" aria-controls="Process-Request" aria-selected="true">Process Request</a>
              <a <?php if($_SESSION['requestClass']== 'tab two') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?> id="profile-tab" data-toggle="tab" href="#Complete-Request" role="tab" aria-controls="Complete-Request" aria-selected="false">Complete Request</a>
              <a <?php if($_SESSION['requestClass']== 'tab three') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?> id="messages-tab" data-toggle="tab" href="#Restock-Spare" role="tab" aria-controls="Restock-Spare" aria-selected="false">Restock Spare</a>
              <!-- <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> -->
        </div>
      </div>
      <!-- navigation pills end -->
    <div class="col-md-10">
      <!-- breadcrumb page -->
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
            <li class="breadcrumb-item active" id="activated" aria-current="page"></li>
          </ol>
      </nav>
      <!-- breadcrumb page end-->
 
      <!-- Tab panes -->
      <div class="tab-content" >
        <!-- Begining of process request -->
        <div <?php if($_SESSION['requestClass']== 'tab one') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Process-Request" role="tabpanel" aria-labelledby="messages-tab">
        <div class="container-flex row">
        <div class="col-md-7">
              <div class="table-responsive ">

                <div class="gv">
                <table id="sparesTables" class="table table-striped table-bordered grid table-hover small" style="width:100%;">
                
                    <thead>
                        <tr>
                            <th>TASK</th>
                            <th>ID</th>
                            <th>SPARE PART</th>
                            <th>SPARE CODE</th>
                            <th>PART NUMBER</th>
                            <th>QTY LEFT</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; $result = $store_db->query("SELECT * FROM spares"); foreach($result as $row) : $count +=1; ?>
                       <tr>
                            <td><button class="btn btn-warning my-cart-btn btn-sm text-white" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['spareName']; ?>" name="<?php echo $row['spareName']; ?>" data-summary="<?php echo $row['desctiption']; ?>" data-price="0" data-quantity="1" data-image="./assets/images/cart1.png">Add</button>
                          </td>
                           <td><?php echo $count?></td>
                           <td><?php echo $row['spareName']; ?></td>
                           <td><?php echo $row['spareCode']; ?></td>
                           <td><?php echo $row['correspondingCode']; ?></td>
                           <td><?php echo $row['remainingStock']; ?></td>
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
                            <th>QTY LEFT</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                  </div>


              </div>
      
          <!-- <div class="col-md-3"> -->
            <!-- cart -->
            <!-- <div class="page-header">
              <h1>Products
                <div style="float: right; cursor: pointer;" >
                  <span class="glyphicon glyphicon-shopping-cart my-cart-icon" id="element"><span class="badge badge-notify my-cart-badge"></span></span>
                </div>
              </h1>
            </div> -->
            
          <!-- </div> -->
             <div class="col-md-5">
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
              <div class="col-md-12">
              <div class="page-header">
                <h3>Process cart
                  <div style="float: right; cursor: pointer; margin-top:15px" >
                    <span class="glyphicon glyphicon-shopping-cart my-cart-icon" id="element"><span class="badge badge-notify my-cart-badge text-white"></span></span>
                  </div>
                </h3>
              </div>
              </div>
            <br>
              <div class="col-md-12">
               <form action="./tools/manage_request.php" method="POST">
                 <div class="row">
                 <div class="form-group col-md-12" style="display: none;">
                        <label for="requestId">Request ID</label>
                        <input type="text" class="form-control" name="requestId" id="requestId" value="<?php if(ISSET($_SESSION['requestId'])) echo $_SESSION['requestId'] ;?>">
                  </div>

                   <div class="form-group col-md-6">
                   <label for="category">Customer Name</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>">
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">Process Number</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>" disabled>
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">Purchase Order</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>">
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">Offer Code</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>">
                   </div>

                   <div class="form-group col-md-12">
                   <label for="category">Address</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>">
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">Country</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>">
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">State / City</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>">
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">Created Date</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>" disabled>
                   </div>

                   <div class="form-group col-md-6">
                   <label for="category">Processed By</label>
                   <input type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['activeUserFull'])) echo $_SESSION['activeUserFull'] ;?>" disabled>
                   </div>

                   <div class="form-group col-md-12">
                   <label for="category">Comment</label>
                   <textarea type="text" class="form-control" name="category" id="category" placeholder="Enter spare category" value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>"></textarea>
                   </div>
                    

                   <div class=" form-group col-md-12 ">
                   <button type="submit" class="form-control-sm btn btn-outline-success" name="createRequest">Create Request</button>
                    <a href="./tools/create_category.php?clearRequest" name="clearRequest" class="form-control-sm btn btn-outline-warning">Clear</a>
                   </div>

                 </div>
                 
               </form>
              </div>
             </div>
           </div>  

        </div>
        <!-- End process request  -->
        <!-- Begin Complete-Request -->
        <div <?php if($_SESSION['requestClass']== 'tab two') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Complete-Request" role="tabpanel" aria-labelledby="profile-tab">
        <div class="container-flex row">
             
             <div class="col-md-6">
             <div class="table-responsive ">

               <div class="gv">
               <table id="locationTables" class="table table-striped table-bordered grid table-hover small" style="width:100%;">
              
                   <thead>
                       <tr>
                           <th>ID</th>
                           <th>Location</th>
                           <th>Created Date</th>
                           <th>Function</th>
                       </tr>
                   </thead>
                   <tbody>
                    <?php $count = 0; $result = $store_db->query("SELECT * FROM location"); foreach($result as $row) : $count +=1; ?>
                       <tr>
                           <td><?php echo $count; ?></td>
                           <td><?php echo $row['locationBox']; ?></td>
                           <td><?php echo $row['createdDate']; ?></td>
                           <td><a href="./tools/create_location.php?editLocation=<?php echo $row['id']; ?>" name="<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">Edit</a></td>
                       </tr>
                       <?php endforeach; ?>
                       </tbody>
                       <tfoot>
                           <tr>
                           <th>ID</th>
                           <th>Location</th>
                           <th>Created Date</th>
                           <th>Function</th>
                           </tr>
                       </tfoot>
                    
                   </table>
                   </div>
                 </div>


             </div>
             <div class="col-md-6">
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
               <form action="./tools/create_location.php" method="POST">
                 <div class="row">
                   <div class="form-group col-md-12">
                   <label for="id">ID</label>
                   <input type="text" class="form-control" name="locationid" id="locationid" disabled value="<?php if(ISSET($_SESSION['id'])) echo $_SESSION['id'] ;?>">
                   </div>

                   <div class="form-group col-md-12">
                   <label for="location">Location</label>
                   <input type="text" class="form-control" name="location" id="location" placeholder="Enter box storage location" value="<?php if(ISSET($_SESSION['locationBox'])) echo $_SESSION['locationBox'] ;?>">
                   </div>
                   
                   <div class=" form-group col-md-12 ">
                    <button type="submit" class="form-control-sm btn btn-outline-success" name="createLocation">Create Location</button>
                    <button type="submit" class="form-control-sm btn btn-outline-primary" name="updateLocation">Update Location</button>
                    <a href="./tools/create_location.php?deleteLocation" name="deleteLocation" class="form-control-sm btn btn-outline-danger">Delete Location</a>
                    <a href="./tools/create_location.php?clearLocation" name="clearLocation" class="form-control-sm btn btn-outline-warning">Clear</a>
                   </div>

                 </div>
                 
               </form>

             </div>
           </div>  

        </div>
        <!-- End Complete-Request -->
        <!-- Begin Restock -->
        <div <?php if($_SESSION['requestClass']== 'tab three') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Restock-Spare" role="tabpanel" aria-labelledby="home-tab">
            <div class="container-flex row">
             
              <div class="col-md-6">
              <div class="table-responsive ">

                <div class="gv">
                <table id="sparesTables" class="table table-striped table-bordered grid table-hover small display" style="width:100%;">
                
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
                            <td><a href="./tools/create_spares.php?editSpares=<?php echo $row['id']; ?>" name="<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white">Edit</a></td>
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
              <div class="col-md-6">
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
                <form class="needs-validation"  action="./tools/create_spares.php" method="POST" novalidate>
                  <div class="row">
                     <div class="form-group col-md-12" style="display: none;">
                        <label for="spareId">Spare ID</label>
                        <input type="text" class="form-control" name="spareId" id="spareId" value="<?php if(ISSET($_SESSION['id'])) echo $_SESSION['id'] ;?>">
                    </div>
                    <div class="form-group col-md-12">
                    <label for="spareName">Spare Name</label>
                    <input type="text" class="form-control" name="spareName" id="spareName" value="<?php if(ISSET($_SESSION['spareName'])) echo $_SESSION['spareName'] ;?>" required>
                    <div class="invalid-feedback">
                         User input is required.
                    </div>
                    </div>

                    <div class="form-group col-md-12">
                    <label for="spareCategory">Spare Category</label>
                    <select name="spareCategory" id="spareCategory" class="form-control">
                      <option value="<?php if(ISSET($_SESSION['spareCategory'])) {echo $_SESSION['spareCategory'];}else{ echo "...Select Spare Category";}?>" selected><?php if(ISSET($_SESSION['spareCategory'])) {echo $_SESSION['spareCategory'];}else{ echo "...Select Spare Category";}?></option>
                      <?php $result = $store_db->query("SELECT * FROM category"); foreach($result as $row) :?>
                        <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                      <?php endforeach; ?>
                    </select>
                    </div>

                    <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" name="description" id="description"><?php if(ISSET($_SESSION['description'])) echo $_SESSION['description'] ;?></textarea>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="spareCode">Spare Code</label>
                    <input type="number" class="form-control" name="spareCode" id="spareCode" value="<?php if(ISSET($_SESSION['spareCode'])) echo $_SESSION['spareCode'] ;?>" required>
                    <div class="invalid-feedback">
                         User input is required.
                    </div>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="corespondingNumber">Coresponding Code</label>
                    <input type="number" class="form-control" name="corespondingNumber" id="corespondingNumber" value="<?php if(ISSET($_SESSION['corespondingNumber'])) echo $_SESSION['corespondingNumber'] ;?>" required>
                    <div class="invalid-feedback">
                         User input is required.
                    </div>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="currentQuantity">Stock Quantity</label>
                    <input type="number" class="form-control" name="currentQuantity" id="currentQuantity" value="<?php if(ISSET($_SESSION['currentQuantity'])) echo $_SESSION['currentQuantity'] ;?>">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="quantitySold">Quantity Sold</label>
                    <input type="number" class="form-control" name="quantitySold" id="quantitySold" value="<?php if(ISSET($_SESSION['quantitySold'])) echo $_SESSION['quantitySold'] ;?>">
                    </div>
                    
                    <div class="form-group col-md-6">
                    <label for="location">Location</label>
                    <select name="location" id="location" class="form-control">
                      <option value="<?php if(ISSET($_SESSION['locationBox'])) {echo $_SESSION['locationBox'];}else{ echo "...Select Box Location";}?>" selected><?php if(ISSET($_SESSION['locationBox'])) {echo $_SESSION['locationBox'];}else{ echo "...Select Box Location";}?></option>
                    <?php $result = $store_db->query("SELECT * FROM location"); foreach($result as $row) :?>
                        <option value="<?php echo $row['locationBox']; ?>"><?php echo $row['locationBox']; ?></option>
                      <?php endforeach; ?>
                    </select>

                    </div>

                    <div class="form-group col-md-6">
                    <label for="dateCreated">Date Created</label>
                    <input type="text" class="form-control" name="dateCreated" id="dateCreated" disabled value="<?php if(ISSET($_SESSION['dateCreated'])) echo $_SESSION['dateCreated'] ;?>">
                    </div>
                    <div class=" form-group col-md-12 ">
                    <button type="submit" class="form-control-sm btn btn-outline-success" name="createSpares">Create Spares</button>
                    <button type="submit" class="form-control-sm btn btn-outline-primary" name="updateSpares">Update Spares</button>
                    <a href="./tools/create_spares.php?deleteSpares" name="deleteSpares" class="form-control-sm btn btn-outline-danger">Delete Spares</a>
                    <a href="./tools/create_spares.php?clearSpares" name="clearSpares" class="form-control-sm btn btn-outline-warning">Clear Spares</a>
                   
                    </div>

                  </div>
                  
                </form>

              </div>
            </div>  

        </div>
        <!-- End restock -->
        <!-- <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...page 4</div> -->
      </div>
      

  </div>
    <!-- Footer section -->
    
        <div class="container">
        <?php require_once './navigation/special_footer.php' ?>
        </div>
    </div>



  <script type='text/javascript' src="./assets/js/bootstrap.min.js"></script>
  <script type='text/javascript' src="./assets/js/jquery.mycart.js"></script>
    <script>
      // console.log($('a .nav-link').find('active').attr("id"))
      // console.log($('a.nav-link.active').attr('aria-controls'))
      $("li#activated").text($('a.nav-link.active').attr('aria-controls').replace("-"," "))

        $('#v-pills-tab a').on('click', function (event) {
            event.preventDefault()
          // console.log(event.target.getAttribute("aria-controls"));

          $("li#activated").text(event.target.getAttribute("aria-controls").replace("-"," "))
        })
  </script>

</body>
</html>

<?php endif; ?>