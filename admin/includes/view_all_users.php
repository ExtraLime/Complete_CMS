    <?php include "delete_modal.php"?>
    
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
            ?>
            <form action="" method='post'>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <?php echo "<td><input rel='$user_id' class='btn btn-danger' type='submit' value='Delete' name='delete'></td>"; ?>
            </form>
            <?php
            
            //echo "<td><a rel='$user_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
            echo "<td><a class='btn btn-info' href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
            echo "</tr>";
        }

                           ?>

                       </tbody>
                       </table>

    <?php
    //delete comment query
    if(isset($_POST['delete'])){
        if(isset($_SESSION['user_role'])&&($_SESSION['user_role'] == 'admin')){

    $delete_id = $_POST['user_id'];

    $query = "DELETE FROM users WHERE user_id = '{$delete_id}' ";
    $delete_user_query = mysqli_query($connection,$query);
    confirmQuery($delete_user_query);
    header("Location: users.php");
    }
    }


    //edit user   
    if(isset($_GET['source'])){
        if(isset($_SESSION['user_role'])&&($_SESSION['user_role'] == 'admin')){
        $new_role = $_GET['source'];
        $user_id = $_GET['u_id'];
        echo $new_role;
        echo $user_id;

        $query = "UPDATE users SET user_role=? WHERE user_id=? ";
        
        $stmt = mysqli_prepare($connection, $query);            
        if($stmt === FALSE){ die(mysqli_error($connection)); }           
        mysqli_stmt_bind_param($stmt, 'si', $new_role, $user_id);        
        mysqli_stmt_execute($stmt);        
        mysqli_stmt_close($stmt);
        header("Location: users.php");
        }
    }

?>                  
<script>

$(document).ready(function(){
    $(".delete_link").on("click", function(){
        let id = $(this).attr("rel");
        let delete_url = `users.php?delete=${id}`;

        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');
    });
});


</script>       