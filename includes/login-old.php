<?php session_start(); ?>
<?php require_once "db.php"?>
<?php include "../admin/functions.php"?>               


<?php if(isset($_POST['login'])){
    
    login_user($_POST['username'], $_POST['password']);


//     $username = $_POST['username'];
//     $user_password = $_POST['user_password'];
//     //login_user($username, $user_password);

//     if(strlen($username) < 2){
//         header("Location: index.php");
//     }
//     $username = mysqli_real_escape_string($connection, $username);
//     $user_password = mysqli_real_escape_string($connection, $user_password);
//     $query = "SELECT * FROM users WHERE username = '{$username}'; ";
//     $select_user_query = mysqli_query($connection, $query);
//     if(!$select_user_query){
//         die("QUERY FAILED!".mysqli_error($connection));
//     }
    
//     while($row = mysqli_fetch_array($select_user_query)){
        
//         $db_user_id = $row['user_id'];
//         $db_user_password = $row['user_password'];
//         $db_username = $row['username'];
//         $db_user_first_name = $row['user_first_name'];
//         $db_user_last_name = $row['user_last_name'];
//         $db_user_role = $row['user_role'];   
            
//     }
    
//     $hashed_password = password_hash($user_password,PASSWORD_BCRYPT, array('cost'=> 10));

// if(password_verify($user_password,$db_user_password)){
//         $_SESSION['username'] = $db_username;
//         $_SESSION['firstname'] = $db_user_first_name;
//         $_SESSION['lastname'] = $db_user_last_name;
//         $_SESSION['user_role'] = $db_user_role;
        
//         header("Location: admin/");
//     }else{
//         echo "Login Failed";
//         header("Location: index.php");
//     }
} 
?>