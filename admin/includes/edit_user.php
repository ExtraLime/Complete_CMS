
  
<?php 

if(isset($_GET['u_id'])){
        $u_id = $_GET['u_id'];

        $query = "SELECT * FROM users WHERE user_id = '{$u_id}'; ";
        $select_user_by_id = mysqli_query($connection, $query);               

        while($row = mysqli_fetch_assoc($select_user_by_id)){
        $user_id = $row['user_id'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_email = $row['user_email'];
        


if(isset($_POST['edit_user'])){
    

        $user_first_name = $_POST['user_first_name'];
        $user_last_name = $_POST['user_last_name'];
        $user_role = $_POST['user_role'];
//        $post_image = $_FILES['image']['name'];
//        $post_image_temp = $_FILES['image']["tmp_name"];
        $username = $_POST['username'];
        $user_password = $_POST['password'];
        $user_email = $_POST['user_email'];
    
    
//        move_uploaded_file($post_image_temp,"../images/$post_image");
//        
//        if(empty($post_image)){
//            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
//            $select_image = mysqli_query($connection,$query);
//            
//            while($row = mysqli_fetch_array($select_image)){
//                $post_image= $row['post_image'];
//            }
//        }
    
        
        $query_password = "SELECT user_password FROM users WHERE user_id = $user_id; ";
        $get_user_query = mysqli_query($connection,$query_password);
        confirmQuery($get_user_query);
        $row = mysqli_fetch_array($get_user_query);

        $db_user_password = $row['user_password'];

        if (empty($user_password)){
            $hashed_password = $db_user_password;
        }else {
            $hashed_password = password_hash($user_password,PASSWORD_BCRYPT, array('cost'=> 10));   
        }

        $query = "UPDATE users SET username=?, user_password=?, user_first_name=?,
        user_last_name=?, user_email=?, user_role=? WHERE user_id=? ";
        
        $stmt = mysqli_prepare($connection, $query);            
        if($stmt === FALSE){ die(mysqli_error($connection)); }           
        mysqli_stmt_bind_param($stmt, 'ssssssi', $username, $hashed_password, $user_first_name, $user_last_name, $user_email, $user_role, $user_id);        
        mysqli_stmt_execute($stmt);        
        mysqli_stmt_close($stmt); 

        echo "<p class='bg-success'>The User was Updated. <a href='./users.php'>View Users</a></p>";
                
}
}
        
}else{
    header("Location: index.php");
}

?>
  <form action="" method='post' enctype="multipart/form-data">
   
   <div class="form-group">
        <label for="user_first_name">First Name</label>
        <input value='<?php echo $user_first_name ?>'name='user_first_name' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
        <label for="user_last_name">Last Name</label>
        <input value='<?php echo $user_last_name ?>' name='user_last_name' class='form-control' type="text">    
    </div>
    
 <div class="form-group">
        <select  name="user_role" id="user_role">
        
        
        <?php 
            if($user_role == 'admin'){
                echo "<option value='admin'>Admin</option>";
                echo "<option value='subscriber'>Subscriber</option>";
            }else{
                echo "<option value='subscriber'>Subscriber</option>";
                echo "<option value='admin'>Admin</option>";

            }
            
            ?>
                
         
         
     </select>
     </div>
    
    
    
<!--
    <div class="form-group">
        <label for="user_image">Post Image</label>
        <input type="file" name='user_image'>    
    </div>
-->
    
    <div class="form-group">
        <label for="username">User Name</label>
        <input value='<?php echo $username ?>' name='username' class='form-control' type="text">    
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input value='<?php echo $user_email ?>' name='user_email' class='form-control' type="email">    
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input autocomplete="off" name='password' class='form-control' type="password">    
    </div>
    

    
    <div class="form-group">
        <label for="edit_user">Edit User</label>
        <input name='edit_user' class='btn btn-primary' type="submit" value="Edit User">    
    </div>
</form>
            