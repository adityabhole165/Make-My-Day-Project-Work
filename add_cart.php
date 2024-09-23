<div class="container" style="display: flex;">
<button id="minus">
<img src="minus.png" alt="" height="30vh">
</button>
<div style="width: 3%; height:7vh;background-color:black;margin-left:3px;color:white;text-align:center;"><div id="counter" style="color:white;"></div></span></div>
<button class="" style="margin-left:3px;" id="plus">
<img src="add.png" alt="" height="30vh">
</button>
</div>
<script>
    let counter=document.getElementById("counter");
    let sum=0;
    document.getElementById('plus').addEventListener('click',()=>{
     sum += counter;
     counter.value=sum;
     console.log(sum);
    })
</script>
