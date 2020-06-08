
  <?php 


if(isset($_GET['p_id'])){
    $the_post_id =  $_GET['p_id'];}

        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_post_by_id = mysqli_query($connection, $query);               

        while($row = mysqli_fetch_assoc($select_post_by_id)){
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_user = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
        }

if(isset($_POST['update_post'])){
    
        $post_title = $_POST['title'];
        $post_user = $_POST['post_user'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status']; 
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']["tmp_name"];
        $post_tags = $_POST['tags'];
        $post_content = $_POST['content'];
    
        move_uploaded_file($post_image_temp,"../images/$post_image");
        
        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
            $select_image = mysqli_query($connection,$query);
            
            while($row = mysqli_fetch_array($select_image)){
                $post_image= $row['post_image'];
            }
        }
    
        $query = "UPDATE posts SET ";
        $query .="post_title = '{$post_title}', ";
        $query .="post_category_id = '{$post_category_id}', ";
        $query .="post_date = now(), ";
        $query .="post_user = '{$post_user}', ";
        $query .="post_status = '{$post_status}', ";
        $query .="post_content = '{$post_content}', ";
        $query .="post_image = '{$post_image}', ";
        $query .="post_tags = '{$post_tags}' ";
        $query .="WHERE post_id = '{$the_post_id}' ";

        $edit_post_query = mysqli_query($connection,$query);
    
        confirmQuery($edit_post_query);
        echo "<p class='bg-success'>The Post was updated. <a href='../post.php?p_id=$the_post_id'>View Post</a> or <a href='posts.php'>Edit Another Post</a></p>";
}


?>

    
        <form action="" method='post' enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value='<?php echo $post_title ?>' name='title' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
    <label for="post_category">Category</label>
    <select name="post_category" id="post_category">Category
<?php
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);               
        //confirmQuery($select_categories);
               
               
        while($row = mysqli_fetch_assoc($select_categories)){
        $cat_title = $row['cat_type'];
        $cat_id = $row['cat_id'];         
            
            echo "<option value='{$cat_id}'>{$cat_title}</option>";}

?>
        
    </select> 
    </div>
    <div class="form-group">
      <label for="post_user">User</label>
    <select name="post_user" id="post_user">
        <?php
        
        $query = "SELECT * FROM users";
        $select_categories = mysqli_query($connection, $query);               
        //confirmQuery($select_categories);
               
               
        while($row = mysqli_fetch_assoc($select_categories)){
        $username = $row['username'];
        $user_id = $row['user_id'];         
            
            echo "<option value='{$username}'>{$username}</option>";}

        ?>
        
    </select>   
    </div>
    
    <!-- <div class="form-group">
        <label for="post_user">Post post_user</label>
        <input value='<?php// echo $post_user ?>' name='post_user' class='form-control' type="text">    
    </div> -->



<div class="form-group">
   <label for="post_status">Post Status</label>
    <select name="post_status" id="">
        <option value='<?php echo $post_status ?>'><?php echo $post_status?></option>
       <?php if($post_status == 'published'){
    echo "<option value='draft'>Draft</option>";
}else {
    echo "<option value='published'>Publish</option>";
    
}
        
        ?>
    </select>
            </div>       
<!--
    <div class="form-group">
        <label for="status">Post Status</label>
        <input value='<?php echo $post_status ?>' name='status' class='form-control' type="text">    
    </div>
-->
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img width="150px" src="../images/<?php echo $post_image?>" alt="">
        <input value="<?php echo $post_image?>" name="image" type="file">    
    </div>
    
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input value='<?php echo $post_tags ?>'name='tags' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea  name='content' class='form-control' cols="30" rows="10" id=''><?php echo $post_content ?>
        </textarea>    
    </div>
    
    <div class="form-group">
        <label for="update_post">Submit</label>
        <input name='update_post' class='btn btn-primary' type="submit" value="Confirm Edits">    
    </div>
</form>