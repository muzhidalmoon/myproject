<?php 
                    $servername = 'localhost';
                    $username = 'root';
                    $password_database = '';
                    $dbname = 'crud_app';
    
                    // conneting database
    
                    $conn = mysqli_connect($servername, $username, $password_database,$dbname);
    
                    if(!$conn){
                        die('Connection failed'.mysqli_connect_error());
                    }
    
?>