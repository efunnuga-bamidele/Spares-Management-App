<?php
  if ( !isset($_SESSION) ) session_start();
  if(empty($_SESSION['preferenceClass'])){
    $_SESSION['preferenceClass']  = 'tab one';
    }

      
  if(isset($_GET["reloadOne"])){
    $_SESSION['preferenceClass']  = 'tab one';
  }else if(isset($_GET["reloadTwo"])){
    $_SESSION['preferenceClass']  = 'tab two';
  }else if(isset($_GET["reloadThree"])){
    $_SESSION['preferenceClass']  = 'tab three';
  }else if(isset($_GET["reloadFour"])){
    $_SESSION['preferenceClass']  = 'tab four';
  }
  else if(isset($_GET["reloadFive"])){
    $_SESSION['preferenceClass']  = 'tab five';
  }
if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :

  require_once './navigation/header.php';
  require_once './navigation/stripes.php'; 

  $user_db = new PDO('sqlite:./schema/users.db');
  // Set errormode to exceptions
  $user_db->setAttribute(PDO::ATTR_ERRMODE, 
                          PDO::ERRMODE_EXCEPTION);

  // Create (connect to) SQLite database in file
  $setting_db = new PDO('sqlite:./schema/settings.db');
  // Set errormode to exceptions
  $setting_db->setAttribute(PDO::ATTR_ERRMODE, 
                          PDO::ERRMODE_EXCEPTION);

?>
    <link rel="stylesheet" href="./assets/css/preference.css">
</head>
      <body>
      <?php //require_once './navigation/nav.php'; ?>

      <div class="row container-fluid" style="margin-top: 90px;">
        <!-- navigation pills -->
        <div class="col-md-2 side-nav">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"
            id="myTab" role="tablist">

            <a <?php if($_SESSION['preferenceClass'] == 'tab one') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                id="User-tab" data-toggle="tab" href="#User-Profile" role="tab" aria-controls="User-Profile"
                aria-selected="true" onclick="reloadTable_10()">User Profile</a>
<!-- currently disabled -->
            <!-- <?php if($_SESSION["accessLevel"] == 4){
                if($_SESSION['preferenceClass'] == "tab two"){
                  echo "<a class='nav-link active' id='Settings-tab' data-toggle='tab' href='#Settings' role='tab' aria-controls='Settings' aria-selected='false' onclick='reloadTable_11()'>Settings</a>";
                }else{
                  echo "<a class='nav-link' id='Settings-tab' data-toggle='tab' href='#Settings' role='tab' aria-controls='Settings' aria-selected='false' onclick='reloadTable_11()'>Settings</a>";
                }
              
              }else{}
              ?> -->

            <a <?php if($_SESSION['preferenceClass']== 'tab three') {echo 'class="nav-link active"';} else {echo 'class="nav-link"';}?>
                id="manageContent-tab" data-toggle="tab" href="#Manage-Contents" role="tab"
                aria-controls="Manage-Contents" aria-selected="false" onclick="reloadTable_12()">Manage Contents</a>

            <?php if($_SESSION["accessLevel"] == 4){
                if($_SESSION['preferenceClass'] == "tab four"){
                  echo "<a class='nav-link active' id='manageUser-tab' data-toggle='tab' href='#Manage-Users' role='tab' aria-controls='Settings' aria-selected='false' onclick='reloadTable_13()'>Manage Users</a>";
                }else{
                  echo "<a class='nav-link' id='manageUser-tab' data-toggle='tab' href='#Manage-Users' role='tab' aria-controls='Settings' aria-selected='false' onclick='reloadTable_13()'>Manage Users</a>";
                }
              
              }else{}
              ?>
            

            <?php if($_SESSION["accessLevel"] == 4){
                if($_SESSION['preferenceClass'] == "tab five"){
                  echo "<a class='nav-link active' id='userLog-tab' data-toggle='tab' href='#Users-Log' role='tab' aria-controls='Users-Log' aria-selected='false' onclick='reloadTable_14()'>Users Log</a>";
                }else{
                  echo "<a class='nav-link' id='userLog-tab' data-toggle='tab' href='#Users-Log' role='tab' aria-controls='Users-Log' aria-selected='false' onclick='reloadTable_14()'>Users Log</a>";
                }
              
              }else{}
              ?>
        
        </div>
    </div>
    <!-- navigation pills end -->
    <div class="col-md-10">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Preference</a></li>
          <li class="breadcrumb-item active" id="activated" aria-current="page">User Profile</li>
        </ol>
    </nav>


      <!-- Tab panes -->
      <div class="tab-content" >
        <!-- Tab One -->
        <div <?php if($_SESSION['preferenceClass']== 'tab one') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="User-Profile" role="tabpanel" aria-labelledby="User-tab">
        <div class="container">
        <?php $email = $_SESSION["activeEmail"];
           $getUser = $user_db->query("SELECT * FROM userprofile WHERE email = '$email'");
           $row = $getUser->fetch();
          ?>
              <div class="row gutters">
              <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
              <div class="card h-100">
                <div class="card-body">
                  <div class="account-settings">
                    <div class="user-profile">
                      <div class="user-avatar">
                        <img src="./assets/images/user.png" alt="Maxwell Admin">
                      </div>
                      <h5 class="user-name"><?php echo $_SESSION['activeUserFull']; ?></h5>
                      <h6 class="user-email"><?php echo $_SESSION['activeEmail']; ?></h6>
                    </div>
                    <div class="about">
                      <h5>About</h5>
                      <p class="small mb-3"><span class="badge badge-dark"><?php echo $row["country"]; ?></span> | <span class="badge badge-success">Active User</span></p>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
              <div class="card h-100">
                <!--  -->
                
                <div class="card-body">
                           <!-- alert notification -->
               <?php
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['preferenceClass']=== "tab one"){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['preferenceClass']=== "tab one"){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
                            <!-- alert notification -->
                <form action="./tools/settings_function.php" method="post">
                  <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <h6 class="mb-2 text-primary">Personal Details</h6>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="firstName">Firstname</label>
                      <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $row['firstName']; ?>" />
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" hidden>
                      <div class="form-group">
                      <label for="id" hidden>Row Id</label>
                      <input type="text" id="id" name="id" class="form-control" value="<?php echo $row['id']; ?>" hidden />
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="lastName">Lastname</label>
                      <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $row['lastName']; ?>" />
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="emailAddress">Email</label>
                      <input type="email" class="form-control" name="emailAddress" id="emailAddress" value="<?php echo $row['email']; ?>" />
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="contry">Country</label>
                      <input type="text" class="form-control" name="contry" id="contry" value="<?php echo $row['country']; ?>" />
                      </div>
                    </div>
                  </div>
                  <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <h6 class="mt-3 mb-2 text-primary">Look and Feel</h6>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="theme">Theme</label>
                      <select name="theme" id="theme" class="form-control">
                      <?php echo "<option selected=".$row['theme'].">" . $row['theme'] ."</option>"; ?>
                      <?php $getTheme = $user_db->query("SELECT * FROM theme");
                      foreach($getTheme as $feed) : ?>
                        <?php echo "<option value =".$feed["themeName"]." >"
                        .$feed["themeName"]."</option>"; 
                        ?> 
                          <?php endforeach; ?>
                      </select>
                      </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <h6 class="mt-3 mb-2 text-primary">Change Password</h6>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="oldPassword">Old Password</label>
                      <input name="oldPassword" type="password" class="form-control" id="oldPassword" value="" />
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="newPassword">New Password</label>
                      <input name="newPassword" type="password" class="form-control" id="newPassword" />
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                      <div class="form-group">
                      <label for="confirmPassword">Confirm Password</label>
                      <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" />
                      </div>
                    </div>
                  </div>
                  <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="text-right">
                        <button type="submit" name="changePassword" class="btn btn-info">Change Password</button>
                        <button type="submit" name="updateProfile" class="btn btn-primary">Update Profile</button>
                        <button type="submit" name="cancel" class="btn btn-secondary">Cancel</button>
                      </div>
                    </div>
                  </div>
                  </form>
                </div>
            
                <!--  -->
              </div>
              </div>
              </div>
              </div>

          </div>
        <!-- End One -->
        <!-- Tab Two -->
        <div <?php if($_SESSION['preferenceClass']== 'tab two') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Settings" role="tabpanel" aria-labelledby="Settings-tab">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, commodi? Et omnis distinctio tempora aut aliquam cupiditate fuga voluptatum eum maxime sapiente minus, ratione mollitia ullam ipsa nobis libero sint?
        </div>
        <!-- End Two -->
        <!-- Tab Three -->
        <div <?php if($_SESSION['preferenceClass']== 'tab three') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Manage-Contents" role="tabpanel" aria-labelledby="manageContent-tab">
        <!-- form 1 -->
        <div class="container-fluid">

                      <!-- alert notification -->
                      <?php
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['preferenceClass']=== "tab three"){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['preferenceClass']=== "tab three"){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
                            <!-- alert notification -->
        <form action="./tools/settings_function.php" method="post" class="row">
        <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=1");
            $feedBack = $getContent->fetch();
            if($feedBack > 0) : ?>
            <div class="col-md-2 form-group">
              <label for="">Content ID</label>
              <input type="text" class="form-control" readonly name="id-1" value="<?php echo $feedBack['id']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Heading</label>
              <input type="text" class="form-control" name="head-1" maxlength="40" value="<?php echo $feedBack['heading']; ?>" readonly>
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Body</label>
              <textarea type="text" class="form-control" rows="4" name="body-1"><?php echo $feedBack['content']; ?></textarea>
            </div>
            <?php endif; ?>
           <div class="col-md-2 form-group">
           <label for="">Action</label> 
           <button type="submit" class="btn btn-outline-primary form" name="content-1">Update Content <?php echo $feedBack['id']; ?></button>
           </div>
          </form>
       
        <!-- form 2 -->
        <form action="./tools/settings_function.php" method="post" class="row">
        <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=2");
            $feedBack = $getContent->fetch();
            if($feedBack > 0) : ?>
            <div class="col-md-2 form-group">
              <label for="">Content ID</label>
              <input type="text" class="form-control" readonly name="id-2" value="<?php echo $feedBack['id']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Heading</label>
              <input type="text" class="form-control" name="head-2" maxlength="40" value="<?php echo $feedBack['heading']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Body</label>
              <textarea type="text" class="form-control" rows="4" name="body-2"><?php echo $feedBack['content']; ?></textarea>
            </div>
            <?php endif; ?>
           <div class="col-md-2 form-group">
           <label for="">Action</label> 
           <button type="submit" class="btn btn-outline-primary form" name="content-2">Update Content <?php echo $feedBack['id']; ?></button>
           </div>
          </form>
        <!-- form 3 -->
        <form action="./tools/settings_function.php" method="post" class="row">
        <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=3");
            $feedBack = $getContent->fetch();
            if($feedBack > 0) : ?>
            <div class="col-md-2 form-group">
              <label for="">Content ID</label>
              <input type="text" class="form-control" readonly name="id-3" value="<?php echo $feedBack['id']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Heading</label>
              <input type="text" class="form-control" name="head-3" maxlength="40" value="<?php echo $feedBack['heading']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Body</label>
              <textarea type="text" class="form-control" rows="4" name="body-3"><?php echo $feedBack['content']; ?></textarea>
            </div>
            <?php endif; ?>
           <div class="col-md-2 form-group">
           <label for="">Action</label> 
           <button type="submit" class="btn btn-outline-primary form" name="content-3">Update Content <?php echo $feedBack['id']; ?></button>
           </div>
          </form>
        <!-- form 4 -->


        <form action="./tools/settings_function.php" method="post" class="row">
        <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=4");
            $feedBack = $getContent->fetch();
            if($feedBack > 0) : ?>
            <div class="col-md-2 form-group">
              <label for="">Content ID</label>
              <input type="text" class="form-control" readonly name="id-4" value="<?php echo $feedBack['id']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Heading</label>
              <input type="text" class="form-control" name="head-4" maxlength="40" value="<?php echo $feedBack['heading']; ?>">
            </div>
            <div class="col-md-4 form-group">
              <label for="">Content Body</label>
              <textarea type="text" class="form-control" rows="4" name="body-4"><?php echo $feedBack['content']; ?></textarea>
            </div>
            <?php endif; ?>
           <div class="col-md-2 form-group">
           <label for="">Action</label> 
           <button type="submit" class="btn btn-outline-primary form" name="content-4">Update Content <?php echo $feedBack['id']; ?></button>
           </div>
          </form>


        </div>
        </div>
        <!-- End Three -->
        <!-- Tab Four -->
        <div <?php if($_SESSION['preferenceClass']== 'tab four') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Manage-Users" role="tabpanel" aria-labelledby="manageUser-tab">

                   <!-- alert notification -->
                   <?php
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage']) && $_SESSION['preferenceClass']=== "tab four"){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage']) && $_SESSION['preferenceClass']=== "tab four"){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
                            <!-- alert notification -->       
          <!-- Table -->
          <div class="table-responsive ">

<div class="gv">
<table id="TABLE_14"
class="display table table-striped table-bordered grid table-hover small text-nowrap "
style="width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>EMAIL</th>
            <th>ACCESS LEVEL</th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 0; $result = $user_db->query("SELECT * FROM userprofile"); foreach($result as $row) : $count +=1; ?>
        <tr>
          <td><?php echo $count?></td>
          <td><a href="./tools/settings_function.php?resetPassword=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" type="submit">Reset Password</a></td>
          <?php if($row['accessLevel'] == "4") : ?>
          <td><a href="./tools/settings_function.php?makeUser=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" type="submit">Make User</a></td>
          <?php else : ?>
          <td><a href="./tools/settings_function.php?makeAdmin=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" type="submit">Make Admin</a></td>
          <?endif; ?>
          <td><a href="./tools/settings_function.php?deleteProfile=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" type="submit">Delete Profile</a></td>
          <td><?php echo $row['firstName']; ?></td>
          <td><?php echo $row['lastName']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['accessLevel']; ?></td>
        </tr>
        <?php endforeach; ?>
       </tbody>
        <tfoot>
            <tr>
            <th>ID</th>
            <th>Action</th>
            <th>Action</th>
            <th>Action</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>EMAIL</th>
            <th>ACCESS LEVEL</th>
            </tr>
        </tfoot>
    </table>
    </div>
  </div>


</div>
        <!-- End Four -->
        <!-- Tab Five -->
        <div <?php if($_SESSION['preferenceClass']== 'tab five') {echo 'class="tab-pane active"';} else {echo 'class="tab-pane"';}?> id="Users-Log" role="tabpanel" aria-labelledby="userLog-tab">
         <!-- Table -->
         <div class="table-responsive ">

<div class="gv">
<table id="TABLE_9"
class="display table table-striped table-bordered grid table-hover small text-nowrap "
style="width:100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>FULL NAME</th>
            <th>EMAIL</th>
            <th>DATE & TIME STOCK</th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 0; $result = $user_db->query("SELECT * FROM userlog"); foreach($result as $row) : $count +=1; ?>
        <tr>
 
          <td><?php echo $count?></td>
          <td><?php echo $row['fullName']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['date']; ?></td>
        </tr>
        <?php endforeach; ?>
       </tbody>
        <tfoot>
            <tr>
            <th>ID</th>
            <th>FULL NAME</th>
            <th>EMAIL</th>
            <th>DATE & TIME STOCK</th>
            </tr>
        </tfoot>
    </table>
    </div>
  </div>
        </div>
        <!-- End Five -->
      </div>
      

  </div>
    <!-- Footer section -->
    
        <div class="container">
        <?php require_once './navigation/footer.php' ?>
        </div>
    </div>
 
    <script>
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