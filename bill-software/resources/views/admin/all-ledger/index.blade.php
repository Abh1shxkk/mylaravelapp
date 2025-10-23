@extends('layouts.admin')

@section('title', 'All Ledger')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-0 d-flex align-items-center">
            <i class="bi bi-journal-text me-2"></i>All Ledger
        </h4>
        <div class="text-muted small">View all ledger accounts</div>
    </div>
</div>

<div class="card shadow-sm">
    <!-- Advanced Search Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.all-ledger.index') }}" class="row g-3" id="ledger-filter-form">
                <div class="col-md-3">
                    <label for="search_field" class="form-label">
                        <i class="bi bi-funnel me-1"></i>Search By
                    </label>
                    <select class="form-select" id="search_field" name="search_field">
                        <option value="all" {{ request('search_field', 'all') == 'all' ? 'selected' : '' }}>All Fields</option>
                        <option value="split_name" {{ request('search_field') == 'split_name' ? 'selected' : '' }}>Split Name</option>
                        <option value="alter_code" {{ request('search_field') == 'alter_code' ? 'selected' : '' }}>AlterCode</option>
                        <option value="mobile" {{ request('search_field') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="telephone" {{ request('search_field') == 'telephone' ? 'selected' : '' }}>Telephone</option>
                        <option value="address" {{ request('search_field') == 'address' ? 'selected' : '' }}>Address</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label">
                        <i class="bi bi-search me-1"></i>Search
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="ledger-search" name="search" value="{{ request('search') }}" placeholder="Type to search..." autocomplete="off">
                        <button class="btn btn-outline-secondary" type="button" id="clear-search" title="Clear search">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="ledger_type_filter" class="form-label">
                        <i class="bi bi-filter me-1"></i>Ledger Type
                    </label>
                    <select class="form-select" id="ledger-type-filter" name="ledger_type">
                        <option value="">All Types</option>
                        <option value="Customer" {{ request('ledger_type') == 'Customer' ? 'selected' : '' }}>Customer</option>
                        <option value="Supplier" {{ request('ledger_type') == 'Supplier' ? 'selected' : '' }}>Supplier</option>
                        <option value="General Ledger" {{ request('ledger_type') == 'General Ledger' ? 'selected' : '' }}>General Ledger</option>
                        <option value="Cash / Bank" {{ request('ledger_type') == 'Cash / Bank' ? 'selected' : '' }}>Cash / Bank</option>
                        <option value="Sale Ledger" {{ request('ledger_type') == 'Sale Ledger' ? 'selected' : '' }}>Sale Ledger</option>
                        <option value="Purchase Ledger" {{ request('ledger_type') == 'Purchase Ledger' ? 'selected' : '' }}>Purchase Ledger</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive" id="ledger-table-wrapper" style="position: relative;">
        <div id="search-loading" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 999; align-items: center; justify-content: center;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 15%;">Code</th>
                    <th style="width: 15%;">Ledger Type</th>
                    <th style="width: 12%;" class="text-end">Debit</th>
                    <th style="width: 12%;" class="text-end">Credit</th>
                    <th style="width: 11%;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="ledger-table-body">
                @forelse($paginator->items() as $index => $ledger)
                    <tr class="ledger-row" data-ledger-type="{{ $ledger['ledger_type'] }}">
                        <td>{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold">{{ $ledger['name'] }}</div>
                        </td>
                        <td>{{ $ledger['code'] }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $ledger['ledger_type'] }}</span>
                        </td>
                        <td class="text-end">
                            @if($ledger['debit'] > 0)
                                <span class="text-danger fw-semibold">₹{{ number_format($ledger['debit'], 2) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($ledger['credit'] > 0)
                                <span class="text-success fw-semibold">₹{{ number_format($ledger['credit'], 2) }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewLedgerDetails({{ json_encode($ledger) }})" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox me-2"></i>No ledger entries found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Footer -->
    <div class="card-footer d-flex flex-column gap-2">
        <div class="align-self-start">Showing {{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }}</div>
        @if($paginator->hasMorePages())
            <div class="d-flex align-items-center justify-content-center gap-2">
                <div id="ledger-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span id="ledger-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
            </div>
            <div id="ledger-sentinel" data-next-url="{{ $paginator->appends(request()->query())->nextPageUrl() }}" style="height: 1px;"></div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const searchInput = document.getElementById('ledger-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const searchFieldSelect = document.getElementById('search_field');
    const ledgerTypeSelect = document.getElementById('ledger-type-filter');
    const filterForm = document.getElementById('ledger-filter-form');
    const sentinel = document.getElementById('ledger-sentinel');
    const spinner = document.getElementById('ledger-spinner');
    const loadText = document.getElementById('ledger-load-text');
    const tbody = document.getElementById('ledger-table-body');
    let searchTimeout;
    let isSearching = false;

    function performSearch() {
        if(isSearching) return;
        isSearching = true;
        
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);
        
        // Debug: Log the parameters being sent
        console.log('Search parameters:', {
            search: formData.get('search'),
            search_field: formData.get('search_field'),
            ledger_type: formData.get('ledger_type')
        });
        console.log('Full URL:', `{{ route('admin.all-ledger.index') }}?${params.toString()}`);
        
        // Show loading spinner
        const loadingSpinner = document.getElementById('search-loading');
        if(loadingSpinner) {
            loadingSpinner.style.display = 'flex';
        }
        
        // Add visual feedback
        if(searchInput) {
            searchInput.style.opacity = '0.6';
        }
        
        fetch(`{{ route('admin.all-ledger.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const tempTbody = tempDiv.querySelector('#ledger-table-body');
            const tempRows = tempTbody.querySelectorAll('tr');
            
            const realRows = Array.from(tempRows).filter(tr => {
                const tds = tr.querySelectorAll('td');
                const hasColspan = tr.querySelector('td[colspan]');
                return !(tds.length === 1 && hasColspan);
            });
            
            tbody.innerHTML = '';
            if(realRows.length) {
                realRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));
            } else {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No ledgers found</td></tr>';
            }
            
            // Update footer with pagination info and sentinel
            const newFooter = tempDiv.querySelector('.card-footer');
            const currentFooter = document.querySelector('.card-footer');
            if(newFooter && currentFooter) {
                currentFooter.innerHTML = newFooter.innerHTML;
            }
            
            // Re-setup infinite scroll observer for the updated/new sentinel
            setupInfiniteScroll();
        })
        .catch(error => {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>';
        })
        .finally(() => {
            isSearching = false;
            
            // Hide loading spinner
            const loadingSpinner = document.getElementById('search-loading');
            if(loadingSpinner) {
                loadingSpinner.style.display = 'none';
            }
            
            if(searchInput) {
                searchInput.style.opacity = '1';
            }
            const s = document.getElementById('ledger-spinner');
            const t = document.getElementById('ledger-load-text');
            s && s.classList.add('d-none');
            t && (t.textContent = 'Scroll for more');
        });
    }

    // Attach debounced keyup on search input
    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });
    }

    // Clear search button
    if(clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            if(searchInput) {
                searchInput.value = '';
                searchInput.focus();
                performSearch();
            }
        });
    }

    // Trigger search when search field dropdown changes
    if(searchFieldSelect) {
        searchFieldSelect.addEventListener('change', function() {
            performSearch();
        });
    }

    // Trigger search when ledger type changes
    if(ledgerTypeSelect) {
        ledgerTypeSelect.addEventListener('change', function() {
            console.log('Ledger type changed to:', this.value);
            performSearch();
        });
    } else {
        console.log('Ledger type select element not found');
    }
    
    let isLoading = false;
    let observer = null;
    
    // Function to setup infinite scroll observer
    function setupInfiniteScroll() {
        const currentSentinel = document.getElementById('ledger-sentinel');
        if(!currentSentinel || !tbody) return;
        
        // Disconnect previous observer if exists
        if(observer) {
            observer.disconnect();
        }
        
        // Get the scrolling container (.content div)
        const contentDiv = document.querySelector('.content');
        
        // Create new observer with correct root (scrolling container)
        observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting && !isLoading) {
                    loadMore();
                }
            });
        }, { 
            root: contentDiv,
            threshold: 0.1,
            rootMargin: '100px'
        });
        
        observer.observe(currentSentinel);
    }
    
    async function loadMore(){
        if(isLoading) return;
        const currentSentinel = document.getElementById('ledger-sentinel');
        if(!currentSentinel) return;
        
        const nextUrl = currentSentinel.getAttribute('data-next-url');
        if(!nextUrl) return;
        
        isLoading = true;
        const spinner = document.getElementById('ledger-spinner');
        const loadText = document.getElementById('ledger-load-text');
        spinner && spinner.classList.remove('d-none');
        loadText && (loadText.textContent = 'Loading...');
        
        try{
            // Add current search/filter params to nextUrl
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const url = new URL(nextUrl, window.location.origin);
            params.forEach((value, key) => {
                if(value) url.searchParams.set(key, value);
            });
            const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const html = await res.text();
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const tempTbody = tempDiv.querySelector('#ledger-table-body');
            const tempRows = tempTbody.querySelectorAll('tr');
            const realRows = Array.from(tempRows).filter(tr => {
                const tds = tr.querySelectorAll('td');
                return !(tds.length === 1 && tr.querySelector('td[colspan]'));
            });
            realRows.forEach(tr => tbody.appendChild(tr.cloneNode(true)));
            
            const newSentinel = tempDiv.querySelector('#ledger-sentinel');
            if(newSentinel){
                currentSentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url'));
                spinner && spinner.classList.add('d-none');
                loadText && (loadText.textContent = 'Scroll for more');
                isLoading = false;
            } else {
                observer && observer.disconnect();
                currentSentinel.remove();
                spinner && spinner.remove();
                loadText && loadText.remove();
            }
        }catch(e){
            spinner && spinner.classList.add('d-none');
            loadText && (loadText.textContent = 'Error loading');
            isLoading = false;
        }
    }
    
    // Initial setup of infinite scroll
    setupInfiniteScroll();

    // Modal view function with loading animation
    window.viewLedgerDetails = function(ledger) {
        // Show loading state first
        showLoadingModal();
        
        // Simulate data fetching with delay (like HSN modal)
        setTimeout(() => {
            populateLedgerData(ledger);
        }, 800); // 800ms loading delay for better UX
    }
    
    function showLoadingModal() {
        // Clean up any existing modals/backdrops first
        const existingBackdrops = document.querySelectorAll('.modal-backdrop');
        existingBackdrops.forEach(backdrop => backdrop.remove());
        
        const existingModals = document.querySelectorAll('.modal.show');
        existingModals.forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
        
        // Get modal element
        const modalElement = document.getElementById('ledgerDetailsModal');
        const modalBody = modalElement.querySelector('.modal-body');
        
        // Set loading content
        modalBody.innerHTML = `
            <div class="modal-loading">
                <div class="loading-spinner"></div>
                <div class="loading-text">Loading ledger details...</div>
            </div>
        `;
        
        // Set loading title
        document.getElementById('ledgerDetailsModalLabel').innerHTML = 
            '<i class="bi bi-hourglass-split me-2"></i>Loading...';
        
        // Show modal with loading state
        showModal(modalElement);
    }
    
    function populateLedgerData(ledger) {
        const modalElement = document.getElementById('ledgerDetailsModal');
        const modalBody = modalElement.querySelector('.modal-body');
        
        // Restore original modal content with dynamic data
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-info-circle me-2"></i>Basic Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-4"><strong>Name:</strong></div>
                                <div class="col-8">${ledger.name || '-'}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Code:</strong></div>
                                <div class="col-8">${ledger.code || '-'}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Type:</strong></div>
                                <div class="col-8">
                                    <span class="badge bg-info text-dark">${ledger.ledger_type || '-'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-currency-rupee me-2"></i>Balance Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-4"><strong>Debit:</strong></div>
                                <div class="col-8">
                                    <span class="text-danger fw-semibold">₹${parseFloat(ledger.debit || 0).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Credit:</strong></div>
                                <div class="col-8">
                                    <span class="text-success fw-semibold">₹${parseFloat(ledger.credit || 0).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Balance:</strong></div>
                                <div class="col-8">
                                    <span class="fw-bold ${((ledger.debit || 0) - (ledger.credit || 0)) >= 0 ? 'text-danger' : 'text-success'}">
                                        ₹${Math.abs((ledger.debit || 0) - (ledger.credit || 0)).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})} ${((ledger.debit || 0) - (ledger.credit || 0)) >= 0 ? 'Dr' : 'Cr'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Details Section -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="bi bi-list-ul me-2"></i>Contact Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Address:</strong>
                                        <div class="text-muted small">${ledger.address || '-'}</div>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Mobile:</strong>
                                        <div class="text-muted small">${ledger.mobile || '-'}</div>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Email:</strong>
                                        <div class="text-muted small">${ledger.email || '-'}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Telephone:</strong>
                                        <div class="text-muted small">${ledger.telephone || '-'}</div>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Fax:</strong>
                                        <div class="text-muted small">${ledger.fax || '-'}</div>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Contact Persons:</strong>
                                        <div class="text-muted small">
                                            ${ledger.contact_person1 && ledger.contact_person1 !== '-' ? ledger.contact_person1 : ''}
                                            ${ledger.contact_person2 && ledger.contact_person2 !== '-' ? (ledger.contact_person1 && ledger.contact_person1 !== '-' ? ', ' + ledger.contact_person2 : ledger.contact_person2) : ''}
                                            ${(!ledger.contact_person1 || ledger.contact_person1 === '-') && (!ledger.contact_person2 || ledger.contact_person2 === '-') ? '-' : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Set final modal title
        document.getElementById('ledgerDetailsModalLabel').innerHTML = 
            `<i class="bi bi-journal-text me-2"></i>${ledger.ledger_type} - ${ledger.name}`;
    }
    
    function showModal(modalElement) {
        // Force ultra-high z-index inline
        modalElement.style.cssText = `
            z-index: 999999999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            display: block !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
        `;
        
        // Add modal-open class to body
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        
        // Create and add backdrop manually
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.style.cssText = `
            z-index: 999999998 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background-color: rgba(0, 0, 0, 0.1) !important;
            animation: backdropFadeIn 0.3s ease-out !important;
        `;
        document.body.appendChild(backdrop);
        
        // Add show class to modal
        modalElement.classList.add('show');
        modalElement.setAttribute('aria-modal', 'true');
        modalElement.setAttribute('role', 'dialog');
        modalElement.style.display = 'block';
        
        // Trigger animation by forcing reflow
        void modalElement.offsetWidth;
        
        // Close modal function with animation
        const closeModal = function() {
            // Add fade-out animation
            backdrop.style.animation = 'backdropFadeIn 0.3s ease-out reverse';
            const modalDialog = modalElement.querySelector('.modal-dialog');
            if (modalDialog) {
                modalDialog.style.animation = 'modalSlideDown 0.4s ease-out reverse';
            }
            
            // Wait for animation to complete before removing
            setTimeout(() => {
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                backdrop.remove();
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
            }, 300);
        };
        
        // Handle close button
        const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', closeModal);
        });
        
        // Handle backdrop click
        backdrop.addEventListener('click', closeModal);
        
        // Handle ESC key
        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }
});
</script>

<style>
    .ledger-row {
        transition: background-color 0.2s ease;
    }

    .ledger-row:hover {
        background-color: #f8f9fa;
    }

    .table-responsive {
        border-radius: 0.375rem;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.6rem;
    }

    /* Modal animations */
    @keyframes backdropFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes modalSlideDown {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @keyframes loadingPulse {
        0%, 100% {
            opacity: 0.4;
        }
        50% {
            opacity: 1;
        }
    }
    
    /* Modal z-index fixes - ULTRA MAXIMUM PRIORITY */
    body.modal-open {
        overflow: hidden !important;
    }
    
    .modal-backdrop {
        z-index: 999999998 !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        background-color: rgba(0, 0, 0, 0.1) !important;
        display: block !important;
        animation: backdropFadeIn 0.3s ease-out !important;
    }
    
    #ledgerDetailsModal {
        z-index: 999999999 !important;
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
        display: none;
    }
    
    #ledgerDetailsModal.show {
        display: block !important;
        z-index: 999999999 !important;
    }

    #ledgerDetailsModal .modal-dialog {
        z-index: 999999999 !important;
        position: relative !important;
        margin: 1.75rem auto !important;
        pointer-events: none !important;
        animation: modalSlideDown 0.5s ease-out !important;
    }
    
    /* Loading state styles */
    .modal-loading {
        text-align: center;
        padding: 2rem;
    }
    
    .loading-spinner {
        display: inline-block;
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .loading-text {
        margin-top: 1rem;
        color: #6c757d;
        animation: loadingPulse 1.5s ease-in-out infinite;
    }

    #ledgerDetailsModal .modal-content {
        z-index: 999999999 !important;
        position: relative !important;
        background: white !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
        border: 2px solid #007bff !important;
        pointer-events: auto !important;
    }

    /* Force everything else down */
    .sidebar, .navbar, .header, .app, .content, .table-responsive, .card {
        z-index: 1 !important;
        position: relative !important;
    }

    /* Ensure scroll-to-top button doesn't interfere */
    #scrollToTop {
        z-index: 9999 !important;
    }
    
    /* Additional override for any high z-index elements */
    *:not(.modal):not(.modal-dialog):not(.modal-content):not(.modal-backdrop) {
        max-z-index: 99999 !important;
    }
</style>

<!-- Ledger Details Modal -->
<div class="modal fade" id="ledgerDetailsModal" tabindex="-1" aria-labelledby="ledgerDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ledgerDetailsModalLabel">
                    <i class="bi bi-journal-text me-2"></i>Ledger Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be populated dynamically -->
            </div>
        </div>
    </div>
</div>

@endpush
