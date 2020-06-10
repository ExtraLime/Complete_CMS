<?php require_once 'includes/header.php';?>
<?php require_once 'includes/navigation.php';?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 
                
                
                if(isset($_GET['p_id'])){
                    
                    $get_post_id = $_GET['p_id'];
                    $get_post_author = $_GET['user'];
                    
                    
                }
                    $query = "SELECT * FROM posts WHERE post_user = '{$get_post_author}'; ";
                    $select_all_posts = mysqli_query($connection, $query);               
                    while($row = mysqli_fetch_assoc($select_all_posts)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        


                        ?>
            
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id?>"><?php echo $post_title?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?author=<?php echo $post_user?>&p_id=<?php echo $post_id ?>"><?php echo $post_user?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image?>" alt="">
                        <hr>
                        <p><?php echo $post_content?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                <?php  }?>
                    
   <!-- Blog Comments -->
                <?php 
                if(isset($_POST['create_comment'])){
                    
                    $get_post_id = $_GET['p_id'];
                    $comment_author  = mysqli_real_escape_string($connection,$_POST['comment_author']);
                    $comment_email  = mysqli_real_escape_string($connection,$_POST['comment_email']);
                    $comment_content  = mysqli_real_escape_string($connection,$_POST['comment_content']);
                    
                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                        $comment_date = time();
                        $comment_status = 'denied';
                        $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES (?,?,?,?,?,?) ";
                        $stmt = mysqli_prepare($connection, $query);
                        mysqli_stmt_bind_param($stmt,'issssi', $get_post_id, $comment_author, $comment_email,$comment_content,$comment_status, $comment_date);
                        if($stmt === FALSE){ die(mysqli_error($connection)); }
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);   
                        

                        
                            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                            $query .="WHERE post_id=?; ";
                                
                            $stmt = mysqli_prepare($connection, $query);
                            mysqli_stmt_bind_param($stmt,'i', $get_post_id);
                            if($stmt === FALSE){ die(mysqli_error($connection)); }
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);   
                            
                            } else {
                                echo "<script>alert('Fields cannot be empty')</script>";
                            }                
                        }

                ?>

                <hr>

                <!-- Posted Comments -->
                
                <?php 
                
                
               
               $get_post_id = $_GET['p_id'];   

                    
                $query = "SELECT * FROM comments WHERE comment_post_id = $get_post_id ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_date DESC; ";
                
                    
                $get_post_comments_query = mysqli_query($connection, $query);
                if(!$get_post_comments_query){
                    die('QUERY FAILED' . mysqli_error($connection));
                }
                        
                    while($row = mysqli_fetch_assoc($get_post_comments_query)){
                        $comment_date = $row['comment_date'];
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];

                        ?>
            
                     <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author ?>
                            <small><?php echo $comment_date ?></small>
                        </h4><?php echo $comment_content ?>
                    </div>
                </div>
                <?php  }?>

                <!-- Comment -->

                <!-- Comment -->              
                </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php';?>
        <!-- /.row -->
</div>
        <hr>
<?php include 'includes/footer.php'?>