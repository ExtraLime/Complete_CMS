                       <table class='table table-bordered table-hover'>
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Category</th>
                                   <th>Title</th>
                                   <th>Author</th>
                                   <th>Date</th>
                                   <th>Image</th>
                                   <th>Tags</th>
                                   <th>Content</th>
                                   <th>Comments</th>
                                   <th>Status</th>
                                    <th>Edit</th>    
                                    <th>Delete</th>                                 
                               </tr>
                           </thead>
                       
                       <tbody>
                           <?php 
                           
        $query = "SELECT * FROM posts";
        $select_posts = mysqli_query($connection, $query);               

        while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_category_id = $row['post_category_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status = $row['post_status'];
            
            
            echo "<tr>";
            echo "<td>$post_id</td>";
            
            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
            $edit_categories = mysqli_query($connection, $query);               

            while($row = mysqli_fetch_assoc($edit_categories)){
            $cat_title = $row['cat_type'];
            $cat_id = $row['cat_id'];               
            
            echo "<td>{$cat_title}</td>";  }
            
            
            
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            echo "<td>$post_author</td>";
            echo "<td>$post_date</td>";
            echo "<td><img height='100px' width='150px' alt='image' src='../images/{$post_image}'></img></td>";
            echo "<td>$post_tags</td>";
            echo "<td>$post_content</td>";
            echo "<td>$post_comment_count</td>";
            echo "<td>$post_status</td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "</tr>";
        
            
        }
                           
                           
                           
                           ?>
                              
                           
                       </tbody>
                       </table>
                       
    
    <?php 
if(isset($_GET['delete'])){
 
    $delete_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = {$delete_id} ";
    $delete_query = mysqli_query($connection,$query);
    confirmQuery($delete_query);
    header("Location: posts.php");
    }
?>                  
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
    
                       