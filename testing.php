<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Add Cart</title>
</head>
<body>
    <div class="text-center my-5">
        <button class="btn btn-primary" id="add">Add+</button>
    </div>
    <div class="d-none " id="myDiv">
   <div class="d-flex justify-content-center">
    <button id="minus" class="btn btn-danger mx-2">-</button>
    <div id="number" style="height: 5vh; width:3%;background-color:gray;color:white;" class="mx-2 text-center"></div>
    <button id="plus" class="btn btn-success">+</button>
    </div>
</div>

<div class="d-none" id="myDiv">
    <button id="add">Show Div</button>
    <button id="plus">+</button>
    <input type="text" id="number" value="0" readonly>
</div>

<script>
   
   let increment = 0;
    // Show the div when the "Show Div" button is clicked
    document.getElementById('add').addEventListener('click', () => {
        const myDiv = document.getElementById('myDiv');
        myDiv.classList.remove('d-none');
        myDiv.classList.add('d-block');
    });

    // Increment the value when the "+" button is clicked
    document.getElementById('plus').addEventListener('click', () => {
        increment++;
        let numberInput = document.getElementById('number').innerHTML=increment;
    });

    document.getElementById('minus').addEventListener('click', () => {
        increment--;
        let numberInput = document.getElementById('number').innerHTML=increment;
        // numberInput.value = increment;
    });
</script>

</body>
</html>