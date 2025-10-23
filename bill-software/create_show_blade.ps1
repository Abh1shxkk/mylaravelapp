$createFile = "c:\xampp\htdocs\bill-software\resources\views\admin\customers\create.blade.php"
$showFile = "c:\xampp\htdocs\bill-software\resources\views\admin\customers\show.blade.php"

# Read create blade
$content = Get-Content $createFile -Raw

# 1. Change title
$content = $content -replace "@section\('title', 'Add Customer'\)", "@section('title', 'Customer Details')"

# 2. Change heading
$content = $content -replace '<h2 class="mb-0">Add New Customer</h2>', '<h2 class="mb-0">Customer Details: {{ $customer->name }}</h2>'

# 3. Remove form tag and replace with div
$content = $content -replace '<form action="\{\{ route\(''admin\.customers\.store''\) \}\}" method="POST" id="customerForm" novalidate>', '<div id="customerDetails">'
$content = $content -replace '</form>', '</div>'

# 4. Remove @csrf
$content = $content -replace '\s+@csrf', ''

# 5. Remove form actions section (Save/Cancel buttons)
$content = $content -replace '<!-- Form Actions -->.*?</div>\s+</div>', '', 'Singleline'

# 6. Add Edit button in header
$content = $content -replace '(<a href="\{\{ route\(''admin\.customers\.index''\) \}\}")', '<a href="{{ route(''admin.customers.edit'', $customer) }}" class="btn btn-primary me-2">
                        <i class="bi bi-pencil me-2"></i>Edit Customer
                    </a>
                    $1'

# 7. Convert all input fields to display paragraphs
# Text inputs
$content = $content -replace '<input type="text" class="form-control[^"]*" name="([^"]+)" value="\{\{ old\(''([^'']+)''\) \}\}"[^>]*>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''-'' }}</p>'
$content = $content -replace '<input type="text" class="form-control[^"]*" name="([^"]+)" value="\{\{ old\(''([^'']+)'', ''([^'']+)''\) \}\}"[^>]*>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''-'' }}</p>'

# Number inputs
$content = $content -replace '<input type="number"[^>]* name="([^"]+)"[^>]*>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''0'' }}</p>'

# Email inputs
$content = $content -replace '<input type="email"[^>]* name="([^"]+)"[^>]*>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''-'' }}</p>'

# Date inputs
$content = $content -replace '<input type="date"[^>]* name="([^"]+)"[^>]*>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''-'' }}</p>'

# 8. Convert all select dropdowns to display paragraphs
$content = $content -replace '<select class="form-select[^"]*" name="([^"]+)">[^<]*<option[^>]*>[^<]*</option>[^<]*<option[^>]*>[^<]*</option>[^<]*</select>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''-'' }}</p>'
$content = $content -replace '<select class="form-select[^"]*" name="([^"]+)">.*?</select>', '<p class="form-control-plaintext">{{ $customer->$1 ?? ''-'' }}</p>', 'Singleline'

# 9. Remove required attribute mentions
$content = $content -replace ' <span class="text-danger">\*</span>', ''
$content = $content -replace ' required', ''

# 10. Remove placeholder attributes
$content = $content -replace ' placeholder="[^"]*"', ''

# Save to show blade
Set-Content -Path $showFile -Value $content -NoNewline

Write-Host "Show blade created successfully!" -ForegroundColor Green
Write-Host "File: $showFile" -ForegroundColor Cyan
