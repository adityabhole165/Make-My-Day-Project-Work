<?php

include("constant.php");
// if($project_mode == "localhost"){
//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $dbname = "mmd";
//     // $conn = mysqli_connect($servername, $username, $password, $dbname);

// }
// else{
//     $servername = "localhost"; // Update with your server name
// $username = "rnsoftwa_mmduser"; // Update with your database username
// $password = " bCn6UpZaflb4"; // Update with your database password
// $dbname = "rnsoftwa_mmd";
// // $conn = mysqli_connect($servername, $username, $password, $dbname);

// }
if($project_mode=="localhost"){
    $con=mysqli_connect('localhost','root','','mmd');
    
    } else{
        
        $con=mysqli_connect('mymmd.com','rnsoftwa_mmduser','bCn6UpZaflb4','rnsoftwa_mmd');
    }
    


// $conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
//   echo "database connected ";
}
//mysqli_close($conn);
?>