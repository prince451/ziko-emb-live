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

.caption{

     font-size:25px;
     
  
}

.icon{
     color:lime;
}

.word{
  color:white;
  font-size:18px;
  font-family: Inter, Helvetica, Arial, sans-serif;
  text-align:left;
}



</style>


 <!-- Content wrapper -->
          <div class="content-wrapper">
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



                <?php

                 $sql = "SELECT * FROM user_details WHERE id = '$fetchUserId'";
                 $run = mysqli_query($conn, $sql);
                 $row = mysqli_fetch_assoc($run);

                 $fullname = $row['name'];
                 $email = $row['email'];
                $mobile = $row['mobile'];

                 $status = $row['status'];

                 if($status == 0){

                   $newStatus =  "Active";

                 }else{

                  $newStatus = "Inactive";
                 }


              



                ?>


              <div class="card">
                <h5 class="card-header">User Profile</h5> <h4 style="color:red;text-align:center;">You are successfully login | Welcome to Ziko Lifestyle   - <strong> <?php echo $fetchUserName; ?></strong> </h4>
                  <div class="card-body" style="background-color:#000000;"">
                      <div class="row mb-5" align="center">

                         <div class="col-md-6">

                         <span><i class="fa fa-user caption icon"></i>&nbsp;</span><span><strong class="word">Name:  <?php echo ucfirst($fullname); ?> </strong></span>
                 
                         </div>


                         <div class="col-md-6">

                         <span><i class="fa fa-mobile caption icon"></i>&nbsp;</span><span><strong class="word">Mobile: <?php echo $mobile; ?></strong></span>
                         
                         </div>

                      </div>


                       <div class="row" align="center">

                         <div class="col-md-6" >

                       
                         <span><i class="fa fa-envelope caption icon"></i>&nbsp;</span><span><strong class="word">Email: <?php echo $email; ?></strong></span>
                        

                         </div>


                         <div class="col-md-6">

                      
                         <span><i class="fa caption icon">&#128994;</i>&nbsp;</span><span><strong class="word  me-1">Status: <?php echo $newStatus; ?></strong></span>


                         </div>

                      </div>





                  </div>
                
              
              </div>
              <!--/ Hoverable Table rows -->









              </div>
</div>




<?php include('includes/footer.php'); ?>