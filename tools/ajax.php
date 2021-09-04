<?php
   
    // Create (connect to) SQLite database in file
    $ajax_db = new PDO('sqlite:../schema/ajax.db');
    // Set errormode to exceptions
    $ajax_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);

// if(!empty($_GET['age'])){


   // Retrieve data from Query String
   $age = $_GET['age'];
   $sex = $_GET['sex'];
   $wpm = $_GET['wpm'];
   // echo "Received "+ $age;

     // Insert a new row in the table for each person returned
     if(!empty($age) && !empty($age) && !empty($age)){
      $query = $ajax_db->exec("INSERT INTO ajaxtable ('age','sex','wpm') VALUES ('$age','$sex','$wpm')");
      echo "Query: " . $query . "<br />";
      }
      
   //build query
   $qry_result  = $ajax_db->query("SELECT * FROM ajaxtable");

   $display_string = '<div class="table-responsive ">';
   $display_string .= '<div class="gv">';
   $display_string .= '<table id="example" class="table table-striped table-bordered grid" style="width:100%;">';
   $display_string .= '<thead>';
   $display_string .= "<tr>";
   $display_string .= "<th>ID</th>";
   $display_string .= "<th>Age</th>";
   $display_string .= "<th>WPM</th>";
   $display_string .= "<th>Gender</th>";
   $display_string .= "</tr>";
   $display_string .= "</thead>";
   
   // $row = $qry_result->fetch();
   //Build Result String
   while($row = $qry_result->fetch()) {
    $display_string .= "<tr>";
      $display_string .= "<td>$row[id]</td>";
      $display_string .= "<td>$row[age]</td>";
      $display_string .= "<td>$row[wpm]</td>";
      $display_string .= "<td>$row[sex]</td>";
      $display_string .= "</tr>";
   }
 
   $display_string .= "</table>";
   $display_string .= "</div>";
   $display_string .= "</div>";
   echo $display_string;
// }
?>
