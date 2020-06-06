<?php include "includes/admin_header.php"?>
<?php  include "includes/admin_navigation.php"?>
   <?php 
    
    if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '{$username}'; ";
        $get_profile_query = mysqli_query($connection,$query);
        if(!$get_profile_query){
            die("QUERY FAILED" . ' ' . mysqli_error($connection));
        }
        while($row = mysqli_fetch_assoc($get_profile_query)){
            $user_first_name = $row['user_first_name'];
            $user_last_name = $row['user_last_name'];
            $username = $row['username'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
            $user_id = $row['user_id'];  
        }
    }
    
   if(isset($_POST['edit_profile'])){
        $username = $_POST['username'];
        $user_first_name = $_POST['user_first_name'];
        $user_last_name = $_POST['user_last_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['password'];
       
        $query = 'SELECT randSalt FROM users';
        $salt_query = mysqli_query($connection, $query);
        if(!$salt_query){
            die("Query Failed" . mysqli_error($connection));
        }
        $row = mysqli_fetch_array($salt_query);
        $salt = $row['randSalt'];    
        $hashed_password = crypt($user_password, $salt);          
       
       
       
       $query = "UPDATE users SET ";
       $query .= "username = '{$username}', ";
       $query .= "user_password = '{$hashed_password}', ";
       $query .= "user_first_name = '{$user_first_name}', ";
       $query .= "user_last_name = '{$user_last_name}', ";       
       $query .= "user_email = '{$user_email}', ";
       $query .= "WHERE user_id = '{$user_id}' ";
       
       $update_profile_query = mysqli_query($connection, $query);
       
       if(!$update_profile_query){
           die("QUERY FAILED". " " . mysqli_error($connection));
       }else{
           header('Location: profile.php');
       }
       
        }
    
    ?>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <div id="wrapper">
        <!--Navigation-->
        <?php include "includes/admin_navigation.php"?>
       
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                         <h1 class="page-header">
                            Welcome to the User Page
                            <small><?php echo $username ?></small>
                            </h1>
<form action="" method='post' enctype="multipart/form-data">
   
   <div class="form-group">
        <label for="user_first_name">First Name</label>
        <input value='<?php echo $user_first_name ?>'name='user_first_name' class='form-control' type="text">    
    </div>
    
    <div class="form-group">
        <label for="user_last_name">Last Name</label>
        <input value='<?php echo $user_last_name ?>' name='user_last_name' class='form-control' type="text">    
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
        <label for="edit_profile">Edit User</label>
        <input name='edit_profile' class='btn btn-primary' type="submit" value="Update Profile">    
    </div>
</form>
            

    
    
                        
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

<?php include 'includes/admin_footer.php'?>