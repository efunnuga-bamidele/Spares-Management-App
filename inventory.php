<?php
 if ( !isset($_SESSION) ) session_start();
 
 if(empty($_SESSION['inventoryClass'])){
  $_SESSION['inventoryClass'] = 'tab one';
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
</style>

</head>

<body>
    <?php // require_once './navigation/nav.php'; ?>

    <div class="row container-fluid" style="margin-top: 90px;">
        <!-- navigation pills -->
        <div class="col-md-2 side-nav">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"
                id="myTab" role="tablist">
                <a <?php if($_SESSION['inventoryClass'] == 'tab one') {echo 'class="nav-link active"';} else {echo 'class="nav-link"'; }?>
                    id="home-tab" data-toggle="tab" href="#Manage-Spares" role="tab" aria-controls="Manage-Spares"
                    aria-selected="true" onclick="reloadTable_1()">Manage Spares</a>
                <a <?php if($_SESSION['inventoryClass']== 'tab two') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                    id="profile-tab" data-toggle="tab" href="#Manage-Location" role="tab"
                    aria-controls="Manage-Location" aria-selected="false" onclick="reloadTable_2()">Manage Location</a>
                <a <?php if($_SESSION['inventoryClass']== 'tab three') {echo 'class="nav-link active"';} else {echo 'class="nav-link"'; }?>
                    id="messages-tab" data-toggle="tab" href="#Manage-Category" role="tab"
                    aria-controls="Manage-Category" aria-selected="false" onclick="reloadTable_3()">Manage Category</a>
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
            <div class="tab-content">
                <!-- Beginning of Spares -->
                <div <?php if($_SESSION['inventoryClass']== 'tab one') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>
                    id="Manage-Spares" role="tabpanel" aria-labelledby="home-tab">
                    <div class="container-flex row">

                        <div class="col-md-7">
                            <div class="table-responsive ">

                                <div class="gv">
                                    <table id="TABLE_1"
                                        class="display table table-striped table-bordered grid table-hover small nowrap "
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
                                                <td><a href="./tools/create_spares.php?editSpares=<?php echo $row['id']; ?>"
                                                        name="<?php echo $row['id']; ?>"
                                                        class="btn btn-sm btn-info text-white">Edit</a></td>
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
                        <div class="col-md-5">
                            <!-- alert notification -->
                            <?php
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['inventoryClass']=== "tab one"){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['inventoryClass']=== "tab one"){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
                            <!-- alert notification -->
                            <form class="needs-validation" action="./tools/create_spares.php" method="POST" novalidate>
                                <div class="row">
                                    <div class="form-group col-md-12" style="display: none;">
                                        <label for="spareId">Spare ID</label>
                                        <input type="text" class="form-control" name="spareId" id="spareId"
                                            value="<?php if(ISSET($_SESSION['id'])) echo $_SESSION['id'] ;?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="spareName">Spare Name</label>
                                        <input type="text" class="form-control" name="spareName" id="spareName"
                                            value="<?php if(ISSET($_SESSION['spareName'])) echo $_SESSION['spareName'] ;?>"
                                            required>
                                        <div class="invalid-feedback">
                                            User input is required.
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="spareCategory">Spare Category</label>
                                        <select name="spareCategory" id="spareCategory" class="form-control">
                                            <option
                                                value="<?php if(ISSET($_SESSION['spareCategory'])) {echo $_SESSION['spareCategory'];}else{ echo "...Select Spare Category";}?>"
                                                selected>
                                                <?php if(ISSET($_SESSION['spareCategory'])) {echo $_SESSION['spareCategory'];}else{ echo "...Select Spare Category";}?>
                                            </option>
                                            <?php $result = $store_db->query("SELECT * FROM category"); foreach($result as $row) :?>
                                            <option value="<?php echo $row['category']; ?>">
                                                <?php echo $row['category']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea type="text" class="form-control" name="description"
                                            id="description"><?php if(ISSET($_SESSION['description'])) echo $_SESSION['description'] ;?></textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="spareCode">Spare Code</label>
                                        <input type="number" class="form-control" name="spareCode" id="spareCode"
                                            value="<?php if(ISSET($_SESSION['spareCode'])) echo $_SESSION['spareCode'] ;?>"
                                            required>
                                        <div class="invalid-feedback">
                                            User input is required.
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="corespondingNumber">Corresponding Code</label>
                                        <input type="number" class="form-control" name="corespondingNumber"
                                            id="corespondingNumber"
                                            value="<?php if(ISSET($_SESSION['corespondingNumber'])) echo $_SESSION['corespondingNumber'] ;?>"
                                            required>
                                        <div class="invalid-feedback">
                                            User input is required.
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="currentQuantity">Stock Quantity</label>
                                        <input type="number" class="form-control" name="currentQuantity"
                                            id="currentQuantity"
                                            value="<?php if(ISSET($_SESSION['currentQuantity'])) echo $_SESSION['currentQuantity'] ;?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="quantitySold">Quantity Sold</label>
                                        <input type="number" class="form-control" name="quantitySold" id="quantitySold"
                                            value="<?php if(ISSET($_SESSION['quantitySold'])) echo $_SESSION['quantitySold'] ;?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="location">Location</label>
                                        <select name="location" id="location" class="form-control">
                                            <option
                                                value="<?php if(ISSET($_SESSION['locationBox'])) {echo $_SESSION['locationBox'];}else{ echo "...Select Box Location";}?>"
                                                selected>
                                                <?php if(ISSET($_SESSION['locationBox'])) {echo $_SESSION['locationBox'];}else{ echo "...Select Box Location";}?>
                                            </option>
                                            <?php $result = $store_db->query("SELECT * FROM location"); foreach($result as $row) :?>
                                            <option value="<?php echo $row['locationBox']; ?>">
                                                <?php echo $row['locationBox']; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="dateCreated">Date Created</label>
                                        <input type="text" class="form-control" name="dateCreated" id="dateCreated"
                                            disabled
                                            value="<?php if(ISSET($_SESSION['dateCreated'])) echo $_SESSION['dateCreated'] ;?>">
                                    </div>
                                    <div class=" form-group col-md-12 ">
                                        <button type="submit" class="form-control-sm btn btn-outline-success"
                                            name="createSpares">Create Spares</button>
                                        <button type="submit" class="form-control-sm btn btn-outline-primary"
                                            name="updateSpares">Update Spares</button>
                                        <a href="./tools/create_spares.php?deleteSpares" name="deleteSpares"
                                            class="form-control-sm btn btn-outline-danger">Delete Spares</a>
                                        <a href="./tools/create_spares.php?clearSpares" name="clearSpares"
                                            class="form-control-sm btn btn-outline-warning">Clear Spares</a>

                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>

                </div>
                <!-- End spare creation -->
                <!-- Begin Location -->
                <div <?php if($_SESSION['inventoryClass']== 'tab two') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>
                    id="Manage-Location" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="container-flex row">

                        <div class="col-md-6">
                            <div class="table-responsive ">

                                <div class="gv">
                                    <table id="TABLE_2"
                                        class="display table table-striped table-bordered grid table-hover small nowrap "
                                        style="width:100%;">

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
                                                <td><a href="./tools/create_location.php?editLocation=<?php echo $row['id']; ?>"
                                                        name="<?php echo $row['id']; ?>"
                                                        class="btn btn-sm btn-info text-white">Edit</a></td>
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
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['inventoryClass']=== "tab two"){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['inventoryClass']=== "tab two"){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
                            <!-- alert notification -->
                            <form action="./tools/create_location.php" method="POST" class="needs-validation"
                                novalidate>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="id">ID</label>
                                        <input type="text" class="form-control" name="locationid" id="locationid"
                                            disabled value="<?php if(ISSET($_SESSION['id'])) echo $_SESSION['id'] ;?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" name="location" id="location"
                                            placeholder="Enter box storage location"
                                            value="<?php if(ISSET($_SESSION['locationBox'])) echo $_SESSION['locationBox'] ;?>"
                                            required>
                                        <div class="invalid-feedback">
                                            User input is required.
                                        </div>
                                    </div>


                                    <div class=" form-group col-md-12 ">
                                        <button type="submit" class="form-control-sm btn btn-outline-success"
                                            name="createLocation">Create Location</button>
                                        <button type="submit" class="form-control-sm btn btn-outline-primary"
                                            name="updateLocation">Update Location</button>
                                        <a href="./tools/create_location.php?deleteLocation" name="deleteLocation"
                                            class="form-control-sm btn btn-outline-danger">Delete Location</a>
                                        <a href="./tools/create_location.php?clearLocation" name="clearLocation"
                                            class="form-control-sm btn btn-outline-warning">Clear</a>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>

                </div>
                <!-- End Location -->
                <!-- Begin Category -->
                <div <?php if($_SESSION['inventoryClass']== 'tab three') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?>
                    id="Manage-Category" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="container-flex row">

                        <div class="col-md-6">
                            <div class="table-responsive ">

                                <div class="gv">
                                    <table id="TABLE_3"
                                        class="display table table-striped table-bordered grid table-hover small nowrap "
                                        style="width:100%;">
                                        <thead style="width:100%;">
                                            <tr>
                                                <th>Function</th>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th>Created Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 0; $result = $store_db->query("SELECT * FROM category"); foreach($result as $row) : $count +=1; ?>
                                            <tr>
                                                <td><a href="./tools/create_category.php?editCategory=<?php echo $row['id']; ?>"
                                                        name="<?php echo $row['id']; ?>"
                                                        class="btn btn-sm btn-info text-white">Edit</a></td>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $row['category']; ?></td>
                                                <td><?php echo $row['current_time']; ?></td>

                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Function</th>
                                                <th>ID</th>
                                                <th>Category</th>
                                                <th>Created Date</th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <!-- alert notification -->
                            <?php
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['inventoryClass']=== "tab three"){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['inventoryClass']=== "tab three"){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
                            <!-- alert notification -->
                            <form action="./tools/create_category.php" method="POST" class="needs-validation"
                                novalidate>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="id">ID</label>
                                        <input type="text" class="form-control" name="id" id="id" disabled
                                            value="<?php if(ISSET($_SESSION['id'])) echo $_SESSION['id'] ;?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="category">Spare Category</label>
                                        <input type="text" class="form-control" name="category" id="category"
                                            placeholder="Enter spare category"
                                            value="<?php if(ISSET($_SESSION['category'])) echo $_SESSION['category'] ;?>"
                                            required>
                                        <div class="invalid-feedback">
                                            User input is required.
                                        </div>
                                    </div>
                                    <div class=" form-group col-md-12 ">
                                        <button type="submit" class="form-control-sm btn btn-outline-success"
                                            name="createCategory">Create Category</button>
                                        <button type="submit" class="form-control-sm btn btn-outline-primary"
                                            name="updateCategory">Update Category</button>
                                        <a href="./tools/create_category.php?deleteCategory" name="deleteCategory"
                                            class="form-control-sm btn btn-outline-danger">Delete Spares</a>
                                        <a href="./tools/create_category.php?clearCategory" name="clearCategory"
                                            class="form-control-sm btn btn-outline-warning">Clear</a>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>

                    </d iv>
                    <!-- End Category -->
                    <!-- <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...page 4</div> -->
                </div>


            </div>
            <!-- Footer section -->

            <div class="container">
                <?php require_once './navigation/footer.php' ?>
            </div>
        </div>

        <script>
        // console.log($('a .nav-link').find('active').attr("id"))
        // console.log($('a.nav-link.active').attr('aria-controls'))
        $("li#activated").text($('a.nav-link.active').attr('aria-controls').replace("-", " "))

        $('#v-pills-tab a').on('click', function(event) {
            event.preventDefault()
            // console.log(event.target.getAttribute("aria-controls"));

            $("li#activated").text(event.target.getAttribute("aria-controls").replace("-", " "))
        })
        </script>

</body>

</html>
<?php endif; ?>