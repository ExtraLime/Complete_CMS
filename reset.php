

<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<?php require_once "admin/functions.php"?>   



<?php

require './vendor/autoload.php';

    if( !isset($_GET['token']) && !isset($_GET['email'])){
        redirect('index');
    }
    $msg = "<p class='text-center'>Reset your Password here: </p>";
    $stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?');
    if($stmt === FALSE){ die(mysqli_error($connection)); }

    mysqli_stmt_bind_param($stmt, 's', $_GET['token']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($_GET['token'] != $token || $_GET['email'] != $user_email){
        redirect("index");
    }

    if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
        if($_POST['password'] === $_POST['confirmPassword']){
            $password = $_POST['password'];
            $hashed = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
            $stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password=? WHERE user_email=? ");
            mysqli_stmt_bind_param($stmt, 'ss', $hashed, $user_email);
            if($stmt === FALSE){ die(mysqli_error($connection)); }
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            redirect('login.php?reset=success');
       }else{
           $msg = "<p class='bg-danger text-center'>Passwords must match.</p>";
       }
    }
?>

<!-- Page Content -->
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <div class='text-center'>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Welcome back : </h2>
                                <?php echo $msg; ?>
                                <div class="panel-body">


                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-check color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   



    <hr>

</div> <!-- /.container -->

