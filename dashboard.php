<?php session_start(); ?>

<?php 


if(isset($_SESSION['email'])){

     
}else{

   header('location:index.php');
}

?>

<?php include('includes/header.php'); ?>

<?php include('includes/sidebar.php'); ?>

<style>

    .text{

       color:white;
    }
</style>


 <!-- Content wrapper -->
          <div class="content-wrapper mb-3">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> PO Details</h4> -->

  
  
              <!-- Hoverable Table rows -->

               <?php 
                
                $userEmail = $_SESSION['email'] ; 

                //  echo $userEmail;
                 
                $userEmail;

                include_once('includes/config.php');

                $sql = "SELECT * FROM user_details WHERE email = '$userEmail'";
                $run = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($run);

                $fetchUserId = $row['id'];
                $fetchUserName = ucfirst($row['name']);
              
                
                
                ?>


              <div class="card">
                <h4 class="card-header" style="color:blue;text-align:center;letter-spacing:3.8px;">D A S H B O A R D</h4> <h4 style="color:red;text-align:center;">You are successfully login | Welcome to Ziko Lifestyle   - <strong> <?php echo $fetchUserName; ?></strong> </h4>
               
                <div class="row mt-3 p-3">

                    <div class="col-md-3 mb-3">
                       <div class="card bg-primary" align="center"><br>
                       <div class="card-header">
                          <h3 class="text">Total Party</h3>
                          <hr>
                       </div>

                           <?php
                            include_once('includes/config.php');
                            $sql1 = "SELECT * FROM party_details";
                            $run1 = mysqli_query($conn, $sql1);
                            $count = mysqli_num_rows($run1);
                            
                            //  if($count > 0){
                            //     $row1 = mysqli_fetch_assoc($run1);
                            //  }


                           ?>
                          
                          <div class="card-body">
                            <h3 class="text"><?php echo $count; ?></h3>
                          </div>
                          
                       </div>
                    </div>

                    <div class="col-md-3 mb-3">
                       <div class="card bg-primary" align="center" class="text"><br>
                         <div class="card-header">
                            <h3 class="text">Total Vendor</h3>
                            <hr>
                         </div>
                           
                         <?php
                           
                            include_once('includes/config.php');
                            $sql2 = "SELECT * FROM vendor_details";
                            $run2 = mysqli_query($conn, $sql2);
                            $count2 = mysqli_num_rows($run2);
                          

                         ?>
                         
                         
                         <div class="card-body">
                            <h3 class="text"><?php echo $count2; ?></h3>
                          </div>
                         
                       </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary" align="center" class="text"><br>
                          <div class="card-header">
                            <h3 class="text">Total Data Entry</h3>
                            <hr>
                          </div>

                          <?php

                            include_once('includes/config.php');
                            $sql3 = "SELECT * FROM emb_details";
                            $run3 = mysqli_query($conn, $sql3);
                            $count3 = mysqli_num_rows($run3);

                          ?>
                             <div class="card-body">
                            <h3 class="text"><?php echo $count3; ?></h3>
                          </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <div class="card bg-primary" align="center" class="text"><br>
                          <div class="card-header">
                            <h3 class="text">Total Users</h3>
                            <hr>
                          </div>
                          <?php
                            include_once('includes/config.php');
                            $sql4 = "SELECT * FROM user_details";
                            $run4 = mysqli_query($conn, $sql4);
                            $count4 = mysqli_num_rows($run4);

                           ?>
                             <div class="card-body">
                            <h3 class="text"><?php echo $count4; ?></h3>
                          </div>
                        </div>

                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col md-4"></div>
                    <div class="col md-4"></div>
                    <div class="col md-4"></div>
                </div> -->
                
                
              </div>
              <!--/ Hoverable Table rows -->









              </div>
</div>




<?php include('includes/footer.php'); ?>