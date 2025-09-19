<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-semibold">Users</h1>
            <a href="{{ route('dashboard.home') }}" class="inline-flex items-center gap-2 text-sm px-3 py-2 border rounded hover:bg-gray-50" title="Back to Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M19.5 21a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75v10.5c0 .414.336.75.75.75h3Z"/><path d="M3.235 10.704a.75.75 0 0 0 0 1.06l8.25 8.25a.75.75 0 0 0 1.28-.53V4.517a.75.75 0 0 0-1.28-.53l-8.25 8.25Z"/></svg>
                Back to Dashboard
            </a>
        </div>
        <div class="flex gap-2 items-center">
            <input id="search" type="text" placeholder="Search name/email" class="border rounded p-2" />
            <select id="role" class="border rounded p-2">
                <option value="">All roles</option>
                <option value="user">User</option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
            </select>
            <select id="per_page" class="border rounded p-2">
                <option selected>6</option>
            </select>
            <button id="createBtn" class="bg-blue-600 text-white px-4 py-2 rounded">Add User</button>
        </div>
    </div>


    <div id="tableWrap" class="overflow-x-auto bg-white rounded shadow"></div>

    <div id="pagination" class="mt-4 flex gap-2"></div>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed bottom-4 right-4 flex flex-col gap-2 z-50"></div>

    <template id="rowTemplate">
        <tr class="border-t">
            <td class="p-3 data-id"></td>
            <td class="p-3">
                <div class="flex items-center gap-3">
                    <img class="h-8 w-8 rounded-full object-cover avatar-img hidden" alt="avatar" />
                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 text-xs font-semibold avatar-fallback">–</div>
                    <span class="data-name"></span>
                </div>
            </td>
            <td class="p-3 data-email"></td>
            <td class="p-3 data-role"></td>
            <td class="p-3 data-active"></td>
            <td class="p-3 flex gap-2">
                <button class="px-3 py-1 bg-gray-600 text-white rounded viewBtn">View</button>
                <button class="px-3 py-1 bg-yellow-500 text-white rounded editBtn">Edit</button>
                <button class="px-3 py-1 bg-red-600 text-white rounded deleteBtn">Delete</button>
            </td>
        </tr>
    </template>

    <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded p-4 w-full max-w-lg">
            <h2 id="modalTitle" class="text-xl font-semibold mb-3"></h2>
            <div id="formErrors" class="hidden mb-3 rounded border border-red-200 bg-red-50 text-red-800 text-sm p-3"></div>
            <form id="userForm" class="grid grid-cols-1 md:grid-cols-2 gap-3" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="_method" value="POST" />
                <div>
                    <label class="block text-sm">Name</label>
                    <input name="name" class="border rounded p-2 w-full" required />
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input type="email" name="email" class="border rounded p-2 w-full" required />
                </div>
                <div>
                    <label class="block text-sm">Phone</label>
                    <input type="text" name="phone" class="border rounded p-2 w-full" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm">Bio</label>
                    <textarea name="bio" class="border rounded p-2 w-full" rows="3"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm">Profile Picture</label>
                    <input type="file" name="profile_picture" accept="image/*" class="border rounded p-2 w-full" />
                </div>
                <div>
                    <label class="block text-sm">Password</label>
                    <div class="relative">
                        <input type="password" name="password" class="border rounded p-2 w-full pr-10" />
                        <button type="button" class="pw-toggle absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-800" aria-label="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5"><path d="M1.5 12s3.5-6 10.5-6 10.5 6 10.5 6-3.5 6-10.5 6S1.5 12 1.5 12Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" class="border rounded p-2 w-full pr-10" />
                        <button type="button" class="pw-toggle absolute inset-y-0 right-0 px-3 text-gray-500 hover:text-gray-800" aria-label="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5"><path d="M1.5 12s3.5-6 10.5-6 10.5 6 10.5 6-3.5 6-10.5 6S1.5 12 1.5 12Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm">Role</label>
                    <select name="role" class="border rounded p-2 w-full">
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm">Active</label>
                    <select name="is_active" class="border rounded p-2 w-full">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex justify-end gap-2 mt-2">
                    <button type="button" id="cancelBtn" class="px-4 py-2 border rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View User Modal -->
    <div id="viewModal" class="fixed inset-0 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded p-4 w-full max-w-md">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-semibold">User Details</h2>
                <button id="viewCloseBtn" class="text-gray-600 hover:text-gray-800">✕</button>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <img id="viewAvatar" class="h-14 w-14 rounded-full object-cover hidden" alt="avatar" />
                <div id="viewAvatarFallback" class="h-14 w-14 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold">–</div>
                <div>
                    <div id="viewName" class="font-semibold text-lg"></div>
                    <div id="viewEmail" class="text-sm text-gray-600"></div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <div class="text-gray-500">ID</div>
                    <div id="viewId" class="font-medium break-all"></div>
                </div>
                <div>
                    <div class="text-gray-500">Role</div>
                    <div id="viewRole" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Active</div>
                    <div id="viewActive" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Phone</div>
                    <div id="viewPhone" class="font-medium break-all"></div>
                </div>
                <div class="col-span-2">
                    <div class="text-gray-500">Bio</div>
                    <div id="viewBio" class="font-medium whitespace-pre-line break-words"></div>
                </div>
                <div>
                    <div class="text-gray-500">Email Verified</div>
                    <div id="viewEmailVerified" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Last Login</div>
                    <div id="viewLastLogin" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Locked Until</div>
                    <div id="viewLockedUntil" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Failed Attempts</div>
                    <div id="viewFailedAttempts" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Created At</div>
                    <div id="viewCreated" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-gray-500">Updated At</div>
                    <div id="viewUpdated" class="font-medium"></div>
                </div>
            </div>
            <div class="mt-5 text-right">
                <button id="viewOkBtn" class="px-4 py-2 border rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded p-4 w-full max-w-md">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-semibold">Delete User</h2>
                <button id="deleteCloseBtn" class="text-gray-600 hover:text-gray-800">✕</button>
            </div>
            <p class="text-sm text-gray-700">Are you sure you want to delete this user? This action cannot be undone.</p>
            <div class="mt-5 flex justify-end gap-2">
                <button id="deleteCancelBtn" class="px-4 py-2 border rounded">Cancel</button>
                <button id="deleteConfirmBtn" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
            </div>
        </div>
    </div>
@if(session('success'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg"
    >
        {{ session('success') }}
    </div>
@endif

<script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function getCookie(name){
            const m = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'))
            return m ? decodeURIComponent(m[1]) : null
        }
        function csrfHeaders(){
            const xsrf = getCookie('XSRF-TOKEN')
            // Prefer cookie-based XSRF token; fallback to server token
            const token = xsrf || '{{ csrf_token() }}'
            return { 'X-XSRF-TOKEN': token, 'X-CSRF-TOKEN': token }
        }
        function withCredentials(opts={}){
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

        function openCreate(){
            modalTitle.textContent = 'Create User'
            methodField.value = 'POST'
            userForm.reset()
            userForm.onsubmit = submitCreate
            showModal()
        }

        function openEdit(user){
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
        const viewLockedUntil = document.getElementById('viewLockedUntil')
        const viewFailedAttempts = document.getElementById('viewFailedAttempts')
        const viewCreated = document.getElementById('viewCreated')
        const viewUpdated = document.getElementById('viewUpdated')
        document.getElementById('viewCloseBtn').onclick = () => closeView()
        document.getElementById('viewOkBtn').onclick = () => closeView()
        function fmt(val){ if(!val) return '-'; try { const d=new Date(val); return isNaN(d)? String(val): d.toLocaleString(); } catch { return String(val) }
        }
        function openView(user){
            viewName.textContent = user.name
            viewEmail.textContent = user.email
            viewRole.textContent = user.role || '-'
            viewActive.textContent = user.is_active ? 'Yes' : 'No'
            viewId.textContent = user.id
            viewPhone.textContent = user.phone || '-'
            viewBio.textContent = user.bio || '-'
            viewEmailVerified.textContent = fmt(user.email_verified_at)
            viewLastLogin.textContent = fmt(user.last_login_at)
            viewLockedUntil.textContent = fmt(user.locked_until)
            viewFailedAttempts.textContent = user.failed_attempts ?? '0'
            viewCreated.textContent = fmt(user.created_at)
            viewUpdated.textContent = fmt(user.updated_at)
            if (user.profile_picture) {
                viewAvatar.src = `${location.origin}/storage/${user.profile_picture}`
                viewAvatar.classList.remove('hidden')
                viewAvatarFallback.classList.add('hidden')
            } else {
                viewAvatar.classList.add('hidden')
                viewAvatarFallback.classList.remove('hidden')
                viewAvatarFallback.textContent = (user.name || 'U').split(' ').map(w=>w[0]).join('').slice(0,2).toUpperCase()
            }
            viewModal.classList.remove('hidden'); viewModal.classList.add('flex')
        }
        function closeView(){ viewModal.classList.add('hidden'); viewModal.classList.remove('flex') }

        function showModal(){ modal.classList.remove('hidden'); modal.classList.add('flex') }
        function closeModal(){ modal.classList.add('hidden'); modal.classList.remove('flex') }

        async function submitCreate(e){
            e.preventDefault()
            const body = new FormData(userForm)
            if (!body.get('password')) { alert('Password is required'); return }
            const res = await fetch(`{{ route('admin.users.store') }}`, withCredentials({ method: 'POST', headers: { ...csrfHeaders(), 'Accept':'application/json' }, body }))
            if (!res.ok) {
                await handleValidationError(res)
                return
            }
            closeModal(); showToast('User created successfully'); load()
        }

        async function submitUpdate(e, id){
            e.preventDefault()
            const form = new FormData(userForm)
            form.append('_method', 'PUT')
            const res = await fetch(`{{ url('/dashboard/admin/users') }}/${id}`, withCredentials({ method: 'POST', headers: { ...csrfHeaders(), 'Accept':'application/json' }, body: form }))
            if (!res.ok) {
                await handleValidationError(res)
                return
            }
            closeModal(); showToast('User updated successfully'); load()
        }

        async function handleValidationError(res){
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
                    // not JSON; show snippet of HTML/text
                    box.innerHTML = text.substring(0, 500)
                }
            } catch (e) {
                box.textContent = `${res.status} ${res.statusText}`
            }
        }

        // Delete modal helpers
        const deleteModal = document.getElementById('deleteModal')
        const openDelete = (id) => { deleteTargetId = id; deleteModal.classList.remove('hidden'); deleteModal.classList.add('flex') }
        const closeDelete = () => { deleteTargetId = null; deleteModal.classList.add('hidden'); deleteModal.classList.remove('flex') }
        document.getElementById('deleteCloseBtn').onclick = closeDelete
        document.getElementById('deleteCancelBtn').onclick = closeDelete
        document.getElementById('deleteConfirmBtn').onclick = async () => {
            if (!deleteTargetId) return
            const body = new URLSearchParams({ _method: 'DELETE', _token: '{{ csrf_token() }}' })
            const res = await fetch(`{{ url('/dashboard/admin/users') }}/${deleteTargetId}`, withCredentials({ method: 'POST', headers: { ...csrfHeaders(), 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json', 'Content-Type':'application/x-www-form-urlencoded' }, body }))
            if (!res.ok) {
                try { const msg = await res.text(); alert(msg.substring(0, 300)); } catch { alert('Failed to delete') }
                return
            }
            closeDelete(); showToast('User deleted successfully'); load()
        }

        async function load(){
            const params = new URLSearchParams({ q: state.q, role: state.role, per_page: state.per_page, page })
            const res = await fetch(`{{ route('admin.users.index') }}?${params.toString()}`, withCredentials({ headers: { 'Accept': 'application/json' } }))
            const data = await res.json()
            renderTable(data)
            renderPagination(data)
        }

        function renderTable(paginated){
            const table = document.createElement('table')
            table.className = 'min-w-full'
            table.innerHTML = `<thead><tr class="bg-gray-100 text-left">
                <th class="p-3">ID</th><th class="p-3">Avatar & Name</th><th class="p-3">Email</th><th class="p-3">Role</th><th class="p-3">Active</th><th class="p-3">Actions</th></tr></thead><tbody></tbody>`
            const tbody = table.querySelector('tbody')
            paginated.data.forEach(u => {
                const tr = rowTemplate.content.cloneNode(true)
                tr.querySelector('.data-id').textContent = u.id
                tr.querySelector('.data-name').textContent = u.name
                tr.querySelector('.data-email').textContent = u.email || '-'
                tr.querySelector('.data-role').textContent = u.role
                tr.querySelector('.data-active').textContent = u.is_active ? 'Yes' : 'No'
                const img = tr.querySelector('.avatar-img')
                const fb = tr.querySelector('.avatar-fallback')
                if (u.profile_picture) {
                    img.src = `${location.origin}/storage/${u.profile_picture}`
                    img.classList.remove('hidden')
                    fb.classList.add('hidden')
                } else {
                    img.classList.add('hidden')
                    fb.classList.remove('hidden')
                    fb.textContent = (u.name || 'U').split(' ').map(w=>w[0]).join('').slice(0,2).toUpperCase()
                }
                tr.querySelector('.viewBtn').onclick = async () => {
                    const r = await fetch(`{{ url('/dashboard/admin/users') }}/${u.id}`, withCredentials({ headers: { 'Accept':'application/json' } }))
                    openView(await r.json())
                }
                tr.querySelector('.editBtn').onclick = () => openEdit(u)
                tr.querySelector('.deleteBtn').onclick = () => openDelete(u.id)
                tbody.appendChild(tr)
            })
            tableWrap.innerHTML = ''
            tableWrap.appendChild(table)
        }

        function renderPagination(p){
            pagination.innerHTML = ''
            const makeBtn = (label, targetPage, disabled=false) => {
                const b = document.createElement('button')
                b.textContent = label
                b.className = `px-3 py-1 border rounded ${disabled ? 'opacity-50 cursor-not-allowed' : ''}`
                if (!disabled) b.onclick = () => { page = targetPage; load() }
                return b
            }
            pagination.appendChild(makeBtn('Prev', Math.max(1, p.current_page - 1), p.current_page === 1))
            pagination.appendChild(document.createTextNode(` Page ${p.current_page} of ${p.last_page} `))
            pagination.appendChild(makeBtn('Next', Math.min(p.last_page, p.current_page + 1), p.current_page === p.last_page))
        }

        // Toast helper
        function showToast(message){
            const wrap = document.getElementById('toastContainer')
            const el = document.createElement('div')
            el.className = 'bg-green-600 text-white px-4 py-2 rounded shadow transform translate-y-2 opacity-0 transition-all duration-300'
            el.textContent = message
            wrap.appendChild(el)
            requestAnimationFrame(() => {
                el.classList.remove('translate-y-2','opacity-0')
                el.classList.add('translate-y-0','opacity-100')
            })
            setTimeout(() => {
                el.classList.add('opacity-0','translate-y-2')
                setTimeout(() => el.remove(), 300)
            }, 2500)
        }

        function enablePwToggles(root=document){
            root.querySelectorAll('.pw-toggle').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = btn.parentElement.querySelector('input')
                    if (!input) return
                    const isPw = input.type === 'password'
                    input.type = isPw ? 'text' : 'password'
                    btn.innerHTML = isPw
                        ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5"><path d="M3 3l18 18" stroke-linecap="round"/><path d="M1.5 12s3.5-6 10.5-6c2.1 0 3.95.46 5.5 1.19M22.5 12s-3.5 6-10.5 6c-2.1 0-3.95-.46-5.5-1.19" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                        : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-5 h-5"><path d="M1.5 12s3.5-6 10.5-6 10.5 6 10.5 6-3.5 6-10.5 6S1.5 12 1.5 12Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3"/></svg>'
                })
            })
        }
        function debounce(fn, wait){ let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), wait) } }
        load()
        enablePwToggles(document)
    </script>
</body>
</html>


