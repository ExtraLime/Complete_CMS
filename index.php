<?php require_once 'includes/header.php';?>
<?php require_once 'includes/navigation.php';?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 

                $per_page = 5;
                $query_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM posts"));
                $count = ceil($query_count/$per_page);

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
                    

                    $query = "SELECT * FROM posts LIMIT $pager, $per_page; ";
                    $select_all_posts = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_all_posts)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,250);
                        $post_status = $row['post_status'];
                        
                        if($post_status == 'published'){

                        

                        ?>


                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id?>"><?php echo $post_title?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_posts.php?user=<?php echo $post_user?>&p_id=<?php echo $post_id?>"><?php echo $post_user?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date?></p>
                        <hr>
                        <a href="post.php?p_id=<?php echo $post_id?>">
                        <img  class="img-responsive" src="images/<?php echo $post_image?>" alt=""></a>
                        <hr>
                        <p><?php echo $post_content?>...</p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>
                <?php  }}?>
                   
                       
                    
                    
                
                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php';?>
        <!-- /pagination -->
        <ul class="pager">
        <?php
        if($page > 2){
            $back = $page - 2;
            echo "<li><a href='index.php?page=<?php echo $back ?>'>Back</a></li>";
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

            <li><a href='index.php?page=<?php echo $page+1?>'>Next</a></li>
        </ul>

        <hr>
<?php include 'includes/footer.php'?>