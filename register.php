<?php 
session_start();

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

              <div class="card">
                <div class="card-header">

                    <h3 style="text-align:center;background-color:black;padding:8px;color:white;">Add New User</h3>

                    

                    <?php
                       
                       if(isset($_SESSION['data'])){

                          echo $_SESSION['data'];
                          unset($_SESSION['data']);
                       }


                     ?>

                </div>

             <div class="card-body"  style="max-length:500px">

            

           
                
                <form action="login/register-process.php" method="POST">
                    <label>Full Name:</label>
                    <input type="text" name="fullname" placeholder="Enter Full name" required class="form-control">
                    <br>

                    <span><label>Email:</label>  

                    <p id="emailError" style="color:red;"></p>
                      

                    <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control" required>
                    <br>

                    <label>Mobile:</label>
                    <p id="mobileError" style="color:red"></p>

                    <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile" class="form-control" maxlength="10" required>
                    <br>

                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter Password" class="form-control">
                    <br>




                    <input type="submit" name="submit" class="btn btn-sm btn-danger">

                </form>

                     <script src="assets/vendor/js/helpers.js"></script>
                   <script>
                    document.getElementById("email").addEventListener("blur", function () {

                        let email = this.value;

                        fetch("login/check-email.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: "email=" + encodeURIComponent(email)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.exists) {
                                document.getElementById("emailError").innerHTML = "Email already exists";
                            }
                        });

                    });



                  </script>


                 <script>
                     document.getElementById('mobile').addEventListener("blur", function () {

                     let mobile = this.value;

                     fetch("login/check-mobile.php", {
                      method: "POST",
                      headers: {
                        "content-Type": "application/x-www-form-urlencoded"
                      },
                      body: "mobile=" + mobile

                    })
                    .then(res => res.json())
                    .then(data => {
                       if(data.exists){

                          document.getElementById("mobileError").innerHTML = "Mobile already Exists";

                         }

                    });


                });

                 </script>
             

             </div>

             

              



              </div>




           </div>   
         </div>


<?php include('includes/footer.php'); ?>