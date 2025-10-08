<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">User Management</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Profile Picture -->
                    @if(Auth::user()->profile_picture)
                        <img class="h-8 w-8 rounded-full object-cover"
                            src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile">
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                    @endif

                    <div class="flex flex-col">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-blue-600">{{ ucfirst(Auth::user()->role ?? 'user') }}</span>
                    </div>

                    <a href="{{ route('dashboard.home') }}"
                        class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>

                    <form method="POST" action="{{ route('dashboard.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen ">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <!-- <h2 class="text-lg font-semibold text-gray-800 mb-4">User Management</h2> -->
                <div class="space-y-3">
                    <div class="block bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <h4 class="font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-users mr-3 text-blue-600"></i>All Users
                        </h4>
                        <p class="text-blue-700 text-sm mt-1">Manage system users</p>
                    </div>

                    <div
                        class="block bg-green-50 p-4 rounded-lg hover:bg-green-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-green-900 flex items-center">
                            <i class="fas fa-user-plus mr-3 text-green-600"></i>Add User
                        </h4>
                        <p class="text-green-700 text-sm mt-1">Create new user account</p>
                    </div>

                    <div
                        class="block bg-purple-50 p-4 rounded-lg hover:bg-purple-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-purple-900 flex items-center">
                            <i class="fas fa-shield-alt mr-3 text-purple-600"></i>Roles
                        </h4>
                        <p class="text-purple-700 text-sm mt-1">Manage user permissions</p>
                    </div>

                    <div
                        class="block bg-orange-50 p-4 rounded-lg hover:bg-orange-100 transition-colors cursor-pointer group">
                        <h4 class="font-semibold text-orange-900 flex items-center">
                            <i class="fas fa-chart-line mr-3 text-orange-600"></i>Statistics
                        </h4>
                        <p class="text-orange-700 text-sm mt-1">User analytics</p>
                    </div>
                </div>

                <!-- Quick Stats in Sidebar -->
                <div class="mt-6 pt-4 border-t">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">Quick Stats</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Users</span>
                            <span id="totalUsers" class="font-semibold">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Active</span>
                            <span id="activeUsers" class="font-semibold text-green-600">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Inactive</span>
                            <span id="inactiveUsers" class="font-semibold text-red-600">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-6 overflow-auto">
            <!-- Search and Filters Bar -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="relative flex-1 max-w-md">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input id="search" type="text" placeholder="Search name or email..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <select id="role"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="">All roles</option>
                            <option value="user">User</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                        <select id="per_page"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                            <option value="6">6 per page</option>
                            <option value="12">12 per page</option>
                            <option value="24">24 per page</option>
                        </select>
                    </div>
                    <button id="createBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="fas fa-plus"></i>Add User
                    </button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Users List</h3>
                </div>
                <div id="tableWrap" class="overflow-x-auto"></div>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="mt-6 flex justify-center gap-2"></div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed bottom-4 right-4 flex flex-col gap-2 z-50"></div>

    <template id="rowTemplate">
        <tr class="border-t hover:bg-gray-50 transition-colors">
            <td class="p-4 data-id font-mono text-sm text-gray-600"></td>
            <td class="p-4">
                <div class="flex items-center gap-3">
                    <img class="h-10 w-10 rounded-full object-cover avatar-img hidden" alt="avatar" />
                    <div
                        class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-sm font-semibold avatar-fallback">
                        –</div>
                    <div>
                        <div class="font-medium text-gray-900 data-name"></div>
                        <div class="text-sm text-gray-500 data-email-small"></div>
                    </div>
                </div>
            </td>
            <td class="p-4 data-email text-gray-600"></td>
            <td class="p-4">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium data-role-badge"></span>
            </td>
            <td class="p-4 data-plan text-gray-600"></td>
            <td class="p-4">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium data-active-badge"></span>
            </td>
            <td class="p-4">
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors viewBtn text-sm">
                        <i class="fas fa-eye mr-1"></i>View
                    </button>
                    <button
                        class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors editBtn text-sm">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <button
                        class="px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors deleteBtn text-sm">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </td>
        </tr>
    </template>

    <!-- Create/Edit User Modal -->
    <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl m-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h2 id="modalTitle" class="text-xl font-semibold"></h2>
                <button id="modalCloseX" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="formErrors"
                class="hidden mb-4 rounded-lg border border-red-200 bg-red-50 text-red-800 text-sm p-3"></div>
            <form id="userForm" class="grid grid-cols-1 md:grid-cols-2 gap-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="_method" value="POST" />
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input name="name"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <textarea name="bio"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        rows="3"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" name="profile_picture" accept="image/*"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password"
                            class="border border-gray-300 rounded-lg p-3 w-full pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <button type="button"
                            class="pw-toggle absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700"
                            aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation"
                            class="border border-gray-300 rounded-lg p-3 w-full pr-12 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <button type="button"
                            class="pw-toggle absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-700"
                            aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="is_active"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Plan (optional)</label>
                    <select name="assign_plan" id="assign_plan"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- No plan --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Plan Status</label>
                    <select name="assign_status"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="active">Active</option>
                        <option value="created">Created</option>
                        <option value="paused">Paused</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">
                    <button type="button" id="cancelBtn"
                        class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View User Modal -->
    <div id="viewModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg m-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">User Details</h2>
                <button id="viewCloseBtn" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="flex items-center gap-4 mb-6">
                <img id="viewAvatar" class="h-16 w-16 rounded-full object-cover hidden" alt="avatar" />
                <div id="viewAvatarFallback"
                    class="h-16 w-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-lg">
                    –</div>
                <div>
                    <div id="viewName" class="font-semibold text-lg"></div>
                    <div id="viewEmail" class="text-gray-600"></div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-gray-500 font-medium">ID</div>
                    <div id="viewId" class="font-mono"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Role</div>
                    <div id="viewRole" class="font-semibold"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Status</div>
                    <div id="viewActive"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Phone</div>
                    <div id="viewPhone"></div>
                </div>
                <div class="col-span-2">
                    <div class="text-gray-500 font-medium">Bio</div>
                    <div id="viewBio" class="whitespace-pre-line"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Email Verified</div>
                    <div id="viewEmailVerified"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Last Login</div>
                    <div id="viewLastLogin"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Created At</div>
                    <div id="viewCreated"></div>
                </div>
                <div>
                    <div class="text-gray-500 font-medium">Updated At</div>
                    <div id="viewUpdated"></div>
                </div>
            </div>
            <div class="mt-6 text-right">
                <button id="viewOkBtn"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Close</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md m-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-red-600">Delete User</h2>
                <button id="deleteCloseBtn" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                    <p class="text-gray-700">Are you sure you want to delete this user?</p>
                </div>
                <p class="text-sm text-gray-600 ml-9">This action cannot be undone and will permanently remove all user
                    data.</p>
            </div>
            <div class="flex justify-end gap-3">
                <button id="deleteCancelBtn"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button id="deleteConfirmBtn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete
                    User</button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function getCookie(name) {
            const m = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'))
            return m ? decodeURIComponent(m[1]) : null
        }
        function csrfHeaders() {
            const xsrf = getCookie('XSRF-TOKEN')
            const token = xsrf || '{{ csrf_token() }}'
            return { 'X-XSRF-TOKEN': token, 'X-CSRF-TOKEN': token }
        }
        function withCredentials(opts = {}) {
            return { credentials: 'same-origin', ...opts }
        }
        let page = 1
        const state = { q: '', role: '', per_page: 6 }
        let deleteTargetId = null

        const tableWrap = document.getElementById('tableWrap')
        const pagination = document.getElementById('pagination')
        const rowTemplate = document.getElementById('rowTemplate')
        const modal = document.getElementById('modal')
        const userForm = document.getElementById('userForm')
        const methodField = document.getElementById('_method')
        const modalTitle = document.getElementById('modalTitle')

        document.getElementById('search').addEventListener('input', debounce(e => { state.q = e.target.value; page = 1; load() }, 300))
        document.getElementById('role').addEventListener('change', e => { state.role = e.target.value; page = 1; load() })
        document.getElementById('per_page').addEventListener('change', e => { state.per_page = e.target.value; page = 1; load() })
        document.getElementById('createBtn').addEventListener('click', () => openCreate())
        document.getElementById('cancelBtn').addEventListener('click', closeModal)
        document.getElementById('modalCloseX').addEventListener('click', closeModal)

        // Sidebar interactions
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('click', function () {
                const text = this.querySelector('h4').textContent.trim()
                if (text === 'Add User') {
                    openCreate()
                } else {
                    showToast(`${text} feature coming soon!`)
                }
            })
        })

        function openCreate() {
            modalTitle.textContent = 'Create New User'
            methodField.value = 'POST'
            userForm.reset()
            userForm.onsubmit = submitCreate
            showModal()
        }

        function openEdit(user) {
            modalTitle.textContent = 'Edit User'
            methodField.value = 'PUT'
            userForm.reset()
            userForm.name.value = user.name
            userForm.email.value = user.email || ''
            userForm.phone.value = user.phone || ''
            userForm.bio.value = user.bio || ''
            userForm.role.value = user.role || 'user'
            userForm.is_active.value = user.is_active ? '1' : '0'
            userForm.onsubmit = (e) => submitUpdate(e, user.id)
            showModal()
        }

        // View modal helpers
        const viewModal = document.getElementById('viewModal')
        const viewAvatar = document.getElementById('viewAvatar')
        const viewAvatarFallback = document.getElementById('viewAvatarFallback')
        const viewName = document.getElementById('viewName')
        const viewEmail = document.getElementById('viewEmail')
        const viewRole = document.getElementById('viewRole')
        const viewActive = document.getElementById('viewActive')
        const viewId = document.getElementById('viewId')
        const viewPhone = document.getElementById('viewPhone')
        const viewBio = document.getElementById('viewBio')
        const viewEmailVerified = document.getElementById('viewEmailVerified')
        const viewLastLogin = document.getElementById('viewLastLogin')
        const viewCreated = document.getElementById('viewCreated')
        const viewUpdated = document.getElementById('viewUpdated')

        document.getElementById('viewCloseBtn').onclick = () => closeView()
        document.getElementById('viewOkBtn').onclick = () => closeView()

        function fmt(val) {
            if (!val) return '-';
            try {
                const d = new Date(val);
                return isNaN(d) ? String(val) : d.toLocaleString();
            } catch {
                return String(val)
            }
        }

        function openView(user) {
            viewName.textContent = user.name
            viewEmail.textContent = user.email
            viewRole.textContent = user.role || '-'
            viewActive.innerHTML = user.is_active ? '<span class="text-green-600 font-medium">Active</span>' : '<span class="text-red-600 font-medium">Inactive</span>'
            viewId.textContent = user.id
            viewPhone.textContent = user.phone || '-'
            viewBio.textContent = user.bio || '-'
            viewEmailVerified.textContent = fmt(user.email_verified_at)
            viewLastLogin.textContent = fmt(user.last_login_at)
            viewCreated.textContent = fmt(user.created_at)
            viewUpdated.textContent = fmt(user.updated_at)

            if (user.profile_picture) {
                viewAvatar.src = `${location.origin}/storage/${user.profile_picture}`
                viewAvatar.classList.remove('hidden')
                viewAvatarFallback.classList.add('hidden')
            } else {
                viewAvatar.classList.add('hidden')
                viewAvatarFallback.classList.remove('hidden')
                viewAvatarFallback.textContent = (user.name || 'U').split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
            }
            viewModal.classList.remove('hidden'); viewModal.classList.add('flex')
        }

        function closeView() {
            viewModal.classList.add('hidden');
            viewModal.classList.remove('flex')
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex')
            document.getElementById('formErrors').classList.add('hidden')
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex')
        }

        async function submitCreate(e) {
            e.preventDefault()
            const body = new FormData(userForm)
            if (!body.get('password')) {
                showFormError('Password is required');
                return
            }

            try {
                const res = await fetch(`{{ route('admin.users.store') }}`, withCredentials({
                    method: 'POST',
                    headers: { ...csrfHeaders(), 'Accept': 'application/json' },
                    body
                }))

                if (!res.ok) {
                    await handleValidationError(res)
                    return
                }

                closeModal();
                showToast('User created successfully', 'success');
                load()
            } catch (error) {
                showFormError('Network error occurred')
            }
        }

        async function submitUpdate(e, id) {
            e.preventDefault()
            const form = new FormData(userForm)
            form.append('_method', 'PUT')

            try {
                const res = await fetch(`{{ url('/dashboard/admin/users') }}/${id}`, withCredentials({
                    method: 'POST',
                    headers: { ...csrfHeaders(), 'Accept': 'application/json' },
                    body: form
                }))

                if (!res.ok) {
                    await handleValidationError(res)
                    return
                }

                closeModal();
                showToast('User updated successfully', 'success');
                load()
            } catch (error) {
                showFormError('Network error occurred')
            }
        }

        function showFormError(message) {
            const box = document.getElementById('formErrors')
            box.classList.remove('hidden')
            box.textContent = message
        }

        async function handleValidationError(res) {
            const box = document.getElementById('formErrors')
            box.classList.remove('hidden');
            box.textContent = 'Request failed';
            try {
                const text = await res.text()
                try {
                    const data = JSON.parse(text)
                    if (data.errors) {
                        const list = Object.values(data.errors).flat()
                        box.innerHTML = list.map(m => `<div>• ${m}</div>`).join('')
                    } else if (data.message) {
                        box.textContent = data.message
                    } else {
                        box.textContent = text
                    }
                } catch {
                    box.innerHTML = text.substring(0, 500)
                }
            } catch (e) {
                box.textContent = `${res.status} ${res.statusText}`
            }
        }

        // Delete modal helpers
        const deleteModal = document.getElementById('deleteModal')
        const openDelete = (id) => {
            deleteTargetId = id;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex')
        }
        const closeDelete = () => {
            deleteTargetId = null;
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex')
        }

        document.getElementById('deleteCloseBtn').onclick = closeDelete
        document.getElementById('deleteCancelBtn').onclick = closeDelete
        document.getElementById('deleteConfirmBtn').onclick = async () => {
            if (!deleteTargetId) return

            try {
                const body = new URLSearchParams({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
                const res = await fetch(`{{ url('/dashboard/admin/users') }}/${deleteTargetId}`, withCredentials({
                    method: 'POST',
                    headers: {
                        ...csrfHeaders(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body
                }))

                if (!res.ok) {
                    try {
                        const msg = await res.text();
                        showToast(msg.substring(0, 100), 'error');
                    } catch {
                        showToast('Failed to delete user', 'error')
                    }
                    return
                }

                closeDelete();
                showToast('User deleted successfully', 'success');
                load()
            } catch (error) {
                showToast('Network error occurred', 'error')
            }
        }

        function updateSidebarStats(data) {
            if (data && data.data) {
                const total = data.total || 0
                const active = data.data.filter(u => u.is_active).length
                const inactive = total - active

                document.getElementById('totalUsers').textContent = total
                document.getElementById('activeUsers').textContent = active
                document.getElementById('inactiveUsers').textContent = inactive
            }
        }

        async function load() {
            try {
                const params = new URLSearchParams({
                    q: state.q,
                    role: state.role,
                    per_page: state.per_page,
                    page
                })

                const res = await fetch(`{{ route('admin.users.index') }}?${params.toString()}`, withCredentials({
                    headers: { 'Accept': 'application/json' }
                }))

                if (!res.ok) {
                    throw new Error('Failed to load users')
                }

                const data = await res.json()
                renderTable(data)
                renderPagination(data)
                updateSidebarStats(data)
            } catch (error) {
                showToast('Failed to load users', 'error')
            }
        }

        function getRoleBadgeClass(role) {
            switch (role?.toLowerCase()) {
                case 'admin':
                    return 'bg-red-100 text-red-800'
                case 'manager':
                    return 'bg-blue-100 text-blue-800'
                default:
                    return 'bg-gray-100 text-gray-800'
            }
        }

        function renderTable(paginated) {
            const table = document.createElement('table')
            table.className = 'min-w-full divide-y divide-gray-200'
            table.innerHTML = `
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200"></tbody>
            `

            const tbody = table.querySelector('tbody')

            if (paginated.data.length === 0) {
                const emptyRow = document.createElement('tr')
                emptyRow.innerHTML = `
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        <i class="fas fa-users text-4xl mb-3 opacity-50"></i>
                        <div>No users found</div>
                        <div class="text-sm">Try adjusting your search criteria</div>
                    </td>
                `
                tbody.appendChild(emptyRow)
            } else {
                paginated.data.forEach(u => {
                    const tr = rowTemplate.content.cloneNode(true)
                    tr.querySelector('.data-id').textContent = u.id
                    tr.querySelector('.data-name').textContent = u.name
                    tr.querySelector('.data-email').textContent = u.email || '-'
                    tr.querySelector('.data-email-small').textContent = u.email || ''
                    // Plan column (uses current_plan from API; show friendly or 'No plan')
                    tr.querySelector('.data-plan').textContent = (u.current_plan ? (u.current_plan.charAt(0).toUpperCase() + u.current_plan.slice(1)) : 'No plan')


                    // Role badge
                    const roleBadge = tr.querySelector('.data-role-badge')
                    roleBadge.textContent = (u.role || 'user').charAt(0).toUpperCase() + (u.role || 'user').slice(1)
                    roleBadge.className += ' ' + getRoleBadgeClass(u.role)

                    // Active badge
                    const activeBadge = tr.querySelector('.data-active-badge')
                    if (u.is_active) {
                        activeBadge.textContent = 'Active'
                        activeBadge.className += ' bg-green-100 text-green-800'
                    } else {
                        activeBadge.textContent = 'Inactive'
                        activeBadge.className += ' bg-red-100 text-red-800'
                    }

                    // Avatar handling
                    const img = tr.querySelector('.avatar-img')
                    const fb = tr.querySelector('.avatar-fallback')
                    if (u.profile_picture) {
                        img.src = `${location.origin}/storage/${u.profile_picture}`
                        img.classList.remove('hidden')
                        fb.classList.add('hidden')
                    } else {
                        img.classList.add('hidden')
                        fb.classList.remove('hidden')
                        fb.textContent = (u.name || 'U').split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
                    }

                    // Button events
                    tr.querySelector('.viewBtn').onclick = async () => {
                        try {
                            const r = await fetch(`{{ url('/dashboard/admin/users') }}/${u.id}`, withCredentials({
                                headers: { 'Accept': 'application/json' }
                            }))
                            if (r.ok) {
                                openView(await r.json())
                            } else {
                                showToast('Failed to load user details', 'error')
                            }
                        } catch {
                            showToast('Network error occurred', 'error')
                        }
                    }
                    tr.querySelector('.editBtn').onclick = () => openEdit(u)
                    tr.querySelector('.deleteBtn').onclick = () => openDelete(u.id)

                    tbody.appendChild(tr)
                })
            }

            tableWrap.innerHTML = ''
            tableWrap.appendChild(table)
        }

        function renderPagination(p) {
            pagination.innerHTML = ''

            if (p.last_page <= 1) return

            const makeBtn = (label, targetPage, disabled = false, icon = null) => {
                const b = document.createElement('button')
                b.innerHTML = icon ? `<i class="${icon}"></i>` : label
                b.className = `px-3 py-2 text-sm border rounded-lg transition-colors ${disabled
                        ? 'opacity-50 cursor-not-allowed bg-gray-100 text-gray-400'
                        : 'hover:bg-blue-50 hover:border-blue-300 text-gray-700'
                    }`
                if (!disabled) {
                    b.onclick = () => { page = targetPage; load() }
                }
                return b
            }

            // Previous button
            pagination.appendChild(makeBtn('', Math.max(1, p.current_page - 1), p.current_page === 1, 'fas fa-chevron-left'))

            // Page numbers
            const start = Math.max(1, p.current_page - 2)
            const end = Math.min(p.last_page, p.current_page + 2)

            if (start > 1) {
                pagination.appendChild(makeBtn('1', 1))
                if (start > 2) {
                    const dots = document.createElement('span')
                    dots.textContent = '...'
                    dots.className = 'px-3 py-2 text-gray-500'
                    pagination.appendChild(dots)
                }
            }

            for (let i = start; i <= end; i++) {
                const btn = makeBtn(i, i, false)
                if (i === p.current_page) {
                    btn.className = btn.className.replace('hover:bg-blue-50 hover:border-blue-300 text-gray-700', 'bg-blue-600 text-white border-blue-600')
                }
                pagination.appendChild(btn)
            }

            if (end < p.last_page) {
                if (end < p.last_page - 1) {
                    const dots = document.createElement('span')
                    dots.textContent = '...'
                    dots.className = 'px-3 py-2 text-gray-500'
                    pagination.appendChild(dots)
                }
                pagination.appendChild(makeBtn(p.last_page, p.last_page))
            }

            // Next button
            pagination.appendChild(makeBtn('', Math.min(p.last_page, p.current_page + 1), p.current_page === p.last_page, 'fas fa-chevron-right'))

            // Page info
            const info = document.createElement('div')
            info.className = 'text-sm text-gray-600 flex items-center ml-4'
            info.textContent = `Showing ${((p.current_page - 1) * p.per_page) + 1}-${Math.min(p.current_page * p.per_page, p.total)} of ${p.total} users`
            pagination.appendChild(info)
        }

        // Toast helper
        function showToast(message, type = 'success') {
            const wrap = document.getElementById('toastContainer')
            const el = document.createElement('div')

            const bgClass = type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'
            const icon = type === 'success' ? 'fas fa-check-circle' : type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-info-circle'

            el.className = `${bgClass} text-white px-4 py-3 rounded-lg shadow-lg transform translate-y-2 opacity-0 transition-all duration-300 flex items-center gap-2 max-w-sm`
            el.innerHTML = `<i class="${icon}"></i><span>${message}</span>`

            wrap.appendChild(el)
            requestAnimationFrame(() => {
                el.classList.remove('translate-y-2', 'opacity-0')
                el.classList.add('translate-y-0', 'opacity-100')
            })
            setTimeout(() => {
                el.classList.add('opacity-0', 'translate-y-2')
                setTimeout(() => el.remove(), 300)
            }, 4000)
        }

        function enablePwToggles(root = document) {
            root.querySelectorAll('.pw-toggle').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = btn.parentElement.querySelector('input')
                    if (!input) return
                    const isPw = input.type === 'password'
                    input.type = isPw ? 'text' : 'password'
                    const icon = btn.querySelector('i')
                    icon.className = isPw ? 'fas fa-eye-slash' : 'fas fa-eye'
                })
            })
        }

        function debounce(fn, wait) {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), wait)
            }
        }

        async function loadPlansIntoForm() {
            try {
                const r = await fetch(`{{ route('admin.payment.plans.json') }}`, withCredentials({ headers: { 'Accept': 'application/json' } }))
                if (!r.ok) return
                const plans = await r.json()
                const sel = document.getElementById('assign_plan')
                if (!sel) return
                sel.innerHTML = '<option value="">-- No plan --</option>' + plans.map(p => `<option value="${p.slug}">${p.name} (${p.billing_period})</option>`).join('')
            } catch { }
        }

        // Initialize
        load()
        loadPlansIntoForm()
        enablePwToggles(document)
    </script>
</body>

</html>