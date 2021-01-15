<?php
    
    $servername = "localhost";
    $username = "id15647380_chrona_kapfileup";
    $password = "Gajah123mada&";
    $dbname = "id15647380_chronabay";

    // Create connection
    $kon = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($kon->connect_error) {
        die("Connection failed: " . $kon->connect_error);
    }

?>