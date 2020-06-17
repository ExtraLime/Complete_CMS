                       
<?php include "delete_modal.php"?>
<?php

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $checkBoxValue){
        $bulk_options = $_POST['bulk'];
        switch($bulk_options){
                case 'approved';
                    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id=?; ";
                    $stmt = mysqli_prepare($connection, $query);            
                    if($stmt === FALSE){ die(mysqli_error($connection)); }           
                    mysqli_stmt_bind_param($stmt, 'i', $checkBoxValue);        
                    mysqli_stmt_execute($stmt);        
                    mysqli_stmt_close($stmt); 
                break;
                case 'denied';
                    $query = "UPDATE comments SET comment_status = 'denied' WHERE comment_id=?; ";
                    $stmt = mysqli_prepare($connection, $query);            
                    if($stmt === FALSE){ die(mysqli_error($connection)); }           
                    mysqli_stmt_bind_param($stmt, 'i', $checkBoxValue);        
                    mysqli_stmt_execute($stmt);        
                    mysqli_stmt_close($stmt); 
                break;
                
                case 'delete';
                    $query = "DELETE FROM comments WHERE comment_id = {$checkBoxValue}; ";
                    $bulk_publish_query = mysqli_query($connection,$query);
                if(!$bulk_publish_query){
                    die("Query Failed" . mysqli_error($connection));
                }
                break;

                default;
                header("Location: posts.php");
        }
    }
}

?>
                       
                       
            <form action='' method='post'>
                    <table class='table table-bordered table-hover'>
                    <div id="bulkOptionContainer" class='col-xs-4'>
                        <select class='form-control' name="bulk" id="">
                            <option value="">Select Option</option>
                            <option value="approved">Approve</option>
                            <option value="denied">Deny</option>
                            <option value="delete">Delete</option>
                        </select>                       
                    </div>
                    <div>
                           <input type="submit" name='submit' class="btn btn-success" value='Apply'>
                           </div>
                       
                       <table class='table table-bordered table-hover'>
                           <thead>
                               <tr>
                                   <th><input id='selectAllBoxes' type="checkbox"></th>
                                   <th>Id</th>
                                   <th>Author</th>
                                   <th>Email</th>
                                   <th>Comment</th>
                                   <th>Status</th>
                                   <th>In Response to</th>
                                   <th>Date</th>
                                   <th>Approve</th>
                                   <th>Deny</th> 
                                   <th>Delete</th>
                                                                
                               </tr>
                           </thead>
                       
                       <tbody>
                           <?php 
        //get all comments from db                  
        $query = "SELECT * FROM comments;";
        $select_comments = mysqli_query($connection, $query);               
        //iterate for each comment
        while($row = mysqli_fetch_assoc($select_comments)){
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_date = $row['comment_date'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
            $comment_status = $row['comment_status'];
            
            //fill in rows
            echo "<tr>";?>
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id ?>'></td><?php
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_email</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_status</td>";
            
            //relate comment and post with link
            $query = "SELECT * FROM posts WHERE post_id =  $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_assoc($select_post_id_query)){
                
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                
            } 

            echo "<td>$comment_date</td>";
            echo "<td><a href='comments.php?source=approved&c_id=$comment_id'>Approve</a></td>";
            echo "<td><a href='comments.php?source=denied&c_id=$comment_id'>Deny</a></td>";?>
            <!-- <?php//echo "<td><a rel='$comment_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";?> -->
            <form action="" method='post'>
                <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                <?php echo "<td><input rel='$comment_id' class='btn btn-danger' type='submit' value='Delete' name='delete'></td>"; ?>
            </form><?php
//          echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
            echo "</tr>";
        }
                           ?>
                       </tbody>
                       </table>
    <?php
    //delete comment query
    if(isset($_POST['delete'])){
 
    $delete_id = $_POST['comment_id'];

    $query = "DELETE FROM comments WHERE comment_id = '{$delete_id}' ";
    $delete_comment_query = mysqli_query($connection,$query);
    confirmQuery($delete_comment_query);
    header("Location: comments.php");
    }


    //update status
    if(isset($_GET['source'])){
        $comment_status = $_GET['source'];
        $comment_id = $_GET['c_id'];
        
        $query = "UPDATE comments SET ";
        $query .= "comment_status=? ";
        $query .="WHERE comment_id =? ; ";
        $stmt = mysqli_prepare($connection, $query);            
        if($stmt === FALSE){ die(mysqli_error($connection)); }           
        mysqli_stmt_bind_param($stmt, 'si', $comment_status, $comment_id);        
        mysqli_stmt_execute($stmt);        
        mysqli_stmt_close($stmt); 
        header("Location: comments.php");
        }
?>                  
<script>'comments.php?delete=$comment_id'

$(document).ready(function(){
    $(".delete_link").on("click", function(){
        let id = $(this).attr("rel");
        let delete_url = `comments.php?delete=${id}`;

        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');
    });
});


</script> 