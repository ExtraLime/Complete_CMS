                       <table class='table table-bordered table-hover'>
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Username</th>
                                   <th>First Name</th>
                                   <th>Last Name</th>
                                   <th>E-Mail</th>
                                   <th>Role</th>
                                   <th>Date</th>
                                   
                                                                
                               </tr>
                           </thead>
                       
                       <tbody>
                           <?php 
        //get all comments from db                  
        $query = "SELECT * FROM users;";
        $select_users = mysqli_query($connection, $query);               
        //iterate for each comment
        while($row = mysqli_fetch_assoc($select_users)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        $user_password = $row['user_password'];
        $user_image = $row['user_image'];
            
            //fill in rows
            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_first_name</td>";
            echo "<td>$user_last_name</td>";
            echo "<td>$user_email</td>";
            echo "<td>$user_role</td>";
            
            echo "<td></td>";
            echo "<td><a href='comments.php?source=approved&c_id='>Approve</a></td>";
            echo "<td><a href='comments.php?source=denied&c_id='>Deny</a></td>";
            echo "<td><a href='comments.php?delete='>Delete</a></td>";
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
