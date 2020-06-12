<?php  require_once "includes/db.php"; ?>
 <?php  require_once "includes/header.php"; ?>
<?php


// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("willdox7@yahoo.com","My subject",$msg);



$message = "Please enter your information";
if(isset($_POST['submit'])){
    global $connection;
    $to         = 'willdox7@yahoo.com';
    $subject    = $_POST['subject'];
    $body       =  $_POST['body'];   
    
    $msg = wordwrap($body, 70);
    mail($to,$subject,$msg);

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
                <h1 class='text-center'>Contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                       <h6 class='text-center'><?php echo $message ?></h6>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Ex. Matches">
                        </div>
                        <div class="form-group">
                            <label for="body">Message</label>
                            <textarea  name='body' class='form-control' cols="30" rows="10" id=''></textarea>    
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
