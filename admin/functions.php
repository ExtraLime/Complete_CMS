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
        $cat_title = mysqli_real_escape_string($connection,$_POST['cat_title']);
       if($cat_title == "" || empty($cat_title)){
           echo "You Didn't Submit Anything.";
       }else{
           $query = "INSERT INTO categories(cat_type) VALUE (?); ";
           $stmt = mysqli_prepare($connection, $query);            
           if($stmt === FALSE){ die(mysqli_error($connection)); }           
           mysqli_stmt_bind_param($stmt, 's', $cat_title);        
           mysqli_stmt_execute($stmt);        
           mysqli_stmt_close($stmt); 
           $create_category_query = mysqli_query($connection, $query);
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
    $cat_id_delete = mysqli_real_escape_string($connection, $_GET['delete']);
    $query = "DELETE FROM categories WHERE cat_id=?; ";
    $stmt = mysqli_prepare($connection, $query);            
    if($stmt === FALSE){ die(mysqli_error($connection)); }           
    mysqli_stmt_bind_param($stmt, 'i', $cat_id_delete);        
    mysqli_stmt_execute($stmt);        
    mysqli_stmt_close($stmt); 
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
        $query = "INSERT INTO users_online(session, time) VALUES(?, ?); ";
        $stmt = mysqli_prepare($connection, $query);            
        if($stmt === FALSE){ die(mysqli_error($connection)); }           
        mysqli_stmt_bind_param($stmt, 'ii', $session, $time);        
        mysqli_stmt_execute($stmt);      
    }else{
        $query = "UPDATE users_online SET time=? WHERE session=?; ";
        $stmt = mysqli_prepare($connection, $query);            
        if($stmt === FALSE){ die(mysqli_error($connection)); }           
        mysqli_stmt_bind_param($stmt, 'ii', $time, $session);        
        mysqli_stmt_execute($stmt);    

    }  
    
    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $time_out; ");
    echo $user_count = mysqli_num_rows($users_online_query);
}//get request isset()
}
online_count();



?>