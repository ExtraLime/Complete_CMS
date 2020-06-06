<?php include "includes/admin_header.php"?>


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
                            Welcome to the Admin Page
                            <small>Author</small>
                            </h1>
<?php

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $checkBoxValue){
        $bulk_options = $_POST['bulk'];
        switch($bulk_options){
                case 'approved';
                    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$checkBoxValue}; ";
                    $bulk_publish_query = mysqli_query($connection,$query);
                if(!$bulk_publish_query){
                    die("Query Failed" . mysqli_error($connection));
                }
                break;
                case 'denied';
                    $query = "UPDATE comments SET comment_status = 'denied' WHERE comment_id = {$checkBoxValue}; ";
                    $bulk_publish_query = mysqli_query($connection,$query);
                if(!$bulk_publish_query){
                    die("Query Failed" . mysqli_error($connection));
                }
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
                           <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a> 
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
        $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']);
        $select_comments = mysqli_query($connection, $query);
        confirmQuery($select_comments)               ;
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
            echo "<td><a href='post_comments.php?source=approved&c_id=$comment_id&id=$post_id'>Approve</a></td>";
            echo "<td><a href='post_comments.php?source=denied&c_id=$comment_id&id=$post_id'>Deny</a></td>";
            echo "<td><a href='post_comments.php?delete=$comment_id&id=$post_id'>Delete</a></td>";
            echo "</tr>";
        
            
        }

                           ?>

                       </tbody>
                       </table>

    <?php
    //delete comment query
    if(isset($_GET['delete'])){
    $id = $_GET['id'] ;
    $delete_id = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id =". mysqli_real_escape_string($connection,$delete_id);
    $delete_comment_query = mysqli_query($connection,$query);
    confirmQuery($delete_comment_query);
    header("Location: post_comments.php?id=$id");
    }
    //update status
    if(isset($_GET['source'])){
        $comment_status = $_GET['source'];
        $comment_id = $_GET['c_id'];
        $id = $_GET['id']
;        $query = "UPDATE comments SET ";
        $query .= "comment_status = '{$comment_status}' ";
        $query .="WHERE comment_id = '{$comment_id}'; ";
        $update_comment_status_query = mysqli_query($connection, $query);
        confirmQuery($update_comment_status_query);
        header("Location: post_comments.php?id=$id");
        }
?>                  
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