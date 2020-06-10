
  
<?php 
if(isset($_POST['create_user'])){       
    
        $user_first_name = $_POST['user_first_name'];
        $user_last_name = $_POST['user_last_name'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $password = $_POST['password'];        
        $user_email = $_POST['user_email'];
     
    
    
    

    $hashed_password = password_hash($password,PASSWORD_BCRYPT, array('cost'=> 10)); 

    $query = "INSERT INTO users(username, user_password, user_first_name,
    user_last_name, user_email, user_role) ";
    
    $stmt = mysqli_prepare($connection, $query."VALUES (?, ?, ?, ?, ?, ?)");        
    if($stmt === FALSE){ die(mysqli_error($connection)); }       
    mysqli_stmt_bind_param($stmt, 'ssssss', $username, $hashed_password, $user_first_name, $user_last_name, $user_email, $user_role);    
    mysqli_stmt_execute($stmt);    
    mysqli_stmt_close($stmt);

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
            