<?php require_once 'includes/header.php';?>
<?php require_once 'includes/navigation.php';?>
<?php require_once "admin/functions.php"?>   


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 
                $per_page = 5;
                $query_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM posts WHERE post_status = 'published'"));
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

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    $query = "SELECT * FROM posts LIMIT $pager, $per_page; ";;
                }else{
                    $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $pager, $per_page; ";
                }
                    

                    
                    $select_all_posts = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_all_posts)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,400);
                        $post_status = $row['post_status'];
                        
                        if($post_status == 'published'){

                            ?>

                            <!-- First Blog Post -->
                            <h2>
                                <a href="/post/<?php echo $post_id?>"><?php echo $post_title?></a>
                            </h2>
                            <p class="lead">
                                by <a href="/author_posts.php?user=<?php echo $post_user?>&p_id=<?php echo $post_id?>"><?php echo $post_user?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                            <hr>
                            <a href="post.php?p_id=<?php echo $post_id?>">
                            <img  class="img-responsive" src="/<?php echo imagePlaceholder($post_image)?>" alt=""></a>
                            <hr>
                            <p><?php echo $post_content?>...</p>


                            <hr>
                            <?php  }}}?>
                   
                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php';?>
        <!-- /pagination -->
        <ul class="pager">
        <?php
        if ($count > 0){
            if($page > 2){
                $back = $page - 2;
                echo "<li><a href='/index.php?page={$back}'>Back</a></li>";
                for($i = $page-2; $i<= $page+2; $i++) {
                    if($i == $page){
                        echo "<li><a class='active_link' href='/index.php?page={$i}'>{$i}</a></li>"; 
                    }else{
                    echo "<li><a href='/index.php?page={$i}'>{$i}</a></li>";
                    }
                }
            }else{
                for($i = 1; $i<= 3; $i++) {
                    if($i == $page){
                        echo "<li><a class='active_link' href='/index.php?page={$i}'>{$i}</a></li>"; 
                    }else{
                    echo "<li><a href='/index.php?page={$i}'>{$i}</a></li>";
                    }
                }
            }
        
        ?>

            <li><a href='/index.php?page=<?php echo parseInt($page)+1?>'>Next</a></li>
            <?php } ?>
        </ul>

        <hr>
<?php include 'includes/footer.php'?>