<?php require_once "db.php"?>
               
<?php session_start(); ?>
<?php if(isset($_POST['login'])){
    
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];

    if(strlen($username) < 2){
        header("Location: ../index.php");
    }

    // $username = mysqli_real_escape_string($connection, $username);
    // $user_password = mysqli_real_escape_string($connection, $user_password);
    $query = "SELECT * FROM users WHERE username = $1'; ";
    $result = pg_prepare($connection, "credentials", $query);
    $result = pg_execute($connection, "credentials", array($username));

    if(!$result){
        die("QUERY FAILED!".pg_error($connection));
    }
    
    while($row = pg_fetch_array($result)){
        
        $db_user_id = $row['user_id'];
        $db_user_password = $row['user_password'];
        $db_username = $row['username'];
        $db_user_first_name = $row['user_first_name'];
        $db_user_last_name = $row['user_last_name'];
        echo $db_user_role;  
        echo $db_user_id;
        echo $db_user_password;

            
    }
    
//if ($username !== $db_username && $user_password !== $db_password){
//    header("Location: ../index.php");
//} else if($username !== $db_username && $user_password !== $db_password){
//    header("Location: ../admin");
//}else {
//    header("Location: ../index.php");
//}
    

//     $hashed_password = password_hash($user_password,PASSWORD_BCRYPT, array('cost'=> 10));

// if(password_verify($user_password,$db_user_password)){
//         $_SESSION['username'] = $db_username;
//         $_SESSION['firstname'] = $db_user_first_name;
//         $_SESSION['lastname'] = $db_user_last_name;
//         $_SESSION['user_role'] = $db_user_role;
        
//         header("Location: ../admin");
//     }else{
//         echo "Login Failed";
//         header("Location: ../index.php");
//     }
    
    
    
} 






?>