<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>STUDENT RECORDS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-container {
            background: linear-gradient(to bottom, #acbec1ff, #acbec1ff);
        }

        .record-table {
            max-height: 500px;
            overflow-y: auto;
        }

        .success-message {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .success-message.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-100">

    <h1 class="text-2xl font-bold bg-yellow-500 text-center py-3">STUDENT RECORDS</h1>

    <div class="flex flex-col md:flex-row p-4 gap-6">
        <!-- Left Side - Form -->
        <div class="w-full md:w-1/3">
            <div class="form-container p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-white mb-4">Add New Student</h2>

                <div class="mb-4">
                    <label class="block text-white mb-2" for="fname">First Name</label>
                    <input type="text" id="fname" placeholder="Enter first name"
                        class="w-full px-4 py-2 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <!-- Error message for first name -->
                   <div id="fnameError" class="text-red-500 text-sm mt-1 font-medium hidden">
    <i class="fas fa-exclamation-circle mr-1"></i> Please enter a valid first name
</div>

                    <!-- Error message for last name -->

                </div>

                <div class="mb-4">
                    <label class="block text-white mb-2" for="lname">Last Name</label>
                    <input type="text" id="lname" placeholder="Enter last name"
                        class="w-full px-4 py-2 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <!-- Error message for last name -->
                   <div id="lnameError" class="text-red-500 text-sm mt-1 font-medium hidden">
    <i class="fas fa-exclamation-circle mr-1"></i> Please enter a valid last name
</div>
                </div>

                <button id="saveBtn"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    <i class="fas fa-save mr-1"></i> Save Record
                </button>

                <!-- Success Message -->
                <div id="successMessage"
                    class="success-message mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-center">
                    <i class="fas fa-check-circle mr-2"></i> Record saved successfully!
                </div>
            </div>


        </div>



        <!-- Right Side - Table -->
        <div class="w-full md:w-2/3">
            <div class="bg-white p-6 rounded-lg shadow-lg record-table">
                <!-- Header with Search Box on the right -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Student Records</h2>

                    <!-- Search Box on the right side -->
                    <div class="bg-gray-100 rounded-full px-3 py-1 flex items-center w-64">

                        <i class="fas fa-search text-gray-400 mr-2"></i>

                        <input type="text" id="searchInput" placeholder="Search records..."
                            class="bg-transparent py-1 focus:outline-none w-full text-sm">
                    </div>
                </div>

                <div id="table-container">
                    <!-- Records will be loaded here -->
                </div>

                <!-- Pagination Controls (always visible) -->
                <div id="pagination" class="flex justify-center mt-6">
                    <!-- Pagination buttons will be inserted here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div
            class="modal-content bg-white rounded-lg shadow-lg p-6 w-96 relative transform scale-75 opacity-0 transition-all duration-300">
            <h2 class="text-xl font-semibold mb-4">Update Record</h2>

            <input type="hidden" id="updateId">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="updateFname">First Name</label>
                <input type="text" id="updateFname" placeholder="First Name"
                    class="w-full px-3 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="updateLname">Last Name</label>
                <input type="text" id="updateLname" placeholder="Last Name"
                    class="w-full px-3 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex justify-end">
                <button id="closeModal"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded mr-2 transition duration-200">Cancel</button>
                <button id="saveUpdate"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">Update</button>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div
            class="modal-content bg-white p-6 rounded-lg shadow-lg w-96 transform scale-75 opacity-0 transition-all duration-300">
            <h2 class="text-xl font-bold mb-4 text-center text-red-600">Confirm Delete</h2>
            <p class="text-gray-700 mb-6 text-center">Are you sure you want to delete this record?</p>
            <div class="flex justify-center space-x-4">
                <button id="confirmDelete"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-200">Yes,
                    Delete</button>
                <button id="cancelDelete"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition duration-200">Cancel</button>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let currentPage = 1;
            let currentSearch = "";
            let totalPages = 1;

            // Function to show success message
            function showSuccessMessage() {
                const message = $("#successMessage");
                message.addClass("show");

                // Hide message after 3 seconds
                setTimeout(() => {
                    message.removeClass("show");
                }, 3000);
            }

            // Load records with optional search query and pagination
            function loadData(searchQuery = "", page = 1) {
                currentPage = page;
                currentSearch = searchQuery;

                $.ajax({
                    url: 'ajaxload.php',
                    type: 'POST',
                    data: {
                        query: searchQuery,
                        page: page,
                        per_page: 5,
                        no_pagination: true // Tell PHP not to include pagination in the response
                    },
                    success: function (data) {
                        $("#table-container").html(data);
                        // After loading data, check if we need to adjust the page
                        checkPageAfterDelete();

                        // Load pagination separately
                        loadPagination(searchQuery, page);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error loading data:", error);
                        $("#table-container").html("<p class='text-center text-red-500'>Error loading data. Please check console for details.</p>");
                    }
                });
            }

            // Load pagination controls
            function loadPagination(searchQuery = "", page = 1) {
                $.ajax({
                    url: 'ajaxload.php',
                    type: 'POST',
                    data: {
                        query: searchQuery,
                        page: page,
                        per_page: 5,
                        pagination_only: true
                    },
                    success: function (data) {
                        $("#pagination").html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error loading pagination:", error);
                        $("#pagination").html(""); // Clear pagination on error
                    }
                });
            }

            // Check if we need to navigate to a previous page after deletion
            function checkPageAfterDelete() {
                // If current page is empty but not page 1, go to previous page
                if ($("#table-container").text().includes("No records found") && currentPage > 1) {
                    loadData(currentSearch, currentPage - 1);
                }
            }

            // Handle pagination button clicks
            $(document).on("click", ".pagination-btn", function () {
                let page = $(this).data("page");
                loadData(currentSearch, page);
            });

            // Initial load
            loadData();

            // Search functionality
            $("#searchInput").on("keyup", function () {
                var searchQuery = $(this).val();
                loadData(searchQuery, 1);
            });

            /// Save Record
function saveRecord(){
    var fname = $("#fname").val().trim(); // trim() added
    var lname = $("#lname").val().trim(); // trim() added
    var isValid = true;

    // Reset error messages
    $("#fnameError").addClass("hidden");
    $("#lnameError").addClass("hidden");
    
    // Remove error border classes
    $("#fname").removeClass("border-red-500");
    $("#lname").removeClass("border-red-500");

    // Validate first name (after trimming)
    if(fname === ""){
        $("#fnameError").removeClass("hidden");
        $("#fname").addClass("border-red-500");
        isValid = false;
    }

    // Validate last name (after trimming)
    if(lname === ""){
        $("#lnameError").removeClass("hidden");
        $("#lname").addClass("border-red-500");
        isValid = false;
    }

    if(!isValid){
        return;
    }

    $.ajax({
        url : "insertconn.php",
        type : "POST",
        data : { first_name : fname, last_name : lname },
        success : function(data){
            // Show success message
            showSuccessMessage();
            
            // Clear search and reload all data
            $("#searchInput").val("");
            loadData("", 1);
            $("#fname").val("");  
            $("#lname").val("");
        }
    });
}

            $("#saveBtn").on("click", function (e) {
                e.preventDefault();
                saveRecord();
            });

            $("#fname, #lname").on("keydown", function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    saveRecord();
                }
            });

            // Functions for modal animation
            function showModal(modalId) {
                let modal = $(modalId);
                let content = modal.find(".modal-content");

                modal.removeClass("hidden");
                setTimeout(() => {
                    content.removeClass("scale-75 opacity-0").addClass("scale-100 opacity-100");
                }, 10);
            }

            function hideModal(modalId) {
                let modal = $(modalId);
                let content = modal.find(".modal-content");

                content.removeClass("scale-100 opacity-100").addClass("scale-75 opacity-0");
                setTimeout(() => {
                    modal.addClass("hidden");
                }, 300);
            }

            // Delete Record
            let deleteId = null;

            $(document).on("click", ".delete-btn", function () {
                deleteId = $(this).data("id");
                showModal("#deleteModal");
            });

            $("#cancelDelete").on("click", function () {
                deleteId = null;
                hideModal("#deleteModal");
            });

            $("#confirmDelete").on("click", function () {
                if (deleteId) {
                    $.ajax({
                        url: "delete.php",
                        type: "POST",
                        data: { id: deleteId },
                        success: function (data) {
                            // After deletion, reload data
                            loadData(currentSearch, currentPage);
                            hideModal("#deleteModal");
                            deleteId = null;
                        }
                    });
                }
            });

            // Open Update Modal
            $(document).on("click", ".update-btn", function () {
                var id = $(this).data("id");
                var fname = $(this).data("fname");
                var lname = $(this).data("lname");

                $("#updateId").val(id);
                $("#updateFname").val(fname);
                $("#updateLname").val(lname);

                showModal("#updateModal");
            });

            // Close Update Modal
            $("#closeModal").on("click", function () {
                hideModal("#updateModal");
            });

            // Save Update
            $("#saveUpdate").on("click", function () {
                var id = $("#updateId").val();
                var fname = $("#updateFname").val();
                var lname = $("#updateLname").val();

                if (fname == "" || lname == "") {
                    alert("Both fields are required!");
                    return;
                }

                $.ajax({
                    url: "update.php",
                    type: "POST",
                    data: { id: id, first_name: fname, last_name: lname },
                    success: function (data) {
                        if (data.includes("success")) {
                            // After update, reload data with current search and page
                            loadData(currentSearch, currentPage);
                            hideModal("#updateModal");
                        } else {
                            alert(data);
                        }
                    }
                });
            });

        });
    </script>

</body>

</html>