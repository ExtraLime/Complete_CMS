<?php include "includes/admin_header.php"?>
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
    
 <div class="form-group">
        <select  name="user_role" id="user_role">
        
        
        <?php 
            if($user_role == 'admin'){
                echo "<option value='subscriber'>Subscriber</option>";
            }else{
                echo "<option value='admin'>Admin</option>";
            }
            
            ?>
         <option value="subscriber"><?php echo $user_role ?></option>        
         
         
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
        <input value='<?php echo $user_password ?>' name='password' class='form-control' type="password">    
    </div>
    

    
    <div class="form-group">
        <label for="edit_user">Edit User</label>
        <input name='edit_user' class='btn btn-primary' type="submit" value="Update Profile">    
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