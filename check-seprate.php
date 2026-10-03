```php
<?php
include 'config.php';

// Get form data
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
$gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : '';
$hobbies = isset($_POST['hobbies']) ? implode(',', $_POST['hobbies']) : '';
$country = isset($_POST['country']) ? mysqli_real_escape_string($conn, $_POST['country']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate required fields
if (empty($name) || empty($email) || empty($gender) || empty($country)) {
    echo "Error: All required fields must be filled";
    exit;
}

// Password required for new user
if (empty($password)) {
    echo "Error: Password is required";
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Handle profile image upload
$profile_image = '';

if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])) {

    $file = $_FILES['profile_image'];

    $filename = time() . '_' . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], 'uploads/' . $filename)) {
        $profile_image = $filename;
    }
}

// Handle multiple file uploads
$files = '';

if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {

    $file_names = [];

    foreach ($_FILES['files']['name'] as $key => $file_name) {

        if (!empty($file_name)) {

            $filename = time() . '_' . $key . '_' . basename($file_name);

            if (move_uploaded_file(
                $_FILES['files']['tmp_name'][$key],
                'uploads/' . $filename
            )) {
                $file_names[] = $filename;
            }
        }
    }

    $files = implode(',', $file_names);
}

// Insert new user
$sql = "INSERT INTO users 
        (name, email, password, gender, hobbies, country, profile_image, files)
        VALUES 
        ('$name', '$email', '$hashed_password', '$gender', '$hobbies', '$country', '$profile_image', '$files')";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
```
