<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="p-4">
    <h1 class="mb-4 text-center">User Data</h1>
    <div class="row">
        <!-- Insert Form (Left Side) -->
        <div class="col-md-5">
            <div class="card shadow-sm p-4">
                <form id="userForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}"
                            placeholder="Enter your name">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}"
                            placeholder="Enter your email">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                            placeholder="Enter your phone">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
                <!-- Success/Error Message -->
                <div id="message"></div>
            </div>
        </div>
        <!-- Search and Table (Right Side) -->
        <div class="col-md-7">
            <div class="card shadow-sm p-4">
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <input type="text" name="search" id="searchInput" class="form-control me-2"
                            placeholder="Type to search by name, email, or phone..." value="{{ request('search') }}">
                        <button type="button" class="btn btn-outline-secondary" id="clearSearch">Clear</button>
                    </div>
                </div>
                <div id="searchResults" class="mb-3">
                    @if (request('search'))
                        <p>Showing results for: <strong>{{ request('search') }}</strong></p>
                    @endif
                </div>
                <div id="loadingIndicator" class="text-center mb-3" style="display: none;">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Searching...</span>
                </div>
                <form id="deleteMultipleForm">
                    @csrf
                    @method('DELETE')
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center" id="userTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($studentdata as $sd)
                                    <tr>
                                        <td>{{ $sd->id }}</td>
                                        <td>
                                            @if ($sd->image)
                                                <img src="{{ asset('storage/' . $sd->image) }}" alt="User Image"
                                                    class="rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $sd->name }}</td>
                                        <td>{{ $sd->email }}</td>
                                        <td>{{ $sd->phone }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-warning edit-btn" data-id="{{ $sd->id }}"
                                                data-name="{{ htmlspecialchars($sd->name) }}"
                                                data-email="{{ htmlspecialchars($sd->email) }}"
                                                data-phone="{{ htmlspecialchars($sd->phone) }}"
                                                data-image="{{ $sd->image ? asset('storage/' . $sd->image) : '' }}">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $sd->id }}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  <div class="pagination"></div>
                   
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="editId">
                        <div class="mb-3">
                            <input type="text" name="username" id="editUsername" class="form-control"
                                placeholder="Enter your name">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="email" id="editEmail" class="form-control"
                                placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="phone" id="editPhone" class="form-control"
                                placeholder="Enter your phone">
                        </div>
                        <div class="mb-3">
                            <label>Current Image</label>
                            <img id="currentImagePreview" src="" alt="Current Image" class="rounded-circle"
                                style="width: 100px; height: 100px; object-fit: cover; display: none;">
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .w-5.h-5 {
            width: 20px;
        }
        
        /* Highlight search terms */
        .highlight {
            background-color: #fff3cd;
            padding: 1px 3px;
            border-radius: 2px;
        }
    </style>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery AJAX Script -->
    <script>
        $(document).ready(function () {
            let searchTimeout;
            
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Real-time Search Input Event
            $('#searchInput').on('input', function() {
                clearTimeout(searchTimeout);
                var searchQuery = $(this).val();
                
                // Clear previous timeout
                searchTimeout = setTimeout(function() {
                    performSearch(searchQuery);
                }, 300); // 300ms delay for better performance
            });

            // Clear Search Button
            $('#clearSearch').click(function() {
                $('#searchInput').val('');
                $('#searchResults').empty();
                refreshTable('', 1);
            });

            // Perform Search Function
            function performSearch(searchQuery) {
                // Show loading indicator
                $('#loadingIndicator').show();
                
                refreshTable(searchQuery, 1);
                
                // Update search results text
                if (searchQuery.trim()) {
                    $('#searchResults').html(`<p class="text-info">Showing results for: <strong>"${searchQuery}"</strong></p>`);
                } else {
                    $('#searchResults').empty();
                }
            }

            // Insert Form AJAX
            $('#userForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var messageDiv = $('#message');

                $.ajax({
                    url: '{{ route('crud.index') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            messageDiv.html(`<div class="alert alert-success mt-3">${response.message}</div>`).hide().fadeIn();
                            refreshTable();
                            $('#userForm')[0].reset();
                            setTimeout(function () {
                                messageDiv.fadeOut(500, function () {
                                    $(this).empty();
                                });
                            }, 3000);
                        } else {
                            messageDiv.html(`<div class="alert alert-danger mt-3">${response.message}</div>`).hide().fadeIn();
                            if (response.errors) {
                                var errorsHtml = '<ul class="mb-0">';
                                $.each(response.errors, function (field, error) {
                                    errorsHtml += `<li>${field}: ${error[0]}</li>`;
                                });
                                errorsHtml += '</ul>';
                                messageDiv.append(errorsHtml);
                            }
                            setTimeout(function () {
                                messageDiv.fadeOut(500, function () {
                                    $(this).empty();
                                });
                            }, 3000);
                        }
                    },
                    error: function (xhr, status, error) {
                        messageDiv.html(`<div class="alert alert-danger mt-3">An unexpected error occurred</div>`).hide().fadeIn();
                        console.error('Error:', error);
                        setTimeout(function () {
                            messageDiv.fadeOut(500, function () {
                                $(this).empty();
                            });
                        }, 3000);
                    }
                });
            });

            // Edit Button Click
            $(document).on('click', '.edit-btn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var imageUrl = $(this).data('image');
                $('#editId').val(id);
                $('#editUsername').val(name);
                $('#editEmail').val(email);
                $('#editPhone').val(phone);
                if (imageUrl) {
                    $('#currentImagePreview').attr('src', imageUrl).css('display', 'block');
                } else {
                    $('#currentImagePreview').css('display', 'none');
                }
                $('#editModal').modal('show');
            });

            // Edit Form Submit
            $('#editForm').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var messageDiv = $('#message');

                $.ajax({
                    url: '{{ route('crud.ajaxUpdate', ':id') }}'.replace(':id', $('#editId').val()),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            messageDiv.html(`<div class="alert alert-success mt-3">${response.message}</div>`).hide().fadeIn();
                            $('#editModal').modal('hide');
                            refreshTable($('#searchInput').val());
                            setTimeout(function () {
                                messageDiv.fadeOut(500, function () {
                                    $(this).empty();
                                });
                            }, 3000);
                        } else {
                            var errorHtml = `<div class="alert alert-danger mt-3">${response.message}`;
                            if (response.errors) {
                                errorHtml += '<ul class="mb-0">';
                                $.each(response.errors, function (field, error) {
                                    errorHtml += `<li>${field}: ${error[0]}</li>`;
                                });
                                errorHtml += '</ul>';
                            }
                            errorHtml += '</div>';
                            messageDiv.html(errorHtml).hide().fadeIn();
                            setTimeout(function () {
                                messageDiv.fadeOut(500, function () {
                                    $(this).empty();
                                });
                            }, 3000);
                        }
                    },
                    error: function (xhr, status, error) {
                        messageDiv.html(`<div class="alert alert-danger mt-3">Update failed</div>`).hide().fadeIn();
                        console.error('Error:', error);
                        setTimeout(function () {
                            messageDiv.fadeOut(500, function () {
                                $(this).empty();
                            });
                        }, 3000);
                    }
                });
            });

            // Delete Button Click
            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#confirmDelete').data('id', id);
                $('#deleteModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDelete').click(function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('crud.ajaxDelete', ':id') }}'.replace(':id', id),
                    type: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            $('#message').html(`<div class="alert alert-success mt-3">${response.message}</div>`).hide().fadeIn();
                            $('#deleteModal').modal('hide');
                            refreshTable($('#searchInput').val());
                            setTimeout(function () {
                                $('#message').fadeOut(500, function () {
                                    $(this).empty();
                                });
                            }, 3000);
                        } else {
                            $('#message').html(`<div class="alert alert-danger mt-3">${response.message}</div>`).hide().fadeIn();
                            setTimeout(function () {
                                $('#message').fadeOut(500, function () {
                                    $(this).empty();
                                });
                            }, 3000);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#message').html(`<div class="alert alert-danger mt-3">Delete failed</div>`).hide().fadeIn();
                        console.error('Error:', error);
                        setTimeout(function () {
                            $('#message').fadeOut(500, function () {
                                $(this).empty();
                            });
                        }, 3000);
                    }
                });
            });

            // Table Refresh Function with Search and Pagination Support
            function refreshTable(searchQuery = '', page = 1) {
                // Show loading indicator
                $('#loadingIndicator').show();
                
                $.ajax({
                    url: '{{ route('crud.getTableData') }}?search=' + encodeURIComponent(searchQuery) + '&page=' + page,
                    type: 'GET',
                    success: function (tableResponse) {
                        // Hide loading indicator
                        $('#loadingIndicator').hide();
                        
                        if (tableResponse.success) {
                            var newBodyHtml = '';
                            if (tableResponse.rows.length === 0) {
                                if (searchQuery.trim()) {
                                    newBodyHtml = `
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            <i class="fas fa-search"></i><br>
                                            No results found for "<strong>${searchQuery}</strong>"<br>
                                            <small>Try adjusting your search terms</small>
                                        </td>
                                    </tr>
                                `;
                                } else {
                                    newBodyHtml = `
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No records found</td>
                                    </tr>
                                `;
                                }
                            } else {
                                tableResponse.rows.forEach(function (row) {
                                    newBodyHtml += `
                                    <tr>
                                        <td>${row.id}</td>
                                        <td>${row.image}</td>
                                        <td>${highlightSearchTerm(row.name, searchQuery)}</td>
                                        <td>${highlightSearchTerm(row.email, searchQuery)}</td>
                                        <td>${highlightSearchTerm(row.phone, searchQuery)}</td>
                                        <td>${row.operations}</td>
                                    </tr>
                                `;
                                });
                            }
                            $('#tableBody').html(newBodyHtml);

                            // Update pagination
                            var pagination = tableResponse.pagination;
                            var paginationHtml = '';
                            if (pagination.last_page > 1) {
                                paginationHtml += '<nav><ul class="pagination justify-content-center">';
                                // Previous page
                                if (pagination.current_page > 1) {
                                    paginationHtml += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" data-page="${pagination.current_page - 1}">Previous</a>
                                    </li>
                                `;
                                }
                                // Page numbers
                                for (var i = 1; i <= pagination.last_page; i++) {
                                    paginationHtml += `
                                    <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                    </li>
                                `;
                                }
                                // Next page
                                if (pagination.current_page < pagination.last_page) {
                                    paginationHtml += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" data-page="${pagination.current_page + 1}">Next</a>
                                    </li>
                                `;
                                }
                                paginationHtml += '</ul></nav>';
                            }
                            $('.pagination').html(paginationHtml);
                        }
                    },
                    error: function () {
                        // Hide loading indicator
                        $('#loadingIndicator').hide();
                        console.error('Failed to refresh table');
                        $('#message').html(`<div class="alert alert-danger mt-3">Failed to load table data</div>`).hide().fadeIn();
                        setTimeout(function () {
                            $('#message').fadeOut(500, function () {
                                $(this).empty();
                            });
                        }, 3000);
                    }
                });
            }

            // Function to highlight search terms
            function highlightSearchTerm(text, searchTerm) {
                if (!searchTerm || !text) return text;
                
                var regex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                return text.replace(regex, '<span class="highlight">$1</span>');
            }

            // Handle Pagination Clicks
            $(document).on('click', '.page-link', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                var searchQuery = $('#searchInput').val();
                refreshTable(searchQuery, page);
            });

            // Initial table load
            refreshTable();
        });
    </script>
</body>

</html>