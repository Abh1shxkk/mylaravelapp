
<?php
include("./config.php");

// Step 1: Get ID from request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch record by ID
    $stmt = $conn->prepare("SELECT * FROM sq1 WHERE id = $id");
    $stmt->execute();
    $student = $stmt->fetch();
}

// Step 2: If form submitted, update record
if (isset($_POST['update'])) {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $city   = $_POST['city'];
    $course = $_POST['course'];
    $batch  = $_POST['batch'];
    $year   = $_POST['year'];
    $age    = $_POST['age'];
    $dob    = $_POST['dob'];

    $sql = "UPDATE sq1 SET name=?, city=?, course=?, batch=?, year=?, age=?, dob=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name,$city,$course,$batch,$year,$age,$dob,$id]);

    // Redirect back to database page
    header("Location: delete.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Update Student</h2>

    <form method="post">
        <input type="hidden" name="id" value="<?= $student['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="<?= $student['name'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" name="city" value="<?= $student['city'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course</label>
            <input type="text" name="course" value="<?= $student['course'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Batch</label>
            <input type="text" name="batch" value="<?= $student['batch'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Year</label>
            <input type="number" name="year" value="<?= $student['year'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" value="<?= $student['age'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" value="<?= $student['dob'] ?>" class="form-control" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="delete.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
