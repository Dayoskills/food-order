<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br> <br> 

<!-- Button to Add Admin -->
<a href="add_food.php" class="btn-primary">Add Food</a>

<br> <br> <br>

<?php 
    if (isset($_SESSION['add'])) {

        echo $_SESSION['add']; //Display message
        unset($_SESSION['add']); //Remove message
    }

    if (isset($_SESSION['delete'])) {

        echo $_SESSION['delete']; //Display message
        unset($_SESSION['delete']); //Remove message
    }

    if (isset($_SESSION['upload'])) {

        echo $_SESSION['upload']; //Display message
        unset($_SESSION['upload']); //Remove message
    }

    if (isset($_SESSION['unauthorised'])) {

        echo $_SESSION['unauthorised']; //Display message
        unset($_SESSION['unauthorised']); //Remove message
    }
?>

<table class="tbl-full"> 
    <tr>
        <th>S.N</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>

    <?php 
        //create a SQL Query to get aall the food
        $sql = "SELECT * FROM tbl_food";

        //Execute the query
        $result = mysqli_query($conn, $sql);

        //Count Rows to check whether we have foods or not
        $count = mysqli_num_rows($result);

        //Create serial number variable and set default value as 1
        $sn = 1;

        if ($count > 0) {

            //We have food in database
            //Get the foods from database and display
            while ($row = mysqli_fetch_assoc($result)) {

                //Get the values from individual columns
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                ?>

                <tr>
                    <td> <?php echo $sn++; ?></td>
                    <td> <?php echo $title; ?></td>
                    <td> $<?php echo $price; ?></td>
                    <td>
                        <?php
                            //check whether we have image or not
                            if ($image_name == "") {

                                //we do not have image, display error message
                                echo "<div class='error'>Image Not Added</div>";
                            } else {
                                
                                //we have image, display image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food_image/<?php echo $image_name; ?>" width="100px">
                                <?php
                            }
                        ?>
                    </td>
                    <td> <?php echo $featured; ?></td>
                    <td> <?php echo $active; ?></td>
                    <td>
                        <a href="update_food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update Food</a>
                        <!-- <a href="delete_food.php" class="btn-danger">Delete Food</a> -->
                        <a href="<?php echo SITEURL; ?>admin/delete_food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>

                    </td>
                </tr>

                <?php
            }
        }else {
            
            //Food not added in database
            echo "<tr> <td colspan= '7' class='error'> Food Not Added</td></tr> ";
        }
    
    ?>


</table>

    </div>
</div>

<?php include('partials/footer.php');?>