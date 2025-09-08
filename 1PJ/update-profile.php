<?php
session_start();
include 'config.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id   = intval($_POST['user_id']);
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $address   = trim($_POST['address']);

    // Validation
    if (empty($firstname) || empty($lastname) || empty($email)) {
        echo "Please fill all required fields.";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Handle profile image upload
    $image_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            echo "Only JPG, PNG, GIF files are allowed.";
            exit;
        }

        $image_name = "profile_".$user_id."_".time().".".$ext;
        $upload_path = "uploads/".$image_name;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            echo "Error uploading image.";
            exit;
        }

        // Update with image
        $sql = "UPDATE user_profile 
                SET firstname=?, lastname=?, email=?, phone=?, address=?, image=? 
                WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssi", $firstname, $lastname, $email, $phone, $address, $image_name, $user_id);
    } else {
        // Update without image
        $sql = "UPDATE user_profile 
                SET firstname=?, lastname=?, email=?, phone=?, address=? 
                WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $firstname, $lastname, $email, $phone, $address, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
