
<form action="" method="post" id="cat_input">
   <div class="form-group">
      <label for="cat_title">Edit Category Title</label>


        <?php
       if(isset($_GET['edit'])){
           $cat_id = $_GET['edit'];


        $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
        $edit_categories = mysqli_query($connection, $query);               

        while($row = mysqli_fetch_assoc($edit_categories)){
        $cat_title = $row['cat_type'];
        $cat_id = $row['cat_id'];                               

                ?>
     <input value="<?php if(isset($cat_title)){echo $cat_title;}?>" class="form-control" type="text" name="cat_title">





        <?php }}?>
        <?php
          if(isset($_POST['update_category'])){
          $cat_title_update = $_POST['cat_title'];
           $query = "UPDATE categories SET cat_type = '{$cat_title_update}' WHERE cat_id = {$cat_id} ";

           $update_query = mysqli_query($connection,$query);
            if(!$update_query){
                die( "Query Failed" . mysqli_error($connection));
            }
          }
       ?>

   </div>
   <div class="form-group">
       <input class="btn btn-primary" type="submit" name="update_category" value='Update Category'>
   </div>                               
</form>        