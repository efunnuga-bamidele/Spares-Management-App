<?php
 if ( !isset($_SESSION) ) session_start();

if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :
  require_once './navigation/header.php';
  require_once './navigation/stripes.php'; 
?>
    
</head>
      <body>
      <?php // require_once './navigation/nav.php'; ?>

      <div class="row container-fluid" style="margin-top: 90px;">
      <div class="col-md-3 side-nav">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"  id="myTab" role="tablist" >
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#Manage-Spares" role="tab" aria-controls="Manage-Spares" aria-selected="true">Manage Spares</a>
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Manage-Location" role="tab" aria-controls="Manage-Location" aria-selected="false">Manage Location</a>
            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#Manage-Category" role="tab" aria-controls="Manage-Category" aria-selected="false">Manage Category</a>
            <!-- <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> -->
      </div>
      </div>
    <div class="col-md-9">
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
            <li class="breadcrumb-item active" id="activated" aria-current="page">Manage Spares</li>
          </ol>
      </nav>


      <!-- Tab panes -->
      <div class="tab-content" >
        <div class="tab-pane active " id="Manage-Spares" role="tabpanel" aria-labelledby="home-tab">
            <div class="container-flex row">
             
              <div class="col-md-6">
              <div class="table-responsive ">

                <div class="gv">
                <table id="example" class="table table-striped table-bordered grid table-hover" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                  </div>


              </div>
              <div class="col-md-6">
                <form action="./tools/create_spares.php" method="POST">
                  <div class="row">
                    <div class="form-group col-md-12">
                    <label for="spareName">Spare Name</label>
                    <input type="text" class="form-control" name="spareName" id="spareName">
                    </div>

                    <div class="form-group col-md-12">
                    <label for="spareCategory">Spare Category</label>
                    <input type="text" class="form-control" name="spareCategory" id="spareCategory">
                    </div>

                    <div class="form-group col-md-12">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" name="description" id="description"></textarea>
                    </div>

                    <div class="form-group col-md-6">
                    <label for="spareCode">Spare Code</label>
                    <input type="number" class="form-control" name="spareCode" id="spareCode">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="corespondingNumber">Coresponding Code</label>
                    <input type="number" class="form-control" name="corespondingNumber" id="corespondingNumber">
                    </div>

                    <div class="form-group col-md-6">
                    <label for="currentQuantity">Current Quantity</label>
                    <input type="number" class="form-control" name="currentQuantity" id="currentQuantity">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="quantitySold">Quantity Sold</label>
                    <input type="number" class="form-control" name="quantitySold" id="quantitySold">
                    </div>
                    
                    <div class="form-group col-md-6">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location">
                    </div>

                    <div class="form-group col-md-6">
                    <label for="dateCreated">Date Created</label>
                    <input type="text" class="form-control" name="dateCreated" id="dateCreated">
                    </div>
                    <div class=" form-group col-md-12 ">
                    <a href="#" class="form-control-sm btn btn-outline-success  " role="button" aria-pressed="true">Create Spare</a>
                    <a href="#" class="form-control-sm btn btn-outline-primary " role="button" aria-pressed="true">Edit Spare</a>
                    <a href="#" class=" form-control-sm btn btn-outline-danger " role="button" aria-pressed="true">Delete Spare</a>
                    <a href="#" class="form-control-sm btn btn-outline-warning " role="button" aria-pressed="true">Clear Field</a>
                    </div>

                  </div>
                  
                </form>

              </div>
            </div>  

        </div>
        <div class="tab-pane" id="Manage-Location" role="tabpanel" aria-labelledby="profile-tab">.page 2..</div>
        <div class="tab-pane" id="Manage-Category" role="tabpanel" aria-labelledby="messages-tab">..page 3.</div>
        <!-- <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...page 4</div> -->
      </div>
      

  </div>
    <!-- Footer section -->
    
        <div class="container">
        <?php require_once './navigation/footer.php' ?>
        </div>
    </div>
 
    <script>
        $('#v-pills-tab a').on('click', function (event) {
            event.preventDefault()
          console.log(event.target.getAttribute("aria-controls"));

          $("li#activated").text(event.target.getAttribute("aria-controls").replace("-"," "))
        })
  </script>
</body>
</html>
<?php endif; ?>