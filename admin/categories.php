<?php include "/includes/admin_header.php"?>


    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <div id="wrapper">
        <!--Navigation-->
        <?php include "/includes/admin_navigation.php"?>
       
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to the Admin Page
                            </h1>
                        <div class="col-xs-6"> 
                        <?php insert_categories();?>
    
                        
                        
                        <form action="" method="post" id="cat_input">
                           <div class="form-group">
                              <label for="cat_title">Add Category Title</label>
                               <input class="form-control" type="text" name="cat_title">
                           </div>
                           <div class="form-group">
                               <input class="btn btn-primary" type="submit" name="submit" value='Add Category'>
                           </div>                               
                        </form>
                         <!-- end of add query-form -->   
                         
                         
                         <!-- begin php for update-->                       
                         <?php                        
                            
                            if(isset($_GET['edit'])){
                                $cat_id = $_GET['edit'];
                                include "/includes/update_categories.php";
                            }                                        
                            ?>
                         <!-- end php for update-->                                            
                                           
                        </div>                                           
                            <div class="col-xs-6">                   
                            <table class="table table-bordered table-hover">
                           <thead>
                               <tr>
                                   <th>ID</th>
                                   <th>Category Title</th>
                               </tr>
                           </thead>
                           <!--//Find all Categories Query-->
                           <tbody>                           
                                <?php findAllCategories();?>
                                  
                                <?php deleteCategories();//Delete Query?>                       

                           </tbody>                           
                           
                       </table>    
                            </div>  
                              
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



<?php include '/includes/admin_footer.php'?>
