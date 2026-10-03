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

                             <button class="btn btn-success btn-sm" style="font-size:18px;position:absolute;right:140px;padding-bottom:-15px;" 
             type="button" data-bs-toggle="modal" data-bs-target="#vendorModal">Add Vendor Data   <strong style="font-size:22px;"> + </strong></button>
             <br><br><br>
           
                     
                    
                  
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
                <h5 class="card-header" align="center">Vendor Details</h5> <h4 style="color:red;text-align:center;">You are successfully login | Welcome to Ziko Lifestyle   - <strong> <?php echo $fetchUserName; ?></strong> </h4>
               
                
                <div class="table-responsive text-nowrap p-3">
                  <table class="table table-hover" id="embTable">
                    <thead>
                      <tr>
                        <th>Vendor Name</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Updated By</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                     <tbody class="table-border-bottom-0">

                    <?php 
                     
                  $stmt = $conn->prepare("SELECT * FROM vendor_details ORDER BY id DESC");
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc())
                    {

                  ?>

                  <tr>
                        
                        
                        <td><i class="fa-lg text-success me-3"></i> <strong><?php echo ucfirst($row['vendor_name']); ?></strong></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['created_by']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo $row['updated_by']; ?></td>
                        <td><?php echo $row['updated_at']; ?></td>
                        
                        
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item edit-btn" href="javascript:void(0);" 
                              data-id= "<?php echo $row['id']; ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                             <a class="dropdown-item delete-btn" href="javascript:void(0);" data-id="<?php echo $row['id']; ?>">
    <i class="bx bx-trash me-1"></i> Delete
</a>
                            </div>
                          </div>
                        </td>
                      </tr>


             <?php }  ?>
                      
                     
                      </tbody>
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->





             

             <div class="modal fade" id="vendorModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-md" role="document">

                         <form id="vendorForm">

                          <input type="hidden" id="formAction" name="action" value="insert">
                          <input type="hidden" id="embId" name="id">

                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1"> Add Details </h5>

                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3" style="position:relative;">
                                    <label for="nameBasic" class="form-label">Vendor Name</label>
                                    <input type="text" id="vendorName" name="vendorName"  class="form-control" placeholder="Vendor Name" required/>
                                    
                                    <!-- <div id="suggestions"></div> -->
                                  </div>
                                </div>


                               
 
                               
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Close
                                </button>
                                <!-- <button type="button" class="btn btn-primary">Save</button> -->
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>

                            </form>
                          </div>
                        </div>


              

</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function() { 

$('#vendorForm').submit(function(e) {

    e.preventDefault();

    var action = $('#formAction').val();

    var url;

    if(action == 'update') {
        url = 'vendor/vendor-edit-process.php';
    } else {
        url = 'vendor/vendor-insert-process.php';
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,

        success: function(res) {

            res = res.trim();

            if(res == 'success' || res == 'success!') {

                alert('Saved');

                $('#vendorModal').modal('hide');

                location.reload();

            } else {

                alert('Error: ' + res);

            }
        }
    });

});

});



//edit or update data


$(document).on('click', '.edit-btn', function() {

var id = $(this).data('id');

$('#formAction').val('update');
$('#embId').val(id);

$.get('vendor/vendor-edit-process.php?action=get&id=' + id, function(vendorData){


  vendorData = JSON.parse(vendorData);
  $('#vendorName').val(vendorData.vendor_name);
  
 $('#vendorModal').modal('show');

})

// $('#embModal').modal('show');
});

//delete with page reload after alert

// $(document).on('click', '.delete-btn', function(){

//    if(confirm('Delete this user?')) {
//             var id = $(this).data('id');
//             $.post('vendor/vendor-delete-process.php', {action: 'delete', id: id}, function(res) {
               
//             res = $.trim(res);
//             if(res == 'success') {
//                     alert('Deleted!');
//                     location.reload();
//                 } else {
//                     alert('Error: ' + res);
//                 }
//             });
//         }

// });


//delete without page reload after alert

$(document).on('click', '.delete-btn', function(){

   if(confirm('Delete this user?')) {
            var btn = $(this);
            var id = btn.data('id');
            $.post('vendor/vendor-delete-process.php', {action: 'delete', id: id}, function(res) {
               
            res = $.trim(res);
            if(res == 'success') {
                    alert('Deleted!');
                   btn.closest('tr').remove();
                } else {
                    alert('Error: ' + res);
                }
            });
        }

});




</script>


<?php include('includes/footer.php'); ?>