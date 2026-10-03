<?php
include 'config.php';

// Handle different actions
if(isset($_GET['action']) && $_GET['action'] == 'get') {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    $user = mysqli_fetch_assoc($result);
    
    unset($user['password']);
    echo json_encode($user);
    exit;
}

if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = intval($_POST['id']);
    
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
    $user = mysqli_fetch_assoc($result);
    
    if($user['profile_image'] && file_exists('uploads/' . $user['profile_image'])) {
        unlink('uploads/' . $user['profile_image']);
    }
    
    if($user['files']) {
        $files = explode(',', $user['files']);
        foreach($files as $file) {
            if($file && file_exists('uploads/' . $file)) {
                unlink('uploads/' . $file);
            }
        }
    }
    
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    echo "success";
    exit;
}

// DEBUG: Log what we're receiving
error_log("POST Data: " . print_r($_POST, true));
error_log("FILES Data: " . print_r($_FILES, true));

// Handle form submission - COMPLETELY FIXED
$id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

// FIX: Get name from POST, not from files
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$hobbies = isset($_POST['hobbies']) ? implode(',', $_POST['hobbies']) : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate required fields
if(empty($name) || empty($email) || empty($gender) || empty($country)) {
    echo "Error: All required fields must be filled";
    exit;
}

// Handle file uploads
$profile_image = '';
if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name']) {
    $file = $_FILES['profile_image'];
    $filename = time() . '_' . basename($file['name']);
    if(move_uploaded_file($file['tmp_name'], 'uploads/' . $filename)) {
        $profile_image = $filename;
    }
}

$files = '';
if(isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
    $file_names = [];
    foreach($_FILES['files']['name'] as $key => $file_name) {
        if($file_name) {
            $filename = time() . '_' . $key . '_' . basename($file_name);
            if(move_uploaded_file($_FILES['files']['tmp_name'][$key], 'uploads/' . $filename)) {
                $file_names[] = $filename;
            }
        }
    }
    $files = implode(',', $file_names);
}

if($id == 0) {
    // Add new user
    if(empty($password)) {
        echo "Error: Password is required for new user";
        exit;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password, gender, hobbies, country, profile_image, files) 
            VALUES ('$name', '$email', '$hashed_password', '$gender', '$hobbies', '$country', '$profile_image', '$files')";
} else {
    // Update user
    $password_sql = "";
    if(!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_sql = ", password = '$hashed_password'";
    }
    
    $file_sql = "";
    if($profile_image) {
        $file_sql .= ", profile_image = '$profile_image'";
        
        // Delete old profile image
        $old_result = mysqli_query($conn, "SELECT profile_image FROM users WHERE id = $id");
        $old_user = mysqli_fetch_assoc($old_result);
        if($old_user['profile_image'] && file_exists('uploads/' . $old_user['profile_image'])) {
            unlink('uploads/' . $old_user['profile_image']);
        }
    }
    
    if($files) {
        $file_sql .= ", files = '$files'";
        
        // Delete old files
        $old_result = mysqli_query($conn, "SELECT files FROM users WHERE id = $id");
        $old_user = mysqli_fetch_assoc($old_result);
        if($old_user['files']) {
            $old_files = explode(',', $old_user['files']);
            foreach($old_files as $old_file) {
                if($old_file && file_exists('uploads/' . $old_file)) {
                    unlink('uploads/' . $old_file);
                }
            }
        }
    }
    
    $sql = "UPDATE users SET 
            name = '$name', 
            email = '$email', 
            gender = '$gender', 
            hobbies = '$hobbies', 
            country = '$country'
            $password_sql $file_sql 
            WHERE id = $id";
}

error_log("SQL Query: " . $sql); // Debug log

if(mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>