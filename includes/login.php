<?php include "db.php"?>
               
<?php session_start(); ?>
<?php if(isset($_POST['login'])){
    
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    echo $username;
    echo $user_password;
    if(strlen($username) < 2){
        header("Location: ../index.php");
    }
    $username = mysqli_real_escape_string($connection, $username);
    $user_password = mysqli_real_escape_string($connection, $user_password);
    $query = "SELECT * FROM users WHERE username = '{$username}'; ";
    $select_user_query = mysqli_query($connection, $query);
    if(!$select_user_query){
        die("QUERY FAILED!".mysqli_error($connection));
    }
    
    while($row = mysqli_fetch_array($select_user_query)){
        
        $db_user_id = $row['user_id'];
        $db_user_password = $row['user_password'];
        $db_username = $row['username'];
        $db_user_first_name = $row['user_first_name'];
        $db_user_last_name = $row['user_last_name'];
        $db_user_role = $row['user_role'];   
            
    }
    
//if ($username !== $db_username && $user_password !== $db_password){
//    header("Location: ../index.php");
//} else if($username !== $db_username && $user_password !== $db_password){
//    header("Location: ../admin");
//}else {
//    header("Location: ../index.php");
//}
    
    
    
if(strlen($username)>1 && $username === $db_username && $user_password ===   $db_user_password){
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_first_name;
        $_SESSION['lastname'] = $db_user_last_name;
        $_SESSION['user_role'] = $db_user_role;
        
        header("Location: ../admin");
    }else{
        echo "Login Failed";
        header("Location: ../index.php");
    }
    
    
    
} 






?>