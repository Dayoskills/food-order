<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php 
            if (isset($_GET['id'])) {

                //Get the ID and all other details
                $id = $_GET['id'];

                //Create SQL Query to get other details
                $sql = "SELECT * FROM tbl_category WHERE id= $id";

                //Execute the Query
                $result = mysqli_query($conn, $sql);

                //Count the Rows to check whether the ID is valid or not
                $resultchecker = mysqli_num_rows($result);

                if ($resultchecker == 1) {

                    //Get all the data
                    $row = mysqli_fetch_assoc($result);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else {
                 
                $_SESSION['no_category_found'] = "<div class='error'>Category Not Found</div>";
                //Redirect to Manage Category Page
                header('location:' .SITEURL. 'admin/manage_category.php');
                }
            }
            else {
            //Failed to Get ID 
            $_SESSION['failed_id'] = "<div class='error'>Unauthorised Access</div>";
            //Redirect to Manage Category Page
            header('location:' .SITEURL. 'admin/manage_category.php');

            //header('location: manage_category.php');
            }
    
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-10">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if ($current_image != "") {
                                //Display the image name
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category_image/<?php echo $current_image;?>" width = 150px
                                <?php
                            } else {
                                //Display error message
                                echo "<div class='error'>Image Not Added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td> Featured: </td>
                        <td>
                            <input <?php if($featured== "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                            <input <?php if($featured== "No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                        </td>
                </tr>

                <tr>
                    <td> Active: </td>
                        <td>
                            <input <?php if($active== "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                            <input <?php if($active== "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                        </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php 
           
           if (isset($_POST['submit'])) {

                //Get all the values from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //Updating new image if selected 
                //Check whether image is selected or not
                if (isset($_FILES['image']['name'])) {
                    //Get the image details
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is available or not
                    if ($image_name != "") {
                        //image Available
                        //A. Upload the new image
                         
                        //Auto rename our Image
                        //Get the extension of our image (jpg, png, gif etc) e.g "specialfood1.jpg"
                        $ext = end(explode(".", $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999). '.'.$ext; //e.g Food_Category_283.jpg 

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category_image/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded, then we will stop the proccess and redirect with error message
                        if ($upload == FALSE) {
                            
                            //Set Message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            //Redirect to Add Category Page
                            header('location:' .SITEURL. 'admin/add_category.php');
                            //header('location: admin/manage_category.php');
                            //Stop the process
                            die();
                        }

                        //B. Remove the current image if available
                        if ($current_image != "") {
                            
                            $remove_path = "../images/category_image/". $current_image;

                            $remove = unlink($remove_path);

                            //Check whether the image is removed or not
                            //if failed to remove image, display error message and stop the process
                            if ($remove == FALSE) {

                                //failed to remove image
                                $_SESSION['failed_remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                                //Redirect to Manage Category Page
                                header('location:' .SITEURL. 'admin/manage_category.php');
                                //header('location: admin/manage_category.php');
                                //Stop the process
                                die();
                            }
                        }
                        
                    }else {
                        $image_name = $current_image;
                    }

                } else {
                    $image_name = $current_image;
                }

                //Update the database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //Execute the Query
                $result2 = mysqli_query($conn, $sql2);

                //Redirect to manage category with message 
                //Check whether is executed or not
                if ($result2 == TRUE) {
                    
                    //Category updated
                    $_SESSION['update'] = "<div class= 'success'>Category Updated Successfully</div>";
                    header('location: manage_category.php');
                }
                else {
                    //Failed to update category
                    $_SESSION['failed'] = "<div class= 'error'>Failed to Update Category </div>";
                    header('location: manage_category.php');
                }
           }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>