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
            echo "<td><a href='users.php?source=admin&u_id={$user_id}'>Make Admin</a></td>";
            echo "<td><a href='users.php?source=subscriber&u_id={$user_id}'>Make Subscriber</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
            echo "</tr>";
        
            
        }

                           ?>

                       </tbody>
                       </table>

    <?php
    //delete comment query
    if(isset($_GET['delete'])){
 
    $delete_id = $_GET['delete'];

    $query = "DELETE FROM users WHERE user_id = '{$delete_id}' ";
    $delete_user_query = mysqli_query($connection,$query);
    confirmQuery($delete_user_query);
    header("Location: users.php");
    }
    //update status
    if(isset($_GET['source'])){
        $new_role = $_GET['source'];
        $user_id = $_GET['u_id'];
        
        $query = "UPDATE users SET ";
        $query .= "user_role = '{$new_role}' ";
        $query .="WHERE user_id = '{$user_id}'; ";
        $change_role_query = mysqli_query($connection, $query);
        confirmQuery($change_role_query);
        header("Location: users.php");
        }
?>                  
