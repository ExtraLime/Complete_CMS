
  
<?php 
if(isset($_POST['create_user'])){       
    
        $user_first_name = $_POST['user_first_name'];
        $user_last_name = $_POST['user_last_name'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];

        
//        $post_image = $_FILES['post_image']['name'];
//        $post_image_temp = $_FILES['post_image']["tmp_name"];
        $password = $_POST['password'];
        $user_email = $_POST['user_email'];
//        $post_date = date("d-m-y");        



//        move_uploaded_file($post_image_temp,"../images/$post_image");
    
    
    
    $query = 'SELECT randSalt FROM users';
    $salt_query = mysqli_query($connection, $query);
    if(!$salt_query){
        die("Query Failed" . mysqli_error($connection));
    }
    $row = mysqli_fetch_array($salt_query);
    $salt = $row['randSalt'];    
    $hashed_password = crypt($password, $salt); 
    
    $query = "INSERT INTO users(username, user_password, user_first_name,
    user_last_name, user_email, user_role) ";
    $query .= "VALUES ('{$username}', '{$hashed_password}', '{$user_first_name}', '{$user_last_name}', '{$user_email}', '{$user_role}') ";
    
    $create_user_query = mysqli_query($connection,$query);
    confirmQuery($create_user_query);
    echo "<p class='bg-success'>User has been Created" . ' '. "<a href='users.php'>View Users</a></p>";
    
} 

?>
  <form action="" method='post' enctype="multipart/form-data">
   
   <div class="form-group">
        <label for="user_first_name">First Name</label>
        <input name='user_first_name' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
        <label for="user_last_name">Last Name</label>
        <input name='user_last_name' class='form-control' type="text">    
    </div>
    
 <div class="form-group">
        <select  name="user_role" id="user_role">
         <option value="subscriber">Select Option</option>        
         <option value="admin">Admin</option>
         <option value="subscriber">Subscriber</option>
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
        <input name='username' class='form-control' type="text">    
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input name='user_email' class='form-control' type="email">    
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input name='password' class='form-control' type="password">    
    </div>
    

    
    <div class="form-group">
        <label for="create_user">Submit</label>
        <input name='create_user' class='btn btn-primary' type="submit" value="Create User">    
    </div>
</form>
            