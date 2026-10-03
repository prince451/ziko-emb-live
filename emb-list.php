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
             type="button" data-bs-toggle="modal" data-bs-target="#embModal">Add Embroidery Data   <strong style="font-size:22px;"> + </strong></button>
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
                <h5 class="card-header" align="center">Embroidery Details</h5> <h4 style="color:red;text-align:center;">You are successfully login | Welcome to Ziko Lifestyle   - <strong> <?php echo $fetchUserName; ?></strong> </h4>
               
                
                <div class="table-responsive text-nowrap p-3">
                  <table class="table table-hover" id="embTable">
                    <thead>
                      <tr>
                        <th>Party Name</th>
                        <th>Embroidery Code</th>
                        <th>Embroidery Color</th>
                        <th>Vendor Name</th>
                        <th>Embroidery Image</th>
                        <th>Emb Process Date</th>
                        <th>Emb Recieve Date</th>
                        <th>PO Generate Date</th>
                        <th>PO Link</th>
                        <th>Status</th>
                        <th>Total Emb (Quantity)</th>
                        <th>Per Piece Price</th>
                        <th>Total Price</th>
                        <th>Remarks</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Updated By</th>
                        <th>Updated At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    <?php 
                     
                  $stmt = $conn->prepare("SELECT * FROM emb_details ORDER BY id DESC");
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while($row = $result->fetch_assoc())
                    {

                  ?>

                  <tr>
                        
                        <?php 
                         $partyId =  $row['party_id'];

                         $stmt = $conn->prepare("SELECT * FROM party_details WHERE id = ? ");
                         $stmt->bind_param("i", $partyId);
                         $stmt->execute();
                         $resultNext = $stmt->get_result();
                         $row3 = $resultNext->fetch_assoc();


                        ?>
                        <td><i class="fa-lg text-success me-3"></i> <strong><?php echo ucfirst($row3['party_name']); ?></strong></td>

                        <td><?php echo $row['emb_design_code']; ?></td>
                        <td><?php echo $row['shoes_color_name']; ?></td>
                       
                          
                      
                       
                          
                        
                         <?php
                         $vCode = $row['vendor_code']; 
                            

                         $stmt = $conn->prepare("SELECT * FROM vendor_details WHERE id = ? ");
                         $stmt->bind_param("i", $vCode);
                         $stmt->execute();
                         $result2 = $stmt->get_result();
                         $row2 = $result2->fetch_assoc();

                          // $sql = "SELECT * FROM vendor_details WHERE id = '$vCode'";
                          // $run = mysqli_query($conn, $sql);
                          // $row2 = mysqli_fetch_assoc($run)
                            ?>
                              <td> <?php echo ucfirst($row2['vendor_name']); ?> </td>

                        <td><img src="embroidery/uploads/<?php echo $row['emb_image'] ?>" width="80px" height="80px" target="_blank"></td>
                       
                        <td><?php echo $row['emb_process_date']; ?></td>
                        <td><?php echo $row['emb_recieve_date']; ?></td>
                        <td><?php echo $row['po_generate_date']; ?></td>
                        <td><a href="<?php echo $row['po_link']; ?>">Link</a></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['total_no_emb']; ?></td>
                        <td><?php echo $row['per_pcs_price']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><?php echo $row['remarks']; ?></td>
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
                              <a class="dropdown-item edit-btn" href="javascript:void(0);" data-id="<?php echo $row['id']; ?>"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item delete-btn" href="javascript:void(0);" data-id="<?php echo $row['id']; ?>"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                              >
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


       <div class="modal fade" id="embModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">

                         <form id="embForm" enctype="multipart/form-data">

                          <input type="hidden" id="formAction" name="action" value="insert">
                          <input type="hidden" id="embId" name="id">

                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Add Details </h5>

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
                                    <label for="nameBasic" class="form-label">Party Name</label>
                                   <input type="text" id="partyInput" name="partyInput" class="form-control" placeholder="Party Name" autocomplete="off" required/>
                                    <input type="hidden" id="partyId" name="party_id">
                                    <div id="suggestions" style="position:absolute; top:100%; left:0; right:0; background:#fff;
border:1px solid #fff; border-radius:4px; z-index:9999; max-height:200px;
     overflow-y:auto; display:none;"></div>
                                  </div>
                                </div>

                                
                                

                                 <div class="row g-2">
                                  <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Embroidery Code/ Design No</label>
                                    <input type="text" id="emb_code" name="emb_code" class="form-control" placeholder="Embroidery Code" required />
                                  </div>
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Embroidery Color</label>
                                    <input type="text" id="shoe_color" name="shoe_color" class="form-control" placeholder="Embroidery Color" required />
                                  </div>
                                </div>

                                 <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label"></label>
                                    <select class="form-control" name="vendor" id="vendor">
                                      <option selected disabled> --- Select Vendor ---</option>
                                      <?php
                                        
                                        $sql = "SELECT * FROM vendor_details";
                                        $run = mysqli_query($conn, $sql);
                                        while($row = mysqli_fetch_assoc($run))
                                        {

                                        ?>

                                        <option value="<?php echo $row['id']; ?>"><?php echo ucfirst($row['vendor_name']); ?></option>


                                       <?php }  ?>
                                      
                                     
                                      
                                     

                                    </select>
                                    <br>
                                     <label for="nameBasic" class="form-label">Upload Embroidery Image</label>
                                    <input type="file" id="emb_image" name="emb_image" class="form-control">
                                    <img id="currentImage" src="" width="100">
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">PO link</label>
                                    <input type="text" id="po_link" name="po_link" class="form-control" placeholder="PO Link">
                                  </div>
                                </div>


                                 <div class="row g-2">
                                  <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Embroidery Process Date</label>
                                    <input type="date" id="emb_process_date" name="emb_process_date" class="form-control" placeholder="Embroidery Code">
                                  </div>
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Embroidery Recieve Date</label>
                                    <input type="date" id="emb_recieve_date" name="emb_recieve_date" class="form-control" placeholder="Shoe Color">
                                  </div>

                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">PO Genarate Date </label>
                                    <input type="date" id="po_generate_date" name="po_generate_date" class="form-control" placeholder="Per Piece Price">
                                  </div>
                                </div><br>

                                  <div class="row g-2">
                                  <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Number Of Embroidery (Qty)</label>
                                    <input type="number" id="emb_number" name="emb_number" class="form-control" placeholder="Number Of Embroidery">
                                  </div>
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">Price Per Piece </label>
                                    <input type="number" id="per_piece_price" name="per_piece_price" step="0.01" class="form-control" placeholder="Per Piece Price">
                                  </div>
                                </div>

                                <br>

                                  <!-- <div class="row g-2">
                                  <div class="col mb-0">
                                    <label for="emailBasic" class="form-label">Total Price</label>
                                    <input type="text" id="total_price" name="total_price" class="form-control" placeholder="Total Price" >
                                  </div>
                                  <div class="col mb-0">
                                    <label for="dobBasic" class="form-label">PO Genarate Date </label>
                                    <input type="date" id="po_generate_date" name="po_generate_date" class="form-control" placeholder="Per Piece Price">
                                  </div>
                                </div> -->
                                <br>

                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label">Remarks</label> 
                                     <textarea cols="86.5" rows="2" id="remarks" name="remarks"></textarea>
                                    <!-- <input type="text" id="nameBasic" class="form-control" placeholder="Enter Name" /> -->
                                  </div>
                                </div>

                                

                                

                                 <!-- <div class="row">
                                  <div class="col mb-3">
                                    <label for="nameBasic" class="form-label"></label>
                                    <input type="file" id="nameBasic" class="form-control" placeholder="Enter Name" />
                                  </div>
                                </div> -->
                               
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

$('#embForm').submit(function(e) {

    e.preventDefault();

    var action = $('#formAction').val();

    var url;

    if(action == 'update') {
        url = 'embroidery/emb-edit-process.php';
    } else {
        url = 'embroidery/emb-insert-process.php';
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

                $('#embModal').modal('hide');

                location.reload();

            } else {

                alert('Error: ' + res);

            }
        }
    });

});

  // ---------- PARTY AUTO SUGGEST ----------
    let timer = null;

    $('#partyInput').on('keyup', function () {
        let q = $(this).val().trim();
        $('#partyId').val('');   // typing ke time id empty

        if (q.length < 2) {
            $('#suggestions').hide().empty();
            return;
        }

        clearTimeout(timer);
        timer = setTimeout(function () {
            $.ajax({
                url: 'search_party.php',
                type: 'GET',
                data: { q: q },
                dataType: 'json',
                success: function (res) {
                    let html = '';
                    if (res.length > 0) {
                        res.forEach(function (item) {
                            html += '<div class="sug-item" data-id="'+item.id+'" data-name="'+item.name+'" '+
                                    'style="padding:8px 12px; cursor:pointer; border-bottom:1px solid #f0f0f0;">'+
                                    item.name+'</div>';
                        });
                    } else {
                        html = '<div style="padding:8px 12px; color:#999;">No party found</div>';
                    }
                    $('#suggestions').html(html).show();
                },
                error: function(xhr, status, err){
                    console.log('AJAX Error:', status, err);
                    console.log('Response:', xhr.responseText);
                }
            });
        }, 250);
    });

    // suggestion pe click
    $(document).on('click', '.sug-item', function () {
        $('#partyInput').val($(this).data('name'));
        $('#partyId').val($(this).data('id'));
        $('#suggestions').hide().empty();
    });

    // bahar click pe dropdown band
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#partyInput, #suggestions').length) {
            $('#suggestions').hide();
        }
    });

});





//edit or update data


$(document).on('click', '.edit-btn', function() {

var id = $(this).data('id');

$('#formAction').val('update');
$('#embId').val(id);

$.get('embroidery/emb-edit-process.php?action=get&id=' + id, function(embData){


  embData = JSON.parse(embData);

$('#partyInput').val(embData.party_name);
$('#partyId').val(embData.party_id);
  $('#emb_code').val(embData.emb_design_code);
  $('#shoe_color').val(embData.shoes_color_name);
  $('#vendor').val(embData.vendor_code);
  // $('#emb_image').val(embData.emb_image);
  
  $('#currentImage').attr('src', 'embroidery/uploads/' + embData.emb_image);
  
  $('#po_link').val(embData.po_link);
  $('#emb_process_date').val(embData.emb_process_date);
  $('#emb_recieve_date').val(embData.emb_recieve_date);
  $('#po_generate_date').val(embData.po_generate_date);
  $('#emb_number').val(embData.total_no_emb);
  $('#per_piece_price').val(embData.per_pcs_price);
  $('#remarks').val(embData.remarks);


   $('#embModal').modal('show');

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
            $.post('embroidery/emb-delete-process.php', {action: 'delete', id: id}, function(res) {
               
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