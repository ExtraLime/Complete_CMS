                       <table class='table table-bordered table-hover'>
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Author</th>
                                   <th>Email</th>
                                   <th>Comment</th>
                                   <th>Status</th>
                                   <th>In Response to</th>
                                   <th>Date</th>
                                   <th>Approve</th>
                                   <th>Deny</th> 
                                   <th>Delete</th>
                                                                
                               </tr>
                           </thead>
                       
                       <tbody>
                           <?php 
        //get all comments from db                  
        $query = "SELECT * FROM comments;";
        $select_comments = mysqli_query($connection, $query);               
        //iterate for each comment
        while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_email = $row['comment_email'];
        $comment_date = $row['comment_date'];
        $comment_content = $row['comment_content'];
        $comment_date = $row['comment_date'];
        $comment_status = $row['comment_status'];
            
            //fill in rows
            echo "<tr>";
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_email</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_status</td>";
            
            //relate comment and post with link
            $query = "SELECT * FROM posts WHERE post_id =  $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_assoc($select_post_id_query)){
                
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                
            } 

            echo "<td>$comment_date</td>";
            echo "<td><a href='comments.php?source=approved&c_id=$comment_id'>Approve</a></td>";
            echo "<td><a href='comments.php?source=denied&c_id=$comment_id'>Deny</a></td>";
            echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
            echo "</tr>";
        
            
        }

                           ?>

                       </tbody>
                       </table>

    <?php
    //delete comment query
    if(isset($_GET['delete'])){
 
    $delete_id = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id = '{$comment_id}' ";
    $delete_comment_query = mysqli_query($connection,$query);
    confirmQuery($delete_comment_query);
    header("Location: comments.php");
    }
    //update status
    if(isset($_GET['source'])){
        $comment_status = $_GET['source'];
        $comment_id = $_GET['c_id'];
        
        $query = "UPDATE comments SET ";
        $query .= "comment_status = '{$comment_status}' ";
        $query .="WHERE comment_id = '{$comment_id}'; ";
        $update_comment_status_query = mysqli_query($connection, $query);
        confirmQuery($update_comment_status_query);
        header("Location: comments.php");
        }
?>                  
