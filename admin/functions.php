<?php 

function confirmQuery($result){
        global $connection;
        if(!$result){
        die("Query Failed".mysqli_error($connection));
    }
}

function insert_categories(){
        global $connection;
        if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
       if($cat_title == "" || empty($cat_title)){
           echo "You Didn't Submit Anything.";
       }else{
           $query = "INSERT INTO categories(cat_type) ";
           $query .= "VALUE ('$cat_title') ";

           $create_category_query = mysqli_query($connection, $query);
           if(!$create_category_query){
               die( "Query Failed".mysqli_error($connection));
           }
       }
    }    
}

function findAllCategories() {
    global $connection;
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);               

        while($row = mysqli_fetch_assoc($select_categories)){
        $cat_title = $row['cat_type'];
        $cat_id = $row['cat_id'];
        echo"<tr>";    
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";    
        echo"<tr>";    

        }
    
}

function deleteRow(){
   
    if(isset($_GET['delete'])){
    global $connection;
    $cat_id_delete = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = {$cat_id_delete} ";

    $delete_query = mysqli_query($connection,$query);
    header("Location: categories.php");
}
}

function online_count(){
    
    if(isset($_GET['usersonline'])){
        
            session_start();
            include "../includes/db.php";
       
    
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 600;
    $time_out = $time - $time_out_in_seconds; 

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    if($count == null){
        mysqli_query($connection,"INSERT INTO users_online(session, time) VALUES('$session', $time); ");
    }else{
        mysqli_query($connection,"UPDATE users_online SET time = '$time' WHERE session = '$session'; ");
    }
    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $time_out; ");
    echo $user_count = mysqli_num_rows($users_online_query);
}//get request isset()
}
online_count();



?>