
  
<?php 
if(isset($_POST['create_post'])){
    
        $post_title = $_POST['title'];
        $post_author = $_POST['author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['status'];

    
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']["tmp_name"];
        $post_tags = $_POST['tags'];
        $post_content = $_POST['content'];
        $post_date = date("d-m-y");        
        $post_comment_count = 0;


        move_uploaded_file($post_image_temp,"../images/$post_image");
    
    $query = "INSERT INTO posts(post_category_id, post_title, post_author,
    post_date,post_image,post_content,post_tags,post_comment_count, post_status) ";
    $query .= "VALUES ({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}') ";
    
    $insert_post_query = mysqli_query($connection,$query);
    confirmQuery($insert_post_query);
    
}

?>
  <form action="" method='post' enctype="multipart/form-data">
   
    <div class="form-group">
        <label for="titls">Post Title</label>
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
        <label for="author">Post Author</label>
        <input name='author' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
        <label for="status">Post Status</label>
        <input name='status' class='form-control' type="text">    
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
        <textarea  name='content' class='form-control' cols="30" rows="10" id=''>
        </textarea>    
    </div>
    
    <div class="form-group">
        <label for="create_post">Submit</label>
        <input name='create_post' class='btn btn-primary' type="submit" value="Publish Post">    
    </div>
</form>
            