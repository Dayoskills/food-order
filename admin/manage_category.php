<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br> <br> 

    <?php 
            if (isset($_SESSION['add'])) {

                echo $_SESSION['add'];  //Display Message
                unset($_SESSION['add']);  //remove message
            }

            if (isset($_SESSION['remove_image'])) {

                echo $_SESSION['remove_image'];  //Display Message
                unset($_SESSION['remove_image']);  //remove message
            }

            if (isset($_SESSION['delete'])) {

                echo $_SESSION['delete'];  //Display Message
                unset($_SESSION['delete']);  //remove message
            }

            if (isset($_SESSION['failed_id'])) {

                echo $_SESSION['failed_id'];
                unset ($_SESSION['failed_id']);
            }

            if (isset($_SESSION['no_category_found'])) {

                echo $_SESSION['no_category_found'];
                unset($_SESSION['no_category_found']);
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if (isset($_SESSION['failed_remove'])) {
                echo $_SESSION['failed_remove'];
                unset($_SESSION['failed_remove']);
            }
        ?>

        <br><br>

            <!-- Button to Add Admin -->
            <a href="add_category.php" class="btn-primary">Add Category</a>
            <br> <br> <br>

            <table class="tbl-full"> 
                <tr>
                    <th>S/N</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php 
                
                    //Query to get all category from database
                    $sql = "SELECT * FROM tbl_category";

                    //Execute the Query
                    $result = mysqli_query($conn, $sql);

                    //Count Rows
                    $resultcheck = mysqli_num_rows($result);

                    //Create serial number variable and assign value as 1
                    $sn = 1;

                    //Check whether we have data in database or not
                    if ($resultcheck > 0) {

                        //We have data in database
                        //Get the data and display
                        while ($row = mysqli_fetch_assoc($result)) {

                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>

                                <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $title; ?></td>

                                        <td>

                                            <?php 
                                                //Check whether image name is available or not
                                                if ($image_name!= "") {

                                                    //Display the image
                                                    ?>

                                                    <img src="<?php echo SITEURL; ?>images/category_image/<?php echo $image_name; ?>" width="100px">
                                                    
                                                    <?php
                                                }
                                                else {
                                                    //Display the message
                                                    echo "<div class='error'>Image Not Added</div>";
                                                }
                                            ?>

                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="update_category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>

                                            <!-- <a href="delete_category.php" class="btn-danger">Delete Category</a> -->
                                            <a href="<?php echo SITEURL; ?>admin/delete_category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                    </td>
                                </tr>

                            <?php 
                        }
                    }
                    else {
                        //We don't have data
                        //We will display the message inside table
                        ?>

                        <tr>
                            <td colspan="6"><div class="error">No Category Added</div></td>
                        </tr>

                        <?php
                    }
                ?>
 
            </table>

    </div>
</div>

<?php include('partials/footer.php');?>