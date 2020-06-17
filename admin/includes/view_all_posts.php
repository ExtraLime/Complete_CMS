<?php include "delete_modal.php";

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $checkBoxValue){
        $bulk_options = $_POST['bulk'];
        switch($bulk_options){
                case 'publish';
                    $query = "UPDATE posts SET post_status = 'published' WHERE post_id=?; ";
                    $bulk_publish_query = mysqli_query($connection,$query);
                    $stmt = mysqli_prepare($connection, $query);            
                    if($stmt === FALSE){ die(mysqli_error($connection)); }           
                    mysqli_stmt_bind_param($stmt, 'i', $checkBoxValue);        
                    mysqli_stmt_execute($stmt);        
                    mysqli_stmt_close($stmt); 
                break;

                case 'draft';
                    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id=?; ";
                    $stmt = mysqli_prepare($connection, $query);            
                    if($stmt === FALSE){ die(mysqli_error($connection)); }           
                    mysqli_stmt_bind_param($stmt, 'i', $checkBoxValue);        
                    mysqli_stmt_execute($stmt);        
                    mysqli_stmt_close($stmt); 
                break;

                case 'delete';
                    $query = "DELETE FROM posts WHERE post_id = {$checkBoxValue}; ";
                    $bulk_publish_query = mysqli_query($connection,$query);
                if(!$bulk_publish_query){
                    die("Query Failed" . mysqli_error($connection));
                }
                break;

                case 'clone':
                    $query = "SELECT * FROM posts WHERE post_id = '{$checkBoxValue}' ";
                    $select_post_query = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_user = $row['post_user'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_content = $row['post_content'];

                    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
                    $query .= "VALUES(?, ?, ?, now(), ?, ?, ?, ?, ?) ";
                    }
                    $stmt = mysqli_prepare($connection, $query);            
                    if($stmt === FALSE){ die(mysqli_error($connection)); }           
                    mysqli_stmt_bind_param($stmt, 'isssssis', $post_category_id, $post_title, $post_user, $post_image, $post_content, $post_tags, $post_comment_count, $post_status);        
                    mysqli_stmt_execute($stmt);        
                    mysqli_stmt_close($stmt); 
                    break;

                    case 'reset_views':
                        
                        $query = "UPDATE posts SET post_views = 0 WHERE post_id=?; ";
                        $stmt = mysqli_prepare($connection, $query);            
                        if($stmt === FALSE){ die(mysqli_error($connection)); }           
                        mysqli_stmt_bind_param($stmt, 'i', $checkBoxValue);        
                        mysqli_stmt_execute($stmt);        
                        mysqli_stmt_close($stmt);

                        break;

                default;
                header("Location: posts.php");
        }
    }
}



?>
                          
                    <form action='' method='post'>
                           <table class='table table-bordered table-hover'>
                           <div id="bulkOptionContainer" class='col-xs-4'>
                               <select class='form-control' name="bulk" id="">
                                   <option value="">Select Option</option>
                                   <option value="publish">Publish</option>
                                   <option value="draft">Draft</option>
                                   <option value="delete">Delete</option>
                                   <option value="clone">Clone</option>
                                   <option value="reset_views">Reset View Count</option>
                               </select>                       
                           </div>
                           
                           <div>
                           <input type="submit" name='submit' class="btn btn-success" value='Apply'>
                           <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a> 
                           </div>
                           <thead>
                               <tr>
                                   <th><input id='selectAllBoxes' type="checkbox"></th>
                                   <th>Id</th>
                                   <th>Category</th>
                                   <th>Title</th>
                                   <th>User</th>
                                   <th>Date</th>
                                   <th>Image</th>
                                   <th>Tags</th>
                                   <th>Content</th>
                                   <th>Comments</th>
                                   <th>View Count</th>
                                   <th>Status</th>                             
                                   <th>Edit</th>    
                                   <th>Delete</th>
                                   <th>Reset View Count</th>                                 
                               </tr>
                           </thead>
                       
                        <tbody>
                           <?php 
                           
        $query = "SELECT posts.post_id, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
        $query.= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_content, posts.post_views, categories.cat_id, categories.cat_type ";
        $query.= "FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC;";

        $select_posts = mysqli_query($connection, $query);               
        if(!$select_posts){
            die(mysqli_error($connection));
        }
        while($row = mysqli_fetch_assoc($select_posts)){
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
        $post_views = $row['post_views'];
        $cat_title = $row['cat_type'];
        $cat_id = $row['cat_id'];

            
            
            echo "<tr>";?>
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
            <?php
            
            echo "<td>$post_id</td>";   
            echo "<td>{$cat_title}</td>";             
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            echo "<td>$post_user</td>"; 
            echo "<td>$post_date</td>";
            echo "<td><img height='100px' width='150px' alt='image' src='../images/{$post_image}'></img></td>";
            echo "<td>$post_tags</td>";
            echo "<td>$post_content</td>";

            $comment_query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
            $fetch_comment = mysqli_query($connection, $comment_query);
            $row = mysqli_fetch_array($fetch_comment);
            $post_comments = mysqli_num_rows($fetch_comment);
         
            if($post_comments>0){
                $comment_post_id = $row['comment_post_id'];
                echo "<td><a href='post_comments.php?id=$post_id'>$post_comments</a></td>";
            } else {
                echo "<td>$post_comments</td>";
            }
            echo "<td>$post_views</td>";
            echo "<td>$post_status</td>";
            echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            ?>
            <form action="" method='post'>
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <?php echo "<td><input rel='$post_id' href='javascript:void(0)' class='btn btn-danger' type='submit' value='Delete' name='delete'></td>"; ?>
            </form>
            <?php
            //echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to reset the view count for this post?');\" href='posts.php?reset_views={$post_id}'>Reset Views</a></td>";
            echo "</tr>";           
        }?>
                             
                       </tbody>
                       </table>
                       </form>
    
    <?php 
if(isset($_POST['delete'])){
 
    $delete_id = $_POST['post_id'];

    $query = "DELETE FROM posts WHERE post_id = {$delete_id} ";
    $delete_query = mysqli_query($connection,$query);
    confirmQuery($delete_query);
    header("Location: posts.php");
    }

if(isset($_GET['reset_views'])){
    $reset_id = $_GET['reset_views'];
    $query = "UPDATE posts SET post_views = 0 WHERE post_id=?; ";
    $stmt = mysqli_prepare($connection, $query);            
    if($stmt === FALSE){ die(mysqli_error($connection)); }           
    mysqli_stmt_bind_param($stmt, 'i', $reset_id);        
    mysqli_stmt_execute($stmt);        
    mysqli_stmt_close($stmt);
    header("Location: posts.php");
}
?>                  

<script>

    $(document).ready(function(){
        $(".delete_link").on("click", function(){
            let id = $(this).attr("rel");
            let delete_url = "posts.php?delete="+id+"";

            $(".modal_delete_link").attr("href", delete_url);

            $("#myModal").modal('show');
        });
    });


</script>       