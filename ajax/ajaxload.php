<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = mysqli_connect($host, $username, $password, $database) or die("connection failed");

// Get page and per page values
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$per_page = isset($_POST['per_page']) ? (int)$_POST['per_page'] : 5;
$offset = ($page - 1) * $per_page;
$pagination_only = isset($_POST['pagination_only']);
$no_pagination = isset($_POST['no_pagination']);

// Agar search query bheji gayi hai
$search = "";
if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM random 
            WHERE first_name LIKE '%$search%' 
               OR last_name LIKE '%$search%'";
    $count_sql = "SELECT COUNT(*) as total FROM random 
                  WHERE first_name LIKE '%$search%' 
                     OR last_name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM random";
    $count_sql = "SELECT COUNT(*) as total FROM random";
}

// Get total count for pagination
$count_result = mysqli_query($conn, $count_sql);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $per_page);

// If we only need pagination controls, output them and exit
if ($pagination_only) {
    $output = "";
    if ($total_pages > 1) {
        $output .= "<div class='flex space-x-2'>";
        
        // Previous button
        if ($page > 1) {
            $output .= "<button class='pagination-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600' data-page='".($page - 1)."'>
                        <i class='fas fa-chevron-left'></i>
                      </button>";
        }
        
        // Page numbers
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                $output .= "<button class='px-3 py-1 bg-blue-700 text-white rounded font-bold'>$i</button>";
            } else {
                $output .= "<button class='pagination-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600' data-page='$i'>$i</button>";
            }
        }
        
        // Next button
        if ($page < $total_pages) {
            $output .= "<button class='pagination-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600' data-page='".($page + 1)."'>
                        <i class='fas fa-chevron-right'></i>
                      </button>";
        }
        
        $output .= "</div>";
    }
    echo $output;
    exit;
}

// Add ORDER BY and LIMIT to the query - NEW RECORDS FIRST
$sql .= " ORDER BY id DESC LIMIT $offset, $per_page";

$results = mysqli_query($conn, $sql);

$output = ""; // Initialize output variable

if (mysqli_num_rows($results) > 0) {
    $output .= "<table class='table-auto w-full mx-auto border-collapse border border-gray-300 shadow-lg'>";
    $output .= "<thead class='bg-gray-200'>
            <tr>
                <th class='border border-gray-300 px-4 py-2'>ID</th>
                <th class='border border-gray-300 px-4 py-2'>First Name</th>
                <th class='border border-gray-300 px-4 py-2'>Last Name</th>
                <th class='border border-gray-300 px-2 py-2 text-center w-24'>Update</th>
                <th class='border border-gray-300 px-2 py-2 text-center w-24'>Delete</th>
            </tr>
          </thead>";
    $output .= "<tbody>";

    // Calculate the starting serial number (1, 2, 3...)
    $serial_number = ($page - 1) * $per_page + 1;
    
    while ($row = mysqli_fetch_assoc($results)) {
        $output .= "<tr class='hover:bg-gray-100'>
                <td class='border border-gray-300 px-4 py-2 text-center'>".$serial_number."</td>
                <td class='border border-gray-300 px-4 py-2'>".$row['first_name']."</td>
                <td class='border border-gray-300 px-4 py-2'>".$row['last_name']."</td>
                <td class='border border-gray-300 px-2 py-2 text-center'>
                    <button class='update-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded' 
                        data-id='".$row['id']."' 
                        data-fname='".$row['first_name']."' 
                        data-lname='".$row['last_name']."'>Update</button>
                </td>
                <td class='border border-gray-300 px-2 py-2 text-center'>
                    <button class='delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded' 
                        data-id='".$row['id']."'>Delete</button>
                </td>
            </tr>";
        
        $serial_number++; // Increment serial number for next record
    }

    $output .= "</tbody></table>";
} else {
    $output .= "<h3 class='text-center text-lg text-gray-600'>No records found.</h3>";
}

// Add pagination controls only if not requested to exclude them
if (!$no_pagination && $total_pages > 1) {
    $output .= "<div class='flex justify-center mt-6 space-x-2'>";
    
    // Previous button
    if ($page > 1) {
        $output .= "<button class='pagination-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600' data-page='".($page - 1)."'>
                    <i class='fas fa-chevron-left'></i>
                  </button>";
    }
    
    // Page numbers
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            $output .= "<button class='px-3 py-1 bg-blue-700 text-white rounded font-bold'>$i</button>";
        } else {
            $output .= "<button class='pagination-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600' data-page='$i'>$i</button>";
        }
    }
    
    // Next button
    if ($page < $total_pages) {
        $output .= "<button class='pagination-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600' data-page='".($page + 1)."'>
                    <i class='fas fa-chevron-right'></i>
                  </button>";
    }
    
    $output .= "</div>";
}

mysqli_close($conn);

// Return HTML response
echo $output;
?>