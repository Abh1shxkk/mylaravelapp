<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

  <!-- Navbar -->
  <!-- Navbar -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="d-flex align-items-center">
      <!-- Home -->
      <a class="navbar-brand fw-bold me-3" href="#">Home</a>
      
      <!-- Database (chhota with icon, Home ke baju me) -->
      <a href="delete.php" class="text-white small d-flex align-items-center text-decoration-none">
        <i class="bi bi-database me-1"></i> Database
      </a>
    </div>
  </div>
</nav>


  <div class="container mt-4">
    <h2>Add Student</h2>
    <form action="" method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" name="city" id="city" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="course" class="form-label">Course</label>
        <input type="text" name="course" id="course" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="batch" class="form-label">Batch</label>
        <input type="text" name="batch" id="batch" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="year" class="form-label">Year</label>
        <input type="number" name="year" id="year" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" name="age" id="age" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="dob" class="form-label">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">Save</button>
    </form>

    <!-- PHP Success/Error Message -->
    <div class="mt-3">
      <?php
      if(isset($_POST['name'])){
        $name   = $_POST['name'];
        $city   = $_POST['city'];
        $course = $_POST['course'];
        $batch  = $_POST['batch'];
        $year   = $_POST['year'];
        $age    = $_POST['age'];
        $dob    = $_POST['dob'];

        include("./config.php");

        $sql="INSERT INTO `sq1` (`name`, `city`, `course`, `batch`, `year`, `age`, `dob`) 
              VALUES ('$name', '$city', '$course', '$batch', '$year', '$age', '$dob')";

        $output = $conn->prepare($sql);
        $result = $output->execute();

        if($result){
          echo "<div class='alert alert-success'>Data is stored into database successfully ✅</div>";
        } else {
          echo "<div class='alert alert-danger'>Failed to store data ❌</div>";
        }
      }
      ?>
    </div>
  </div>
</body>
</html>
