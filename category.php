<?php require_once 'includes/header.php';?>
<?php require_once 'includes/navigation.php';?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 
                
                    if(isset($_GET['category'])){
                        
                        $post_category_id = $_GET['category'];
                    }

                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                        $query = "SELECT * FROM posts WHERE post_category_id = '$post_category_id'; ";
                    }else{
                        $query = "SELECT * FROM posts WHERE post_category_id = '$post_category_id' AND post_status = 'published'; ";
                    }
                

                    $select_all_posts = mysqli_query($connection, $query);
                    $per_page = 5;
                    $query_count = mysqli_num_rows($select_all_posts);
                    $count = ceil($query_count/$per_page);
    
                    if ($count < 1){
                        echo "<h3 class='text-center'>Nothing to see here!</h3>";
                    }else{
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = '';
                    }
                    if ($page == 1 || $page == ''){
                        $pager = 1;
                    }else{
                        $pager = ($page * $per_page) - $per_page;
                    }               
                    while($row = mysqli_fetch_assoc($select_all_posts)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,400);

                        ?>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="post/<?php echo $post_id?>"><?php echo $post_title?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index"><?php echo $post_user?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo $post_image?>" alt="">
                        <hr>
                        <p><?php echo $post_content?>...</p>
                        <a class="btn btn-primary" href="post/<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                <?php  }}?>
                    
                    
                
                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php';?>
        <!-- /.row -->
        <ul class="pager">
        <?php
        if ($count > 0){
            if($page > 2){
                $back = $page - 2;
                echo "<li><a href='index.php?page=$back>Back</a></li>";
                for($i = $page-2; $i<= $page+2; $i++) {
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>"; 
                    }else{
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                }
            }else{
                for($i = 1; $i<= 3; $i++) {
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>"; 
                    }else{
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                }
            }
        
        ?>

            <li><a href='index.php?page=<?php echo parseInt($page)+1?>'>Next</a></li>
            <?php } ?>
        </ul>

        <hr>
<?php include 'includes/footer.php'?>