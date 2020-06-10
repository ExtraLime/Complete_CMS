
  
<?php 
if(isset($_POST['create_post'])){
    
        $post_title = $_POST['title'];
        $post_user = $_POST['post_user'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];

    
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']["tmp_name"];
        $post_tags = $_POST['tags'];
        $post_content = $_POST['content'];
        $post_date = date('y-m-d');        
        $post_comment_count = 0;
        

        move_uploaded_file($post_image_temp,"../images/$post_image");


        $stmt = mysqli_prepare($connection, "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if($stmt === FALSE){ die(mysqli_error($connection)); }
        mysqli_stmt_bind_param($stmt, 'issssssis', $post_category_id, $post_title, $post_user, $post_date, $post_image, $post_content, $post_tags, $post_comment_count, $post_status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
    $post_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>The Post was created. <a href='../post.php?p_id=$post_id'>View Post</a> or <a href='posts.php'>View Another Post</a></p>";
}

?>
  <form action="" method='post' enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="titles">Post Title</label>
        <input name='title' class='form-control' type="text">    
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
      <label for="post_author">Author</label>
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
        <label for="author">Post Author</label>
        <input name='author' class='form-control' type="text">    
    </div> -->
    
<div class="form-group">
   <label for="post_status">Post Status</label>
    <select name="post_status" id="">
        <option value='draft'>Draft</option>
        <option value='published'>Publish</option>
        

    </select>
            </div>      
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name='post_image'>    
    </div>
    
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input name='tags' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea  name='content' class='form-control' cols="30" rows="10" id=''></textarea>    
    </div>
    
    <div class="form-group">
        <label for="create_post">Submit</label>
        <input name='create_post' class='btn btn-primary' type="submit" value="Publish Post">    
    </div>
</form>
            