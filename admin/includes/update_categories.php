
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
          $cat_title_update = mysqli_real_escape_string($connection,$_POST['cat_title']);
           $query = "UPDATE categories SET cat_type = '{$cat_title_update}' WHERE cat_id = {$cat_id} ";

            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_type=? WHERE cat_id=?");
           
            if($stmt === FALSE){ die(mysqli_error($connection)); }
            mysqli_stmt_bind_param($stmt, 'si', $cat_title_update, $cat_id);
            mysqli_stmt_execute($stmt);
          }
          
       ?>

   </div>
   <div class="form-group">
       <input class="btn btn-primary" type="submit" name="update_category" value='Update Category'>
   </div>                               
</form>        