@extends('layouts.admin')

@section('title', 'General Reminders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="mb-0 d-flex align-items-center"><i class="bi bi-bell me-2"></i> General Reminders</h4>
    <div class="text-muted small">Manage your reminders</div>
  </div>
  <a href="{{ route('admin.general-reminders.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Add New Reminder
  </a>
</div>

<div class="card shadow-sm">
  <div class="table-responsive" id="reminder-table-wrapper" style="position: relative;">
    <table class="table align-middle mb-0" id="reminder-table">
      <thead class="table-light">
        <tr>
          <th style="width: 5%">#</th>
          <th style="width: 25%">Name</th>
          <th style="width: 15%">Code</th>
          <th style="width: 20%">Due Date</th>
          <th style="width: 20%">Status</th>
          <th style="width: 15%" class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody id="reminder-table-body">
        @forelse($reminders as $reminder)
          <tr>
            <td>{{ ($reminders->currentPage() - 1) * $reminders->perPage() + $loop->iteration }}</td>
            <td>{{ $reminder->name ?? '-' }}</td>
            <td>{{ $reminder->code ?? '-' }}</td>
            <td>{{ $reminder->due_date ? $reminder->due_date->format('d M Y') : '-' }}</td>
            <td>{{ $reminder->status ?? '-' }}</td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.general-reminders.edit', $reminder) }}" title="Edit">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.general-reminders.destroy', $reminder) }}" method="POST" class="d-inline ajax-delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-sm btn-outline-danger ajax-delete" 
                        data-delete-url="{{ route('admin.general-reminders.destroy', $reminder) }}"
                        data-delete-message="Delete this reminder?" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-muted">No reminders found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  
  <div class="card-footer bg-light d-flex flex-column gap-2">
    <div class="align-self-start">
      Showing {{ $reminders->firstItem() ?? 0 }}-{{ $reminders->lastItem() ?? 0 }} of {{ $reminders->total() }}
    </div>
    @if($reminders->hasMorePages())
      <div class="d-flex align-items-center justify-content-center gap-2">
        <div id="reminder-spinner" class="spinner-border text-primary d-none" style="width: 2rem; height: 2rem;" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span id="reminder-load-text" class="text-muted" style="font-size: 0.9rem;">Scroll for more</span>
      </div>
      <div id="reminder-sentinel" data-next-url="{{ $reminders->appends(request()->query())->nextPageUrl() }}" style="height: 20px;"></div>
    @endif
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const tbody = document.getElementById('reminder-table-body');
  let isLoading = false;
  let observer = null;

  // Infinite scroll implementation
  function initInfiniteScroll() {
    const sentinel = document.getElementById('reminder-sentinel');

    if (!sentinel) {
      return;
    }

    if (observer) {
      observer.disconnect();
    }

    observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting && !isLoading) {
          const nextUrl = sentinel.getAttribute('data-next-url');
          if (nextUrl) {
            loadMore(nextUrl);
          }
        }
      });
    }, { rootMargin: '300px' });

    observer.observe(sentinel);
  }

  function loadMore(url) {
    if (isLoading) return;
    isLoading = true;

    const spinner = document.getElementById('reminder-spinner');
    const loadText = document.getElementById('reminder-load-text');

    if (spinner) spinner.classList.remove('d-none');
    if (loadText) loadText.textContent = 'Loading...';

    fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = html;
      const newRows = tempDiv.querySelectorAll('#reminder-table-body tr');
      
      const realRows = Array.from(newRows).filter(tr => {
        const tds = tr.querySelectorAll('td');
        const hasColspan = tr.querySelector('td[colspan]');
        return !(tds.length === 1 && hasColspan);
      });

      realRows.forEach(tr => {
        tbody.appendChild(tr.cloneNode(true));
      });

      const newFooter = tempDiv.querySelector('.card-footer');
      const currentFooter = document.querySelector('.card-footer');
      if (newFooter && currentFooter) {
        currentFooter.innerHTML = newFooter.innerHTML;
        
        // Reinitialize observer after footer update with a small delay
        setTimeout(() => {
          initInfiniteScroll();
        }, 100);
      }

      const newSentinel = tempDiv.querySelector('#reminder-sentinel');
      const currentSentinel = document.getElementById('reminder-sentinel');
      if (newSentinel && currentSentinel) {
        currentSentinel.setAttribute('data-next-url', newSentinel.getAttribute('data-next-url') || '');
      } else if (currentSentinel && !newSentinel) {
        currentSentinel.remove();
        if (observer) {
          observer.disconnect();
        }
      }
    })
    .catch(error => {
      console.error('Load more error:', error);
    })
    .finally(() => {
      isLoading = false;
      if (spinner) spinner.classList.add('d-none');
      if (loadText) loadText.textContent = 'Scroll for more';
    });
  }

  initInfiniteScroll();
});
</script>
@endpush
