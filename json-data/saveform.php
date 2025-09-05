<?php
$file = 'studentsdata.json';

// Purana data read karo
if (file_exists($file)) {
    $data = json_decode(file_get_contents($file), true);
} else {
    $data = [];
}

// Naya student
$newStudent = [
    "name" => $_POST['name'],
    "age" => $_POST['age'],
    "city" => $_POST['city']
];

// Add to array
$data[] = $newStudent;

// Save JSON file
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

echo "<p>Student saved successfully!</p>";
echo "<a href='index5.php'>Add another student</a>";
?>
