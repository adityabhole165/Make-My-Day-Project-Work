<?php
error_reporting(0);
$project_mode="localhost";

if($project_mode=="localhost"){
$con=mysqli_connect('localhost','root','','mmd');

} else{
    
    $con=mysqli_connect('mymmd.com','rnsoftwa_mmduser','bCn6UpZaflb4','rnsoftwa_mmd');
}

?>