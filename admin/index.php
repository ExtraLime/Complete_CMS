<?php include "includes/admin_header.php"?>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



    <div id="wrapper">
       
       <?php if(!$connection) echo "connection problem";?>
          
       
        <!--Navigation-->
        <?php include "includes/admin_navigation.php"?>
        
       
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the Admin Page
                            <small><?php echo $_SESSION['username'];?></small>    
                        </h1>
                       
                    </div>
                </div>
                
                
       <!--start widgets -->         
               <?php 
                
                $post_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM posts "));
                $comment_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM comments "));
                $users_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM users "));
                $categories_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM categories "));
                
                ?>
                <?php 
                
                $published_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM posts WHERE post_status = 'published'; "));
                $draft_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM posts WHERE post_status = 'draft'; "));
                $denied_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM comments WHERE comment_status = 'denied'; "));
                $subscriber_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM users WHERE user_role = 'admin'; "));
                $categories_count = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM categories "));
                
                ?>
                <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $post_count;?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                     <div class='huge'><?php echo $comment_count ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $users_count ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class='huge'><?php echo $categories_count ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->
                
                
                <div class="row">
                       <div id="columnchart_material" style="width: auto; height: 500px;">

                        <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Count' ],
            <?php 
                $element_text = ['All Posts','Active Posts', 'Draft Count', 'Comments','Pending Comment Count','User Count','Admin Count','Categories'];
                $element_count = [$post_count, $published_count, $draft_count, $comment_count, $denied_count, $users_count, $subscriber_count, $categories_count];

                         for($i=0;$i < sizeof($element_text); $i++){
                             echo "['{$element_text[$i]}'".","."{$element_count[$i]}],";
                         }

            ?>
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

                </div></div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



<?php include "includes/admin_footer.php"?>
