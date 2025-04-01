<?php include('partials/menu.php'); ?>

<?php 
    //check whether ID is set
    if (isset($_GET['id'])) 
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        //execute the query
        $result2 = mysqli_query($conn, $sql2);

        //Get the values based on query selected
        $row2 = mysqli_fetch_assoc($result2);

        //Get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else 
    {
        //Redirect to manage food Page
        header('location: admin/manage_food.php');    
        
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td> <input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5"></textarea></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>" ></td>
                </tr>

                <tr>
                    <td>Current Price:</td>
                    <td>
                        <?php if ($current_image == "") 
                        {
                            //Image not available
                            echo "<div class='error'>Image Not Available</div>";
                        } 
                        else 
                        {
                            //Image is available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food_image/<?php echo $current_image; ?>" width= "150">
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php 
                                //Query to get Active Categories
                                $sql = "SELECT * FROM tbl_category WHERE active= 'Yes'";
                                //Execute the Query 
                                $result = mysqli_query($conn, $sql);
                                //Count Rows
                                $count = mysqli_num_rows($result);

                                //check whether category available or not
                                if ($count > 0) {
                                    
                                    //category Available
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                            <option <?php if($current_category==$category_id) {echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php 
                                    }
                                } else {
                                    //Category Not Available
                                    echo "<option value='0'>Category Not Available</option>";
                                }
                            ?>
                        
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php $id; ?>">
                        <input type="hidden" name="current_image" value="<?php $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
                
        <?php 

            if (isset($_POST['submit']))
            {
                //echo "button clicked";

                //1. Get all the details from the form

                //2. update the image if selected

                //3. remove the image if new image is uploaded and current image exists

                //4. update the food in database

                //5. redirect to manage food page with session message 
                
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>