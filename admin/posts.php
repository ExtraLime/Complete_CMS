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
                            Posts Page
                            
                            </h1>

                              <?php 
    
    if(isset($_GET['source'])){
        $source = $_GET['source'];
    }else{
        $source = '';
    }
    switch($source){
        case 'add_post';
        include "includes/add_post.php";
            break;
        case 'edit_post';
            include "includes/edit_post.php";
            break;
        case 200;
            echo "Nice 200";
            break;    
        
        default;
            include "includes/view_all_posts.php";
            break;
            
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
