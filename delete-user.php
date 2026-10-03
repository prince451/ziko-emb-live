<?php

echo $id = $_GET['id'];

// die("User ID is: " . $id); 
include('includes/config.php');

$sql = "DELETE FROM user_details WHERE id = '$id'";
$run = mysqli_query($conn, $sql);



if($run){

   header('location:list-users.php');
}else{

  header('location:list-users.php');
}


// $stmt = $conn->prepare("DELETE FROM users_table WHERE id = ?");
// $stmt->bind_param('i', $id);


// if($stmt->execute()){

//     $stmt->close();
//     $conn->close();

//    header('location:list-users.php');
// }else{

//    echo "Error: " . $stmt-error;
// }






?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-success",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});
swalWithBootstrapButtons.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel!",
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) swalWithBootstrapButtons.fire({
    title: "Deleted!",
    text: "Your file has been deleted.",
    icon: "success"
  });
  else if (result.dismiss === Swal.DismissReason.cancel)
 /* Read more about handling dismissals below */
  swalWithBootstrapButtons.fire({
    title: "Cancelled",
    text: "Your imaginary file is safe :)",
    icon: "error"
  });
});




</script>:

