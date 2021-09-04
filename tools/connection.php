<?php

    // Create (connect to) SQLite database in file
    $user_db = new PDO('sqlite:../schema/users.db');
    // Set errormode to exceptions
    $user_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);



    // Create (connect to) SQLite database in file
    $setting_db = new PDO('sqlite:../schema/settings.db');
    // Set errormode to exceptions
    $setting_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);


    // Create (connect to) SQLite database in file
    $store_db = new PDO('sqlite:../schema/store.db');
    // Set errormode to exceptions
    $store_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);



?>