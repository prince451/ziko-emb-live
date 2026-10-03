<?php


include('includes/config.php');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($q) < 2) { echo json_encode([]); exit; }

$q = mysqli_real_escape_string($conn, $q);

$sql = "SELECT id, party_name FROM party_details 
        WHERE party_name LIKE '%$q%' 
        ORDER BY party_name ASC LIMIT 10";

$run = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($run)) {
    $data[] = ['id' => $row['id'], 'name' => $row['party_name']];
}

header('Content-Type: application/json');
echo json_encode($data);