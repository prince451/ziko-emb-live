<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        .preview-image { max-width: 100px; max-height: 100px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h3>User Management</h3>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#userModal">
                    + Add User
                </button>
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Hobbies</th>
                            <th>Country</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['hobbies'] ? str_replace(',', ', ', $row['hobbies']) : 'None'; ?></td>
                            <td><?php echo $row['country']; ?></td>
                            <td>
                                <?php if($row['profile_image']): ?>
                                    <img src="uploads/<?php echo $row['profile_image']; ?>" width="50">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm view-btn" data-id="<?php echo $row['id']; ?>">View</button>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $row['id']; ?>">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="userModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="userForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="user_id" name="user_id">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email *</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Password <span id="passNote">*</span></label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Gender *</label><br>
                                <input type="radio" name="gender" value="Male" required> Male
                                <input type="radio" name="gender" value="Female" class="ms-2"> Female
                                <input type="radio" name="gender" value="Other" class="ms-2"> Other
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Hobbies</label><br>
                                <input type="checkbox" name="hobbies[]" value="Reading"> Reading
                                <input type="checkbox" name="hobbies[]" value="Sports" class="ms-2"> Sports
                                <input type="checkbox" name="hobbies[]" value="Music" class="ms-2"> Music
                                <input type="checkbox" name="hobbies[]" value="Traveling" class="ms-2"> Traveling
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Country *</label>
                                <select class="form-control" name="country" id="country" required>
                                    <option value="">Select</option>
                                    <option value="India">India</option>
                                    <option value="USA">USA</option>
                                    <option value="UK">UK</option>
                                    <option value="Canada">Canada</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Profile Image</label>
                                <input type="file" class="form-control" name="profile_image" id="profile_image">
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Files</label>
                                <input type="file" class="form-control" name="files[]" multiple>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="viewContent"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

  <script>
$(document).ready(function() {
    // Table with search
    $('#userTable').DataTable();

    // Save user
    $('#userForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'process.php',
            type: 'POST', 
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(res) {
                if(res == 'success') {
                    alert('Saved!');
                    $('#userModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + res);
                }
            }
        });
    });

    // Edit user
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.get('process.php?action=get&id=' + id, function(user) {
            user = JSON.parse(user);
            
            $('#user_id').val(user.id);
            $('#name').val(user.name);
            $('#email').val(user.email);
            $('[name="gender"][value="' + user.gender + '"]').prop('checked', true);
            $('#country').val(user.country);
            
            // Hobbies
            $('[name="hobbies[]"]').prop('checked', false);
            if(user.hobbies) {
                user.hobbies.split(',').forEach(function(hobby) {
                    $('[name="hobbies[]"][value="' + hobby.trim() + '"]').prop('checked', true);
                });
            }
            
            $('#userModal').modal('show');
        })
    });

    // View user - YEH ADD KAR DIYA
    $(document).on('click', '.view-btn', function() {
        var id = $(this).data('id');
        $.get('process.php?action=get&id=' + id, function(user) {
            user = JSON.parse(user);
            var html = '<p><strong>Name:</strong> ' + user.name + '</p>';
            html += '<p><strong>Email:</strong> ' + user.email + '</p>';
            html += '<p><strong>Gender:</strong> ' + user.gender + '</p>';
            html += '<p><strong>Hobbies:</strong> ' + (user.hobbies || 'None') + '</p>';
            html += '<p><strong>Country:</strong> ' + user.country + '</p>';
            
            if(user.profile_image) {
                html += '<p><strong>Profile Image:</strong><br><img src="uploads/' + user.profile_image + '" width="100"></p>';
            }
            
            $('#viewContent').html(html);
            $('#viewModal').modal('show');
        });
    });

    // Delete user  
    $(document).on('click', '.delete-btn', function() {
        if(confirm('Delete this user?')) {
            var id = $(this).data('id');
            $.post('process.php', {action: 'delete', id: id}, function(res) {
                if(res == 'success') {
                    alert('Deleted!');
                    location.reload();
                } else {
                    alert('Error: ' + res);
                }
            });
        }
    });

    // Image preview
    $('#profile_image').change(function() {
        if(this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html('<img src="' + e.target.result + '" class="preview-image">');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
</body>
</html>