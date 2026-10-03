<?php session_start(); ?>

<?php 

if(isset($_SESSION['email'])){

     
}else{

   header('location:index.php');
}

?>

<?php include('includes/header.php'); ?>

<?php include('includes/sidebar.php'); ?>


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


             


              <div class="card">
                <h5 class="card-header">PO Details</h5> <h4 style="color:red;text-align:center;">You are successfully login | Welcome to Ziko Lifestyle   - <strong> <?php echo $fetchUserName; ?></strong> </h4>
               
                
                <div class="table-responsive text-nowrap p-3">
                  <table class="table table-hover" id="embTable">
                    <thead>
                      <tr>
                        
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                         <?php
                             
                                 

                                  $stmt = $conn->prepare("SELECT * FROM user_details ORDER BY id DESC");
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  while($row = $result->fetch_assoc())
                                  {

                                  ?>


                                   <tr> 
                                       
                                        <td><i class=" fa-lg text-danger me-3"></i> <strong><?php echo ucfirst($row['name']); ?></strong></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['mobile']; ?></td>
                                        <td>
                                          <?php
                                            
                                            $status = $row['status'];

                                            if($status == 0){

                                              $finalStatus = "<span style='color:lime;' class='bedge'>Active</span>";

                                            }else{

                                              $finalStatus = "<span style='color:red;'>Inactive</span>";
                                            }
                                         
                                              echo $finalStatus;

                                          ?>
                                        </td>
                                        <!-- <td><span class="badge bg-label-primary me-1">Active</span></td> -->
                                        <td>
                                          <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                              <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                              <a class="dropdown-item" href="edit-user.php?id=<?php echo $row["id"]; ?>"
                                             
                                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                              >
                                              <a class="dropdown-item" onclick="deleteBtn()" href="delete-user.php?id=<?php echo $row["id"]; ?>"
                                                ><i class="bx bx-trash me-1"></i> Delete</a
                                              >
                                            </div>
                                          </div>
                                        </td>
                                      </tr>


                                <?php  }  ?>

                                  
              
                     
                      </tbody>

                  
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->









        </div>
</div>




<?php include('includes/footer.php'); ?>