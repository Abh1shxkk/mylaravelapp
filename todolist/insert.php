<?php
include("config.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    if (!empty($subject) && !empty($description)) {
        $sql = "INSERT INTO tasks (subject, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$subject, $description]);

        // Redirect back to same page after insert
        header("Location: insert.php?success=1");
        exit();
    } else {
        $error = "Please fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Task</title>
  <style>
      body {
          font-family: Arial, sans-serif;
          background: #f4f4f9;
          margin: 0;
      }
      .navbar {
          background: #007bff;
          padding: 15px;
          text-align: center;
      }
      .navbar a {
          color: #fff;
          text-decoration: none;
          font-size: 18px;
          margin: 0 15px;
          font-weight: bold;
      }
      .navbar a:hover {
          text-decoration: underline;
      }
      .container {
          background: #fff;
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
          width: 400px;
          margin: 40px auto;
      }
      h2 {
          text-align: center;
          margin-bottom: 20px;
          color: #333;
      }
      label {
          display: block;
          margin-bottom: 5px;
          font-weight: bold;
          color: #555;
      }
      input[type="text"], textarea {
          width: 100%;
          padding: 10px;
          margin-bottom: 15px;
          border: 1px solid #ccc;
          border-radius: 5px;
          font-size: 14px;
      }
      button {
          width: 100%;
          padding: 10px;
          border: none;
          border-radius: 5px;
          background: #007bff;
          color: #fff;
          font-size: 16px;
          cursor: pointer;
          transition: 0.3s;
      }
      button:hover {
          background: #0056b3;
      }
      .message {
          text-align: center;
          margin-bottom: 15px;
          color: green;
          font-weight: bold;
      }
      .error {
          text-align: center;
          margin-bottom: 15px;
          color: red;
          font-weight: bold;
      }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
      <a href="insert.php">Add Task</a>
      <a href="saved.php">Saved List</a>
  </div>

  <div class="container">
      <h2>Add New Task</h2>
      <?php if (isset($_GET['success'])): ?>
          <div class="message">Task added successfully ✅</div>
      <?php endif; ?>
      <?php if (isset($error)): ?>
          <div class="error"><?= $error ?></div>
      <?php endif; ?>

      <form method="post">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" placeholder="Enter task subject" required>

          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" placeholder="Enter task details" required></textarea>

          <button type="submit">Add Task</button>
      </form>
  </div>
</body>
</html>
