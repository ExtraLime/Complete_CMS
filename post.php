<?php require_once 'includes/header.php';?>
<?php require_once 'includes/navigation.php';?>
<?php require_once "admin/functions.php"?>   

<?php 
if(isset($_POST['liked'])){
    //select the post
    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];

    $searchPost = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_fetch_array(mysqli_query($connection, $searchPost));
    if (!$postResult){die(mysqli_error($connection));}
    $likes = $postResult['post_likes'];

    // update post with likes
    $likePost = "UPDATE posts SET post_likes=$likes+1 WHERE post_id=$post_id";
    $likeResult = mysqli_query($connection, $likePost);
    if (!$likeResult){die(mysqli_error($connection));}
    //insert data create likes
    $query = "INSERT INTO likes(post_id, user_id) VALUES($post_id, $user_id)";

    $result = mysqli_query($connection, $query);
    if($result === FALSE){ die(mysqli_error($connection)); }
    exit();

}


if(isset($_POST['unliked'])){
    //select the post

    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];

    $searchPost = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_fetch_array(mysqli_query($connection, $searchPost));
    if (!$postResult){die(mysqli_error($connection));}
    $likes = $postResult['post_likes'];

    // delete like  from likes
    $stmt = mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id; ");
    if($stmt === FALSE){ die(mysqli_error($connection)); }
    //insert data create likes
    $unlikePost = "UPDATE posts SET post_likes=$likes-1 WHERE post_id=$post_id";
    $unlikeResult = mysqli_query($connection, $unlikePost);
    if (!$unlikeResult){die(mysqli_error($connection));}
    exit();

}
?>


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 
                
                if(isset($_GET['p_id'])){
                    
                    $get_post_id = $_GET['p_id'];
                    
                    $query = "UPDATE posts SET post_views = post_views + 1 ";
                    $query .="WHERE post_id=?; ";
                        
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt,'i', $get_post_id);
                    if($stmt === FALSE){ die(mysqli_error($connection)); }
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt); 
                    
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                        $query = "SELECT * FROM posts WHERE post_id = $get_post_id; ";
                    }else{
                        $query = "SELECT * FROM posts WHERE post_id = $get_post_id AND post_status = 'published'; ";
                    }
                
                    $select_all_posts = mysqli_query($connection, $query);               
                    while($row = mysqli_fetch_assoc($select_all_posts)){
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>
            


                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title?></a>
                        </h2>
                        <p class="lead">
                            by <a href="/author_posts.php?author=<?php echo $post_user?>&p_id=<?php echo $get_post_id?>"><?php echo $post_user?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                        <hr>
                        <img class="img-responsive" src="<?php echo imagePlaceholder($post_image)?>" alt="">
                        <hr>
                        <p><?php echo $post_content?></p>

                        <?php if(isLoggedIn()){ ?>
                            <div class="row">
                                <p class="pull-right"><a
                                    class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>"
                                    href=""><span class="glyphicon glyphicon-thumbs-up"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : 'Want to like it?'; ?>"
                                ></span>
                                <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'; ?>
                            </a></p>
                            </div>


                    <?php  } else { ?>

                            <div class="row">
                                <p class="pull-right login-to-post">You need to <a href="/login">Login</a> to like </p>
                            </div>          
                    <?php }?>

                        <div class="row">
                            <p class="pull-right"><?php getPostlikes($get_post_id)?> likes</p>
                        </div>
                        <div class="clearfit"></div>
                        <hr>
                <?php }
            
            
?>
                    
   <!-- Blog Comments -->
                <?php 
                if(isset($_POST['create_comment'])){
                    
                    $get_post_id = $_GET['p_id'];
                    $comment_author  = $_POST['comment_author'];
                    $comment_email  = $_POST['comment_email'];
                    $comment_content  = $_POST['comment_content'];
                    
                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                        $comment_status = 'denied';
                        $comment_date = date("y-m-d");
                        $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES (?, ?, ?, ?, ?, ?); ";

                        $stmt = mysqli_prepare($connection, $query);
                        mysqli_stmt_bind_param($stmt,'isssss', $get_post_id, $comment_author, $comment_email,$comment_content,$comment_status, $comment_date);
                        if($stmt === FALSE){ die(mysqli_error($connection)); }
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);  
                        

                        } else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form method="post" action="" role="form">
                        
                           
                           
                        <div class="form-group">
                           <label for="comment_author">Author</label>
                            <input name="comment_author" type="text" class="form-control" name="comment_author">
                        </div>
                         <div class="form-group">
                           <label for="comment_email">Email</label>
                            <input name="comment_email" type="email" class="form-control" name="comment_email">
                        </div>
                         <div class="form-group">
                           <label for="comment_content">Comment</label>                            
                             <textarea class="form-control" name="comment_content"></textarea>
                        </div>                                               
                        <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

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
                <?php  } }else{
            
                    header("Location: index.php");
            
                        }?>
                     
                </div>

            

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php';?>
        <!-- /.row -->
</div>
        <hr>
<?php include 'includes/footer.php'?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>



<script>


$(document).ready(function(){
    let post_id = <?php echo $get_post_id;?>;
    let user_id = <?php echo loggedInUserId();?>;
    $('.like').click(function(){
        $.ajax({
            url: "post.php?p_id=<?php echo $get_post_id; ?>",
            type:'post',
            data: {
                'liked': 1,
                'post_id':post_id,
                'user_id':user_id
            }
        })

    });
});

$(document).ready(function(){
    let post_id = <?php echo $get_post_id;?>;
    let user_id = <?php echo loggedInUserId();?>;
    $('.unlike').click(function(){
        $.ajax({
            url: "post.php?p_id=<?php echo $get_post_id; ?>",
            type:'post',
            data: {
                'unliked': 1,
                'post_id':post_id,
                'user_id':user_id
            }
        })

    });
});



</script>       

