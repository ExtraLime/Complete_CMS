<?php  require_once "includes/db.php"; ?>
 <?php  require_once "includes/header.php"; ?>
<?php
$message = "Please enter your information";
if(isset($_POST['submit'])){
    global $connection;
    $username = $_POST['username'];
    $user_password = $_POST['password'];
    $user_email =  $_POST['email'];    
    
    if(!empty($username) && !empty($user_password) && !empty($user_email)){
    
    
    
        $username = mysqli_real_escape_string($connection,$_POST['username']);
        $user_password = mysqli_real_escape_string($connection,$_POST['password']);
        $user_email = mysqli_real_escape_string($connection,$_POST['email']);

        $sql_u = "SELECT * FROM users WHERE username='$username'";
        $sql_e = "SELECT * FROM users WHERE user_email='$user_email'";
        $res_u = mysqli_query($connection, $sql_u);
        $res_e = mysqli_query($connection, $sql_e);
    
    
        if (mysqli_num_rows($res_u) > 0) {
        $message =  "<p class='bg-danger'>Sorry... username already taken;</p>"; 	
        }else if(mysqli_num_rows($res_e) > 0){
        $message = "<p class='bg-danger'>This email is already registered <a href='index.php'>Go Back</a></p>"; 		
        }else{
        $user_password = password_hash($user_password,PASSWORD_BCRYPT, array('cost'=> 10));
        $user_role = 'subscriber';
        $query = "INSERT INTO users (username, user_password, user_email, user_role) ";
        $query .= "VALUES(?, ?, ?, ?) ";
    
        $stmt = mysqli_prepare($connection,$query);
        if($stmt === FALSE){ die(mysqli_error($connection)); 
        }else{
            mysqli_stmt_bind_param($stmt,'ssss',$username, $user_password, $user_email, $user_role);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $message = "<p class='bg-success text-center'>Your account has been created. <a href='./index.php'>Login</a></p>";
            }
        }    
    }else {
        $message = 'All fields are required';
    }
}



?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       <h6 class='text-center'><?php echo $message ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Choose Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
