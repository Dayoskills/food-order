<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php 
            if (isset($_SESSION['upload'])) {

                echo $_SESSION['upload']; //Display message
                unset($_SESSION['upload']); //remove message
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Title of the Food"></td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="description of the food"></textarea></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price"></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php 
                                //Create PHP code to display categories from database
                                //1. Create SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //Execute the Query
                                $result = mysqli_query($conn, $sql);

                                //Count rows to check whether we have categories or not
                                $count = mysqli_num_rows($result);

                                //If count is greater than zero, we have categories else we donot have categories
                                if ($count > 0) {

                                    //we have categories
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        //Get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                } else {
                                    
                                    //we donot have categories
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php 
                                }

                                //2. Display on Dropdown                            
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php 

            if (isset($_POST['submit'])) {

                //Add the Food in Database
                
                //1.Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //Check whether radio button for featured and active are checked or not
                if (isset($_POST['featured'])) {

                    $featured = $_POST['featured'];
                }else {
                    $featured = "No"; //Setting the Default value 
                }

                if (isset($_POST['active'])) {

                    $active = $_POST['active'];
                }else {
                    $active = "No"; //Setting default value
                }

                //2.Upload the Image if selected
                //Check whether the select image is clicked or not and upload the image only if the image is selected
                if (isset($_FILES['image']['name'])) {

                    //Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //Check whether the image is selected or not and upload image only if selected
                    if ($image_name != "") {

                        //Image is selected
                        //Rename the Image
                        //Get the extension of selected image(jpg, gif, png, etc)
                        $ext = end(explode('.', $image_name));

                        //Create new name for Image
                        $image_name = "Food_name_".rand(0000,9999).".".$ext;

                        //Upload the image
                        //Get the Src path and destination path 

                        //Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination path for the image to be uploaded
                        $dst = "../images/food_image/".$image_name;

                        //Finally upload the food Image
                        $upload = move_uploaded_file($src, $dst);

                        //Check whether image uploaded or not
                        if ($upload == FALSE) {

                            //Failed to upload the Image
                            //Redirect to Add Food page with error message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            header('location: admin/add_food.php');
                            //stop the process
                            die();
                        }
                    }
                } else {
                    $image_name = ""; //Setting default value as blank
                }

                //3.Insert into Database
                //Create a SQL Query to save or add food
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active' 
                    ";

                    //Execute the query
                    $result2 = mysqli_query($conn, $sql2);

                    //check whether data is inserted successfully
                    if ($result2 == TRUE) {

                        //Data inserted successfully and redirect to manage food page 
                        $_SESSION['add'] = "<div class= 'success'>Food Added Successfully</div>";
                        //header('location:'.SITEURL.'admin/manage_food.php');
                        header('location: manage_food.php');
                    }else {
                        
                        //Failed to insert data and redirect to manage food page 
                        $_SESSION['add'] = "<div class= 'error'>Failed to Add Food</div>";
                        header('location:'.SITEURL.'admin/manage_food.php');
                    }
                
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>