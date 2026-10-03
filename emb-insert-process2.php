<?php
   
session_start();

// for getting loggedIn user details

 include_once('../includes/config.php');
                
    $userEmail = $_SESSION['email'] ; 

//  echo $userEmail;
                 
    $userEmail;

                

    $sql = "SELECT * FROM user_details WHERE email = '$userEmail'";
    $run = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($run);

    $fetchUserId = $row['id'];
    $fetchUserName = ucfirst($row['name']);
              
                
        

// for inserting empbroidery data into table


$partyName = isset($_POST['partyInput']) ? mysqli_real_escape_string($conn, $_POST['partyInput']): '';
$embCode = isset($_POST['emb_code']) ? mysqli_real_escape_string($conn, $_POST['emb_code']): '';
$shoeColor = isset($_POST['shoe_color']) ? mysqli_real_escape_string($conn, $_POST['shoe_color']): '';
$vendor = isset($_POST['vendor']) ? mysqli_real_escape_string($conn, $_POST['vendor']) : '';


// $embImage = isset($_POST['emb_image']) ? mysqli_real_escape_string($conn, $_POST['emb_image']): '';



$poLink = isset($_POST['po_link']) ? mysqli_real_escape_string($conn, $_POST['po_link']): '';

$embProcessDate = isset($_POST['emb_process_date']) ? mysqli_real_escape_string($conn, $_POST['emb_process_date']): '';
$embRecieveDate = isset($_POST['emb_recieve_date']) ? mysqli_real_escape_string($conn, $_POST['emb_recieve_date']): '';

$embNumber = isset($_POST['emb_number']) ? mysqli_real_escape_string($conn, $_POST['emb_number']) : '';

$perPiecePrice = isset($_POST['per_piece_price']) ? mysqli_real_escape_string($conn, $_POST['per_piece_price']) : '';



$poGenerateDate = isset($_POST['po_generate_date']) ? mysqli_real_escape_string($conn, $_POST['po_generate_date']): '';

$remarks = isset($_POST['remarks']) ? mysqli_real_escape_string($conn, $_POST['remarks']) : '';

$totalPrice = $perPiecePrice * $embNumber;

$createdAt = date('Y-m-d H:i:s');


if(empty($partyName) || empty($embCode) || empty($shoeColor) || empty($vendor) || empty($poLink) || empty($embProcessDate) || empty($embRecieveDate) || empty($embNumber) || empty($perPiecePrice) || empty($totalPrice) || empty($poGenerateDate) || empty($remarks)) {

echo "Error: All required fields must be filled !";
exit;
  
}


$emb_image = '';

if(isset($_FILES['emb_image']) && !empty($_FILES['emb_image']['name'])){

 $embFile = $_FILES['emb_image'];

 $extension = strtolower(pathinfo($embFile['name'], PATHINFO_EXTENSION));

$fileName = 'emb-' . bin2hex(random_bytes(8)) . '.' . $extension;

//  $fileName = time(). rand(9999,1111) .  ' _ ' . basename($embFile['name']);

//   $filename = time() . '_' . basename($file['name']);

    if (move_uploaded_file($embFile['tmp_name'], 'uploads/' . $fileName)) {
        $emb_image = $fileName;
    }


}


$stmt = $conn->prepare("INSERT INTO emb_details (party_id, emb_design_code, shoes_color_name, vendor_code, emb_image, emb_process_date, emb_recieve_date, po_generate_date, po_link, total_no_emb, per_pcs_price, total_price, remarks, created_at, created_by) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ississsssiddsss", $partyName, $embCode, $shoeColor, $vendor, $emb_image, $embProcessDate, $embRecieveDate, $poGenerateDate, $poLink, $embNumber, $perPiecePrice, $totalPrice, $remarks, $createdAt, $fetchUserName);
if($stmt->execute()){

   echo "success!";

}else{

   echo "something error!";
}

       
$stmt->close();
$conn->close();

?>