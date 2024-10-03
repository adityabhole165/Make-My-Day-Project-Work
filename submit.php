<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Form Without Reload</title>
</head>
<body>
    <?php
include('connection.php');
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $menu_id = $_POST['menuId'];
        $menu_name = $_POST['menuName'];
        $menu_des = $_POST['desc'];
        $menu_rate = $_POST['rate'];
        $menu_img = $_POST['img'];
        $menu_discount = $_POST['discount'];

        $sql = "INSERT INTO m_menuitems(MenuId,MenuSubCategoryName,MenuName,MenuImageUrl,Description,Rate,MenuTypeId,Discount)
                VALUES('$menu_id','','$menu_name','$menu_img','$menu_des','$menu_rate','','$menu_discount')";
        $run = mysqli_query($con, $sql);

        if ($run) {
            echo '<script>alert("Successfully inserted")</script>';
        } else {
            echo '<script>alert("Error Occurred")</script>';
        }
    }
    ?>
    <form id="myForm">
        <input type="hidden" value="2" name="menuId" required>
        <input type="hidden" value="Tomato Soup" name="menuName" required>
        <input type="hidden" value="Tomato SOup" name="desc" required>
        <input type="hidden" value="100" name="rate" required>
        <input type="hidden" value="image" name="img" required>
        <input type="hidden" value="10" name="discount" required>

        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);

            fetch('submit.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.text(); // or response.json() depending on your server response
            })
            .then(data => {
                console.log('Success:', data);
                // Handle the response data here
            })
            .catch((error) => {
                console.error('Error:', error);
                // Handle errors here
            });
        });
    </script>
</body>
</html>
