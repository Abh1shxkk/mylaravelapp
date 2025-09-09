<?php
include("config.php");

// Handle AJAX requests
$response = ['status' => 'error', 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    header('Content-Type: application/json');
    if ($_POST['action'] == 'add') {
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        if (!empty($subject) && !empty($description)) {
            $sql = "INSERT INTO tasks (sub, des, created_at) VALUES (?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $subject, $description);
            if (mysqli_stmt_execute($stmt)) {
                $response['status'] = 'success';
                $response['message'] = 'Note added successfully!';
                $response['id'] = mysqli_insert_id($conn); // Ensure this returns a valid ID
            } else {
                $response['message'] = 'Error adding note: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $response['message'] = 'Please fill all fields!';
        }
    } elseif ($_POST['action'] == 'delete') {
        $delete_id = intval($_POST['id']);
        if ($delete_id > 0) {
            $sql = "DELETE FROM tasks WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $delete_id);
            if (mysqli_stmt_execute($stmt)) {
                $response['status'] = 'success';
                $response['message'] = 'Note deleted successfully!';
            } else {
                $response['message'] = 'Error deleting note: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $response['message'] = 'Invalid note ID!';
        }
    } elseif ($_POST['action'] == 'view') {
        $view_id = intval($_POST['id']);
        $sql = "SELECT des FROM tasks WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $view_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $response['status'] = 'success';
            $response['description'] = htmlspecialchars($row['des']);
        } else {
            $response['message'] = 'Note not found!';
        }
        mysqli_stmt_close($stmt);
    }

    echo json_encode($response);
    exit();
}

// Get all notes for initial load
$notes = [];
$sql = "SELECT * FROM tasks ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = $row;
        }
    }
} else {
    error_log("SQL Error: $sql - " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notes Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            margin: 0 20px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .navbar a.active {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            display: flex;
            gap: 30px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .form-section {
            flex: 1;
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 30px;
        }

        .notes-section {
            flex: 2;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f3f4;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 16px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.4);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(102, 126, 234, 0.5);
        }

        button:active {
            transform: translateY(0);
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 8px;
            background: #d4edda;
            color: #155724;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s;
            display: none;
            /* Hidden by default, shown via AJAX */
        }

        .error {
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 8px;
            background: #f8d7da;
            color: #721c24;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s;
            display: none;
            /* Hidden by default, shown via AJAX */
        }

        .notes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
            gap: 20px;
        }

        .note-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            min-height: 100px;
            max-height: 150px;
        }

        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .note-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .note-title-container {
            flex: 1;
            min-width: 0;
        }

        .note-title {
            font-size: 18px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 10px;
        }

        .note-date {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 5px;
            width: 100%;
        }

        .note-content {
            padding: 10px;
            color: #555;
            line-height: 1.2;
            display: none;
        }

        .note-actions {
            display: flex;
            gap: 5px;
            padding: 0;
        }

        .btn {
            padding: 2px 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 0;
            background: transparent;
            transition: all 0.2s;
        }

        .btn i {
            font-size: 12px;
            color: #fff;
        }

        .btn-view {
            background: #17a2b8;
        }

        .btn-view:hover {
            background: #138496;
        }

        .btn-edit {
            background: #28a745;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }
.modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 70%;
  max-width: 800px;
  max-height: 80vh;
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
  z-index: 1000;
  overflow-y: auto;  /* Scrollable banane ke liye */
}
.modal h2 {
  font-size: 22px;
  margin-bottom: 15px;
  text-align: center;
}

.modal p {
  font-size: 16px;
  line-height: 1.5;
  text-align: center;
}

.modal h3 {
  margin-top: 0;
  text-align: center;
}

.close-modal {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 24px;
  cursor: pointer;
}
       .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 500px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    text-align: center;
    max-height: 80vh; /* Limit height */
    overflow-y: auto; /* Scrollbar for long content */
    display: none; /* Hidden until activated */
}

       .modal-content.active {
    display: block; /* Show when active */
}

        #modalDescription {
            margin-top: 10px;
            text-align: left;
            word-wrap: break-word;
        }

        /* #deleteModal {
            display: none;
            /* Ensure hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        } */

      .modal-actions {
  display: flex;
  flex-direction: row;       /* ek line me lane ke liye */
  justify-content: center;   /* center me align karne ke liye */
  align-items: center;
  gap: 15px;                 /* dono ke beech gap */
  margin-top: 20px;
}

.modal-actions button {
  padding: 8px 20px;
  border-radius: 6px;
  cursor: pointer;
  min-width: 100px;          /* optional: same width buttons */
  text-align: center;
}

        .modal-actions .btn {
  padding: 8px 20px;
  border-radius: 6px;
  cursor: pointer;
}

        .btn-cancel {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: #6c757d;
            color: #fff;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .close-modal {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #dc3545;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            .container {
                flex-direction: column;
            }

            .form-section {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .note-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .note-title-container {
                width: 100%;
            }

            .note-actions {
                margin-top: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="insert.php" class="active">Add Note</a>
        <a href="dashboard.php">Dashboard</a>
    </div>

    <div class="container">
        <div class="form-section">
            <h2>Create New Note</h2>
            <div id="message" class="message"></div>
            <div id="error" class="error"></div>

            <form id="addNoteForm">
                <input type="hidden" name="action" value="add">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Enter note title" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter note content"
                    required></textarea>

                <button type="submit">Add Note</button>
            </form>
        </div>

        <div class="notes-section">
            <h2>Your Notes</h2>
            <div class="notes-grid" id="notesGrid">
                <?php foreach ($notes as $note): ?>
                    <div class="note-card" data-id="<?= $note['id'] ?>">
                        <div class="note-header">
                            <div class="note-title-container">
                                <div class="note-title"><?= htmlspecialchars($note['sub']) ?></div>
                            </div>
                            <div class="note-actions">
                                <button class="btn btn-view" data-id="<?= $note['id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-edit" data-id="<?= $note['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-delete" data-id="<?= $note['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="note-date"><?= date('M j, Y g:i A', strtotime($note['created_at'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (empty($notes)): ?>
                <div class="empty-state">
                    <i class="fas fa-sticky-note"></i>
                    <p>No notes yet. Create your first note!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- View Modal -->
<div id="viewModal" class="modal" style="display: none;">
    <span class="close-modal">&times;</span>
    <h3>Note Description</h3>
    <div id="modalDescription"></div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <span class="close-modal">&times;</span>
    <h3>Confirm Delete</h3>
    <p>Are you sure you want to delete this note?</p>
    <div class="modal-actions">
        <button id="confirmDelete" class="btn btn-delete">Yes</button>
        <button id="cancelDelete" class="btn btn-cancel">No</button>
    </div>
</div>

        <script>
            $(document).ready(function () {
                // Add note via AJAX (unchanged)
                $('#addNoteForm').submit(function (e) {
                    e.preventDefault();
                    const subject = $('#subject').val();
                    const description = $('#description').val();
                    console.log('Submitting:', { subject, description });
                    $.ajax({
                        url: 'notes.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function (response) {
                            console.log('Response:', response);
                            if (response.status === 'success') {
                                $('#message').text(response.message).show().delay(3000).fadeOut();
                                $('#addNoteForm')[0].reset();
                                const newNote = `
                        <div class="note-card" data-id="${response.id}">
                            <div class="note-header">
                                <div class="note-title-container">
                                    <div class="note-title">${subject}</div>
                                </div>
                                <div class="note-actions">
                                    <button class="btn btn-view" data-id="${response.id}"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-edit" data-id="${response.id}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-delete" data-id="${response.id}"><i class="fas fa-trash"></i></button>
                                </div>
                                <div class="note-date">${new Date().toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true })}</div>
                            </div>
                        </div>
                    `;
                                $('#notesGrid').prepend(newNote);
                                $('.empty-state').hide();
                            } else {
                                $('#error').text(response.message).show().delay(3000).fadeOut();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log('AJAX Error:', { status, error, xhr });
                            $('#error').text('An error occurred. Please try again.').show().delay(3000).fadeOut();
                        }
                    });
                });

                // Delete note via AJAX with modal
                $('#notesGrid').on('click', '.btn-delete', function () {
                    const noteId = $(this).data('id');
                    $('#deleteModal').data('note-id', noteId).find('.modal-content').addClass('active').end().show(); // Show modal with active class
                });

                // Confirm delete
                $('#confirmDelete').click(function () {
                    const noteId = $('#deleteModal').data('note-id');
                    $.ajax({
                        url: 'notes.php',
                        type: 'POST',
                        data: { action: 'delete', id: noteId },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                $(`[data-id="${noteId}"]`).remove();
                                $('#deleteModal').hide().find('.modal-content').removeClass('active');
                                $('#message').text(response.message).show().delay(3000).fadeOut();
                                if ($('#notesGrid').children().length === 0) {
                                    $('.empty-state').show();
                                }
                            } else {
                                $('#deleteModal').hide().find('.modal-content').removeClass('active');
                                $('#error').text(response.message).show().delay(3000).fadeOut();
                            }
                        },
                        error: function () {
                            $('#deleteModal').hide().find('.modal-content').removeClass('active');
                            $('#error').text('An error occurred. Please try again.').show().delay(3000).fadeOut();
                        }
                    });
                });

                // Cancel delete
                $('#cancelDelete').click(function () {
                    $('#deleteModal').hide().find('.modal-content').removeClass('active');
                });

                // View note via AJAX
                $('#notesGrid').on('click', '.btn-view', function () {
                    const noteId = $(this).data('id');
                    $.ajax({
                        url: 'notes.php',
                        type: 'POST',
                        data: { action: 'view', id: noteId },
                        dataType: 'json',
                        success: function (response) {
                            console.log('View Response:', response);
                            if (response.status === 'success') {
                                $('#modalDescription').text(response.description);
                                $('#viewModal').find('.modal-content').addClass('active').end().show(); // Show modal with active class
                            } else {
                                $('#error').text(response.message).show().delay(3000).fadeOut();
                            }
                        },
                        error: function () {
                            $('#error').text('An error occurred. Please try again.').show().delay(3000).fadeOut();
                        }
                    });
                });

                // Close modals
                $('.close-modal').click(function () {
                    $(this).closest('.modal').hide().find('.modal-content').removeClass('active');
                });

                // Close modals on outside click
                $(window).click(function (e) {
                    if ($(e.target).is('#viewModal') || $(e.target).is('#deleteModal')) {
                        $(e.target).hide().find('.modal-content').removeClass('active');
                    }
                });
            });
        </script>

        <?php mysqli_close($conn); ?>
</body>

</html>