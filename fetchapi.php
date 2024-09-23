<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
?>

<div id="demo"></div>
<script>
 let url = "http://localhost/API/API's/read.php";
let options = {
  method: 'GET', // GET, POST, PUT, DELETE, etc.
  headers: {
    'Content-Type': 'application/json',
 
  }
};

fetch(url, options)
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }
    return response.json(); 
  })
  .then(data => {
    console.log('Success:', data);
    // Use the data here
    document.getElementById("demo").innerHTML = JSON.stringify(data, null, 2);
  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });


</script>
